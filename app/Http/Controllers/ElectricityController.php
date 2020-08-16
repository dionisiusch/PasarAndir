<?php

namespace App\Http\Controllers;

use App\Model\Electricity;
use Illuminate\Http\Request;
use App\Http\Services\ElectricityService;
use GuzzleHttp\Client;

class ElectricityController extends Controller
{
    /** @var ElectricityService */
    private $electricityService;

    public function __construct()
    {
        $this->electricityService = app(ElectricityService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $electricities = $this->electricityService->showAllElectricities();

        // return view('electricities.index', compact('electricities')); 
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
            'name'=>'required',
            'type'=>'required',
            'value'=>'required',
            'price'=>'required',
        ]);

        $response = $this->electricityService->createElectricity($request);

        // return redirect('/electricities')->with('success', 'Electricities has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $electricity = $this->electricityService->getElectricityById($id);

        // return view('electricities.show', compact('electricity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function edit(Electricity $electricity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'value'=>'required',
            'price'=>'required',
        ]);

        $response = $this->electricityService->updateElectricityById($request, $id);

        // return redirect('/electricities')->with('success', 'Electricity has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->electricityService->deleteElectricityById($id);

        // return redirect('/electricities')->with('success', 'Electricity has been deleted');
    }
}
