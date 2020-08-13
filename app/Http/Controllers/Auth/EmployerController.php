<?php

namespace App\Http\Controllers\Auth;

use App\Model\Employer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class EmployerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Employer Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
    {
        switch(Auth::user()->role){
            case 1:
                $this->redirectTo = '/generalmanager';
                return $this->redirectTo;
                break;
            case 2:
                    $this->redirectTo = '/admin';
                return $this->redirectTo;
                break;
            case 3:
                $this->redirectTo = '/collector';
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/employer/login';
                return $this->redirectTo;
        }
         
        // return $next($request);
    } 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }
}
