<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employer;
use Illuminate\Support\Facades\Hash;

class EmployerRegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'username' => ['required', 'string', 'max:50', 'unique:employers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:employers'],
            'phone_number' => ['required', 'string', 'unique:employers'],
        ]);
        
        $employer = new Employer([
            'role_id' => $request['role_id'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'name' => $request['name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
        ]);

        $employer->save();

        return redirect('/master/employer')->with('success', 'Data Employer Berhasil Ditambahkan.');
    }
}
