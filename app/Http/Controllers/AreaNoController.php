<?php

namespace App\Http\Controllers;

use App\Model\AreaNo;
use App\Model\Area;
use App\Model\No;
use Illuminate\Http\Request;
use App\Http\Services\AreaNoService;
use App\Http\Services\AreaService;
use App\Http\Services\noService;
use GuzzleHttp\Client;

class AreaNoController extends Controller
{
    /** @var AreaNoService */
    private $areaNoService;

    /** @var AreaService */
    private $areaService;

    /** @var NoService */
    private $noService;

    public function __construct()
    {
        $this->areaNoService = app(AreaNoService::class);
        $this->areaService = app(AreaService::class);
        $this->noService = app(NoService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areaNos = $this->areaNoService->showAllAreaNos();
        $areas = $this->areaService->showAllAreas();
        $nos = $this->noService->showAllNos();

        // return view('areaNos.index', compact('areaNos', 'areas', 'nos')); 
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
            'area_id'=>'required',
            'no_id'=>'required'
        ]);

        $response = $this->areaNoService->createAreaNo($request);

        // return redirect('/areanos')->with('success', 'AreaNo has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\AreaNo  $areaNo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $areaNo = $this->areaNoService->getAreaNoById($id);
        $area = $this->areaService->getAreaById($id);
        $no = $this->noService->getNoById($id);

        // return view('areaNos.show', compact('areaNo', 'area', 'no')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\AreaNo  $areaNo
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaNo $areaNo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AreaNo  $areaNo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'area_id'=>'required',
            'no_id'=>'required'
        ]);

        $response = $this->areaNoService->updateAreaNoById($request, $id);

        // return redirect('/areanos')->with('success', 'AreaNo has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AreaNo  $areaNo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->areaNoService->deleteAreaNoById($id);

        // return redirect('/areanos')->with('success', 'AreaNo has been deleted');
    }
}
