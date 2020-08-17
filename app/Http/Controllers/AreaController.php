<?php

namespace App\Http\Controllers;

use App\Model\Area;
use Illuminate\Http\Request;
use App\Http\Services\AreaService;
use App\Http\Services\FloorService;
use GuzzleHttp\Client;

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

        // return view('master.area.areaShow');
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

        // return redirect('/master/areas')->with('success', 'Data Area Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $area = $this->areaService->getAreaById($id);
            $floor = $this->floorService->getFloorById($area->floor_id);
      
            $data = array(
                'floor_code' => $floor->code,
                'floor_name' => $floor->name,
                'price' => $area->price,
                'name'  => $area->name,
                'id'  => $id
            );
            
            return json_encode($data);
        }
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

        // return redirect('/master/areas')->with('success', 'Data Area Berhasil Di Update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Area Gagal Dihapus.';
        $response = $this->areaService->deleteAreaById($id);

        if($response){
            $msg = 'Data Area Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->areaService->searchArea($query);
            } else {
                $data = DB::table('areas')
                ->get();
            }
         
            $total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
                    $output .= '
					<tr class="tr-shadow">
						<td>'.$row->code.'</td>
						<td>
						'.$row->name.'
						</td>
						<td>
							<div class="table-data-feature">
							<button class="item edit" data-toggle="modal" data-target="#scrollmodal-update" title="Edit" id="'.$row->id.'">
								<i class="zmdi zmdi-edit"></i>
							</button>
							<button class="item delete" type="submit" data-toggle="tooltip" data-placement="top" title="Delete" id="'.$row->id.'">
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
}
