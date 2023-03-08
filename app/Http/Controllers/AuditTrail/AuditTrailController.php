<?php

namespace App\Http\Controllers\AuditTrail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\AuditTrailService;
use App\Service\UserService;
use App\Service\TestSiteService;
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
    public function index(Request $request)
    {
        $userService = new UserService();
        $TestSiteService = new TestSiteService();
        $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
        $userData = $userService->getAllActiveUser();
        if ($request->isMethod('post')) {
           //echo '<pre>'; print_r($request['testsiteId']); die;
            $auditTrail = new AuditTrailService();
            $result = $auditTrail->getAllAudit($request);
            return view('audittrail.index',array('userName' => $userData,'testSite' => $testSite,'result' => $result,'params' => $request));
        }
        else
        {
            return view('audittrail.index',array('userName' => $userData,'testSite' => $testSite));
               // return Redirect::to('login')->with('status', 'Please Login');
        }
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

