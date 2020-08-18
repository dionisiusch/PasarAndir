<?php

namespace App\Http\Controllers;

use App\Model\Stall;
use App\Model\StallWater;
use Illuminate\Http\Request;
use App\Http\Services\StallService;
use App\Http\Services\StallWaterService;
use GuzzleHttp\Client;

class StallWaterController extends Controller
{
    /** @var StallWaterService */
    private $stallWaterService;

    /** @var StallService */
    private $stallService;

    public function __construct()
    {
        $this->stallWaterService = app(StallWaterService::class);
        $this->stallService = app(StallService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stallWaters = $this->stallWaterService->showAllStallWaters();

        // return view('master.stallwater.stallwaterShow');
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
                'stall_id'=>'required',
                'meter_before'=>'required',
                'meter_after'=>'required',
            ]);
    
            $response = $this->stallWaterService->createStallWater($request);
    
            // return redirect('/master/stallWater')->with('success', 'Data Biaya Air Kios Berhasil Ditambahkan');
        } catch (Exception $e) {
            // return redirect('/master/stallWater')->with('error', 'Data Biaya Air Kios Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\StallWater  $stallWater
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $stallWater = $this->stallWaterService->getStallWaterById($id);
            $stall = $this->stallService->getStallById($stallWater->stall_id);
      
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
     * @param  \App\Model\StallWater  $stallWater
     * @return \Illuminate\Http\Response
     */
    public function edit(StallWater $stallWater)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\StallWater  $stallWater
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
    
            $response = $this->stallWaterService->updateStallWaterById($request, $id);
    
            // return redirect('/master/stallWater')->with('success', 'Data Biaya Air Kios Berhasil Di Ubah');
        } catch (Exception $e) {
            // return redirect('/master/stallWater')->with('error', 'Data Biaya Air Kios Gagal Di Ubah');

        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\StallWater  $stallWater
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Biaya Air Kios Gagal Dihapus.';
        $response = $this->stallWaterService->deleteStallWaterById($id);

        if($response){
            $msg = 'Data Biaya Air Kios Berhasil Dihapus.';
        }

        return $msg;
    }

    # NO AJAX IN INVOICE-RELATED CONTROLLER
}
