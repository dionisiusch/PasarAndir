<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\Stall;
use App\Model\Floor;
use App\Model\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\UserService;
use App\Http\Services\StallService;
use App\Http\Services\FloorService;
use App\Http\Services\AreaService;
use GuzzleHttp\Client;
use DB;

class UserController extends Controller
{
    /** @var userService */
    private $userService;

    /** @var areaService */
    private $areaService;

    /** @var stallService */
    private $stallService;

    /** @var floorService */
    private $floorService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
        $this->stallService = app(StallService::class);
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
        $users = $this->userService->showAllUsers();

        return view('master.user.userShow');
    }

    public function billing()
    {
        return view('userbilling');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $user = $this->userService->getUserById($id);

            $data = array(
                'joined_date'  => $user->joined_date,
                'pic_phone_number'  => $user->pic_phone_number,
                'pic_name'  => $user->pic_name,
                'password'  => $user->password,
                'username'  => $user->username,
                'id'  => $id
            );

            return json_encode($data);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'old_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = $this->userService->getUserById(Auth::guard('web')->id());

            if (Hash::make($user->password) != Hash::make($request->old_password)) {
                // return redirect('/password')->with('error', 'Password User Gagal Di Ubah.'); 
            }

            $response = $this->userService->updateUserPasswordById($request->new_password, Auth::guard('web')->id());

            // return redirect('/password')->with('success', 'Password User Berhasil Di Ubah.');       
        } catch (Exception $e) {
            // return redirect('/password')->with('error', 'Password User Gagal Di Ubah.');       
        }
    }

    public function updatePIC(Request $request, $id)
    {
        try {
            $request->validate([
                'pic_name' => 'required',
                'pic_phone_number' => 'required',
                'joined_date' => 'required'
            ]);

            $response = $this->userService->updatePICUserById($request, $id);

            return redirect('/master/user')->with('success', 'Data PIC User Berhasil Di Update.');
        } catch (Exception $e) {
            return redirect('/master/user')->with('success', 'Data PIC User Gagal Di Update.');
        }
    }

    public function updateAuth(Request $request, $id)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $response = $this->userService->updateAuthUserById($request, $id);

            return redirect('/master/user')->with('success', 'Otentikasi User Berhasil Di Update.');
        } catch (Exception $e) {
            return redirect('/master/user')->with('success', 'Otentikasi User Gagal Di Update.');
        }
    }

    public function getStallByUserId(Request $request)
    {
        if ($request->ajax()) {
            $text = "";
            $stall_arr = array();
            $id = $request->get('id');
            $stalls_id = $this->stallService->getStallIdByUserId($id);
            foreach ($stalls_id as $stall_id) {
                $stall = $this->stallService->getStallById($stall_id);
                $area = $this->areaService->getAreaById($stall->area_id);
                $floor = $this->floorService->getFloorById($area->floor_id);
                if ($stall->status == "Aktif") {
                    $status = "<h4><span class='badge badge-success'>Aktif</span></h4>";
                } else {
                    $status = "<h4><span class='badge badge-danger'>Tidak Aktif</span></h4>";
                }
                $area_name = "[" . $floor->name . "] " . " Blok " . $area->name . " No. " . $area->no;
                $text .= "<tr><td style='font-weight: bold'>" . $area_name . "</td><td style='font-weight: bold'>" . $stall->name . "</td><td>" . $status . "</td></tr>";
                $data = array('area_name' => $area_name, 'stall_name' => $stall->name, 'stall_id' => $stall->id);
                array_push($stall_arr, $data);
            }
            $output = array(
                'text' => $text,
                'stall' => $stall_arr
            );
            return json_encode($output);
        }
    }

    public function resetPassword($id)
    {
        $password = Str::random(15);

        try {
            $response = $this->userService->resetPasswordUserById($id, $password);

            return redirect('/master/user')->with('success', 'Password Baru ' . $password);
        } catch (Exception $e) {
            return redirect('/master/user')->with('success', 'Reset Password Gagal');
        }
    }

    public function resetToDefault($id)
    {
        try {
            $response = $this->userService->resetToDefaultUserById($id);

            return ('User telah dikembalikan ke default. ');
        } catch (Exception $e) {
            return ('User gagal dikembalikan ke default. ');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = $this->userService->searchUser($query);
            } else {
                $data = $this->userService->showAllUsers();
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="tr-shadow">
                        <td>' . $row->username . '</td>
                        <td>
                        ' . $row->pic_name . '
                        </td>
                         <td>
                        ' . $row->pic_phone_number . '
                        </td>
                         <td>
                        ' . $row->joined_date . '
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
            $users = $this->userService->searchUser($search);
        } else {
            $users = $this->userService->showAllUsers();
        }

        $response = array();

        foreach ($users as $user) {
            $response[] = array(
                "id" => $user->id,
                "text" => $user->pic_name
            );
        }

        echo json_encode($response);
    }
}
