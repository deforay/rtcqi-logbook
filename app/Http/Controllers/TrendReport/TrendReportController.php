<?php

namespace App\Http\Controllers\TrendReport;

use App\Http\Controllers\Controller;
use App\Service\TestSiteService;
use App\Service\MonthlyReportService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use View;
use Session;

class TrendReportController extends Controller
{
    //View Trend Report main screen
    public function index()
    {
        if(session('login')==true)
        {
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('trendreport.index',array('testSite'=>$testSite,'monthlyReport'=>$monthlyReport));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function getTrendMonthlyReport(Request $request)
    {
        // dd($request);die;
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getTrendMonthlyReport($request);
        // dd($data);die;
        $view = View::make('trendreport.getTrendReport', ['report'=>$data]);
            return $view;
    }
}

