<?php
/*

Date : 27 May 2021
Desc : Controller for Login screen
*/

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;
use DB;
use App\Service\CommonService;
use Redirect;
use Session;

class LoginController extends Controller
{
    //View Login main screen
    public function index()
    {
        $addUser = new UserService();
        $activeUsers = $addUser->getAllActiveUser();
        $activeUsersCount = $activeUsers->count();
        if ($activeUsersCount > 0) {
            return view('login.index');
        } else {
            return view('login.register');
        }
    }


    //validate login
    public function validateEmployee(Request $request)
    {
        $service = new UserService();
        $login = $service->validateLogin($request);

        if (trim($login) == 1) {
            if (session('forcePasswordReset') == '1') {
                return view('login.changepassword');
            }
            return Redirect::to('/dashboard');
        } else {
            return Redirect::route('login.index')->with('status', 'Please check your login credentials');
        }
    }


    //Logout
    public function logout(Request $request, $name)
    {
        $commonservice = new CommonService();
        //$data=new Array();
        $data['username'] = $name;
        $userservice = new UserService();
        if ($request->isMethod('post') && session('login') == true) {
            $commonservice->eventLog('log-out', base64_decode($name) . ' logged out', 'user', $id = null);
            $userservice->loggedInHistory($data, base64_decode($name) . ' logged out');
            $request->session()->flush();
            $request->session()->regenerate();
            Session::flush();
            return Redirect::to('/login'); // redirect the user to the login screen
        } else {
            if (session('login') == null) {
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

        if ($request->isMethod('post')) {

            $service = new UserService();
            $resetPassword = $service->resetPassword($request);
            if ($resetPassword != '0') {

                return Redirect::route('login.index')->with('status', 'Password changed successfully');
            } else {
                return Redirect::route('login.index')->with('status', 'Your account is inactive, Please contact admin.');
            }
        } else {
            return view('login.resetPassword');
        }
    }

    public function profile()
    {
        return view('login.profile');
    }
}
