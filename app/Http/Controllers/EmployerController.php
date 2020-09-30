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
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $employer = $this->employerService->getEmployerById($id);
            $role = $this->roleService->getRoleById($employer->role_id);

            $data = array(
                'email'  => $employer->email,
                'phone_number'  => $employer->phone_number,
                'name'  => $employer->name,
                'username'  => $employer->username,
                'role_name' => $role->name,
                'id'  => $id
            );

            return json_encode($data);
        }
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
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => ['required', 'email', 'unique:employers'],
                'phone_number' => ['required', 'max:13', 'unique:employers'],
            ]);

            $response = $this->employerService->updateEmployerById($request);

            // return redirect('/master/employer')->with('success', 'Data Employer Berhasil Di Update.');       
        } catch (Exception $e) {
            // return redirect('/master/employer')->with('error', 'Data Employer Gagal Di Update.');       
        }
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'old_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $employer = $this->employerService->getEmployerById($id);

            if (Hash::make($employer->password) != Hash::make($request->old_password)) {
                // return redirect('/master/employer')->with('error', 'Password Employer Gagal Di Ubah.'); 
            }

            $response = $this->employerService->updateEmployerPasswordById($request->new_password, $id);

            // return redirect('/master/employer')->with('success', 'Data Employer Berhasil Di Ubah.');       
        } catch (Exception $e) {
            // return redirect('/master/employer')->with('error', 'Data Employer Gagal Di Ubah.');       
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Employer Gagal Dihapus.';
        $response = $this->employerService->deleteEmployerById($id);

        if ($response) {
            $msg = 'Data Employer Berhasil Dihapus.';
        }

        return $msg;
    }

    public function registration()
    {
        return view('auth.registeremployer');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = $this->employerService->searchEmployer($query);
            } else {
                $data = $this->employerService->showAllEmployers();
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $role = $this->roleService->getRoleById($row->role_id);
                    if ($role->id == 1) {
                        $role_text = "<span class='badge badge-success'>" . $role->name . "</span>";
                    } else if ($role->id == 2) {
                        $role_text = "<span class='badge badge-warning'>" . $role->name . "</span>";
                    } else {
                        $role_text = "<span class='badge badge-danger'>" . $role->name . "</span>";
                    }
                    $output .= '
                    <tr class="tr-shadow">
                        <td>' . $row->username . '</td>
                        <td>
                        ' . $row->name . '
                        </td>
                         <td>
                        ' . $row->phone_number . '
                        </td>
                         <td>
                        ' . $row->email . '
                        </td>
                         <td>
                        ' . $role_text . '
                        </td>
                        <td>
                            <div class="table-data-feature">
                            <button class="item edit" data-toggle="modal" data-target="#scrollmodal-update" title="Edit" id="' . $row->id . '">
                                <i class="zmdi zmdi-edit"></i>
                            </button>
                            <button class="item delete" type="submit" data-toggle="tooltip" data-placement="top" title="Delete" id="' . $row->id . '">
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

    public function select2(Request $request)
    {
        $search = $request->search;

        if ($search != '') {
            $employers = $this->employerService->searchEmployer($search);
        } else {
            $employers = $this->employerService->showAllEmployers();
        }

        $response = array();

        foreach ($employers as $employer) {
            $response[] = array(
                "id" => $employer->id,
                "text" => $employer->name
            );
        }

        echo json_encode($response);
    }
}
