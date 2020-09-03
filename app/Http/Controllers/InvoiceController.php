<?php

namespace App\Http\Controllers;

use App\Model\Invoice;
use App\Model\Stall;
use App\Model\Electricity;
use App\Model\StallElectricity;
use App\Model\StallWater;
use Illuminate\Http\Request;
use App\Http\Services\InvoiceService;
use App\Http\Services\ElectricityService;
use App\Http\Services\StallService;
use App\Http\Services\StallElectricityService;
use App\Http\Services\StallWaterService;
use GuzzleHttp\Client;

class InvoiceController extends Controller
{
    /** @var InvoiceService */
    private $invoiceService;

    /** @var StallElectricityService */
    private $stallElectricityService;

    /** @var StallWaterService */
    private $stallWaterService;

    /** @var ElectricityService */
    private $electricityService;

    /** @var StallService */
    private $stallService;

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
        $this->stallElectricityService = app(StallElectricityService::class);
        $this->stallWaterService = app(StallWaterService::class);
        $this->electricityService = app(ElectricityService::class);
        $this->stallService = app(StallService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = $this->invoiceService->showAllInvoices();

        return view('master.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //DISCOUNT AND FINE NOT REQUIRED
        $request->validate([
            'stall_id'=>'required',
            'stall_electricity_id'=>'required',
            'stall_water_id'=>'required',
            'minimal_payment'=>'required',
            'month_bill'=>'required',
            'grace_date'=>'required',
            'status'=>'required'
        ]);

        $response = $this->invoiceService->createInvoice($request);

        // return redirect('/master/invoice')->with('success', 'Data Invoice Berhasil Ditambahkan.');       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $invoice = $this->invoiceService->getInvoiceById($id);
            $stall = $this->stallService->getStallById($invoice->stall_id);
            $stallElectricity = $this->stallElectricityService->getStallElectricityById($invoice->stall_electricity_id);
            $stallWater = $this->stallWaterService->getStallWaterById($invoice->stall_water_id);
            $electricity = $this->electricityService->getElectricityById($stall->electricity_id);
            $billElectricityKwh = $stallElectricity->kwh_price * ($stallElectricity->meter_after - $stallElectricity->meter_before);
            $billElectricityKva = $electricity->power_meter * $stallElectricity->kva_price;
            $billWater = ($stallWater->price * ($stallWater->meter_after - $stallWater->meter_before)) + $stallWater->fixed_price;

            $data = array(
                'grand_total' => $billElectricityKwh + $billElectricityKva + $billWater + $invoice->fine - $invoice->discount,
                'sub_total' => $billElectricityKwh + $billElectricityKva + $billWater,
                'water_bill' => $billWater,
                'electricity_bill' => $billElectricityKwh + $billElectricityKva,
                'electricity_name' => $electricity->name,
                'updated_at' => $invoice->updated_at,
                'created_at' => $invoice->created_at,
                'status' => $invoice->status,
                'grace_date' => $invoice->grace_date,
                'month_bill' => $invoice->month_bill,
                'fine' => $invoice->fine,
                'minimal_payment'  => $invoice->minimal_payment,
                'discount'  => $invoice->discount,
                'id'  => $id
            );
            
            return json_encode($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'stall_id'=>'required',
            'minimal_payment'=>'required',
            'month_bill'=>'required',
            'grace_date'=>'required',
            'status'=>'required'
        ]);

        $response = $this->invoiceService->updateInvoiceById($request, $id);

        // return redirect('/master/invoice')->with('success', 'Data Invoice Berhasil Di Update.');   
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'=>'required'
        ]);

        $response = $this->invoiceService->updateInvoiceStatusById($request, $id);

        // return redirect('/master/invoice')->with('success', 'Status Invoice Berhasil Di Update.');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Invoice Gagal Dihapus.';
        $response = $this->invoiceService->deleteInvoiceById($id);

        if($response){
            $msg = 'Data Invoice Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->invoiceService->searchInvoice($query);
            } else {
                $data = $this->invoiceService->showAllInvoices();
            }
         
            $total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
                    $stall = $this->stallService->getStallById($row->stall_id);
                    $output .= '
                    <tr class="tr-shadow">
                        <td>'.$stall->name.'</td>
                        <td>'.$row->discount.'</td>
                        <td>'.$row->minimal_payment.'</td>
                        <td>'.$row->fine.'</td>
                        <td>'.$row->month_bil.'</td>
                        <td>'.$row->grace_date.'</td>
                        <td>'.$row->status.'</td>
						<td>
							<div class="table-data-feature">
							<button class="item edit" data-toggle="modal" data-target="#scrollmodal-update" title="Edit" id="'.$row->id.'">
								<i class="zmdi zmdi-edit"></i>
							</button>
							<button class="item delete" type="submit" data-toggle="tooltip" data-placement="top" title="Delete" id="'.$row->id.'">
								<i class="zmdi zmdi-delete"></i>
							</button>
							</div>
						</td>
					</tr>
					<tr class="spacer"></tr> 
        	        ';
      	        }
            } else {
				$output = '
				<tr class="tr-shadow">
				    <td align="center" colspan="2">Data not found.</td>
				</tr>
				';
			}
			
			$data = array(
				'table_data'  => $output,
				'total_data'  => $total_row
			);
			
   		    return json_encode($data);
 		}
	}
}
