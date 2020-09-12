<?php

namespace App\Http\Controllers;

use App\Model\PowerMeter;
use Illuminate\Http\Request;
use App\Http\Services\PowerMeterService;
use GuzzleHttp\Client;
use DB;
use App\Http\Helpers\Helper;

class PowerMeterController extends Controller
{
    /** @var PowerMeterService */
    private $powerMeterService;

    /** @var Helper */
    private $helper;

    public function __construct()
    {
        $this->powerMeterService = app(PowerMeterService::class);
        $this->helper = app(Helper::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $powerMeters = $this->powerMeterService->showAllPowerMeters();

        return view('master.powermeter.powermeterShow');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
                'power_meter' => 'required',
                'kva_price' => 'required',
                'kwh_price' => 'required'
            ]);
            $kvaPrice = $this->helper->price_decoder($request->kva_price);
            $kwhPrice = $this->helper->price_decoder($request->kwh_price);

            $response = $this->powerMeterService->createPowerMeter($request, $kvaPrice, $kwhPrice);

            return redirect('/master/powermeter')->with('success', 'Data Watt PLN Berhasil Ditambahkan.');
        } catch (Exception $e) {
            return redirect('/master/powermeter')->with('error', 'Data Watt PLN Gagal Ditambahkan.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\PowerMeter  $powerMeter
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $powerMeter = $this->powerMeterService->getPowerMeterById($id);

            $data = array(
                'kwh_price'  => $powerMeter->kwh_price,
                'kva_price'  => $powerMeter->kva_price,
                'power_meter'  => $powerMeter->power_meter,
                'power_meter_id'  => $powerMeter->power_meter_id,
                'id'  => $id
            );

            return json_encode($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\PowerMeter  $powerMeter
     * @return \Illuminate\Http\Response
     */
    public function edit(PowerMeter $powerMeter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\PowerMeter  $powerMeter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'power_meter' => 'required',
                'kva_price' => 'required',
                'kwh_price' => 'required'
            ]);
            $kvaPrice = $this->helper->price_decoder($request->kva_price);
            $kwhPrice = $this->helper->price_decoder($request->kwh_price);

            $response = $this->powerMeterService->updatePowerMeterById($request, $id, $kvaPrice, $kwhPrice);

            return redirect('/master/powermeter')->with('success', 'Data Watt PLN Berhasil Di Update.');
        } catch (Exception $e) {
            return redirect('/master/powermeter')->with('error', 'Data Watt PLN Gagal Di Update.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\PowerMeter  $powerMeter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Watt PLN Gagal Dihapus.';
        $response = $this->powerMeterService->deletePowerMeterById($id);

        if ($response) {
            $msg = 'Data Watt PLN Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = $this->powerMeterService->searchPowerMeter($query);
            } else {
                $data = $this->powerMeterService->showAllPowerMeters();
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="tr-shadow">
                        <td>
                        ' . $row->power_meter . '
                        </td>
                        <td>
                        ' . parent::rupiah($row->kva_price) . '
                        </td>
                        <td>
                        ' . parent::rupiah($row->kwh_price) . '
                        </td>
                        <td>
                            <div class="table-data-feature">
                            <button class="item edit" data-toggle="modal" data-target="#scrollmodal-update" title="Edit" id="' . $row->id . '">
                                <i class="zmdi zmdi-edit"></i>
                            </button>
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
                    <td align="center" colspan="3">Data not found.</td>
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

    public function select2(Request $request)
    {
        $search = $request->search;

        if ($search != '') {
            $powerMeters = $this->powerMeterService->searchPowerMeter($search);
        } else {
            $powerMeters = $this->powerMeterService->showAllPowerMeters();
        }

        $response = array();

        foreach ($powerMeters as $powerMeter) {
            $response[] = array(
                "id" => $powerMeter->id,
                "text" => $powerMeter->power_meter . " W"
            );
        }

        echo json_encode($response);
    }
}
