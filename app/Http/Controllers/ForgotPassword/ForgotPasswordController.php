<?php

namespace App\Http\Controllers\ForgotPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Redirect;
use Mail;
use DB;

class ForgotPasswordController extends Controller
{
    public function sendEmailWithResetLink(Request $request)
    {
        $service = new UserService();
        $check_email_exists = $service->getUserByEmail($request->email);

        if(count($check_email_exists) <= 0)
        {
            $response = array('status' => 'error', 'message' => 'Email address does not exist');
            return json_encode($response);
        }
        return $this->sendEmailWithToken($request->email);
    }

    public function sendEmailWithToken($email)
    {
        DB::table('password_resets')->where(['email'=> $email])->delete();

        $token = Str::random(64);
  
        DB::table('password_resets')->insert([
            'email' => $email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($email){
            $message->to($email);
            $message->subject('Reset Password On '.env('APP_URL'));
        });

        $response = array('status' => 'success', 'message' => 'We have sent you a mail to reset your password');
        return json_encode($response);
    }

    public function showResetPasswordForm($token) {
        
        $password_resets = DB::table('password_resets')
                    ->where([
                    'token' => $token
                    ])
                    ->orderBy('created_at','desc')
                    ->first();

        // return view('forgotpassword.index')->with(['token' => $token, 'error' => 'Reset Link Expired!']);

        if(!$password_resets){
            return Redirect::to('/login')->with(['status' => 'Reset Link Expired!']);
        }

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $password_resets->created_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());

        if($to->diffInHours($from) >= 24){
            return Redirect::to('/login')->with(['status' => 'Reset Link Expired!']);
        }

        return view('forgotpassword.index', ['token' => $token]);
    }
 
     /**
      * Write code on Method
      *
      * @return response()
      */
     public function submitResetPasswordForm(Request $request)
     {
         $request->validate([
             'password' => 'required|string|min:8|confirmed',
             'password_confirmation' => 'required'
         ]);
 
         $findinfo = DB::table('password_resets')
                             ->where([
                               'token' => $request->token
                             ])
                             ->orderBy('created_at','desc')
                             ->first();
 
         if(!$findinfo){
             return back()->withInput()->with('error', 'Reset Link is already expired!');
         }

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $findinfo->created_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());

        if($to->diffInHours($from) >= 24)
        {
            return back()->withInput()->with('error', 'Reset Link Expired!');
        }
 
         $service = new UserService();
         $response = $service->resetForgotPassword($findinfo->email, $request->password);

         if($response != 1)
         {
            return back()->withInput()->with('error', 'Failed to change password. Please try again later');
         }

         DB::table('password_resets')->where(['email'=> $findinfo->email])->delete();
 
         return redirect('/login')->with('success', 'Your password has been changed!');
     }
}
