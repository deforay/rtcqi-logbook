<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Service\TestSiteService;
use App\Service\MonthlyReportService;
use App\Service\FacilityService;
use App\Service\TestKitService;
use Illuminate\Http\Request;
use App\Service\DistrictService;
use App\Service\ProvinceService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestKitExport;
use App\Exports\TrendExport;
use App\Exports\LogBookExport;
use App\Exports\InvalidResultExport;
use App\Service\CommonService;
use App\Exports\CustomerExport;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use View;
use Session;

class ReportController extends Controller
{
    //View Trend Report main screen
    public function trendReport()
    {
        if (session('login') == true) {
            $FacilityService = new FacilityService();
            $facility = $FacilityService->getAllActiveFacility();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.trendReport', array('testSite' => $testSite, 'facility' => $facility, 'monthlyReport' => $monthlyReport,'district' => $district,'province' => $province));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Trend Report 

    public function getTrendMonthlyReport(Request $request)
    {
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getTrendMonthlyReport($datas);
        // dd($data);die;
        $view = View::make('report.getTrendReport', ['report' => $data]);
        return $view;
    }

    public function logbook()
    {
        if (session('login') == true) {
            $FacilityService = new FacilityService();
            $facility = $FacilityService->getAllActiveFacility();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.logbook', array('testSite' => $testSite, 'facility' => $facility, 'monthlyReport' => $monthlyReport));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Logbook Report 

    public function getLogbookReport(Request $request)
    {
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getLogbookReport($datas);
        $view = View::make('report.getLogbookReport', ['report' => $data]);
        return $view;
    }

    public function overallagreement(Request $request, $id)
    {
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getPageSummary($id);
        $KitTypeService = new TestKitService();
        $kittype = $KitTypeService->getAllActiveTestKit();
        $view = View::make('report.overallagreement', ['report' => $data, 'kittype' => $kittype]);
        return $view;
    }

    // testKitReport
    public function testKitReport()
    {
        if (session('login') == true) {
            $FacilityService = new FacilityService();
            $facility = $FacilityService->getAllActiveFacility();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.testKitReport', array('testSite' => $testSite, 'facility' => $facility, 'monthlyReport' => $monthlyReport));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function getTestKitMonthlyReport(Request $request)
    {
        $data = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getTestKitMonthlyReport($data);
        // dd($data);die;
        $view = View::make('report.getTestKitReport', ['report' => $data]);
        return $view;
    }

    // Custom Report
    public function customReport()
    {
        if (session('login') == true) {
            $FacilityService = new FacilityService();
            $facility = $FacilityService->getAllActiveFacility();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.customReport', array('testSite' => $testSite, 'facility' => $facility, 'monthlyReport' => $monthlyReport, 'province' => $province, 'district' => $district));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function getCustomMonthlyReport(Request $request)
    {
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getCustomMonthlyReport($datas);
        // dd($data);die;
        $view = View::make('report.getCustomReport', ['report' => $data]);
        return $view;
    }

    // invalidResultReport
    public function invalidresultReport()
    {
        if (session('login') == true) {
            $FacilityService = new FacilityService();
            $facility = $FacilityService->getAllActiveFacility();
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.invalidresultReport', array('testSite' => $testSite, 'facility' => $facility, 'monthlyReport' => $monthlyReport));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function getInvalidResultReport(Request $request)
    {
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getInvalidResultReport($datas);
        // dd($data);die;
        $view = View::make('report.getInvalidResultReport', ['report' => $data]);
        return $view;
    }

    public function testKitExport(Request $request)
    {
        $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new TestKitExport($data), 'Test-Kit-Report-' . $dateTime . '.xlsx');
    }

    public function trendExport(Request $request)
    {
        $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new TrendExport($data), 'Trend-Report-' . $dateTime . '.xlsx');
    }

    public function logBookExport(Request $request)
    {
        $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new LogBookExport($data), 'Logbook-Report-' . $dateTime . '.xlsx');
    }

    public function invalidResultExport(Request $request)
    {
        $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new InvalidResultExport($data), 'Invalid-Result-Report-' . $dateTime . '.xlsx');
    }

    public function customerExport(Request $request)
    {
        $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new CustomerExport($data), 'Custom-Report-' . $dateTime . '.xlsx');
    }
}
