<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\CommonService;
use Redirect;

class CommonController extends Controller
{
    //
    public function duplicateValidation(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->duplicateValidation($request);
    }
    public function mobileDuplicateValidation(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->mobileDuplicateValidation($request);
    }

    public function checkMobileValidation(Request $request){
        $commonService = new CommonService();
        return $commonService->checkMobileValidation($request); 
    }
    public function checkNameValidation(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->checkNameValidation($request);
    }
    
    public function changeStatus(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->changeStatus($request);
    }
    
    public function addNewField(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->addNewField($request);
    }
    
    public function addNewUnitField(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->addNewUnitField($request);
    }
    
    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|confirmed',
            ]);

            $service = new CommonService();
            $pswd = $service->updatePassword($request);
            if($pswd==1){
                return Redirect::to('/dashboard')->withErrors(['msg' => 'Password Changed Succesfully']);
               
            }else{
                return view('login.changepassword',array('status'=>'Your new password is too similar to your current password. Please try another password.'));
            }
        }
        else
        {
            return view('login.changepassword');
        }
    }
    
    public function addNewBranchType(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->addNewBranchType($request);
    }
    
    public function checkItemNameValidation(Request $request)
    {
        $commonService = new CommonService();
        return $commonService->checkItemNameValidation($request);
    }
}
