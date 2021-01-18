<?php
/*
Author : Sudarmathi M
Date : 22 June 2020
Desc : Controller for Login screen
*/

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Service\CommonService;
use App\Service\VendorsService;
use App\Service\VendorsTypeService;
use App\Service\CountriesService;
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
            if(trim($login)==1 && session('loginType')!= "vendor" && strtolower(session('roleName'))!='admin')
            {
                return Redirect::to('/inventoryoutwards');
            }
            elseif(trim($login)==1)
            {
                return Redirect::to('/dashboard');
            }
            elseif(trim($login)==2)
            { 
                return Redirect::route('login.index')->with('status', 'No Role Available, Please Contact Admin!');
            }
            
            elseif(trim($login)==3)
            { 
                $msg = array();
                $permitted_chars = '0123456789';
			    $otp_no = substr(str_shuffle($permitted_chars), 0, 6);
                $msg['msg'] =  $otp_no.' is the OTP for your Vendor login';
                session(['login_otp' => $otp_no]);
                // print_r(session('login_otp'));die;
                Mail::send('mailtemplate.email', $msg, function ($message)  {
                    $toEmail = session('email');
                    $subject = 'OTP - Procurement & Inventory Manager.';
                    $send = $message->to($toEmail, session('name'))
                                    ->subject($subject);
                });

                if (Mail::failures()) {
                    \Log::info('Mail sent failed for - '.session('userId'));
                }
                else {
                    \Log::info('Mail sent successfully - '.session('userId'));
                }
                $vendorsService = new VendorsTypeService();
                $vendorTypeResult = $vendorsService->getActiveVendorsType();
                $countryService = new CountriesService();
                $countriesResult = $countryService->getAllActiveCountries();
                $vendorsId=base64_encode(session('userId'));
                $vendorsService = new VendorsService();
                $result = $vendorsService->getVendorsById($vendorsId);
                return view('login.profile',array('vendors'=>$result,'vendors_type'=>$vendorTypeResult,'countries'=>$countriesResult,'id'=>$vendorsId));
                
            }
            else
            { 
                return Redirect::route('login.index')->with('status', 'Login Failed');
            }
    }


    //Logout
    public function logout(Request $request){
        // Auth::logout(); // log the user out of our application
        // Session::flush();
        // return Redirect::to('/'); // redirect the user to the login screen
        
        if($request->isMethod('post') && session('login')==true){
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), session('userId'), 'user-logout', 'User has been logout by', 'logout');
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
