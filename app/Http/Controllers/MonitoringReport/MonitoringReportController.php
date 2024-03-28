<?php

namespace App\Http\Controllers\MonitoringReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\DistrictService;
use App\Service\SubDistrictService;
use App\Service\ProvinceService;
use App\Service\TestSiteService;
use App\Service\MonthlyReportService;
use View;
use Redirect;
use Session;

class MonitoringReportController extends Controller
{
    public function sitewiseReport()
    {
        
        if (session('login') == true) {
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $SubDistrictService = new SubDistrictService();
            $subDistrict = $SubDistrictService->getAllSubDistrict();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('monitoringreport.sitewiseReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport, 'district' => $district, 'subdistrict' => $subDistrict, 'province' => $province));
        } else{
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    public function getSiteWiseReport(Request $request)
    {
        $comingFrom="";
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getSiteWiseReport($datas);
        // dd($data);die;
        if(isset($datas['comingFrom'])){
            $comingFrom=$datas['comingFrom'];
        }
        $view = View::make('monitoringreport.getSiteWiseReport', ['report' => $data,'comingFrom'=>$comingFrom]);
        return $view;
    }
    
    public function sendMail(Request $request){
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->sendSiteWiseReminderEmail($datas);
        return response()->json(['code'=>200,'success' => 'Your inquire is successfully sent.']);
    }
}
