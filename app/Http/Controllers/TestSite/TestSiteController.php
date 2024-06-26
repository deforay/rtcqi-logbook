<?php

namespace App\Http\Controllers\TestSite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProvinceService;
use App\Service\DistrictService;
use App\Service\SubDistrictService;
use App\Service\TestSiteService;
use App\Service\SiteTypeService;
use App\Service\ImplementingPartnersService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class TestSiteController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllTestSite','getProvince','getDistrict', 'getSubDistrict','getAllTestSiteList','bulkUpload');        
       
    }
    //View TestSite main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('testsite.index');
        }
        else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
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
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $SiteTypeService = new SiteTypeService();
            $sitetype = $SiteTypeService->getAllActiveSiteType();  
            $ImplementingPartnersService = new ImplementingPartnersService();
            $implementingpartners = $ImplementingPartnersService->getAllActiveImplementingPartners();  
            return view('testsite.add',array('province'=>$province, 'sitetype'=>$sitetype, 'implementingpartners'=>$implementingpartners));
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
            $TestSiteService = new TestSiteService();
            $edit = $TestSiteService->updateTestSite($request,$id);
            return Redirect::route('testsite.index')->with('status', $edit);
        }
        else
        {
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $DistrictService = new DistrictService();
            $SubDistrictService = new SubDistrictService();
            $TestSiteService = new TestSiteService();
            $SiteTypeService = new SiteTypeService();
            $sitetype = $SiteTypeService->getAllActiveSiteType();            
            $result = $TestSiteService->getTestSiteById($id);
            $resultsitetype=explode(',', $result[0]->site_type);
            
            
            $district = $DistrictService->getDistictByData($result);
            $subDistrict = $SubDistrictService->getSubDistictByData($result);
            $ImplementingPartnersService = new ImplementingPartnersService();
            $implementingpartners = $ImplementingPartnersService->getAllActiveImplementingPartners();  
            
            return view('testsite.edit',array('result'=>$result,'id'=>$id,'province'=>$province,'district'=>$district,'subdistrict'=>$subDistrict,'sitetype'=>$sitetype, 'resultsitetype'=>$resultsitetype, 'implementingpartners'=>$implementingpartners));
        }
    }

    public function getDistrict($id){

    	$DistrictService = new DistrictService();
        $district = $DistrictService->getDistictName($id);
  
        return response()->json($district);
     
    }
    public function getSubDistrict($id){

    	$SubDistrictService = new SubDistrictService();
        $subDistrict = $SubDistrictService->getSubDistictName($id);
  
        return response()->json($subDistrict);
     
    }

    public function getProvince($id){
        $testSiteService = new TestSiteService();
        $district = $testSiteService->getTestSiteData($id);
        return response()->json($district);
    }

    public function getAllTestSiteList(Request $request)
    {
        $params = $request->all();
        $testSiteService = new TestSiteService();
        return $testSiteService->getAllTestSiteList($params);
        // log::info($district);
        // return $subDistrict;
    }

    public function bulkUpload(Request $request)
    {
        if ($request->isMethod('post')) 
        {
        $params = $request->all();
        $testSiteService = new TestSiteService();
            $result = $testSiteService->bulkUploadTestSite($params);
            if($result > 0) return Redirect::route('testsite.index')->with('status', "Test sites uploaded successfully");
        }
        return view('testsite.bulk-upload');
    }
}

