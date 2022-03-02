<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\FacilityService;
use App\Service\ProvinceService;
use App\Service\DistrictService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class FacilityController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllFacility');        
       
    }
    //View Facility main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('facility.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Facility (display add screen and add the Facility values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addFacility = new FacilityService();
            $result = $addFacility->saveFacility($request);
            return Redirect::route('facility.index')->with('status', $result);
        }
        else
        {
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            return view('facility.add',array('province'=>$province));
        }
    }

    // Get all the facility list
    public function getAllFacility(Request $request)
    {
        $service = new FacilityService();
        $data = $service->getAllFacility();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Facility\\FacilityController']['edit']) && ($role['App\\Http\\Controllers\\Facility\\FacilityController']['edit'] == "allow")){
                        $button .= '<a href="/facility/edit/'. base64_encode($data->facility_id).'" name="edit" id="'.$data->facility_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit facility
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $FacilityService = new FacilityService();
            $edit = $FacilityService->updateFacility($request,$id);
            return Redirect::route('facility.index')->with('status', $edit);
        }
        else
        {
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $DistrictService = new DistrictService();
            $FacilityService = new FacilityService();
            $result = $FacilityService->getFacilityById($id);
            $district = $DistrictService->getDistictById($result);
            return view('facility.edit',array('result'=>$result,'id'=>$id,'province'=>$province,'district'=>$district));
        }
    }
}

