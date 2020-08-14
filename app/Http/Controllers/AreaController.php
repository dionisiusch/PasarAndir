<?php

namespace App\Http\Controllers;

use App\Model\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /** @var AreaService */
    private $areaService;

    /** @var FloorService */
    private $floorService;

    public function __construct()
    {
        $this->areaService = app(AreaService::class);
        $this->floorService = app(FloorService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = $this->areaService->showAllAreas();
        $floors = $this->floorService->showAllFloors();

        // return view('areas.index', compact('areas', 'floors')); 
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
            'floor_id'=>'required',
            'name'=>'required',
            'price'=>'required'
        ]);

        $response = $this->areaService->createArea($request);

        // return redirect('/areas')->with('success', 'Area has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = $this->areaService->getAreaById($id);
        $floor = $this->floorService->getFloorById($id);

        // return view('areas.show', compact('area', 'floor')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'floor_id'=>'required',
            'name'=>'required',
            'price'=>'required'
        ]);

        $response = $this->areaService->updateAreaById($request, $id);

        // return redirect('/areas')->with('success', 'Area has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $response = $this->areaService->deleteAreaById($id);

        // return redirect('/areas')->with('success', 'Area has been deleted');
    }
}
