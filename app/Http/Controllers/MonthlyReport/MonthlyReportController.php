<?php

namespace App\Http\Controllers\MonthlyReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\MonthlyReportService;
use App\Service\ProvinceService;
use App\Service\SiteTypeService;
use App\Service\TestKitService;
use App\Service\TestSiteService;
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
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();   
            $TestSiteService = new TestSiteService();
            $testsite = $TestSiteService->getAllActiveTestSite();   
            $SiteTypeService = new SiteTypeService();
            $sitetype = $SiteTypeService->getAllActiveSiteType(); 
            $KitTypeService = new TestKitService();
            $kittype = $KitTypeService->getAllActiveTestKit();   
            return view('monthlyreport.add',array('province'=>$province, 'testsite'=>$testsite, 'sitetype'=>$sitetype,'kittype'=>$kittype));
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
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();   
            $TestSiteService = new TestSiteService();
            $testsite = $TestSiteService->getAllActiveTestSite();   
            $SiteTypeService = new SiteTypeService();
            $sitetype = $SiteTypeService->getAllActiveSiteType(); 
            $MonthlyReportService = new MonthlyReportService();
            $result = $MonthlyReportService->getMonthlyReportById($id);
            return view('monthlyreport.edit',array('result'=>$result,'id'=>$id, 'province'=>$province, 'testsite'=>$testsite, 'sitetype'=>$sitetype));
        }
    }
}

