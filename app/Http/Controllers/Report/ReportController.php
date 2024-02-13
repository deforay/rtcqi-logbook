<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Service\TestSiteService;
use App\Service\MonthlyReportService;
use App\Service\TestKitService;
use Illuminate\Http\Request;
use App\Service\DistrictService;
use App\Service\SubDistrictService;
use App\Service\ProvinceService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestKitExport;
use App\Exports\TrendExport;
use App\Exports\NotUploadExport;
use App\Exports\LogBookExport;
use App\Exports\InvalidResultExport;
use App\Service\CommonService;
use App\Exports\CustomerExport;
use App\Exports\NotReportedSitesExport;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use View;
use Session;
use Log;

class ReportController extends Controller
{
    //View Trend Report main screen
    public function trendReport()
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
            return view('report.trendReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport,'district' => $district,'subdistrict' => $subDistrict, 'province' => $province));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Trend Report 

    public function getDistrictByProvinceId(Request $request)
    {
        $input = $request->all();
        $districtService = new DistrictService();
        $district = $districtService->getDistrictByProvinceId($input['provinceId']??[]);
        // log::info($district);
        return $district;
    }
    public function getSubDistrictByDistrictId(Request $request)
    {
        $input = $request->all();
        $subDistrictService = new SubDistrictService();
        $subDistrict = $subDistrictService->getSubDistrictByDistrictId($input['districtId']??[]);
        // log::info($district);
        return $subDistrict;
    }

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
            return view('report.logbook', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport,'district' => $district,'subdistrict' => $subDistrict,'province' => $province));
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
            

            return view('report.testKitReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport, 'district' => $district, 'subdistrict' => $subDistrict, 'province' => $province, ''));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function getTestKitMonthlyReport(Request $request)
    {
        $data = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $reportdata = $monthlyReportService->getTestKitMonthlyReport($data);
        $testKitService = new TestKitService();
        $reportdata['summary'] = $testKitService->getTestKitSummary($data);
        // dd($data);die;
        $view = View::make('report.getTestKitReport', array('report' => $reportdata));
        return $view;
    }

    // Custom Report
    public function customReport()
    {
        if (session('login') == true) {
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.customReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport, 'province' => $province, 'district' => $district));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }
    
    //Not Reported Sites Report
    public function notReportedSites()
    {
        if (session('login') == true) {
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $SubDistrictService = new SubDistrictService();
            $subdistrict = $SubDistrictService->getAllSubDistrict();
            return view('report.notReportedSites', array('province' => $province, 'district' => $district, 'province' => $province, 'subdistrict' => $subdistrict));
        } else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function getNotReportedSites(Request $request)
    {
        
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getNotReportedSites($datas);
        //dd($data);die;
        $view = View::make('report.getNotReportedSites', ['report' => $data]);
        return $view;
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
            $TestSiteService = new TestSiteService();
            $testSite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $SubDistrictService = new SubDistrictService();
            $subDistrict = $SubDistrictService->getAllSubDistrict();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $monthlyReportService = new MonthlyReportService();
            $monthlyReport = $monthlyReportService->getAllActiveMonthlyReport();
            return view('report.invalidresultReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport,'district' => $district, 'subdistrict' => $subDistrict, 'province' => $province));
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

    public function notUploadExport(Request $request)
    {
        $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();     
        return Excel::download(new NotUploadExport($data), 'Not-Upload-Report-' . $dateTime . '.xlsx');
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
    public function notReportedSitesExport(Request $request)
    {
        $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new NotReportedSitesExport($data), 'Not-Reported-Sites-Report-' . $dateTime . '.xlsx');
    }
}
