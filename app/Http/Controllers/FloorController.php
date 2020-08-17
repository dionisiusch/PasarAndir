<?php

namespace App\Http\Controllers;

use App\Model\Floor;
use App\Model\Area;
use Illuminate\Http\Request;
use App\Http\Services\FloorService;
use App\Http\Services\AreaService;
use GuzzleHttp\Client;

class FloorController extends Controller
{
    /** @var FloorService */
    private $floorService;

    /** @var FloorService */
    private $areaService;

    public function __construct()
    {
        $this->floorService = app(FloorService::class);
        $this->areaService = app(AreaService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = $this->floorService->showAllFloors();
        // return view('floors.index', compact('floors')); 
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
            'code'=>'required',
            'name'=>'required'
        ]);

        $response = $this->floorService->createFloor($request);

        // return redirect('/floors')->with('success', 'Floor has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $floor = $this->floorService->getFloorById($id);

        // return view('floors.show', compact('floor')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function edit(Floor $floor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required',
            'name'=>'required'
        ]);

        $response = $this->floorService->updateFloorById($request, $id);

        // return redirect('/floors')->with('success', 'Floor has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->floorService->deleteFloorById($id);

        // DO NOT DELETE IT
        // $areaIdsWithFloorDeleted = Area::where('floor_id', $id)->pluck('id')->toArray();

        // foreach($areaIdsWithFloorDeleted as $areaId) {
        //     $r = $this->areaService->deleteAreaById($areaId);
        // }

        // return redirect('/floors')->with('success', 'Floor has been deleted');
    }
}