<?php

namespace App\Http\Controllers\TestSite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\FacilityService;
use App\Service\ProvinceService;
use App\Service\DistrictService;
use App\Service\TestSiteService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class TestSiteController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllTestSite','getProvince');        
       
    }
    //View TestSite main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('testsite.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add TestSite (display add screen and add the TestSite values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addTestSite = new TestSiteService();
            $result = $addTestSite->saveTestSite($request);
            return Redirect::route('testsite.index')->with('status', $result);
        }
        else
        {
            $FacilityService = new FacilityService();  
            $facility = $FacilityService->getAllActiveFacility();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            return view('testsite.add',array('facility'=>$facility,'province'=>$province));
        }
    }

    // Get all the test site list
    public function getAllTestSite(Request $request)
    {
        $service = new TestSiteService();
        $data = $service->getAllTestSite();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['edit']) && ($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['edit'] == "allow")){
                        $button .= '<a href="/testsite/edit/'. base64_encode($data->ts_id).'" name="edit" id="'.$data->ts_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit test site
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $TestSiteService = new TestSiteService();
            $edit = $TestSiteService->updateTestSite($request,$id);
            return Redirect::route('testsite.index')->with('status', $edit);
        }
        else
        {
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $DistrictService = new DistrictService();
            $FacilityService = new FacilityService();  
            $facility = $FacilityService->getAllActiveFacility();
            $TestSiteService = new TestSiteService();
            $result = $TestSiteService->getTestSiteById($id);
            $district = $DistrictService->getDistictByData($result);

            return view('testsite.edit',array('result'=>$result,'id'=>$id,'facility'=>$facility,'province'=>$province,'district'=>$district));
        }
    }

    public function getDistrict($id){

    	$DistrictService = new DistrictService();
        $district = $DistrictService->getDistictName($id);
  
        return response()->json($district);
     
    }

    public function getProvince($id){

        $testSiteService = new TestSiteService();
        $district = $testSiteService->getTestSiteData($id);
  
        return response()->json($district);
     
    }
}

