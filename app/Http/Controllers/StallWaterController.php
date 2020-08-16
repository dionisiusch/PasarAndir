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

        // return view('stallwaters.index', compact('stallWaters')); 
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
        $request->validate([
            'stall_id'=>'required',
            'meter_before'=>'required',
            'meter_after'=>'required',
        ]);

        $response = $this->stallWaterService->createStallWater($request);

        // return redirect('/stallwaters')->with('success', 'Stall Water has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\StallWater  $stallWater
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stallWater = $this->stallWaterService->getStallWaterById($id);

        // return view('stallwaters.show', compact('stallWater'));
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
        $request->validate([
            'stall_id'=>'required',
            'meter_before'=>'required',
            'meter_after'=>'required',
        ]);

        $response = $this->stallWaterService->updateStallWaterById($request, $id);

        // return redirect('/stallwaters')->with('success', 'Stall Water has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\StallWater  $stallWater
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->stallWaterService->deleteStallWaterById($id);

        // return redirect('/stallwaters')->with('success', 'Stall Water has been deleted');
    }
}
