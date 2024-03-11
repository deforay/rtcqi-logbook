<?php

namespace App\Http\Controllers\UserFacilityMap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;
use App\Service\UserFacilityMapService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class UserFacilityMapController extends Controller
{
    //View User Facility Map main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('userfacilitymap.index');
        }
        else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    // //Add User Facility Map (display add screen and add the User Facility Map values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addUserFacility = new UserFacilityMapService();
            $result = $addUserFacility->saveUserFacility($request);
            return Redirect::route('userfacilitymap.index')->with('status', $result);
        }
        else
        {
            $UserService = new UserService();
            $user = $UserService->getAllActiveUser();   
             
            return view('userfacilitymap.add',array('user'=>$user));
        }
    }

    // Get all the  UserFacilityMap list
    public function getAllUserFacility(Request $request)
    {
        $service = new UserFacilityMapService();
        $data = $service->getAllUserFacility();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $button .= '<a href="/userfacilitymap/edit/'. base64_encode($data->ufm_id).'" name="edit" id="'.$data->ufm_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        return $button . '</div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit UserFacilityMap
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $UserFacilityService = new UserFacilityMapService();
            $edit = $UserFacilityService->updateUserFacility($request,$id);
            return Redirect::route('userfacilitymap.index')->with('status', $edit);
        }
        else
        {
            $UserService = new UserService();
            //$FacilityService = new FacilityService();
            $user = $UserService->getAllActiveUser();   
            //$facility = $FacilityService->getAllActiveFacility(); 
            $UserFacilityService = new UserFacilityMapService();
            $result = $UserFacilityService->getUserFacilityById($id);
            //dd($result);die;
            return view('userfacilitymap.edit',array('result'=>$result,'user'=>$user,'id'=>$id));
        }
    }
}

