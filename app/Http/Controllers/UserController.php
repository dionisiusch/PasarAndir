<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use GuzzleHttp\Client;
use DB;

class UserController extends Controller
{
    /** @var userService */
    private $userService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
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

    public function updatePIC(Request $request, $id)
    {
        try {
            $request->validate([
                'pic_name'=>'required',
                'pic_phone_number'=>'required',
                'joined_date'=>'required'
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
                'username'=>'required',
                'password'=>'required'
            ]);
    
            $response = $this->userService->updateAuthUserById($request, $id);
    
            return redirect('/master/user')->with('success', 'Otentikasi User Berhasil Di Update.');
        } catch (Exception $e) {
            return redirect('/master/user')->with('success', 'Otentikasi User Gagal Di Update.');
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
    
            return('User telah dikembalikan ke default. ');
        } catch (Exception $e) {
            return ('User gagal dikembalikan ke default. ');
        }
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->userService->searchUser($query);
            } else {
                $data = DB::table('users')
                ->get();
            }
         
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $output .= '
                    <tr class="tr-shadow">
                        <td>'.$row->username.'</td>
                        <td>
                        '.$row->pic_name.'
                        </td>
                         <td>
                        '.$row->pic_phone_number.'
                        </td>
                         <td>
                        '.$row->joined_date.'
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
         $users = $this->userService->searchUser($search);
      }else{
         $users = DB::table('users')
         ->get();
      }

      $response = array();

      foreach($users as $user){
         $response[] = array(
              "id"=>$user->id,
              "text"=>$user->pic_name
         );
      }
        
      echo json_encode($response);
   }
}