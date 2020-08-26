<?php

namespace App\Http\Controllers;

use App\Model\Floor;
use App\Model\Area;
use Illuminate\Http\Request;
use App\Http\Services\FloorService;
use App\Http\Services\AreaService;
use GuzzleHttp\Client;
use DB;

class FloorController extends Controller
{
  /** @var FloorService */
  private $floorService;

  /** @var AreaService */
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
    return view('master.floor.floorShow'); 
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
    try {
      $request->validate([
        'code'=>'required',
        'name'=>'required'
      ]);
  
      $response = $this->floorService->createFloor($request);
      return redirect('/master/floor')->with('success', 'Data Lantai Berhasil Ditambahkan.');           
    } catch (Exception $e) {
      return redirect('/master/floor')->with('error', 'Data Lantai Gagal Ditambahkan.');           
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Model\Floor  $floor
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request)
  {
    if($request->ajax()) {
      $id = $request->get('id');
      $floor = $this->floorService->getFloorById($id);

      $data = array(
      'code'  => $floor->code,
      'name'  => $floor->name,
      'id'  => $id
      );
      
      return json_encode($data);
    }
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
    try {
      $request->validate([
        'code'=>'required',
        'name'=>'required'
      ]);
  
      $response = $this->floorService->updateFloorById($request, $id);
  
      return redirect('/master/floor')->with('success', 'Data Lantai Berhasil Di Update.');            
    } catch (Exception $e) {
      return redirect('/master/floor')->with('error', 'Data Lantai Gagal Di Update.');            
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\Floor  $floor
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $msg = 'Data Lantai Gagal Dihapus.';
    $response = $this->floorService->deleteFloorById($id);
    //$response = $this->floorService->deleteFloorById($id);

    // DO NOT DELETE IT
    // $areaIdsWithFloorDeleted = Area::where('floor_id', $id)->pluck('id')->toArray();

    // foreach($areaIdsWithFloorDeleted as $areaId) {
    //     $r = $this->areaService->deleteAreaById($areaId);
    // }

    if($response){
      $msg = 'Data Lantai Berhasil Dihapus.';
    
    return $msg;

    // DO NOT DELETE IT
    // $areaIdsWithFloorDeleted = Area::where('floor_id', $id)->pluck('id')->toArray();

    // foreach($areaIdsWithFloorDeleted as $areaId) {
    //     $r = $this->areaService->deleteAreaById($areaId);
    // }

    // return redirect('/floors')->with('success', 'Floor has been deleted');
   }
  }   

  public function search(Request $request)
  {
    if($request->ajax()) {
      $output = '';
      $query = $request->get('query');
      if($query != '') {
				$data = $this->floorService->searchFloor($query);
     	} else {
      	$data = $this->floorService->showAllFloors();
    
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

  public function select2(Request $request){
     $search = $request->search;

      if($search != ''){
         $floors = $this->floorService->searchFloor($search);
      }else{
         $floors = $this->floorService->showAllFloors();
      }

      $response = array();
      // $preselect = '';
      foreach($floors as $floor){
         $response[] = array(
              "id"=>$floor->id,
              "text"=>$floor->name
         );
         // $preselect.='<option value="'.$floor->id.'"> '.$floor->name.'</option>';
      }
       // $response['option'] = $preselect; 
      echo json_encode($response);
   }
}
