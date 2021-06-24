<?php

namespace App\Http\Controllers\MonthlyReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\MonthlyReportService;
use App\Service\ProvinceService;
use App\Service\SiteTypeService;
use App\Service\TestKitService;
use App\Service\TestSiteService;
use App\Service\AllowedTestKitService;
use App\Service\GlobalConfigService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class MonthlyReportController extends Controller
{
    //View MonthlyReport main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('monthlyreport.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add MonthlyReport (display add screen and add the MonthlyReport values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addMonthlyReport = new MonthlyReportService();
            $result = $addMonthlyReport->saveMonthlyReport($request);
            return Redirect::route('monthlyreport.index')->with('status', $result);
        }
        else
        {
            $allowedTestKit = new AllowedTestKitService();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();   
            $TestSiteService = new TestSiteService();
            $testsite = $TestSiteService->getAllActiveTestSite();   
            $SiteTypeService = new SiteTypeService();
            $sitetype = $SiteTypeService->getAllActiveSiteType(); 
            $KitTypeService = new TestKitService();
            $kittype = $KitTypeService->getAllActiveTestKit();   
            $GlobalConfigService = new GlobalConfigService();
            $globalValue = $GlobalConfigService->getGlobalConfigValue('no_of_test');
            $allowedTestKitNo = $allowedTestKit->getAllKitNo($globalValue);
            
            return view('monthlyreport.add',array('kittype'=>$kittype,'globalValue'=>$globalValue, 'province'=>$province, 'testsite'=>$testsite, 'sitetype'=>$sitetype,'allowedTestKitNo'=>$allowedTestKitNo));
        }
    }

    // Get all the  MonthlyReport list
    public function getAllMonthlyReport(Request $request)
    {
        $service = new MonthlyReportService();
        $data = $service->getAllMonthlyReport();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $button .= '<a href="/monthlyreport/edit/'. base64_encode($data->mr_id).'" name="edit" id="'.$data->mr_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit MonthlyReport
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $MonthlyReportService = new MonthlyReportService();
            $edit = $MonthlyReportService->updateMonthlyReport($request,$id);
            return Redirect::route('monthlyreport.index')->with('status', $edit);
        }
        else
        {
            $allowedTestKit = new AllowedTestKitService();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();   
            $TestSiteService = new TestSiteService();
            $testsite = $TestSiteService->getAllActiveTestSite();   
            $SiteTypeService = new SiteTypeService();
            $sitetype = $SiteTypeService->getAllActiveSiteType(); 
            $MonthlyReportService = new MonthlyReportService();
            $result = $MonthlyReportService->getMonthlyReportById($id);
            $GlobalConfigService = new GlobalConfigService();
            $globalValue = $GlobalConfigService->getGlobalConfigValue('no_of_test');
            $KitTypeService = new TestKitService();
            $kittype = $KitTypeService->getAllActiveTestKit(); 
            $allowedTestKitNo = $allowedTestKit->getAllKitNo($globalValue);
            return view('monthlyreport.edit',array('allowedTestKitNo'=>$allowedTestKitNo,'globalValue'=>$globalValue, 'result'=>$result,'id'=>$id, 'province'=>$province, 'testsite'=>$testsite, 'sitetype'=>$sitetype, 'kittype'=>$kittype));
        }
    }

    public function monthlyreportdata(Request $request)
    {
        if(session('login')==true)
        {
            $GlobalConfigService = new GlobalConfigService();
            $glob = $GlobalConfigService->getAllGlobalConfig();
            $arr = array();
            // now we create an associative array so that we can easily create view variables
            for ($i = 0; $i < sizeof($glob); $i++) {
                $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
            }
            if ($request->isMethod('post')) 
            {
                $service = new MonthlyReportService();
                $result = $service->importMonthlyReportData($request);
                return view('monthlyreport.upload',array('status'=>$result, 'global'=>$arr));
            }
            else{
                return view('monthlyreport.upload',array('global'=>$arr));
            }
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

}

