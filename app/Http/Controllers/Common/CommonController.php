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
        $data = $commonService->duplicateValidation($request);
        return $data;
    }
    public function mobileDuplicateValidation(Request $request)
    {
        $commonService = new CommonService();
        $data = $commonService->mobileDuplicateValidation($request);
        return $data;
    }

    public function checkMobileValidation(Request $request){
        $commonService = new CommonService();
        $data = $commonService->checkMobileValidation($request);
        return $data; 
    }
    public function checkNameValidation(Request $request)
    {
        $commonService = new CommonService();
        $data = $commonService->checkNameValidation($request);
        return $data;
    }
    
    public function changeStatus(Request $request)
    {
        $commonService = new CommonService();
        $data = $commonService->changeStatus($request);
        return $data;
    }
    
    public function addNewField(Request $request)
    {
        $commonService = new CommonService();
        $data = $commonService->addNewField($request);
        return $data;
    }
    
    public function addNewUnitField(Request $request)
    {
        $commonService = new CommonService();
        $data = $commonService->addNewUnitField($request);
        return $data;
    }
    
    public function changePassword($id,Request $request)
    {
        // dd(session('loginType'));
        if ($request->isMethod('post')) 
        {
            $service = new CommonService();
            $pswd = $service->updatePassword($request,$id);
            if($pswd==1){
                return Redirect::to('/dashboard')->with('status', 'Password Changed Succesfully');
            }else{
                return view('login.changepassword',array('id'=>$id,'status'=>'Your new password is too similar to your current password. Please try another password.'));
            }
        }
        else
        {
            return view('login.changepassword',array('id'=>$id));
        }
    }
    
    public function addNewBranchType(Request $request)
    {
        $commonService = new CommonService();
        $data = $commonService->addNewBranchType($request);
        return $data;
    }
    
    public function checkItemNameValidation(Request $request)
    {
        $commonService = new CommonService();
        $data = $commonService->checkItemNameValidation($request);
        return $data;
    }
}
