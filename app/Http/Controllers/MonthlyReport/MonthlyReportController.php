<?php

namespace App\Http\Controllers\MonthlyReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\MonthlyReportService;
use App\Service\ProvinceService;
use App\Service\SiteTypeService;
use App\Service\DistrictService;
use App\Service\SubDistrictService;
use App\Service\TestKitService;
use App\Service\TestSiteService;
use App\Service\AllowedTestKitService;
use App\Service\GlobalConfigService;
use App\Service\UserService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class MonthlyReportController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllMonthlyReport','getSelectedSiteMonthlyReport','monthlyreportdata','getReportingMonth','CheckPreLot','getIdReportingMonth','getAllNotUploadMonthlyReport', 'getDuplicateMonthlyReport');        
       
    }
    //View MonthlyReport main screen
    public function index()
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
            return view('monthlyreport.index', array('testSite' => $testSite,'district' => $district, 'subdistrict' => $subDistrict,'province' => $province));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    //Add MonthlyReport (display add screen and add the MonthlyReport values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $addMonthlyReport = new MonthlyReportService();
            $result = $addMonthlyReport->saveMonthlyReport($request);
            //echo $result; exit();
            return Redirect::route('monthlyreport.index')->with('status', $result);
        } else {
            $allowedTestKit = new AllowedTestKitService();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $SubDistrictService = new SubDistrictService();
            $subDistrict = $SubDistrictService->getAllSubDistrict();
            $TestSiteService = new TestSiteService();
            // $testsite = $TestSiteService->getAllActiveTestSite();
            $testsite = $TestSiteService->getAllCurrentUserActiveTestSite();
            $SiteTypeService = new SiteTypeService();
            $sitetype = $SiteTypeService->getAllActiveSiteType();
            $KitTypeService = new TestKitService();
            $kittype = $KitTypeService->getAllActiveTestKit();
            $GlobalConfigService = new GlobalConfigService();
            $globalValue = $GlobalConfigService->getGlobalConfigValue('no_of_test');
            $allowedTestKitNo = $allowedTestKit->getAllKitNo($globalValue);
            $monthService = new MonthlyReportService();
            $latest = $monthService->getLatestValue();
            $glob = $GlobalConfigService->getAllGlobalConfig();
            $testingAlgorithmType = $GlobalConfigService->getGlobalConfigValue('testing_algorithm');
            $arr = array();
            // now we create an associative array so that we can easily create view variables
            $counter = count($glob);
            // now we create an associative array so that we can easily create view variables
            for ($i = 0; $i < $counter; $i++) {
                $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
            }
            return view('monthlyreport.add', array('latest' => $latest, 'kittype' => $kittype, 'global' => $arr, 'globalValue' => $globalValue, 'province' => $province, 'district' => $district,  'subdistrict' => $subDistrict, 'testsite' => $testsite, 'sitetype' => $sitetype, 'allowedTestKitNo' => $allowedTestKitNo,'testingAlgorithmType'=>$testingAlgorithmType));
        }
    }

    // Get all the  MonthlyReport list
    public function getAllMonthlyReport(Request $request)
    {
        $datas = $request->all();
        $service = new MonthlyReportService();
        $data = $service->getAllMonthlyReport($datas);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $button = '<div>';
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit'] == "allow")){
                $button .= '<a href="/monthlyreport/edit/' . base64_encode($data->mr_id) . '" name="edit" id="' . $data->mr_id . '" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
            }else{
                $button .= '';
            }
                return $button . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function getSelectedSiteMonthlyReport(Request $request)
    {
        
        $datas = $request->all();
        // dd($datas);die;
        $service = new MonthlyReportService();
        $data = $service->getSelectedSiteMonthlyReport($datas);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $button = '<div>';
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit'] == "allow")){
                $button .= '<a href="/monthlyreport/edit/' . base64_encode($data->mr_id) . '" name="edit" id="' . $data->mr_id . '" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
            }else{
                $button .= '';
            }
                return $button . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //edit MonthlyReport
    public function edit($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $MonthlyReportService = new MonthlyReportService();
            $edit = $MonthlyReportService->updateMonthlyReport($request, $id);
            return Redirect::route('monthlyreport.index')->with('status', $edit);
        } else {
            $allowedTestKit = new AllowedTestKitService();
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $SubDistrictService = new SubDistrictService();
            $subDistrict = $SubDistrictService->getAllSubDistrict();            
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
            $UserService = new UserService();
            $auditData = $UserService->getAllActivityById($id);
            $allowedTestKitNo = $allowedTestKit->getAllKitNo($globalValue);
            $glob = $GlobalConfigService->getAllGlobalConfig();
            $testingAlgorithmType = $GlobalConfigService->getGlobalConfigValue('testing_algorithm');
            $arr = array();
            // now we create an associative array so that we can easily create view variables
            $counter = count($glob);
            // now we create an associative array so that we can easily create view variables
            for ($i = 0; $i < $counter; $i++) {
                $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
            }
            return view('monthlyreport.edit', array('allowedTestKitNo' => $allowedTestKitNo, 'global' => $arr, 'globalValue' => $globalValue, 'result' => $result, 'id' => $id, 'province' => $province, 'district' => $district, 'subdistrict' => $subDistrict, 'testsite' => $testsite, 'sitetype' => $sitetype, 'kittype' => $kittype,'auditData'=>$auditData,'testingAlgorithmType'=>$testingAlgorithmType));
        }
    }

    public function monthlyreportdata(Request $request)
    {
        if (session('login') == true) {
            $GlobalConfigService = new GlobalConfigService();
            $glob = $GlobalConfigService->getAllGlobalConfig();
            $arr = array();
            // now we create an associative array so that we can easily create view variables
            $counter = count($glob);
            // now we create an associative array so that we can easily create view variables
            for ($i = 0; $i < $counter; $i++) {
                $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
            }
            if ($request->isMethod('post')) {
                $service = new MonthlyReportService();
                $result = $service->importMonthlyReportData($request);

                if($result =='error'){
                    $validateError = "Please verify that the format of the uploaded file matches the downloaded template.";
                    return view('monthlyreport.upload', array('error' => $validateError,'global' => $arr)); 
                }
                return view('monthlyreport.upload', array('status' => $result, 'global' => $arr));
            } else {
                return view('monthlyreport.upload', array('global' => $arr));
            }
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    public function CheckPreLot(Request $request)
    {
        $service = new MonthlyReportService();
        return $service->CheckPreLot($request);
    }

    public function insertTrackTable()
    {
        $service = new MonthlyReportService();
        return $service->insertData();
    }

    public function getReportingMonth(Request $request)
    {
        $service = new MonthlyReportService();
        return $service->getExistingReportingMonth($request);
    }
    public function getIdReportingMonth(Request $request)
    {
        $service = new MonthlyReportService();
        return $service->getIdExistingReportingMonth($request);
    }

    public function notUpload()
    {        
        if (session('login') == true) {
            $MonthlyReportService = new MonthlyReportService();
            $testSite = $MonthlyReportService->getAllNotUploadActiveTestSite();
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            //$ProvinceService = new MonthlyReportService();
            $province = $MonthlyReportService->getAllNotUploadActiveProvince();
            return view('monthlyreport.notUpload', array('testSite' => $testSite,'district' => $district,'province' => $province));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    public function getAllNotUploadMonthlyReport(Request $request)
    {
        $datas = $request->all();
        // dd($datas);die;
        $service = new MonthlyReportService();
        $data = $service->getAllNotUploadMonthlyReport($datas);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $button = '<div>';
                $role = session('role');
                $button .= '';
                return $button . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDuplicateMonthlyReport(Request $request)
    {
        $datas = $request->all();
        // dd($datas);die;
        $service = new MonthlyReportService();
        $result = $service->getDuplicateMonthlyReport($datas);
        
        return $result;
    }
    
}
