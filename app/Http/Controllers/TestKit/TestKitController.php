<?php

namespace App\Http\Controllers\TestKit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\TestKitService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class TestKitController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllTestKit');        
       
    }
    //View TestKit main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('testkit.index');
        }
        else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    //Add TestKit (display add screen and add the TestKit values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addTestKit = new TestKitService();
            $result = $addTestKit->saveTestKit($request);
            return Redirect::route('testkit.index')->with('status', $result);
        }
        else
        {
            
            return view('testkit.add');
        }
    }

    // Get all the test site list
    public function getAllTestKit(Request $request)
    {
        $service = new TestKitService();
        $data = $service->getAllTestKit();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\TestKit\\TestKitController']['edit']) && ($role['App\\Http\\Controllers\\TestKit\\TestKitController']['edit'] == "allow")){
                        $button .= '<a href="/testkit/edit/'. base64_encode($data->tk_id).'" name="edit" id="'.$data->tk_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        return $button . '</div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit test site
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $TestKitService = new TestKitService();
            $edit = $TestKitService->updateTestKit($request,$id);
            return Redirect::route('testkit.index')->with('status', $edit);
        }
        else
        {
            $TestKitService = new TestKitService();
            $result = $TestKitService->getTestKitById($id);
            return view('testkit.edit',array('result'=>$result,'id'=>$id));
        }
    }
}

