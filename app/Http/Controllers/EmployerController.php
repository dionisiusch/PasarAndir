<?php

namespace App\Http\Controllers;

use App\Employer;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Services\EmployerService;
use App\Http\Services\RoleService;


class EmployerController extends Controller
{
    /** @var EmployerService */
    private $employerService;

    /** @var RoleService */
    private $roleService;

    public function __construct()
    {
        $this->employerService = app(EmployerService::class);
        $this->roleService = app(RoleService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employers = $this->employerService->showAllEmployers();

        return view('master.employer.employerShow');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function show(Employer $employer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function edit(Employer $employer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employer $employer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employer $employer)
    {
        //
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->employerService->searchEmployer($query);
            } else {
                $data = $this->employerService->showAllEmployers();
            }
         
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $role = $this->roleService->getRoleById($row->role_id);
                    if($role->id==1){
                        $role_text = "<span class='badge badge-success'>".$role->name."</span>";
                    }else if($role->id==2){
                        $role_text = "<span class='badge badge-warning'>".$role->name."</span>";
                    }else{
                        $role_text = "<span class='badge badge-danger'>".$role->name."</span>";
                    }
                    $output .= '
                    <tr class="tr-shadow">
                        <td>'.$row->username.'</td>
                        <td>
                        '.$row->name.'
                        </td>
                         <td>
                        '.$row->phone_number.'
                        </td>
                         <td>
                        '.$row->email.'
                        </td>
                         <td>
                        '.$role_text.'
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
            $employers = $this->employerService->searchEmployer($search);
        }else{
            $employers = $this->employerService->showAllEmployers();
        }

        $response = array();

        foreach($employers as $employer){
            $response[] = array(
                "id"=>$employer->id,
                "text"=>$employer->name
            );
        }
           
        echo json_encode($response);
    }
}
