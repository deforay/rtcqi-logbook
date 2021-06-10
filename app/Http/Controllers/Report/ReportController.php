<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Service\TestSiteService;
use App\Service\MonthlyReportService;
use App\Service\FacilityService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use View;
use Session;

class ReportController extends Controller
{
    //View Trend Report main screen
    public function trendReport()
    {
        if(session('login')==true)
        {
            $FacilityService = new FacilityService();
            $facility = $FacilityService->getAllActiveFacility();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.trendReport',array('testSite'=>$testSite,'facility'=>$facility,'monthlyReport'=>$monthlyReport));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Trend Report 

    public function getTrendMonthlyReport(Request $request)
    {
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getTrendMonthlyReport($request);
        // dd($data);die;
        $view = View::make('report.getTrendReport', ['report'=>$data]);
            return $view;
    }

    public function logbook()
    {
        if(session('login')==true)
        {
            $FacilityService = new FacilityService();
            $facility = $FacilityService->getAllActiveFacility();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.logbook',array('testSite'=>$testSite,'facility'=>$facility,'monthlyReport'=>$monthlyReport));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

}

