<?php

namespace App\Http\Services;

use App\Employer;
use DB;
use Auth;

class EmployerService
{
    public function showAllEmployers()
    {
        $employers = Employer::all()->except(Auth::guard('employer')->id());

        return $employers;
    }

    public function updateEmployerById($data, $id)
    {
        $employer = Stall::find($id);
        $employer->name = $data->get('name');
        $employer->email = $data->get('email');
        $employer->phone_number = $data->get('phone_number');
        $employer->save();

        return $employer;
    }

    public function deleteEmployerById($id)
    {
        $employer = Employer::find($id);
        $employer->delete();

        return $employer;
    }

    public function searchEmployer($query)
    {
        return DB::table('employers')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('username', 'like', '%'.$query.'%')
            ->orWhere('email', 'like', '%'.$query.'%')
            ->orWhere('phone_number', 'like', '%'.$query.'%')
            ->where('id', '!=' , Auth::guard('employer')->id())
            ->get();
    }
}
