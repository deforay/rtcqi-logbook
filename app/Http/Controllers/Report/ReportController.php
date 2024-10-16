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
use App\Exports\TestKitSummaryExport;
use App\Exports\TrendExport;
use App\Exports\NotUploadExport;
use App\Exports\LogBookExport;
use App\Exports\InvalidResultExport;
use App\Service\CommonService;
use App\Exports\CustomerExport;
use App\Exports\NotReportedSitesExport;
use App\Service\GlobalConfigService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use View;
use Session;
use Log;

class ReportController extends Controller
{
    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

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
            $globalConfigService = new GlobalConfigService();
            $testingAlgorithm = explode(',', $globalConfigService->getGlobalConfigValue('testing_algorithm'));
            return view('report.trendReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport,'district' => $district,'subdistrict' => $subDistrict, 'province' => $province, 'testingAlgorithm' => $testingAlgorithm));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    // Trend Report 

    public function getDistrictByProvinceId(Request $request)
    {
        $input = $request->all();
        $districtService = new DistrictService();
        // log::info($district);
        return $districtService->getDistrictByProvinceId($input['provinceId']??[]);
    }
    public function getSubDistrictByDistrictId(Request $request)
    {
        $input = $request->all();
        $subDistrictService = new SubDistrictService();
        // log::info($district);
        return $subDistrictService->getSubDistrictByDistrictId($input['districtId']??[]);
    }

    public function getTrendMonthlyReport(Request $request)
    {
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getTrendMonthlyReport($datas);
        $data['chart']=$monthlyReportService->getTrendMonthlyReportChartData($datas);
        //dd($data);die;
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
            $globalConfigService = new GlobalConfigService();
            $testingAlgorithm = explode(',', $globalConfigService->getGlobalConfigValue('testing_algorithm'));
            return view('report.logbook', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport,'district' => $district,'subdistrict' => $subDistrict,'province' => $province, 'testingAlgorithm' => $testingAlgorithm));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    // Logbook Report 

    public function getLogbookReport(Request $request)
    {
        $datas = $request->all();
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getLogbookReport($datas);
        return View::make('report.getLogbookReport', ['report' => $data]);
    }

    public function overallagreement(Request $request, $id)
    {
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getPageSummary($id);
        $KitTypeService = new TestKitService();
        $kittype = $KitTypeService->getAllActiveTestKit();
        return View::make('report.overallagreement', ['report' => $data, 'kittype' => $kittype]);
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
            $globalConfigService = new GlobalConfigService();
            $testingAlgorithm = explode(',', $globalConfigService->getGlobalConfigValue('testing_algorithm'));

            return view('report.testKitReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport, 'district' => $district, 'subdistrict' => $subDistrict, 'province' => $province, 'testingAlgorithm' => $testingAlgorithm));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
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
            $globalConfigService = new GlobalConfigService();
            $testingAlgorithm = explode(',', $globalConfigService->getGlobalConfigValue('testing_algorithm'));
            return view('report.customReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport, 'province' => $province, 'district' => $district, 'testingAlgorithm' => $testingAlgorithm));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
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
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
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
            $globalConfigService = new GlobalConfigService();
            $testingAlgorithm = explode(',', $globalConfigService->getGlobalConfigValue('testing_algorithm'));
            return view('report.invalidresultReport', array('testSite' => $testSite, 'monthlyReport' => $monthlyReport,'district' => $district, 'subdistrict' => $subDistrict, 'province' => $province, 'testingAlgorithm' => $testingAlgorithm));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
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
        
        if(isset($_POST['exportReport'])){
            $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new TestKitExport($data), 'Test-Kit-Report-' . $dateTime . '.xlsx');
        }else{
            $commonservice = new CommonService();
        $dateTime = $commonservice->getDateAndTime();
        $data = $request->all();
        return Excel::download(new TestKitSummaryExport($data), 'Test-Kit-Summary-Report-' . $dateTime . '.xlsx');
        }
        
    }
    
    public function trendExport(Request $request)
    {
        $data = $request->all();        
        $downloadName = $this->commonService->excelName('Trend-Report');
        return Excel::download(new TrendExport($data), $downloadName);
    }

    public function logBookExport(Request $request)
    {
        $data = $request->all();
        $downloadName = $this->commonService->excelName('Logbook-Report');        
        return Excel::download(new LogBookExport($data), $downloadName);
    }

    public function notUploadExport(Request $request)
    {
        $data = $request->all();
        $downloadName = $this->commonService->excelName('Not-Upload-Report');
        return Excel::download(new NotUploadExport($data), $downloadName);
    }

    public function invalidResultExport(Request $request)
    {
        $data = $request->all();
        $downloadName = $this->commonService->excelName('Invalid-Result-Report');
        return Excel::download(new InvalidResultExport($data), $downloadName);
    }

    public function customerExport(Request $request)
    {
        $data = $request->all();
        $downloadName = $this->commonService->excelName('Custom-Report');
        return Excel::download(new CustomerExport($data), $downloadName);
    }
    public function notReportedSitesExport(Request $request)
    {
        $data = $request->all();
        $downloadName = $this->commonService->excelName('Not-Reported-Sites-Report');
        return Excel::download(new NotReportedSitesExport($data), $downloadName);
    }    
}
