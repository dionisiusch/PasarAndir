<?php

namespace App\Http\Controllers;

use App\Model\Receipt;
use App\Model\Stall;
use Illuminate\Http\Request;
use App\Http\Services\ReceiptService;
use App\Http\Services\InvoiceService;
use App\Http\Services\InvoiceReceiptService;
use App\Http\Services\StallService;
use App\Http\Services\AreaService;
use App\Http\Services\FloorService;
use App\Http\Services\ElectricityService;
use App\Http\Services\StallElectricityService;
use App\Http\Services\StallWaterService;
use App\Http\Helpers\Helper;
use GuzzleHttp\Client;
use DB;

class ReceiptController extends Controller
{
    /** @var ReceiptService */
    private $receiptService;

    /** @var InvoiceService */
    private $invoiceService;

    /** @var InvoiceReceiptService */
    private $invoiceReceiptService;
    
    /** @var StallElectricityService */
    private $stallElectricityService;

    /** @var StallWaterService */
    private $stallWaterService;

    /** @var ElectricityService */
    private $electricityService;

    /** @var StallService */
    private $stallService;

    /** @var AreaService */
    private $areaService;

    /** @var FloorService */
    private $floorService;

    /** @var Helper */
    private $helper;

    public function __construct()
    {
        $this->receiptService = app(ReceiptService::class);
        $this->invoiceService = app(InvoiceService::class);
        $this->invoiceReceiptService = app(InvoiceReceiptService::class);
        $this->stallElectricityService = app(StallElectricityService::class);
        $this->stallWaterService = app(StallWaterService::class);
        $this->electricityService = app(ElectricityService::class);
        $this->stallService = app(StallService::class);
        $this->areaService = app(AreaService::class);
        $this->floorService = app(FloorService::class);
        $this->helper = app(Helper::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = $this->receiptService->showAllReceipts();

        return view('master.receipt.index');
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
        try {
            $request->validate([
                'invoice_id'=>'required',
                'stall_id'=>'required',
                'payment'=>'required'
            ]);

            $payment = $this->helper->price_decoder($request->payment);
    
            $receipt = $this->receiptService->createReceipt($request, $payment);
            $invoiceReceipt = $this->invoiceReceiptService->createInvoiceReceipt($request->invoice_id, $receipt->id, $payment);

            $invoice = $this->invoiceService->createInvoice($request->invoice_id);
            $stallElectricity = $this->stallElectricityService->getStallElectricityById($invoice->stall_electricity_id);
            $stallWater = $this->stallWaterService->getStallWaterById($invoice->stall_water_id);
            $electricity = $this->electricityService->getElectricityById($stall->electricity_id);
            $billElectricityKwh = $stallElectricity->kwh_price * ($stallElectricity->meter_after - $stallElectricity->meter_before);
            $billElectricityKva = $electricity->power_meter * $stallElectricity->kva_price;
            $billWater = ($stallWater->price * ($stallWater->meter_after - $stallWater->meter_before)) + $stallWater->fixed_price;

            $total = $billElectricityKwh + $billElectricityKva + $billWater + $invoice->fine - $invoice->discount;

            $totalPaidByInvoiceId = $this->invoiceReceiptService->sumTotalPaymentByInvoiceId($request->invoice_id);

            if($totalPaidByInvoiceId >= $total){
                $invoiceUpdate = $this->invoiceService->updateInvoiceStatusPaidOffById($request->invoice_id);
            }
    
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Berhasil Ditambahkan.');       
        } catch (Exception $e) {
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Gagal Ditambahkan.'); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $receipt = $this->receiptService->getReceiptById($id);
            $invoiceIds = $this->invoiceReceiptService->showAllInvoicesByReceiptId($id);
            $invoices = $this->invoiceService->getInvoiceById($invoiceIds);
            $stall = $this->stallService->getStallById($receipt->stall_id);
      
            $data = array(
                'invoices' => $invoices,
                'payment' => $receipt->stall,
                'stall'  => $stall,
                'id'  => $id
            );
            
            return json_encode($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'invoice_id' => 'required',
                'stall_id'=>'required',
                'payment'=>'required'
            ]);
            $payment = $this->helper->price_decoder($request->payment);
    
            $response = $this->receiptService->updateReceiptById($request, $id, $payment);
            $responseInvoiceReceipt = $this->invoiceReceiptService->updateInvoiceReceiptByInvoiceIdAndReceiptId($request->invoice_id, $id, $payment);
    
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Berhasil Di Update.');       
        } catch (Exception $e) {
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Gagal Di Update.'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Receipt Kios Gagal Dihapus.';
        $response = $this->receiptService->deleteReceiptById($id);

        if($response){
            $msg = 'Data Receipt Kios Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->receiptService->searchReceipt($query);
            } else {
                $data = $this->receiptService->showAllReceipts();
            }
         
            $total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
                    $stall = $this->stallService->getStallById($row->stall_id);
                    $invoiceId = $this->invoiceReceiptService->showAllInvoicesByReceiptId($row->id);
                    $invoice = $this->invoiceService->getInvoiceById($invoiceId);
                    $area = $this->areaService->getAreaById($invoice->area_id);
                    $floor = $this->floorService->getFloorById($area->floor_id);

                    $output .= '
					<tr class="tr-shadow">
						<td>'.$row->name.'</td>
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
