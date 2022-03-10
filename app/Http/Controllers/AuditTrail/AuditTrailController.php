<?php

namespace App\Http\Controllers\AuditTrail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\AuditTrailService;
use App\Service\UserService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class AuditTrailController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllAuditData');        
       
    }
    //View Audit Trail main screen
    public function index()
    {
        if(session('login')==true)
        {
            $userService = new UserService();
            $userData = $userService->getAllActiveUser();
            return view('audittrail.index',array('userName' => $userData));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Get all the  Audit Trail list
    public function getAllAuditData(Request $request)
    {
        $datas = $request->all();
        $service = new AuditTrailService();
        $data = $service->getAllAudit($datas);
        return DataTables::of($data)
            ->make(true);
    }
}

