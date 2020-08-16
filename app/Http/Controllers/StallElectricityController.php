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

        // return view('stallelectricities.index', compact('stallElectricities')); 
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
        $request->validate([
            'stall_id'=>'required',
            'electricity_id'=>'required',
            'meter_before'=>'required',
            'meter_after'=>'required',
        ]);

        $response = $this->stallElectricityService->createStallElectricity($request);

        // return redirect('/stallelectricities')->with('success', 'Stall Electricity has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\StallElectricity  $stallElectricity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stallElectricity = $this->stallElectricityService->getStallElectricityById($id);

        // return view('stallelectricities.show', compact('stallElectricity'));
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
        $request->validate([
            'stall_id'=>'required',
            'electricity_id'=>'required',
            'meter_before'=>'required',
            'meter_after'=>'required',
        ]);

        $response = $this->stallElectricityService->updateStallElectricityById($request, $id);

        // return redirect('/stallelectricities')->with('success', 'Stall Electricity has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\StallElectricity  $stallElectricity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->stallElectricityService->deleteStallElectricityById($id);

        // return redirect('/stallelectricities')->with('success', 'Stall Electricity has been deleted');
    }
}
