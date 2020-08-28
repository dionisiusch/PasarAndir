<?php

namespace App\Http\Controllers;

use App\Model\Stall;
use App\User;
use App\Model\Area;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Services\StallService;
use App\Http\Services\AreaService;
use App\Http\Services\CategoryService;
use App\Http\Services\UserService;
use App\Http\Services\FloorService;
use GuzzleHttp\Client;
Use DB;

class StallController extends Controller
{
    /** @var StallService */
    private $stallService;

    /** @var AreaNoService */
    private $areaService;

    /** @var CategoryService */
    private $categoryService;

    /** @var userService */
    private $userService;

    /** @var floorService */
    private $floorService;

    public function __construct()
    {
        $this->stallService = app(StallService::class);
        $this->areaService = app(AreaService::class);
        $this->categoryService = app(CategoryService::class);
        $this->userService = app(UserService::class);
        $this->floorService = app(FloorService::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stalls = $this->stallService->showAllStalls();
        $areas = $this->areaService->showAllAreas();
        $categories = $this->categoryService->showAllCategories();

        return view('master.stall.stallShow');
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
                'user_id'=>'required',
                'area_id'=>'required',
                'category_id'=>'required',
                'name'=>'required',
                'length'=>'required',
                'width'=>'required',
                'height'=>'required',
                'status'=>'required'
            ]);
    
            $response = $this->stallService->createStall($request);
    
            return redirect('/master/stall')->with('success', 'Data Kios Berhasil Ditambahkan.');       
        } catch (Exception $e) {
            return redirect('/master/stall')->with('success', 'Data Kios Gagal Ditambahkan.');       
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $stall = $this->stallService->getStallById($id);
            $category = $this->categoryService->getCategoryById($stall->category_id);
            $user = $this->userService->getUserById($stall->user_id);
            $area = $this->areaService->getAreaById($stall->area_id);
            $floor = $this->floorService->getFloorById($area->floor_id);
      
            $data = array(
                'floor_name'  => $floor->name,
                'floor_id'  => $floor->id,
                'pic_name'  => $user->pic_name,
                'user_id'  => $user->id,
                'area_name'  => $area->name,
                'area_id'  => $area->id,
                'area_no'  => $area->no,
                'category_name'  =>$category->name,
                'category_id'  =>$category->id,
                'height'  => $stall->height,
                'width'  => $stall->width,
                'length'  => $stall->length,
                'name'  => $stall->name,
                'status'  => $stall->status,
                'id'  => $id
            );
            
            return json_encode($data);
        }
        // return view('stalls.show', compact('stall')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function edit(Stall $stall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id'=>'required',
                'area_id'=>'required',
                'category_id'=>'required',
                'name'=>'required',
                'length'=>'required',
                'width'=>'required',
                'height'=>'required',
                'status'=>'required'
            ]);
    
            $response = $this->stallService->updateStallById($request, $id);
    
            return redirect('/master/stall')->with('success', 'Data Kios Berhasil Di Update.');
        } catch (Exception $e) {
            return redirect('/master/stall')->with('success', 'Data Kios Gagal Di Update.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Kios Gagal Dihapus.';
        $response = $this->stallService->deleteStallById($id);

        if($response){
            $msg = 'Data Kios Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->stallService->searchStall($query);
            } else {
                $data = $this->stallService->showAllStalls();
            }
         
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $user = $this->userService->getUserById($row->user_id);
                    $area = $this->areaService->getAreaById($row->area_id);
                    $category = $this->categoryService->getCategoryById($row->category_id);
                    $floor = $this->floorService->getFloorById($area->floor_id);
                    // $user = $this->userService->getUserById($area->user_id);
                    if($row->status=="Aktif"){
                        $status = "<h4><span class='badge badge-success'>Aktif</span></h4>";
                    }else{
                         $status = "<h4><span class='badge badge-danger'>Tidak Aktif</span></h4>";
                    }
                    $output .= '
                    <tr class="tr-shadow">
                        <td>'.$user->pic_name.'</td>
                        <td>
                        '.$floor->name.' Blok
                        '.$area->name.' No.
                        '.$area->no.'
                        </td>
                        <td>'.$category->name.'</td>
                        <td>'.$row->name.'</td>
                        <td>'.$row->width.'</td>
                        <td>'.$row->length.'</td>
                        <td>'.$row->height.'</td>
                        <td>'.$status.'</td>
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
         $stalls = $this->stallService->searchStall($search);
      }else{
         $stalls = $this->stallService->showAllStalls();
      }

      $response = array();
      // $preselect = '';
      foreach($stalls as $stall){
        $area = $this->areaService->getAreaById($stall->area_id);
        $floor = $this->floorService->getFloorById($area->floor_id);

        $output = $floor->name . " Blok " . $area->name . " No. " . $area->no . " | " . $stall->name;

         $response[] = array(
              "id"=>$stall->id,
              "text"=>$output
         );
         // $preselect.='<option value="'.$floor->id.'"> '.$floor->name.'</option>';
      }
       // $response['option'] = $preselect; 
      echo json_encode($response);
   }
}
