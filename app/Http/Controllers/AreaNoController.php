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

        // return view('master.areaNo.areaNoShow');
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

        // return redirect('/master/areano')->with('success', 'Data Area Nomor Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\AreaNo  $areaNo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $areaNo = $this->areaNoService->getAreaNoById($id);
            $area = $this->areaService->getAreaById($areaNo->area_id);
            $no = $this->noService->getNoById($areaNo->no_id);
      
            $data = array(
                'no' => $no->no,
                'area_name' => $area->name,
                'id'  => $id
            );
            
            return json_encode($data);
        }
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

        // return redirect('/master/areano')->with('success', 'Data Area Nomor Berhasil Di Update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AreaNo  $areaNo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Area Nomor Gagal Dihapus.';
        $response = $this->areaNoService->deleteAreaNoById($id);

        if($response){
            $msg = 'Data Area Nomor Kios Berhasil Dihapus.';
        }

        return $msg;
    }

    # NO AJAX ON THIS CONTROLLER, USE AREA AND NO AJAX INSTEAD
}
