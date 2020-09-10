<?php

namespace App\Http\Controllers;

use App\Model\Invoice;
use App\Model\Stall;
use App\Model\Electricity;
use App\Model\StallElectricity;
use App\Model\StallWater;
use App\Model\Floor;
use App\Model\Area;
use App\User;
use Illuminate\Http\Request;
use App\Http\Services\InvoiceService;
use App\Http\Services\ElectricityService;
use App\Http\Services\StallService;
use App\Http\Services\StallElectricityService;
use App\Http\Services\StallWaterService;
use App\Http\Services\UserService;
use App\Http\Services\AreaService;
use App\Http\Services\FloorService;
use App\Http\Services\InvoiceReceiptService;
use App\Http\Services\PowerMeterService;
use App\Http\Helpers\Helper;
use GuzzleHttp\Client;
use DB;

class InvoiceController extends Controller
{
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

    /** @var PowerMeterService */
    private $powerMeterService;

    /** @var StallService */
    private $stallService;

    /** @var UserService */
    private $userService;

    /** @var FloorService */
    private $floorService;

    /** @var AreaService */
    private $areaService;

    /** @var Helper */
    private $helper;

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
        $this->invoiceReceiptService = app(InvoiceReceiptService::class);
        $this->stallElectricityService = app(StallElectricityService::class);
        $this->stallWaterService = app(StallWaterService::class);
        $this->electricityService = app(ElectricityService::class);
        $this->powerMeterService = app(PowerMeterService::class);
        $this->stallService = app(StallService::class);
        $this->userService = app(UserService::class);
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
        $invoices = $this->invoiceService->showAllInvoices();

        return view('master.invoice.invoiceShow');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.invoice.invoiceCreate');
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
            'stall_id' => 'required',
            'minimal_payment' => 'required',
            'month_bill' => 'required',
            'grace_date' => 'required',
            'status' => 'required'
        ]);

        $minimalPayment = $this->helper->price_decoder($request->minimal_payment);

        $stallElectricityId = $this->stallElectricityService->getNewestStallElectricityById($request->stall_id);
        $stallWaterId = $this->stallWaterService->getNewestStallWaterById($request->stall_id);

        $response = $this->invoiceService->createInvoice($request, $stallElectricityId->id, $stallWaterId->id, $minimalPayment);

        return redirect('invoicecreate')->with('success', 'Data Invoice Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $invoice = $this->invoiceService->getInvoiceById($id);
            $stall = $this->stallService->getStallById($invoice->stall_id);
            $area = $this->areaService->getAreaById($stall->area_id);
            $floor = $this->floorService->getFloorById($area->floor_id);
            $user = $this->userService->getUserById($stall->user_id);
            $stallElectricity = $this->stallElectricityService->getStallElectricityById($invoice->stall_electricity_id);
            $stallWater = $this->stallWaterService->getStallWaterById($invoice->stall_water_id);
            $electricity = $this->electricityService->getElectricityById($stall->electricity_id);
            $powerMeter = $this->powerMeterService->getPowerMeterById($electricity->power_meter_id);
            $billStall = $area->price * $stall->width * $stall->length;
            $billElectricityKwh = $stallElectricity->kwh_price * ($stallElectricity->meter_after - $stallElectricity->meter_before);
            $billElectricityKva = $powerMeter->power_meter * $stallElectricity->kva_price;
            $billWater = ($stallWater->price * ($stallWater->meter_after - $stallWater->meter_before)) + $stallWater->fixed_price;
            $stallElectricity_used = $stallElectricity->meter_after -  $stallElectricity->meter_before;
            $area_name = "[" . $floor->name . "]" . " Blok " . $area->name . " No. " . $area->no;
            $totalPayment = $this->invoiceReceiptService->sumTotalPaymentByInvoiceId($id);

            $data = array(
                'stall_id' => $stall->id,
                'total_payment' => $totalPayment,
                'grand_total' => $billStall + $billElectricityKwh + $billElectricityKva + $billWater + $invoice->fine - $invoice->discount,
                'sub_total' => $billStall + $billElectricityKwh + $billElectricityKva + $billWater,
                'stall_bill' => $billStall,
                'water_bill' => $billWater,
                'kwh_price' => $stallElectricity->kwh_price,
                'kva_price' => $stallElectricity->kva_price,
                'electricity_power_meter' => $powerMeter->power_meter,
                'electricity_meter_after' => $stallElectricity->meter_after,
                'electricity_meter_before' => $stallElectricity->meter_before,
                'electricity_meter_used' => $stallElectricity_used,
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
                'floor_name' => $floor->name,
                'floor_code' => $floor->code,
                'area_no' => $area->no,
                'area_name' => $area_name,
                'pic_phone_number' => $user->pic_phone_number,
                'pic_name' => $user->pic_name,
                'area_price' => $area->price,
                'id'  => $id
            );

            return json_encode($data);
        }
    }

    public function showInvoicesByStallId(Request $request)
    {
        if ($request->ajax()) {
            $text = "";
            $id = $request->get('id');
            $invoices = $this->invoiceService->getInvoicesByStallId($id);
            foreach ($invoices as $invoice) {
                if ($invoice->status == "Lunas") {
                    $status = "<h4><span class='badge badge-success'>Lunas</span></h4>";
                } else {
                    $status = "<h4><span class='badge badge-danger'>Belum Lunas</span></h4>";
                }
                $text .= "<tr class='tr-shadow invoice-row' id='" . $invoice->id . "' data-toggle='modal' data-target='#largeModal'><td>" . $invoice->month_bill . "</td><td>" . $status;
            }
            $output = array(
                'text' => $text
            );
            return json_encode($output);
        }
    }

    public function remainCreditInvoice($id)
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        $totalPayment = $this->invoiceReceiptService->sumTotalPaymentByInvoiceId($id);
        $stall = $this->stallService->getStallById($invoice->stall_id);
        $area = $this->areaService->getAreaById($stall->area_id);
        $stallElectricity = $this->stallElectricityService->getStallElectricityById($invoice->stall_electricity_id);
        $stallWater = $this->stallWaterService->getStallWaterById($invoice->stall_water_id);
        $electricity = $this->electricityService->getElectricityById($stall->electricity_id);
        $powerMeter = $this->powerMeterService->getPowerMeterById($electricity->power_meter_id);
        $billStall = $area->price * $stall->width * $stall->length;
        $billElectricityKwh = $stallElectricity->kwh_price * ($stallElectricity->meter_after - $stallElectricity->meter_before);
        $billElectricityKva = $powerMeter->power_meter * $stallElectricity->kva_price;
        $billWater = ($stallWater->price * ($stallWater->meter_after - $stallWater->meter_before)) + $stallWater->fixed_price;

        $totalThatMustBePaid = $billStall + $billElectricityKwh + $billElectricityKva + $billWater + $invoice->fine - $invoice->discount;

        return ($totalThatMustBePaid - $totalPayment);
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
            'stall_id' => 'required',
            'minimal_payment' => 'required',
            'month_bill' => 'required',
            'grace_date' => 'required',
            'status' => 'required'
        ]);

        $minimalPayment = $this->helper->price_decoder($request->minimal_payment);

        $response = $this->invoiceService->updateInvoiceById($request, $id, $minimalPayment);

        // return redirect('/master/invoice')->with('success', 'Data Invoice Berhasil Di Update.');   
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
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

        if ($response) {
            $msg = 'Data Invoice Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = $this->invoiceService->searchInvoice($query);
            } else {
                $data = $this->invoiceService->showAllInvoicesSortByStatus();
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $stall = $this->stallService->getStallById($row->stall_id);
                    $user = $this->userService->getUserById($stall->user_id);
                    $area = $this->areaService->getAreaById($stall->area_id);
                    $floor = $this->floorService->getFloorById($area->floor_id);
                    $blok = "[" . $floor->name . "] " . " Blok " . $area->name . " No. " . $area->no;
                    $status = "";
                    if ($row->status == "Lunas") {
                        $status = "<span class='badge badge-success'>Lunas</span>";
                    } else {
                        $status = "<span class='badge badge-danger'>Belum Lunas</span>";
                    }
                    $output .= '
                    <tr class="tr-shadow invoice-row" id="' . $row->id . '" data-toggle="modal" data-target="#largeModal">
                        <td>' . $user->pic_name . '</td>
                        <td>' . $blok . '</td>
                        <td>' . $stall->name . '</td>
                        <td>' . $row->month_bill . '</td>
                        <td>' . $status . '</td>
						<td>
							<div class="table-data-feature">
							<button class="item delete" type="submit" data-toggle="tooltip" data-placement="top" title="Delete" id="' . $row->id . '">
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

    public function searchForReceipt(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = $this->invoiceService->searchInvoicesForReceipt($query);
            } else {
                $data = $this->invoiceService->showAllInvoicesForReceipt();
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $stall = $this->stallService->getStallById($row->stall_id);
                    $user = $this->userService->getUserById($stall->user_id);
                    $area = $this->areaService->getAreaById($stall->area_id);
                    $floor = $this->floorService->getFloorById($area->floor_id);
                    $stallElectricity = $this->stallElectricityService->getStallElectricityById($row->stall_electricity_id);
                    $stallWater = $this->stallWaterService->getStallWaterById($row->stall_water_id);
                    $electricity = $this->electricityService->getElectricityById($stall->electricity_id);
                    $powerMeter = $this->powerMeterService->getPowerMeterById($electricity->power_meter_id);
                    $billStall = $area->price * $stall->width * $stall->length;
                    $billElectricityKwh = $stallElectricity->kwh_price * ($stallElectricity->meter_after - $stallElectricity->meter_before);
                    $billElectricityKva = $powerMeter->power_meter * $stallElectricity->kva_price;
                    $billWater = ($stallWater->price * ($stallWater->meter_after - $stallWater->meter_before)) + $stallWater->fixed_price;
                    $total = $billStall + $billElectricityKwh + $billElectricityKva + $billWater + $row->fine - $row->discount;
                    $blok = "[" . $floor->name . "] " . " Blok " . $area->name . " No. " . $area->no;
                    $status = "";
                    if ($row->status == "Lunas") {
                        $status = "<span class='badge badge-success'>Lunas</span>";
                    } else {
                        $status = "<span class='badge badge-danger'>Belum Lunas</span>";
                    }
                    $output .= '
                    <tr class="tr-shadow invoice-row" id="' . $row->id . '" data-dismiss="modal">
                        <td>' . $blok . '</td>
                        <td>' . $stall->name . '</td>
                        <td>' . parent::rupiah($total) . '</td>
                        <td>' . $row->month_bill . '</td>
                        <td>' . $status . '</td>
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
