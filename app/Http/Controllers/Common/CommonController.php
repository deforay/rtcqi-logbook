<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\CommonService;

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
}
