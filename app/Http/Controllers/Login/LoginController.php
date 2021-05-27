<?php
/*
Author : Prasath M
Date : 27 May 2021
Desc : Controller for Login screen
*/

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;
use Redirect;
use Session;
use App\Service\CommonService;
use Mail;
class LoginController extends Controller
{
     //View Login main screen
     public function index()
     {
         return view('login.index');
     }
     //validate login
     public function validateEmployee(Request $request)
    {
            $service = new UserService();
            $login = $service->validateLogin($request);
            if(trim($login)==1)
            {
                return Redirect::to('/dashboard');
            }
            else
            { 
                return Redirect::route('login.index')->with('status', 'Login Failed');
            }
    }


    //Logout
    public function logout(Request $request){
        if($request->isMethod('post') && session('login')==true){
            $request->session()->flush();
            $request->session()->regenerate();
            
            Session::flush();
            return Redirect::to('/login'); // redirect the user to the login screen
        }else{
            if(session('login')== null){
                return Redirect::to('/login');
            }
            return redirect()->back();
        }
    }

    public function forgotPassword()
    {
        return view('login.forgotPassword');
    }
     public function validateForgotPassword(Request $request)
    {
        
            $service = new UserService();
            $pResult = $service->validateEmail($request);
            return Redirect::route('login.index')->with('status', $pResult['message']);
    }


    //reset Password
    public function resetPassword(Request $request)
    {
        
        if ($request->isMethod('post')) 
        {
            
            $service = new UserService();
            $resetPassword = $service->resetPassword($request);
            if($resetPassword!='0'){

                return Redirect::route('login.index')->with('status', 'Password changed successfully');
            }else{
                return Redirect::route('login.index')->with('status', 'Your account is inactive, Please contact admin.');
            }
        }
        else
        {
           return view('login.resetPassword');
           
        }
    }

    public function profile()
    {
        return view('login.profile');
    }
}
