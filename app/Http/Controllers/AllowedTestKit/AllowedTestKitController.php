<?php

namespace App\Http\Controllers\AllowedTestKit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\TestKitService;
use App\Service\AllowedTestKitService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class AllowedTestKitController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllAllowedTestKit');        
       
    }
    //View User Allowed Test Kit main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('allowedtestkit.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // //Add User Allowed Test Kit (display add screen and add the Allowed Test Kit values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $allowedTestKit = new AllowedTestKitService();
            $result = $allowedTestKit->saveAllowedTestKit($request);
            return Redirect::route('allowedtestkit.index')->with('status', $result);
        }
        else
        {
            $TestKitService = new TestKitService();
            $test = $TestKitService->getAllActiveTestKit();  
            return view('allowedtestkit.add',array('test'=>$test));
        }
    }

    // Get all the  AllowedTestKit list
    public function getAllAllowedTestKit(Request $request)
    {
        $service = new AllowedTestKitService();
        $data = $service->getAllAllowedKitTest();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['edit']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['edit'] == "allow")){
                        $button .= '<a href="/allowedtestkit/edit/'. base64_encode($data->test_kit_no).'" name="edit" id="'.$data->test_kit_no.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit AllowedTestKit
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $allowedTestKitservice = new AllowedTestKitService();
            $edit = $allowedTestKitservice->updateAllowedTestKit($request,$id);
            return Redirect::route('allowedtestkit.index')->with('status', $edit);
        }
        else
        {
            $TestKitService = new TestKitService();
            $test = $TestKitService->getAllActiveTestKit();  
            $allowedTestKitservice = new AllowedTestKitService();
            $result = $allowedTestKitservice->getAllowedKitTestByValue($id);
            // dd($result);die;

            $testKitId = array(); 
            foreach($result as $value) {
                array_push($testKitId,$value->testkit_id);
            }
            // dd($testKitId);die;
            return view('allowedtestkit.edit',array('result'=>$result,'test'=>$test,'id'=>$id,'testKitId'=>$testKitId));
        }
    }
}

