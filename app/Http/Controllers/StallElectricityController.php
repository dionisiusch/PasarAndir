<?php

namespace App\Http\Controllers;

use App\Model\Stall;
use App\Model\Electricity;
use App\Model\StallElectricity;
use Illuminate\Http\Request;
use App\Http\Services\ElectricityService;
use App\Http\Services\StallService;
use App\Http\Services\StallElectricityService;
use GuzzleHttp\Client;

class StallElectricityController extends Controller
{
    /** @var StallElectricityService */
    private $stallElectricityService;

    /** @var ElectricityService */
    private $electricityService;

    /** @var StallService */
    private $stallService;

    public function __construct()
    {
        $this->stallElectricityService = app(StallElectricityService::class);
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
        $stallElectricities = $this->stallElectricityService->showAllStallElectricities();

        // return view('master.stallElectricity.stallElectricityShow'); 
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
    public function store($id)
    {
        try {
            $request->validate([
                'stall_id'=>'required',
                'meter_before'=>'required',
                'meter_after'=>'required',
            ]);
    
            $response = $this->stallElectricityService->createStallElectricity($request);
    
            // return redirect('/master/stallElectricity')->with('success', 'Data Biaya Listrik Kios Berhasil Ditambahkan.');       
        } catch (Exception $e) {
            // return redirect('/master/stallElectricity')->with('error', 'Data Biaya Listrik Kios Gagal Ditambahkan.');       
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\StallElectricity  $stallElectricity
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $stallElectricity = $this->stallElectricityService->getStallElectricityById($id);
            $stall = $this->stallService->getStallById($stallElectricity->stall_id);

            $data = array(
                'meter_after' => $stallElectricity->meter_after,
                'meter_before' => $stallElectricity->meter_before,
                'stall'  => $stall,
                'id'  => $id
            );
            
            return json_encode($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\StallElectricity  $stallElectricity
     * @return \Illuminate\Http\Response
     */
    public function edit(StallElectricity $stallElectricity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\StallElectricity  $stallElectricity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'stall_id'=>'required',
                'meter_before'=>'required',
                'meter_after'=>'required',
            ]);
    
            $response = $this->stallElectricityService->updateStallElectricityById($request, $id);
    
            // return redirect('/master/stallElectricity')->with('success', 'Data Biaya Listrik Kios Berhasil Di Update.');
        } catch (Exception $e) {
            // return redirect('/master/stallElectricity')->with('error', 'Data Biaya Listrik Kios Gagal Di Update.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\StallElectricity  $stallElectricity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Biaya Listrik Kios Gagal Dihapus.';
        $response = $this->stallElectricityService->deleteStallElectricityById($id);

        if($response){
            $msg = 'Data Biaya Listrik Kios Berhasil Dihapus.';
        }

        return $msg;
    }

    # NO AJAX IN INVOICE-RELATED CONTROLLER
}
