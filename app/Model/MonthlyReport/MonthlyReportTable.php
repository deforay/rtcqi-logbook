<?php

namespace App\Model\MonthlyReport;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\GlobalConfigService;
use Illuminate\Support\Facades\Session;
use App\Imports\MonthlyReportDataUpload;
use App\Model\TestSite\TestSiteTable;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Carbon\Carbon;

class MonthlyReportTable extends Model
{
    protected $table = 'monthly_reports';

    //add MonthlyReport
    public function saveMonthlyReport($request)
    {
        //to get all request values
        $data = $request->all();
        $model = new TestSiteTable();
        $districtId = $data['districtId'];
        $subDistrictId = $data['subDistrictId'];
        $latitude = $model->fetchLatitudeValue($data['testsiteId']);
        $longitude = $model->fetchLongitudeValue($data['testsiteId']);
        $user_name = session('name');
        // print_r($data);die;
        $commonservice = new CommonService();
        $DateOfCollect = $data['DateOfCollect'] == "" ? date('Y-m-d') : $commonservice->dateFormat($data['DateOfCollect']);
        $reportingMon = ($data['reportingMon']);
        $recency = '';
        if (isset($data['isRecency']))
            $recency = $data['isRecency'];
        if ($request->input('provinceId') != null && trim($request->input('provinceId')) != '') {
            $id = DB::table('monthly_reports')->insertGetId(
                [
                    'province_id' => $data['provinceId'],
                    'site_unique_id' => $data['siteUniqueId'],
                    'ts_id' => $data['testsiteId'],
                    'st_id' => $data['sitetypeId'],
                    'site_manager' => $data['siteManager'],
                    'is_flc' => $data['isFlu'],
                    'is_recency' => $recency,
                    'contact_no' => $data['contactNo'],
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    //'algorithm_type' => $data['algoType'],
                    'date_of_data_collection' => $DateOfCollect,
                    'reporting_month' => $reportingMon,
                    'book_no' => $data['bookNo'],
                    'name_of_data_collector' => $data['nameOfDataCollect'] == "" ? $user_name : $data['nameOfDataCollect'],
                    'source' => 'web-form',
                    'added_on' => date('Y-m-d'),
                    'added_by' => session('userId'),
                    'last_modified_on' => $commonservice->getDateTime(),
                    'district_id' => $districtId,
                    'sub_district_id' => $subDistrictId,
                    'tester_name' => $data['testername'],
                    // 'signature' => $data['signature'],
                ]
            );
            $GlobalConfigService = new GlobalConfigService();
            $result = $GlobalConfigService->getAllGlobalConfig();
            $arr = array();
            // now we create an associative array so that we can easily create view variables
            for ($i = 0; $i < sizeof($result); $i++) {
                $arr[$result[$i]->global_name] = $result[$i]->global_value;
            }
            // print_r($data);die;
            for ($p = 0; $p < count($data['pageNO']); $p++) {
                $startDate = $commonservice->dateFormat($data['startDate'][$p]);
                $endDate = $commonservice->dateFormat($data['endDate'][$p]);

                $insMonthlyArr = array(
                    'mr_id' => $id,
                    'page_no' => $data['pageNO'][$p],
                    'start_test_date' => $startDate,
                    'end_test_date' => $endDate,
                    'final_positive' => $data['totalPositive'][$p],
                    'final_negative' => $data['totalNegative'][$p],
                    'final_undetermined' => $data['finalUndetermined'][$p],
                    'created_on' => $commonservice->getDateTime(),
                    'created_by' => session('userId')
                );
                for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                    $m = $l;
                    $insMonthlyArr['test_' . $m . '_kit_id'] = $data['testkitId' . $l][$p];
                    $insMonthlyArr['lot_no_' . $m] = $data['lotNO' . $l][$p];
                    $insMonthlyArr['expiry_date_' . $m] = $commonservice->dateFormat($data['expiryDate' . $l][$p]);
                    $insMonthlyArr['test_' . $m . '_reactive'] = $data['totalReactive' . $l][$p];
                    $insMonthlyArr['test_' . $m . '_nonreactive'] = $data['totalNonReactive' . $l][$p];
                    $insMonthlyArr['test_' . $m . '_invalid'] = $data['totalInvalid' . $l][$p];
                }
                $totalPositive = $data['totalPositive'][$p];
                $totalTested = $data['totalReactive1'][$p] + $data['totalNonReactive1'][$p];
                $positivePercentage = ($totalTested == 0) ? 'N.A' : number_format($totalPositive * 100 / $totalTested, 2);
                $posAgreement = 0;
                if ($data['totalReactive1'][$p] > 0)
                    $posAgreement = number_format(100 * ($data['totalReactive2'][$p]) / ($data['totalReactive1'][$p]), 2);
                $OverallAgreement = number_format(100 * ($data['totalReactive2'][$p] + $data['totalNonReactive1'][$p]) / ($data['totalReactive1'][$p] + $data['totalNonReactive1'][$p]), 2);
                $insMonthlyArr['positive_percentage'] = $positivePercentage;
                $insMonthlyArr['positive_agreement'] = $posAgreement;
                $insMonthlyArr['overall_agreement'] = $OverallAgreement;
                // print_r($insMonthlyArr);die;
                $monthly_reports_pages = DB::table('monthly_reports_pages')->insertGetId(
                    $insMonthlyArr
                );
            }
            $commonservice->eventLog('add-monthly-report-request', $user_name . ' has added the monthly report information for book no ' . $data['bookNo'] . '', 'monthly-report', $id);
        }

        return $id;
    }

    // Fetch All MonthlyReport List
    public function fetchAllMonthlyReport($params)
    {
        $commonservice = new CommonService();
        $start_date = '';
        $end_date = '';

        if (isset($params['searchDate']) && $params['searchDate'] != '') {
            $sDate = explode("to", $params['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        $user_id = session('userId');
        $query = DB::table('monthly_reports')
            ->select('monthly_reports.mr_id', DB::raw('count(monthly_reports_pages.page_no) as page_no'), 'monthly_reports.reporting_month', 'monthly_reports.date_of_data_collection', 'monthly_reports.name_of_data_collector', 'monthly_reports.book_no', 'monthly_reports.last_modified_on', 'site_types.site_type_name', 'test_sites.site_name', DB::raw('MIN(monthly_reports_pages.start_test_date) as start_test_date'), DB::raw('MAX(monthly_reports_pages.end_test_date) as end_test_date'))
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'monthly_reports.sub_district_id')
            ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
            ->groupBy('monthly_reports.mr_id');

        if (Session::get('tsId') != '' && !isset($params['testSiteId'])) {
            $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                ->where('users_testsite_map.user_id', '=', $user_id);
        }

        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->where('monthly_reports_pages.start_test_date',  '>=', $start_date)
                    ->where('monthly_reports_pages.end_test_date', '<=', $end_date);
            });
        }
        if (isset($params['provinceId']) && $params['provinceId'] != '') {
            $query = $query->whereIn('provinces.province_id', $params['provinceId']);
            $query = $query->groupBy(DB::raw('provinces.province_id'));
        }
        if (isset($params['districtId']) && $params['districtId'] != '') {
            $query = $query->whereIn('districts.district_id', $params['districtId']);
            $query = $query->groupBy(DB::raw('districts.district_id'));
        }
        if (isset($params['subDistrictId']) && $params['subDistrictId'] != '') {
            $query = $query->whereIn('sub_districts.sub_district_id', $params['subDistrictId']);
            $query = $query->groupBy(DB::raw('sub_districts.sub_district_id'));
        }
        if (isset($params['testSiteId']) && $params['testSiteId'] != '') {
            $query = $query->whereIn('test_sites.ts_id', $params['testSiteId']);
            $query = $query->groupBy(DB::raw('test_sites.ts_id'));
        }
        // dd($query->toSql());
        $salesResult = $query->get();

        return $salesResult;
    }

    //Fetch Selected Site Monthly Report
    public function fetchSelectedSiteMonthlyReport($params)
    {
        $commonservice = new CommonService();

        $user_id = session('userId');
        $query = DB::table('monthly_reports')
            ->select('monthly_reports.mr_id', DB::raw('count(monthly_reports_pages.page_no) as page_no'), 'monthly_reports.reporting_month', 'monthly_reports.date_of_data_collection', 'monthly_reports.name_of_data_collector', 'monthly_reports.book_no', 'monthly_reports.last_modified_on', 'site_types.site_type_name', 'test_sites.site_name', DB::raw('MIN(monthly_reports_pages.start_test_date) as start_test_date'), DB::raw('MAX(monthly_reports_pages.end_test_date) as end_test_date'))
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
            ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
            ->groupBy('monthly_reports.mr_id');

        if (Session::get('tsId') != '' && !isset($params['testSiteId'])) {
            $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                ->where('users_testsite_map.user_id', '=', $user_id);
        }

        if (isset($params['testSiteId']) && $params['testSiteId'] != '') {
            $query = $query->where('test_sites.ts_id', '=', $params['testSiteId']);
            $query = $query->groupBy(DB::raw('test_sites.ts_id'));
        }

        $query = $query->orderBy('monthly_reports.mr_id', 'DESC')->limit(5);
        // dd($query->toSql());
        $salesResult = $query->get();

        return $salesResult;
    }


    // Fetch All Active MonthlyReport List
    public function fetchAllActiveMonthlyReport()
    {
        $data = DB::table('monthly_reports')
            // ->where('province_status','=','active')
            ->get();
        return $data;
    }

    // Fetch All Active MonthlyReport List
    public function fetchUniqueActiveMonthlyReport($siteId, $reportingMon)
    {
        $data = DB::table('monthly_reports')
            ->where('ts_id', '=', $siteId)
            ->where('reporting_month', '=', $reportingMon)
            ->get();
        return $data;
    }

    // fetch particular MonthlyReport details
    public function fetchMonthlyReportById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('monthly_reports')
            ->join('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->where('monthly_reports.mr_id', '=', $id)
            ->get();
        $data['test_details'] = DB::table('monthly_reports_pages')
            ->where('monthly_reports_pages.mr_id', '=', $id)->get();
        return $data;
    }

    // Update particular MonthlyReport details
    public function updateMonthlyReport($params, $id)
    {
        //echo base64_decode($id); exit();
        $user_name = session('name');
        $data = $params->all();

        $model = new TestSiteTable();
        $districtId = $data['districtId'];
        $subDistrictId = $data['subDistrictId'];
        //$districtId = $model->fetchDistrictId($data['testsiteId']);
        $latitude = $model->fetchLatitudeValue($data['testsiteId']);
        $longitude = $model->fetchLongitudeValue($data['testsiteId']);
        $commonservice = new CommonService();
        $DateOfCollect = ($data['DateOfCollect'] == "" ? date('Y-m-d') : $commonservice->dateFormat($data['DateOfCollect']));
        $reportingMon = ($data['reportingMon']);
        $recency = '';
        if (isset($data['isRecency']))
            $recency = $data['isRecency'];
        $upData = array(
            'province_id' => $data['provinceId'],
            'district_id' => $districtId,
            'sub_district_id' => $subDistrictId,
            'site_unique_id' => $data['siteUniqueId'],
            'ts_id' => $data['testsiteId'],
            'st_id' => $data['sitetypeId'],
            'site_manager' => $data['siteManager'],
            'is_flc' => $data['isFlu'],
            'is_recency' => $recency,
            'contact_no' => $data['contactNo'],
            'latitude' => $latitude,
            'longitude' => $longitude,
            //'algorithm_type' => $data['algoType'],
            'date_of_data_collection' => $DateOfCollect,
            'reporting_month' => $reportingMon,
            'book_no' => $data['bookNo'],
            'name_of_data_collector' => $data['nameOfDataCollect'] == "" ? $user_name : $data['nameOfDataCollect'],
            'last_modified_on' => $commonservice->getDateTime(),
            'district_id' => $districtId,
            'tester_name' => $data['testername'],
            'updated_by' => session('userId')
            // 'signature' => $data['signature'],
        );
        $response = DB::table('monthly_reports')
            ->where('mr_id', '=', base64_decode($id))
            ->update(
                $upData
            );
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        for ($p = 0; $p < count($data['pageNO']); $p++) {
            //print_r($data['pageNO']); exit();
            $startDate = $commonservice->dateFormat($data['startDate'][$p]);
            $endDate = $commonservice->dateFormat($data['endDate'][$p]);
            $insMonthlyArr = array(
                'mr_id' => base64_decode($id),
                'page_no' => $data['pageNO'][$p],
                'start_test_date' => $startDate,
                'end_test_date' => $endDate,
                'final_positive' => $data['totalPositive'][$p],
                'final_negative' => $data['totalNegative'][$p],
                'final_undetermined' => $data['finalUndetermined'][$p],
                'updated_on' => $commonservice->getDateTime(),
                'updated_by' => session('userId')
            );
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $m = $l;
                $insMonthlyArr['test_' . $m . '_kit_id'] = $data['testkitId' . $l][$p];
                $insMonthlyArr['lot_no_' . $m] = $data['lotNO' . $l][$p];
                $insMonthlyArr['expiry_date_' . $m] = $commonservice->dateFormat($data['expiryDate' . $l][$p]);
                $insMonthlyArr['test_' . $m . '_reactive'] = $data['totalReactive' . $l][$p];
                $insMonthlyArr['test_' . $m . '_nonreactive'] = $data['totalNonReactive' . $l][$p];
                $insMonthlyArr['test_' . $m . '_invalid'] = $data['totalInvalid' . $l][$p];
            }
            $totalPositive = $data['totalPositive'][$p];
            $totalTested = $data['totalReactive1'][$p] + $data['totalNonReactive1'][$p];
            $positivePercentage = ($totalTested == 0) ? 'N.A' : number_format($totalPositive * 100 / $totalTested, 2);
            $posAgreement = 0;
            if ($data['totalReactive1'][$p] > 0)
                $posAgreement = number_format(100 * ($data['totalReactive2'][$p]) / ($data['totalReactive1'][$p]), 2);
            $OverallAgreement = number_format(100 * ($data['totalReactive2'][$p] + $data['totalNonReactive1'][$p]) / ($data['totalReactive1'][$p] + $data['totalNonReactive1'][$p]), 2);
            $insMonthlyArr['positive_percentage'] = $positivePercentage;
            $insMonthlyArr['positive_agreement'] = $posAgreement;
            $insMonthlyArr['overall_agreement'] = $OverallAgreement;
            // print_r($insMonthlyArr);die;
            if (isset($data['mrp_id'][$p]) && $data['mrp_id'][$p] != '') {
                //echo $data['mrp_id'][$p];exit();
                DB::table('monthly_reports_pages')
                    ->where('mrp_id', '=', $data['mrp_id'][$p])
                    ->update(
                        $insMonthlyArr
                    );
            } else {
                DB::table('monthly_reports_pages')->insertGetId(
                    $insMonthlyArr
                );
            }
        }
        $commonservice->eventLog('update-monthly-report-request', $user_name . ' has updated the monthly report information for book no ' . $data['bookNo'] . '', 'monthly-report', base64_decode($id));
        return 1;
    }

    public function fetchTrendMonthlyReport($params)
    {
        $commonservice = new CommonService();
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        $user_id = session('userId');
        $result = array();
        $data = $params;
        $start_date = '';
        $end_date = '';
        if (isset($data['searchDate']) && $data['searchDate'] != '') {
            $sDate = explode("to", $data['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        //DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'monthly_reports.sub_district_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id');

        if (Session::get('tsId') != '' && !isset($data['testSiteId'])) {
            $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                ->where('users_testsite_map.user_id', '=', $user_id);
        }
        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->whereDate('monthly_reports_pages.start_test_date',  '>=', $start_date)
                    ->whereDate('monthly_reports_pages.end_test_date', '<=', $end_date)
                    ->whereDate('monthly_reports_pages.end_test_date', '>=', $start_date);
            });
        }
        if (isset($data['provinceId']) && $data['provinceId'] != '') {
            $query = $query->whereIn('provinces.province_id', $data['provinceId']);
            $query = $query->groupBy(DB::raw('provinces.province_id'));
        }
        if (isset($data['districtId']) && $data['districtId'] != '') {
            $query = $query->whereIn('districts.district_id', $data['districtId']);
            $query = $query->groupBy(DB::raw('districts.district_id'));
        }
        if (isset($data['subDistrictId']) && $data['subDistrictId'] != '') {
            $query = $query->whereIn('sub_districts.sub_district_id', $data['subDistrictId']);
            $query = $query->groupBy(DB::raw('sub_districts.sub_district_id'));
        }
        if (isset($data['algorithmType']) && $data['algorithmType'] != '') {
            $query = $query->whereIn('monthly_reports.algorithm_type', $data['algorithmType']);
            $query = $query->groupBy(DB::raw('monthly_reports.mr_id'));
        }
        if (isset($data['testSiteId']) && $data['testSiteId'] != '') {
            $query = $query->whereIn('test_sites.ts_id', $data['testSiteId']);
            $query = $query->groupBy(DB::raw('test_sites.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'monthly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive) as test_' . $l . '_reactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_invalid');
            }
            $query = $query->selectRaw('sum(monthly_reports_pages.final_positive) as final');
            $query = $query->selectRaw('sum(monthly_reports_pages.final_negative) as final_negative');
            $query = $query->selectRaw('sum(monthly_reports_pages.final_undetermined) as final_undetermined');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as month');
            //$query = $query->groupBy(DB::raw('MONTH(monthly_reports_pages.end_test_date'),DB::raw('monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('MONTH(monthly_reports_pages.end_test_date)'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'yearly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive) as test_' . $l . '_reactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_invalid');
            }
            $query = $query->selectRaw('sum(monthly_reports_pages.final_positive) as final');
            $query = $query->selectRaw('sum(monthly_reports_pages.final_negative) as final_negative');
            $query = $query->selectRaw('sum(monthly_reports_pages.final_undetermined) as final_undetermined');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%Y") as year');
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('YEAR(monthly_reports_pages.end_test_date)'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'quaterly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive) as test_' . $l . '_reactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_invalid');
            }
            $query = $query->selectRaw('sum(monthly_reports_pages.final_positive) as final');
            $query = $query->selectRaw('sum(monthly_reports_pages.final_negative) as final_negative');
            $query = $query->selectRaw('sum(monthly_reports_pages.final_undetermined) as final_undetermined');
            $query = $query->selectRaw('YEAR(monthly_reports_pages.end_test_date) as end_test_date');
            $query = $query->selectRaw("(CASE WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 1  AND 3  THEN 'Q4' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 4  AND 6  THEN 'Q1' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 7  AND 9  THEN 'Q2' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 10 AND 12 THEN 'Q3' END) AS quarterly");

            $query =  $query->selectRaw("DATE_FORMAT(monthly_reports_pages.end_test_date,'%Y') as quaYear");

            //$query = $query->groupBy(DB::raw('QUARTER(monthly_reports_pages.end_test_date)'), DB::raw('monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('QUARTER(monthly_reports_pages.end_test_date)'));
        }
        // dd($query->toSql());
        // dd($user_id);
        $salesResult = $query->get();
        $result['reportFrequency'] = $data['reportFrequency'];
        $result['res'] = $salesResult;
        return $result;
    }


    /// Logbook report display with filters

    public function fetchLogbookReport($params)
    {
        $commonservice = new CommonService();
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        $user_id = session('userId');
        $data = $params;
        $start_date = '';
        $end_date = '';
        if (isset($data['searchDate']) && $data['searchDate'] != '') {
            $sDate = explode("to", $data['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        // DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages as mrp')
            ->select('monthly_reports.*', 'mrp.mr_id', DB::raw('sum(mrp.final_positive) as final_positive'), DB::raw('sum(mrp.final_negative) as final_negative'), DB::raw('sum(mrp.final_undetermined) as final_undetermined'), 'mrp.mrp_id', 'mrp.overall_agreement', 'mrp.positive_agreement', 'mrp.positive_percentage', DB::raw('MIN(mrp.start_test_date) as start_test_date'), DB::raw('MAX(mrp.end_test_date) as end_test_date'), DB::raw('sum(mrp.test_1_reactive + mrp.test_1_nonreactive) as total_test'),  'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'mrp.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'monthly_reports.sub_district_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->groupBy('monthly_reports.mr_id');

        if (Session::get('tsId') != '' && !isset($data['testSiteId'])) {
            $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                ->where('users_testsite_map.user_id', '=', $user_id);
        }

        for ($l = 1; $l <= $arr['no_of_test']; $l++) {
            $query = $query->selectRaw('sum(mrp.test_' . $l . '_reactive) as test_' . $l . '_reactive');
            $query = $query->selectRaw('sum(mrp.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
            $query = $query->selectRaw('sum(mrp.test_' . $l . '_invalid) as test_' . $l . '_invalid');
        }

        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->where('mrp.start_test_date',  '>=', $start_date)
                    ->where('mrp.end_test_date', '<=', $end_date);
            });
        }
        if (isset($data['provinceId']) && $data['provinceId'] != '') {
            $query = $query->whereIn('provinces.province_id', $data['provinceId']);
            $query = $query->groupBy(DB::raw('provinces.province_id'));
        }
        if (isset($data['districtId']) && $data['districtId'] != '') {
            $query = $query->whereIn('districts.district_id', $data['districtId']);
            $query = $query->groupBy(DB::raw('districts.district_id'));
        }
        if (isset($data['subDistrictId']) && $data['subDistrictId'] != '') {
            $query = $query->whereIn('sub_districts.sub_district_id', $data['subDistrictId']);
            $query = $query->groupBy(DB::raw('sub_districts.sub_district_id'));
        }
        if (isset($data['algorithmType']) && $data['algorithmType'] != '') {
            $query = $query->whereIn('monthly_reports.algorithm_type', $data['algorithmType']);
            $query = $query->groupBy(DB::raw('monthly_reports.mr_id'));
        }
        if (isset($data['testSiteId']) && $data['testSiteId'] != '') {
            $query = $query->whereIn('test_sites.ts_id', $data['testSiteId']);
            $query = $query->groupBy(DB::raw('test_sites.ts_id'));
        }
        // dd($query->toSql());
        $salesResult = $query->get();

        return $salesResult;
    }
    /// Page summary for log data
    public function fetchPageSummary($id)
    {
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        $id = base64_decode($id);
        $data = DB::table('monthly_reports_pages as mrp')
            ->select('monthly_reports.*', DB::raw('sum(mrp.final_undetermined) as final_undetermined'), DB::raw('sum(mrp.final_negative) as final_negative'), 'mrp.page_no as page_no', DB::raw('sum(mrp.final_positive) as final_positive'), 'mrp.mrp_id', 'mrp.overall_agreement', 'mrp.positive_agreement', 'mrp.positive_percentage', DB::raw('MIN(mrp.start_test_date) as start_test_date'), DB::raw('MAX(mrp.end_test_date) as end_test_date'), DB::raw('sum(mrp.test_1_reactive + mrp.test_1_nonreactive) as total_test'), 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'mrp.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->groupBy('mrp.mr_id')
            ->where('mrp.mr_id', '=', $id);

        for ($l = 1; $l <= $arr['no_of_test']; $l++) {
            $data = $data->selectRaw('sum(mrp.test_' . $l . '_reactive) as test_' . $l . '_reactive');
            $data = $data->selectRaw('sum(mrp.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
            $data = $data->selectRaw('sum(mrp.test_' . $l . '_invalid) as test_' . $l . '_invalid');
            $data = $data->selectRaw('mrp.test_' . $l . '_kit_id');
            $data = $data->selectRaw('mrp.lot_no_' . $l . '');
            $data = $data->selectRaw('mrp.expiry_date_' . $l . '');
        }

        $result = $data->get();
        return $result;
    }

    // Test Kit Use Data
    public function fetchTestKitMonthlyReport($params)
    {
        $commonservice = new CommonService();
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        $user_id = session('userId');
        $result = array();
        $data = $params;
        $start_date = '';
        $end_date = '';
        if (isset($data['searchDate']) && $data['searchDate'] != '') {
            $sDate = explode("to", $data['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        //DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
            ->leftjoin('sub_districts', 'sub_districts.district_id', '=', 'monthly_reports.sub_district_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id');

        if (Session::get('tsId') != '' && !isset($data['testSiteId'])) {
            $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                ->where('users_testsite_map.user_id', '=', $user_id);
        }
        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->where('monthly_reports_pages.start_test_date',  '>=', $start_date)
                    ->where('monthly_reports_pages.end_test_date', '<=', $end_date)
                    ->whereDate('monthly_reports_pages.end_test_date', '>=', $start_date);
            });
        }
        if (isset($data['provinceId']) && $data['provinceId'] != '') {
            $query = $query->whereIn('provinces.province_id', $data['provinceId']);
            $query = $query->groupBy(DB::raw('provinces.province_id'));
        }
        if (isset($data['districtId']) && $data['districtId'] != '') {
            $query = $query->whereIn('districts.district_id', $data['districtId']);
            $query = $query->groupBy(DB::raw('districts.district_id'));
        }
        if (isset($data['subDistrictId']) && $data['subDistrictId'] != '') {
            $query = $query->whereIn('sub_districts.sub_district_id', $data['subDistrictId']);
            $query = $query->groupBy(DB::raw('sub_districts.sub_district_id'));
        }
        if (isset($data['algorithmType']) && $data['algorithmType'] != '') {
            $query = $query->whereIn('monthly_reports.algorithm_type', $data['algorithmType']);
            $query = $query->groupBy(DB::raw('monthly_reports.mr_id'));
        }
        if (isset($data['testSiteId']) && $data['testSiteId'] != '') {
            $query = $query->whereIn('test_sites.ts_id', $data['testSiteId']);
            $query = $query->groupBy(DB::raw('test_sites.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'monthly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive + monthly_reports_pages.test_' . $l . '_nonreactive + monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_kit_used');
            }
            if ($arr['no_of_test'] == 1) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as total_invalid');
            } elseif ($arr['no_of_test'] == 2) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid) as total_invalid');
            } elseif ($arr['no_of_test'] == 3) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid) as total_invalid');
            } else {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid + monthly_reports_pages.test_4_invalid) as total_invalid');
            }
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as month');
            //$query = $query->groupBy(DB::raw('MONTH(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('MONTH(monthly_reports_pages.end_test_date)'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'yearly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive + monthly_reports_pages.test_' . $l . '_nonreactive + monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_kit_used');
            }
            if ($arr['no_of_test'] == 1) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as total_invalid');
            } elseif ($arr['no_of_test'] == 2) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid) as total_invalid');
            } elseif ($arr['no_of_test'] == 3) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid) as total_invalid');
            } else {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid + monthly_reports_pages.test_4_invalid) as total_invalid');
            }
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%Y") as year');
            //$query = $query->groupBy(DB::raw('YEAR(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('YEAR(monthly_reports_pages.end_test_date)'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'quaterly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive + monthly_reports_pages.test_' . $l . '_nonreactive + monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_kit_used');
            }
            if ($arr['no_of_test'] == 1) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as total_invalid');
            } elseif ($arr['no_of_test'] == 2) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid) as total_invalid');
            } elseif ($arr['no_of_test'] == 3) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid) as total_invalid');
            } else {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid + monthly_reports_pages.test_4_invalid) as total_invalid');
            }
            $query = $query->selectRaw('YEAR(monthly_reports_pages.end_test_date) as end_test_date');
            $query = $query->selectRaw("(CASE WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 1  AND 3  THEN 'Q4' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 4  AND 6  THEN 'Q1' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 7  AND 9  THEN 'Q2' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 10 AND 12 THEN 'Q3' END) AS quarterly");

            $query =  $query->selectRaw("DATE_FORMAT(monthly_reports_pages.end_test_date,'%Y') as quaYear");

            //$query = $query->groupBy(DB::raw('QUARTER(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('QUARTER(monthly_reports_pages.end_test_date)'));
        }
        $salesResult = $query->get();

        $result['reportFrequency'] = $data['reportFrequency'];
        $result['res'] = $salesResult;
        // dd(DB::getQueryLog($salesResult));die;

        return $result;
    }

    // Custom Report

    public function fetchCustomMonthlyReport($params)
    {
        $commonservice = new CommonService();
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        $user_id = session('userId');
        $result = array();
        $data = $params;
        $start_date = '';
        $end_date = '';
        if (isset($data['searchDate']) && $data['searchDate'] != '') {
            $sDate = explode("to", $data['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        //DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id');

        if (Session::get('tsId') != '') {
            $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                ->where('users_testsite_map.user_id', '=', $user_id);
        }
        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->where('monthly_reports_pages.start_test_date',  '>=', $start_date)
                    ->where('monthly_reports_pages.end_test_date', '<=', $end_date)
                    ->whereDate('monthly_reports_pages.end_test_date', '>=', $start_date);
            });
        }
        if (isset($data['algorithmType']) && $data['algorithmType'] != '') {
            $query = $query->whereIn('monthly_reports.algorithm_type', $data['algorithmType']);
            $query = $query->groupBy(DB::raw('monthly_reports.mr_id'));
        }
        if (isset($data['testSiteId']) && $data['testSiteId'] != '') {
            $query = $query->whereIn('test_sites.ts_id', $data['testSiteId']);
            $query = $query->groupBy(DB::raw('test_sites.ts_id'));
        }
        if (isset($data['provinceId']) && $data['provinceId'] != '') {
            $query = $query->whereIn('provinces.province_id', $data['provinceId']);
            $query = $query->groupBy(DB::raw('provinces.province_id'));
        }
        if (isset($data['districtId']) && $data['districtId'] != '') {
            $query = $query->whereIn('districts.district_id', $data['districtId']);
            $query = $query->groupBy(DB::raw('districts.district_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'monthly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive) as test_' . $l . '_reactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_invalid');
            }
            $query = $query->selectRaw('sum(monthly_reports_pages.final_positive) as final');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as month');
            //$query = $query->groupBy(DB::raw('MONTH(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('MONTH(monthly_reports_pages.end_test_date)'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'yearly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive) as test_' . $l . '_reactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_invalid');
            }
            $query = $query->selectRaw('sum(monthly_reports_pages.final_positive) as final');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%Y") as year');
            //$query = $query->groupBy(DB::raw('YEAR(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('YEAR(monthly_reports_pages.end_test_date)'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'quaterly') {
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_reactive) as test_' . $l . '_reactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_nonreactive) as test_' . $l . '_nonreactive');
                $query = $query->selectRaw('sum(monthly_reports_pages.test_' . $l . '_invalid) as test_' . $l . '_invalid');
            }
            $query = $query->selectRaw('sum(monthly_reports_pages.final_positive) as final');
            $query = $query->selectRaw('YEAR(monthly_reports_pages.end_test_date) as end_test_date');
            $query = $query->selectRaw("(CASE WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 1  AND 3  THEN 'Q4' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 4  AND 6  THEN 'Q1' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 7  AND 9  THEN 'Q2' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 10 AND 12 THEN 'Q3' END) AS quarterly");

            $query =  $query->selectRaw("DATE_FORMAT(monthly_reports_pages.end_test_date,'%Y') as quaYear");

            //$query = $query->groupBy(DB::raw('QUARTER(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
            $query = $query->groupBy(DB::raw('monthly_reports.ts_id'), DB::raw('QUARTER(monthly_reports_pages.end_test_date)'));
        }
        $salesResult = $query->get();
        // dd(DB::getQueryLog($salesResult));die;
        $result['reportFrequency'] = $data['reportFrequency'];
        $result['res'] = $salesResult;
        return $result;
    }

    //Not Reported Sites
    public function fetchNotReportedSites($request)
    {
        $commonservice = new CommonService();
        $start_date = '';
        $end_date = '';
        $data = $request;
        if (isset($data['searchDate']) && $data['searchDate'] != '') {
            $sDate = explode("to", $data['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        
        $query = DB::table('users_testsite_map')
            ->select('test_sites.ts_id', 'test_sites.site_name', 'provinces.province_name', 'districts.district_name', 'sub_districts.sub_district_name', 'test_sites.updated_on')
            ->join('test_sites', 'test_sites.ts_id', '=', 'users_testsite_map.ts_id')
            ->leftjoin('monthly_reports', 'monthly_reports.ts_id', '=','users_testsite_map.ts_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'test_sites.site_province')
            ->leftjoin('districts', 'districts.district_id', '=', 'test_sites.site_district')
            ->leftjoin('sub_districts', 'sub_districts.district_id', '=', 'test_sites.site_sub_district')            
            ->whereIn('users_testsite_map.ts_id', Session::get('tsId'))
            ->Where('monthly_reports.ts_id',NULL)
            ->GroupBy('test_sites.ts_id');

            if (trim($start_date) != "" && trim($end_date) != "") {
                $query = $query->where(function ($query) use ($start_date, $end_date) {
                    $query->where('test_sites.created_on',  '>=', $start_date)
                        ->where('test_sites.created_on', '<=', $end_date)
                        ->whereDate('test_sites.created_on', '>=', $start_date);
                });
            }
            if (isset($data['provinceId']) && $data['provinceId'] != '') {
                $query = $query->whereIn('provinces.province_id', $data['provinceId']);
                $query = $query->groupBy(DB::raw('provinces.province_id'));
            }
            if (isset($data['districtId']) && $data['districtId'] != '') {
                $query = $query->whereIn('districts.district_id', $data['districtId']);
                $query = $query->groupBy(DB::raw('districts.district_id'));
            }
            if (isset($data['subDistrictId']) && $data['subDistrictId'] != '') {
                $query = $query->whereIn('sub_districts.sub_district_id', $data['subDistrictId']);
                $query = $query->groupBy(DB::raw('sub_districts.sub_district_id'));
            }
            $data=$query->get();
            return $data;
    }
    
    public function importMonthlyReportData($request)
    {
        $user_name = session('name');
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'grade_excel'  => 'required|mimes:xls,xlsx'
        ]);
        // dd($data);
        $autoId = 0;
        $commonservice = new CommonService();
        $model = new TestSiteTable();
        $rslt = "";
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $dateTime = date('Ymd_His');
                $file = $request->file('grade_excel');
                $fileName = $dateTime . '-' . $file->getClientOriginalName();
                $savePath = public_path('/uploads/');
                move_uploaded_file($_FILES['grade_excel']['tmp_name'], $savePath . $fileName);
                $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($savePath . $fileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
                $reader->setReadDataOnly(TRUE);
                $reader->setReadEmptyCells(FALSE);
                $spreadsheet = $reader->load($savePath . $fileName);
                unlink($savePath . $fileName);
                $array = $spreadsheet->getActiveSheet()->toArray();
                // $array =  Excel::toArray(new MonthlyReportDataUpload(), $savePath . $fileName);
                $rowCnt = 1;
                $cnt = 0;
                $rslt = "";
                $GlobalConfigService = new GlobalConfigService();
                $result = $GlobalConfigService->getAllGlobalConfig();
                $arr = array();
                // now we create an associative array so that we can easily create view variables
                for ($i = 0; $i < sizeof($result); $i++) {
                    $arr[$result[$i]->global_name] = $result[$i]->global_value;
                }
                $notInsertRowArray = array();
                $notInsertRow = 0;

                foreach ($array as $row) {
                    if ($rowCnt > 1) {

                        $isDataValid = $this->isValidData($row);
                        $comment = !$isDataValid ? $this->getErrorComment($row) : '';

                        if ($isDataValid) {
                            $reporting_date = '';
                            if (is_numeric($row[11])) {
                                $reporting_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[11])->format('M-Y');
                            } else if (is_string($row[11])) {
                                $reporting_date = date('M-Y', strtotime($row[11]));
                            }
                            $dateOfCollection = '';
                            if (is_numeric($row[10])) {
                                $dateOfCollection = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y-m-d');
                            } else if (is_string($row[10])) {
                                $dateOfCollection = date('Y-m-d', strtotime($row[10]));
                            }
                            $startDate = '';
                            if (is_numeric($row[15])) {
                                $startDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15])->format('Y-m-d');
                            } else if (is_string($row[15])) {
                                $startDate = date('Y-m-d', strtotime($row[15]));
                            }


                            $endDate = '';
                            if (is_numeric($row[16])) {
                                $endDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16])->format('Y-m-d');
                            } else if (is_string($row[16])) {
                                $endDate = date('Y-m-d', strtotime($row[16]));
                            }
                            $expiryDate1 = '';
                            if (is_numeric($row[19])) {
                                $expiryDate1 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19])->format('Y-m-d');
                            } else if (is_string($row[19])) {
                                $expiryDate1 = date('Y-m-d', strtotime($row[19]));
                            }
                            $test_site_name = $row[0];
                            $site_type = $row[1];
                            
                            $province = $row[2];
                            $site_manager = $row[3];
                            $site_unique_id = $row[4];
                            $tester_name = $row[5];
                            $if_flc = $row[6];
                            $is_recency = $row[7];
                            $contact_no = $row[8];
                            $algo_type = $row[9];
                            $date_of_collection = $dateOfCollection;
                            $report_months = $reporting_date;
                            $book_no = $row[12];
                            $name_of_collector = $row[13] == "" ? $user_name : $row[13];
                            $page_no = $row[14] == "" ? 0 : $row[14];
                            $start_date = $startDate;
                            $end_date = $endDate;
                            if ($arr['no_of_test'] >= 1) {
                                $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row[18]))
                                    ->get();
                                if (count($testkitData) > 0) {
                                    $testkitId = $testkitData[0]->tk_id;
                                } else {
                                    $testkitId = DB::table('test_kits')->insertGetId(
                                        [
                                            'test_kit_name' => trim($row[18]),
                                            'test_kit_status' => 'active',
                                        ]
                                    );
                                }
                                $test_kit1 = $testkitId;
                                $lot_no1 = $row[18];
                                $expiry_date1 = $expiryDate1;
                                $testkit1_reactive = $row[20];
                                $testkit1_nonreactive = $row[21];
                                $testkit1_invalid = $row[22];
                            }
                            if ($arr['no_of_test'] >= 2) {
                                $expiryDate2 = '';
                                if (is_numeric($row[25])) {
                                    $expiryDate2 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[25])->format('Y-m-d');
                                } else if (is_string($row[25])) {
                                    $expiryDate2 = date('Y-m-d', strtotime($row[25]));
                                }
                                $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row[23]))
                                    ->get();
                                if (count($testkitData) > 0) {
                                    $testkitId = $testkitData[0]->tk_id;
                                } else {
                                    $testkitId = DB::table('test_kits')->insertGetId(
                                        [
                                            'test_kit_name' => trim($row[23]),
                                            'test_kit_status' => 'active',
                                        ]
                                    );
                                }
                                $test_kit2 = $testkitId;
                                $lot_no2 = $row[24];
                                $expiry_date2 = $expiryDate2;
                                $testkit2_reactive = $row[26];
                                $testkit2_nonreactive = $row[27];
                                $testkit2_invalid = $row[28];
                            }
                            if ($arr['no_of_test'] >= 3) {
                                $expiryDate3 = '';
                                if (is_numeric($row[31])) {
                                    $expiryDate3 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[31])->format('Y-m-d');
                                } else if (is_string($row[31])) {
                                    $expiryDate3 = date('Y-m-d', strtotime($row[31]));
                                }
                                $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row[29]))
                                    ->get();
                                if (count($testkitData) > 0) {
                                    $testkitId = $testkitData[0]->tk_id;
                                } else {
                                    $testkitId = DB::table('test_kits')->insertGetId(
                                        [
                                            'test_kit_name' => trim($row[29]),
                                            'test_kit_status' => 'active',
                                        ]
                                    );
                                }
                                $test_kit3 = $testkitId;
                                $lot_no3 = $row[30];
                                $expiry_date3 = $expiryDate3;
                                $testkit3_reactive = $row[32];
                                $testkit3_nonreactive = $row[33];
                                $testkit3_invalid = $row[34];
                            }
                            if ($arr['no_of_test'] >= 4) {
                                $expiryDate4 = '';
                                if (is_numeric($row[37])) {
                                    $expiryDate4 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[37])->format('Y-m-d');
                                } else if (is_string($row[37])) {
                                    $expiryDate4 = date('Y-m-d', strtotime($row[37]));
                                }
                                $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row[35]))
                                    ->get();
                                if (count($testkitData) > 0) {
                                    $testkitId = $testkitData[0]->tk_id;
                                } else {
                                    $testkitId = DB::table('test_kits')->insertGetId(
                                        [
                                            'test_kit_name' => trim($row[35]),
                                            'test_kit_status' => 'active',
                                        ]
                                    );
                                }
                                $test_kit4 = $testkitId;
                                $lot_no4 = $row[36];
                                $expiry_date4 = $expiryDate4;
                                $testkit4_reactive = $row[38];
                                $testkit4_nonreactive = $row[39];
                                $testkit4_invalid = $row[40];
                            }
                            if ($arr['no_of_test'] == 1) {
                                $final_positive = $row[23];
                                $final_negative = $row[24];
                                $final_indeterminate = $row[25];
                            } else if ($arr['no_of_test'] == 2) {
                                $final_positive = $row[29];
                                $final_negative = $row[30];
                                $final_indeterminate = $row[31];
                            } else if ($arr['no_of_test'] == 3) {
                                $final_positive = $row[35];
                                $final_negative = $row[36];
                                $final_indeterminate = $row[37];
                            } else if ($arr['no_of_test'] == 4) {
                                $final_positive = $row[41];
                                $final_negative = $row[42];
                                $final_indeterminate = $row[43];
                            }

                            $siteTypeData = DB::table('site_types')
                                ->where('site_type_name', '=', trim($site_type))
                                ->get();
                            if (count($siteTypeData) > 0) {
                                $siteTypeId = $siteTypeData[0]->st_id;
                            } else {
                                $siteTypeId = DB::table('site_types')->insertGetId(
                                    [
                                        'site_type_name' => trim($site_type),
                                        'site_type_status' => 'active',
                                    ]
                                );
                            }
                            
                            $testsiteData = DB::table('test_sites')
                                ->where('site_name', '=', trim($test_site_name))
                                ->get();
                            if (count($testsiteData) > 0) {
                                $testSiteId = $testsiteData[0]->ts_id;
                            } else {
                                $testSiteId = DB::table('test_sites')->insertGetId(
                                    [
                                        'site_name' => trim($test_site_name),
                                        'test_site_status' => 'active',                                        
                                    ]
                                );
                            }

                            $districtId = $model->fetchDistrictId($testSiteId);
                            $subDistrictId = $model->fetchSubDistrictId($testSiteId);
                            $latitude = $model->fetchLatitudeValue($testSiteId);
                            $longitude = $model->fetchLongitudeValue($testSiteId);

                            $provinceData = DB::table('provinces')
                                ->where('province_name', '=', trim($province))
                                ->get();
                            if (count($provinceData) > 0) {
                                $provinceId = $provinceData[0]->province_id;
                            } else {
                                $provinceId = DB::table('provinces')->insertGetId(
                                    [
                                        'province_name' => trim($province),
                                        'province_status' => 'active',
                                    ]
                                );
                            }
                            $duplicateCheck = DB::table('monthly_reports')
                                ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
                                ->where('ts_id', '=', $testSiteId)
                                ->where('st_id', '=', $siteTypeId)
                                ->where('reporting_month', '=', $report_months)
                                //->where('book_no', '=', $book_no)
                                ->where('monthly_reports_pages.page_no', '=', $page_no)
                                ->get();

                            if (count($duplicateCheck) == 0) {
                                $monthyReportVal = DB::table('monthly_reports')
                                    ->where('ts_id', '=', $testSiteId)
                                    ->where('reporting_month', '=', $report_months)
                                    ->where('book_no', '=', $book_no)
                                    ->get();
                                if (count($monthyReportVal) > 0) {
                                    $mr_id = $monthyReportVal[0]->mr_id;
                                } else {
                                    $mr_id = DB::table('monthly_reports')->insertGetId(
                                        [
                                            'province_id' => $provinceId,
                                            'site_unique_id' => $site_unique_id,
                                            'ts_id' => $testSiteId,
                                            'st_id' => $siteTypeId,
                                            'site_manager' => $site_manager,
                                            'is_flc' => $if_flc,
                                            'is_recency' => $is_recency,
                                            'contact_no' => $contact_no,
                                            //'algorithm_type' => $algo_type,
                                            'date_of_data_collection' => $date_of_collection,
                                            'reporting_month' => $report_months,
                                            'book_no' => $book_no,
                                            'name_of_data_collector' => $name_of_collector,
                                            'source' => 'excel',
                                            'added_on' => date('Y-m-d'),
                                            'added_by' => session('userId'),
                                            'district_id' => $districtId,
                                            'sub_district_id' => $subDistrictId,
                                            'tester_name' => $tester_name,
                                            'latitude' => $latitude,
                                            'longitude' => $longitude,
                                            'file_name' => $fileName,
                                            'last_modified_on' => $commonservice->getDateTime(),

                                        ]
                                    );
                                }
                                $insMonthlyArr = array(
                                    'mr_id' => $mr_id,
                                    'page_no' => $page_no,
                                    'start_test_date' => $start_date,
                                    'end_test_date' => $end_date,
                                    'final_positive' => $final_positive,
                                    'final_negative' => $final_negative,
                                    'final_undetermined' => $final_indeterminate,
                                    'created_on' => $commonservice->getDateTime(),
                                    'created_by' => session('userId'),
                                );
                                if ($arr['no_of_test'] >= 1) {
                                    $insMonthlyArr['test_1_kit_id'] = $test_kit1;
                                    $insMonthlyArr['lot_no_1'] = $lot_no1;
                                    $insMonthlyArr['expiry_date_1'] = $expiry_date1;
                                    $insMonthlyArr['test_1_reactive'] = $testkit1_reactive;
                                    $insMonthlyArr['test_1_nonreactive'] = $testkit1_nonreactive;
                                    $insMonthlyArr['test_1_invalid'] = $testkit1_invalid;
                                }
                                if ($arr['no_of_test'] >= 2) {
                                    $insMonthlyArr['test_2_kit_id'] = $test_kit2;
                                    $insMonthlyArr['lot_no_2'] = $lot_no2;
                                    $insMonthlyArr['expiry_date_2'] = $expiry_date2;
                                    $insMonthlyArr['test_2_reactive'] = $testkit2_reactive;
                                    $insMonthlyArr['test_2_nonreactive'] = $testkit2_nonreactive;
                                    $insMonthlyArr['test_2_invalid'] = $testkit2_invalid;
                                }
                                if ($arr['no_of_test'] >= 3) {
                                    $insMonthlyArr['test_3_kit_id'] = $test_kit3;
                                    $insMonthlyArr['lot_no_3'] = $lot_no3;
                                    $insMonthlyArr['expiry_date_3'] = $expiry_date3;
                                    $insMonthlyArr['test_3_reactive'] = $testkit3_reactive;
                                    $insMonthlyArr['test_3_nonreactive'] = $testkit3_nonreactive;
                                    $insMonthlyArr['test_3_invalid'] = $testkit3_invalid;
                                }
                                if ($arr['no_of_test'] >= 4) {
                                    $insMonthlyArr['test_4_kit_id'] = $test_kit4;
                                    $insMonthlyArr['lot_no_4'] = $lot_no4;
                                    $insMonthlyArr['expiry_date_4'] = $expiry_date4;
                                    $insMonthlyArr['test_4_reactive'] = $testkit4_reactive;
                                    $insMonthlyArr['test_4_nonreactive'] = $testkit4_nonreactive;
                                    $insMonthlyArr['test_4_invalid'] = $testkit4_invalid;
                                }
                                $totalPositive = $final_positive;
                                $totalTested = (int)$testkit1_reactive + (int)$testkit1_nonreactive;
                                $positivePercentage = ((int)$totalTested == 0) ? 'N.A' : number_format((int)$totalPositive * 100 / (int)$totalTested, 2);
                                $posAgreement = 0;
                                $OverallAgreement = 0;
                                if ((int)$testkit1_reactive > 0)
                                    $posAgreement = number_format(100 * ((int)$testkit2_reactive) / ((int)$testkit1_reactive), 2);
                                if (((int)$testkit1_reactive + (int)$testkit1_nonreactive) > 0)
                                    $OverallAgreement = number_format(100 * ((int)$testkit2_reactive + (int)$testkit1_nonreactive) / ((int)$testkit1_reactive + (int)$testkit1_nonreactive), 2);
                                $insMonthlyArr['positive_percentage'] = $positivePercentage;
                                $insMonthlyArr['positive_agreement'] = $posAgreement;
                                $insMonthlyArr['overall_agreement'] = $OverallAgreement;

                                $monthly_reports_pages = DB::table('monthly_reports_pages')->insertGetId($insMonthlyArr);
                                if ($monthly_reports_pages) {
                                    $cnt++;
                                } else {

                                    //Failed Imports - Excel Uploads
                                    /*
                                    $test_site_name = $row[0];
                                    $site_type = $row[1];
                                    
                                    $province = $row[2];
                                    $site_manager = $row[3];
                                    $site_unique_id = $row[4];
                                    $tester_name = $row[5];
                                    $if_flc = $row[6];
                                    $is_recency = $row[7];
                                    $contact_no = $row[8];
                                    $algo_type = $row[9];
                                    */
                                    //$commentArray=array();
                                    $startDate = '';
                                    if (is_numeric($row[15])) {
                                        $startDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15])->format('Y-m-d');
                                    } else if (is_string($row[15])) {
                                        $startDate = date('Y-m-d', strtotime($row[15]));
                                    }

                                    $endDate = '';
                                    if (is_numeric($row[16])) {
                                        $endDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16])->format('Y-m-d');
                                    } else if (is_string($row[16])) {
                                        $endDate = date('Y-m-d', strtotime($row[16]));
                                    }

                                    $expiryDate1 = '';
                                    if (is_numeric($row[19])) {
                                        $expiryDate1 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19])->format('Y-m-d');
                                    } else if (is_string($row[19])) {
                                        $expiryDate1 = date('Y-m-d', strtotime($row[19]));
                                    }

                                    $dateOfCollection = '';
                                    if (is_numeric($row[10])) {
                                        $dateOfCollection = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y-m-d');
                                    } else if (is_string($row[10])) {
                                        $dateOfCollection = date('Y-m-d', strtotime($row[10]));
                                    }

                                    $date_of_collection = $dateOfCollection;
                                    $report_months = $reporting_date;
                                    $book_no = $row[12];
                                    $name_of_collector = $row[13] == "" ? $user_name : $row[13];;
                                    $page_no = $row[14] == "" ? 0 : $row[14];
                                    $start_date = $startDate;
                                    $end_date = $endDate;
                                    $expiry_date1 = $expiryDate1;
                                    // $start_date = $row[15];
                                    // $end_date = $row[16];
                                    /*
                                    if ($arr['no_of_test'] == 1) {
                                        $final_positive = $row[23];
                                        $final_negative = $row[24];
                                        $final_indeterminate = $row[25];

                                    } else if ($arr['no_of_test'] == 2) {
                                        $final_positive = $row[29];
                                        $final_negative = $row[30];
                                        $final_indeterminate = $row[31];
                                    } else if ($arr['no_of_test'] == 3) {
                                        $final_positive = $row[35];
                                        $final_negative = $row[36];
                                        $final_indeterminate = $row[37];
                                    } else if ($arr['no_of_test'] == 4) {
                                        $final_positive = $row[41];
                                        $final_negative = $row[42];
                                        $final_indeterminate = $row[43];
                                    }
                                    */

                                    $unLoadData = array(
                                        'test_site_name' => $test_site_name,
                                        'site_type' => $site_type,
                                        'province_name' => $province,
                                        'site_manager' => $site_manager,
                                        'site_unique_id' => $site_unique_id,
                                        'tester_name' => $tester_name,
                                        'is_flc' => $if_flc,
                                        'is_recency' => $is_recency,
                                        'contact_no' => $contact_no,
                                        //'algorithm_type' => $algo_type,
                                        'date_of_data_collection' => $date_of_collection,
                                        'reporting_month' => $report_months,
                                        'book_no' => $book_no,
                                        'name_of_data_collector' => $name_of_collector,
                                        'source' => 'excel',
                                        'page_no' => $page_no,
                                        'start_test_date' => $start_date,
                                        'end_test_date' => $end_date,
                                        'final_positive' => $final_positive,
                                        'final_negative' => $final_negative,
                                        'final_undetermined' => $final_indeterminate,
                                        'added_on' => $commonservice->getDateTime(),
                                        'added_by' => session('userId'),
                                        'file_name' => $fileName,
                                        'comment' =>  $comment,
                                    );

                                    if ($arr['no_of_test'] >= 1) {
                                        $unLoadData['test_kit_name1'] = trim($row[17]);
                                        $unLoadData['lot_no_1'] = $row[18];
                                        $unLoadData['expiry_date_1'] = $expiry_date1;
                                        $unLoadData['test_1_reactive'] = $row[20];
                                        $unLoadData['test_1_non_reactive'] = $row[21];
                                        $unLoadData['test_1_invalid'] = $row[22];
                                    }
                                    if ($arr['no_of_test'] >= 2) {
                                        $unLoadData['test_kit_name2'] = trim($row[23]);
                                        $unLoadData['lot_no_2'] = $row[24];
                                        $unLoadData['expiry_date_2'] = $row[25];
                                        $unLoadData['test_2_reactive'] = $row[26];
                                        $unLoadData['test_2_non_reactive'] = $row[27];
                                        $unLoadData['test_2_invalid'] = $row[28];
                                    }
                                    if ($arr['no_of_test'] >= 3) {
                                        $unLoadData['test_kit_name3'] = trim($row[29]);
                                        $unLoadData['lot_no_3'] = $row[30];
                                        $unLoadData['expiry_date_3'] = $row[31];
                                        $unLoadData['test_3_reactive'] = $row[32];
                                        $unLoadData['test_3_non_reactive'] = $row[33];
                                        $unLoadData['test_3_invalid'] = $row[34];
                                    }
                                    if ($arr['no_of_test'] >= 4) {
                                        $unLoadData['test_kit_name4'] = trim($row[35]);
                                        $unLoadData['lot_no_4'] = $row[36];
                                        $unLoadData['expiry_date_4'] = $row[37];
                                        $unLoadData['test_4_reactive'] = $row[38];
                                        $unLoadData['test_4_non_reactive'] = $row[39];
                                        $unLoadData['test_4_invalid'] = $row[40];
                                    }

                                    $nu_mr_id = DB::table('not_uploaded_monthly_reports')->insertGetId($unLoadData);

                                    $notInsertRow++;
                                    //array_push($notInsertRowArray,$rowCnt);
                                }
                            } else {
                                //Failed Imports - Excel Uploads
                                /*
                                    $test_site_name = $row[0];
                                    $site_type = $row[1];
                                    
                                    $province = $row[2];
                                    $site_manager = $row[3];
                                    $site_unique_id = $row[4];
                                    $tester_name = $row[5];
                                    $if_flc = $row[6];
                                    $is_recency = $row[7];
                                    $contact_no = $row[8];
                                    $algo_type = $row[9];
                                    */
                                //$commentArray=array();
                                $startDate = '';
                                if (is_numeric($row[15])) {
                                    $startDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15])->format('Y-m-d');
                                } else if (is_string($row[15])) {
                                    $startDate = date('Y-m-d', strtotime($row[15]));
                                }

                                $endDate = '';
                                if (is_numeric($row[16])) {
                                    $endDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16])->format('Y-m-d');
                                } else if (is_string($row[16])) {
                                    $endDate = date('Y-m-d', strtotime($row[16]));
                                }

                                $expiryDate1 = '';
                                if (is_numeric($row[19])) {
                                    $expiryDate1 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19])->format('Y-m-d');
                                } else if (is_string($row[19])) {
                                    $expiryDate1 = date('Y-m-d', strtotime($row[19]));
                                }

                                $dateOfCollection = '';
                                if (is_numeric($row[10])) {
                                    $dateOfCollection = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y-m-d');
                                } else if (is_string($row[10])) {
                                    $dateOfCollection = date('Y-m-d', strtotime($row[10]));
                                }

                                $date_of_collection = $dateOfCollection;
                                $report_months = $reporting_date;
                                $book_no = $row[12];
                                $name_of_collector = $row[13] == "" ? $user_name : $row[13];;
                                $page_no = $row[14] == "" ? 0 : $row[14];
                                $start_date = $startDate;
                                $end_date = $endDate;
                                $expiry_date1 = $expiryDate1;
                                // $start_date = $row[15];
                                // $end_date = $row[16];
                                /*
                                    if ($arr['no_of_test'] == 1) {
                                        $final_positive = $row[23];
                                        $final_negative = $row[24];
                                        $final_indeterminate = $row[25];

                                    } else if ($arr['no_of_test'] == 2) {
                                        $final_positive = $row[29];
                                        $final_negative = $row[30];
                                        $final_indeterminate = $row[31];
                                    } else if ($arr['no_of_test'] == 3) {
                                        $final_positive = $row[35];
                                        $final_negative = $row[36];
                                        $final_indeterminate = $row[37];
                                    } else if ($arr['no_of_test'] == 4) {
                                        $final_positive = $row[41];
                                        $final_negative = $row[42];
                                        $final_indeterminate = $row[43];
                                    }
                                    */

                                $unLoadData = array(
                                    'test_site_name' => $test_site_name,
                                    'site_type' => $site_type,
                                    'province_name' => $province,
                                    'site_manager' => $site_manager,
                                    'site_unique_id' => $site_unique_id,
                                    'tester_name' => $tester_name,
                                    'is_flc' => $if_flc,
                                    'is_recency' => $is_recency,
                                    'contact_no' => $contact_no,
                                    //'algorithm_type' => $algo_type,
                                    'date_of_data_collection' => $date_of_collection,
                                    'reporting_month' => $report_months,
                                    'book_no' => $book_no,
                                    'name_of_data_collector' => $name_of_collector,
                                    'source' => 'excel',
                                    'page_no' => $page_no,
                                    'start_test_date' => $start_date,
                                    'end_test_date' => $end_date,
                                    'final_positive' => $final_positive,
                                    'final_negative' => $final_negative,
                                    'final_undetermined' => $final_indeterminate,
                                    'added_on' => $commonservice->getDateTime(),
                                    'added_by' => session('userId'),
                                    'file_name' => $fileName,
                                    'comment' =>  'Duplicate Entry',
                                );

                                if ($arr['no_of_test'] >= 1) {
                                    $unLoadData['test_kit_name1'] = trim($row[17]);
                                    $unLoadData['lot_no_1'] = $row[18];
                                    $unLoadData['expiry_date_1'] = $expiry_date1;
                                    $unLoadData['test_1_reactive'] = $row[20];
                                    $unLoadData['test_1_non_reactive'] = $row[21];
                                    $unLoadData['test_1_invalid'] = $row[22];
                                }
                                if ($arr['no_of_test'] >= 2) {
                                    $unLoadData['test_kit_name2'] = trim($row[23]);
                                    $unLoadData['lot_no_2'] = $row[24];
                                    $unLoadData['expiry_date_2'] = $row[25];
                                    $unLoadData['test_2_reactive'] = $row[26];
                                    $unLoadData['test_2_non_reactive'] = $row[27];
                                    $unLoadData['test_2_invalid'] = $row[28];
                                }
                                if ($arr['no_of_test'] >= 3) {
                                    $unLoadData['test_kit_name3'] = trim($row[29]);
                                    $unLoadData['lot_no_3'] = $row[30];
                                    $unLoadData['expiry_date_3'] = $row[31];
                                    $unLoadData['test_3_reactive'] = $row[32];
                                    $unLoadData['test_3_non_reactive'] = $row[33];
                                    $unLoadData['test_3_invalid'] = $row[34];
                                }
                                if ($arr['no_of_test'] >= 4) {
                                    $unLoadData['test_kit_name4'] = trim($row[35]);
                                    $unLoadData['lot_no_4'] = $row[36];
                                    $unLoadData['expiry_date_4'] = $row[37];
                                    $unLoadData['test_4_reactive'] = $row[38];
                                    $unLoadData['test_4_non_reactive'] = $row[39];
                                    $unLoadData['test_4_invalid'] = $row[40];
                                }

                                $nu_mr_id = DB::table('not_uploaded_monthly_reports')->insertGetId($unLoadData);

                                $notInsertRow++;
                                //array_push($notInsertRowArray,$rowCnt);
                            }
                        } else {
                            //Failed Imports - Excel Uploads
                            $startDate = '';
                            if (is_numeric($row[15])) {
                                $startDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15])->format('Y-m-d');
                            } else if (is_string($row[15])) {
                                $startDate = date('Y-m-d', strtotime($row[15]));
                            }

                            $endDate = '';
                            if (is_numeric($row[16])) {
                                $endDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16])->format('Y-m-d');
                            } else if (is_string($row[16])) {
                                $endDate = date('Y-m-d', strtotime($row[16]));
                            }

                            $expiryDate1 = '';
                            if (is_numeric($row[19])) {
                                $expiryDate1 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19])->format('Y-m-d');
                            } else if (is_string($row[19])) {
                                $expiryDate1 = date('Y-m-d', strtotime($row[19]));
                            }

                            $reporting_date = '';
                            if (is_numeric($row[11])) {
                                $reporting_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[11])->format('M-Y');
                            } else if (is_string($row[11])) {
                                $reporting_date = date('M-Y', strtotime($row[11]));
                            }

                            $dateOfCollection = '';
                            if (is_numeric($row[10])) {
                                $dateOfCollection = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y-m-d');
                            } else if (is_string($row[10])) {
                                $dateOfCollection = date('Y-m-d', strtotime($row[10]));
                            }

                            $test_site_name = $row[0];
                            $site_type = $row[1];
                            
                            $province = $row[2];
                            $site_manager = $row[3];
                            $site_unique_id = $row[4];
                            $tester_name = $row[5];
                            $if_flc = $row[6];
                            $is_recency = $row[7];
                            $contact_no = $row[8];
                            $algo_type = $row[9];
                            $date_of_collection = $dateOfCollection;
                            $report_months = $reporting_date;
                            $book_no = $row[12];
                            $name_of_collector = $row[13] == "" ? $user_name : $row[13];
                            $page_no = $row[14] == "" ? 0 : $row[14];
                            $start_date = $startDate;
                            $end_date = $endDate;
                            $expiry_date1 = $expiryDate1;


                            if ($arr['no_of_test'] == 1) {
                                $final_positive = $row[23];
                                $final_negative = $row[24];
                                $final_indeterminate = $row[25];
                            } else if ($arr['no_of_test'] == 2) {
                                $final_positive = $row[29];
                                $final_negative = $row[30];
                                $final_indeterminate = $row[31];
                            } else if ($arr['no_of_test'] == 3) {
                                $final_positive = $row[35];
                                $final_negative = $row[36];
                                $final_indeterminate = $row[37];
                            } else if ($arr['no_of_test'] == 4) {
                                $final_positive = $row[41];
                                $final_negative = $row[42];
                                $final_indeterminate = $row[43];
                            }


                            $unLoadData = array(
                                'test_site_name' => $test_site_name,
                                'site_type' => $site_type,
                                'province_name' => $province,
                                'site_manager' => $site_manager,
                                'site_unique_id' => $site_unique_id,
                                'tester_name' => $tester_name,
                                'is_flc' => $if_flc,
                                'is_recency' => $is_recency,
                                'contact_no' => $contact_no,
                                //'algorithm_type' => $algo_type,
                                'date_of_data_collection' => $date_of_collection,
                                'reporting_month' => $report_months,
                                'book_no' => $book_no,
                                'name_of_data_collector' => $name_of_collector,
                                'source' => 'excel',
                                'page_no' => $page_no,
                                'start_test_date' => $start_date,
                                'end_test_date' => $end_date,
                                'final_positive' => $final_positive,
                                'final_negative' => $final_negative,
                                'final_undetermined' => $final_indeterminate,
                                'added_on' => $commonservice->getDateTime(),
                                'added_by' => session('userId'),
                                'file_name' => $fileName,
                                'comment' =>  $comment,
                            );

                            if ($arr['no_of_test'] >= 1) {
                                $unLoadData['test_kit_name1'] = trim($row[17]);
                                $unLoadData['lot_no_1'] = $row[18];
                                $unLoadData['expiry_date_1'] = $expiry_date1;
                                $unLoadData['test_1_reactive'] = $row[20];
                                $unLoadData['test_1_non_reactive'] = $row[21];
                                $unLoadData['test_1_invalid'] = $row[22];
                            }
                            if ($arr['no_of_test'] >= 2) {
                                $unLoadData['test_kit_name2'] = trim($row[23]);
                                $unLoadData['lot_no_2'] = $row[24];
                                $unLoadData['expiry_date_2'] = $row[25];
                                $unLoadData['test_2_reactive'] = $row[26];
                                $unLoadData['test_2_non_reactive'] = $row[27];
                                $unLoadData['test_2_invalid'] = $row[28];
                            }
                            if ($arr['no_of_test'] >= 3) {
                                $unLoadData['test_kit_name3'] = trim($row[29]);
                                $unLoadData['lot_no_3'] = $row[30];
                                $unLoadData['expiry_date_3'] = $row[31];
                                $unLoadData['test_3_reactive'] = $row[32];
                                $unLoadData['test_3_non_reactive'] = $row[33];
                                $unLoadData['test_3_invalid'] = $row[34];
                            }
                            if ($arr['no_of_test'] >= 4) {
                                $unLoadData['test_kit_name4'] = trim($row[35]);
                                $unLoadData['lot_no_4'] = $row[36];
                                $unLoadData['expiry_date_4'] = $row[37];
                                $unLoadData['test_4_reactive'] = $row[38];
                                $unLoadData['test_4_non_reactive'] = $row[39];
                                $unLoadData['test_4_invalid'] = $row[40];
                            }

                            $mr_id = DB::table('not_uploaded_monthly_reports')->insertGetId($unLoadData);
                            $notInsertRow++;
                            //array_push($notInsertRowArray,$rowCnt);
                        }
                    }
                    $rowCnt++;
                }
                if ($cnt > 0) {
                    $commonservice->eventLog('import-monthly-report', $user_name . ' has imported a new monthly report', 'monthly-report', $mr_id);
                }
                $rslt .= "File Name: " . $fileName . "<br/>";
                $rslt .= "No.of Records: " . ($cnt + $notInsertRow) . "<br/>";
                $rslt .= "No.of Records Uploaded Successfully: " . ($cnt) . "<br/>";
                $rslt .= "No.of Records not Uploaded: " . $notInsertRow . "<br/>";

                DB::commit();
            } catch (Exception $exc) {
                DB::rollBack();
                $exc->getMessage();
                $rslt .= "Nothing Updated <br>";
            }
        }
        // print($invStkId);die;
        return $rslt;
    }

    public function isValidData($row)
    {

        $validData = true;

        if (trim($row[0]) == '' || trim($row[1]) == '' || trim($row[2]) == '' || trim($row[5]) == '' || trim($row[6]) == '' || trim($row[11]) == '' || trim($row[15]) == '' || trim($row[16]) == '' || trim($row[17]) == '' || trim($row[18]) == '' || trim($row[19]) == '') {
            $validData = false;
        }

        return $validData;
    }

    public function getErrorComment($row)
    {

        $commentArray = array();

        if (trim($row[0]) == '') {
            array_push($commentArray, 'Test Site');
        }

        if (trim($row[1]) == '') {
            array_push($commentArray, 'Entry Point');
        }

        if (trim($row[2]) == '') {
            array_push($commentArray, 'Province');
        }

        if (trim($row[5]) == '') {
            array_push($commentArray, 'Lab Manager Name');
        }

        if (trim($row[6]) == '') {
            array_push($commentArray, 'Is FLC');
        }

        if (trim($row[11]) == '') {
            array_push($commentArray, 'Reporting Month');
        }

        if (trim($row[15]) == '') {
            array_push($commentArray, 'Start Date');
        }

        if (trim($row[16]) == '') {
            array_push($commentArray, 'End Date');
        }

        if (trim($row[17]) == '') {
            array_push($commentArray, 'Test Kit Name 1');
        }

        if (trim($row[18]) == '') {
            array_push($commentArray, 'Lot No.1');
        }

        if (trim($row[19]) == '') {
            array_push($commentArray, 'Expiry Date 1');
        }

        return implode(", ", $commentArray) . ' field(s) are missing';
    }

    // Invalid Result Report

    public function fetchInvalidResultReport($params)
    {
        $commonservice = new CommonService();
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        $user_id = session('userId');
        $data = $params;
        $start_date = '';
        $end_date = '';
        if (isset($data['searchDate']) && $data['searchDate'] != '') {
            $sDate = explode("to", $data['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        // DB::enableQueryLog();
        if ($arr['no_of_test'] == 1) {
            $query = DB::table('monthly_reports_pages')
                ->select('monthly_reports.*', 'monthly_reports_pages.*', 'test_sites.*', 'site_types.*', 'tk1.test_kit_name as testKit_1_name')
                ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
                ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->join('test_kits as tk1', 'tk1.tk_id', '=', 'monthly_reports_pages.test_1_kit_id')
                ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
                ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'monthly_reports.sub_district_id')
                ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id');

            if (Session::get('tsId') != '' && !isset($data['testSiteId'])) {
                $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                    ->where('users_testsite_map.user_id', '=', $user_id);
            }
        } elseif ($arr['no_of_test'] == 2) {
            $query = DB::table('monthly_reports_pages')
                ->select('monthly_reports.*', 'monthly_reports_pages.*', 'test_sites.*', 'site_types.*', 'tk1.test_kit_name as testKit_1_name', 'tk2.test_kit_name as testKit_2_name')
                ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
                ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->join('test_kits as tk1', 'tk1.tk_id', '=', 'monthly_reports_pages.test_1_kit_id')
                ->join('test_kits as tk2', 'tk2.tk_id', '=', 'monthly_reports_pages.test_2_kit_id')
                ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
                ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'monthly_reports.sub_district_id')
                ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id');

            if (Session::get('tsId') != '' && !isset($data['testSiteId'])) {
                $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                    ->where('users_testsite_map.user_id', '=', $user_id);
            }
        } elseif ($arr['no_of_test'] == 3) {
            $query = DB::table('monthly_reports_pages')
                ->select('monthly_reports.*', 'monthly_reports_pages.*',  'test_sites.*', 'site_types.*', 'tk1.test_kit_name as testKit_1_name', 'tk2.test_kit_name as testKit_2_name', 'tk3.test_kit_name as testKit_3_name')
                ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
                ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->join('test_kits as tk1', 'tk1.tk_id', '=', 'monthly_reports_pages.test_1_kit_id')
                ->join('test_kits as tk2', 'tk2.tk_id', '=', 'monthly_reports_pages.test_2_kit_id')
                ->join('test_kits as tk3', 'tk3.tk_id', '=', 'monthly_reports_pages.test_3_kit_id')
                ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
                ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'monthly_reports.sub_district_id')
                ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id');

            if (Session::get('tsId') != '' && !isset($data['testSiteId'])) {
                $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                    ->where('users_testsite_map.user_id', '=', $user_id);
            }
        } else {
            $query = DB::table('monthly_reports_pages')
                ->select('monthly_reports.*', 'monthly_reports_pages.*', 'test_sites.*', 'site_types.*', 'tk1.test_kit_name as testKit_1_name', 'tk2.test_kit_name as testKit_2_name', 'tk3.test_kit_name as testKit_3_name', 'tk4.test_kit_name as testKit_4_name')
                ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
                ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->join('test_kits as tk1', 'tk1.tk_id', '=', 'monthly_reports_pages.test_1_kit_id')
                ->join('test_kits as tk2', 'tk2.tk_id', '=', 'monthly_reports_pages.test_2_kit_id')
                ->join('test_kits as tk3', 'tk3.tk_id', '=', 'monthly_reports_pages.test_3_kit_id')
                ->join('test_kits as tk4', 'tk4.tk_id', '=', 'monthly_reports_pages.test_4_kit_id')
                ->leftjoin('districts', 'districts.district_id', '=', 'monthly_reports.district_id')
                ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'monthly_reports.sub_district_id')
                ->leftjoin('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id');

            if (Session::get('tsId') != '' && !isset($data['testSiteId'])) {
                $query->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
                    ->where('users_testsite_map.user_id', '=', $user_id);
            }
        }

        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->where('monthly_reports_pages.start_test_date',  '>=', $start_date)
                    ->where('monthly_reports_pages.end_test_date', '<=', $end_date);
            });
        }
        if (isset($data['provinceId']) && $data['provinceId'] != '') {
            $query = $query->whereIn('provinces.province_id', $data['provinceId']);
            $query = $query->groupBy(DB::raw('provinces.province_id'));
        }
        if (isset($data['districtId']) && $data['districtId'] != '') {
            $query = $query->whereIn('districts.district_id', $data['districtId']);
            $query = $query->groupBy(DB::raw('districts.district_id'));
        }
        if (isset($data['subDistrictId']) && $data['subDistrictId'] != '') {
            $query = $query->whereIn('sub_districts.sub_district_id', $data['subDistrictId']);
            $query = $query->groupBy(DB::raw('sub_districts.sub_district_id'));
        }
        if (isset($data['algorithmType']) && $data['algorithmType'] != '') {
            $query = $query->whereIn('monthly_reports.algorithm_type', $data['algorithmType']);
            $query = $query->groupBy(DB::raw('monthly_reports.algorithm_type'));
        }
        if (isset($data['testSiteId']) && $data['testSiteId'] != '') {
            $query = $query->whereIn('test_sites.ts_id', $data['testSiteId']);
            $query = $query->groupBy(DB::raw('test_sites.ts_id'));
        }
        $salesResult = $query->get();
        return $salesResult;
    }
    public function getLatestValue()
    {
        $res = DB::table('monthly_reports_pages')->latest('mrp_id')->first();
        // dd($res);
        return $res;
    }

    public function CheckPreLot($params)
    {
        $input = $params->all();
        $out = 0;
        $expire = $input['expfield'];
        $expireDate = $input['expiry'];
        $outArr = array();
        // print_r($input);die;
        $res = DB::table('monthly_reports_pages')->latest('mrp_id')
            ->where($input['field'], '=', $input['lot'])
            ->first();
        if (isset($res->$expire)) {
            if ($res->$expire == $expireDate) {
                $out = 1;
            } else {
                $outArr['expiry'] = date('d-m-Y', strtotime($res->$expire));
            }
        } else {
            $out = 2;
        }
        $outArr['status'] = $out;

        return $outArr;
    }

    // Fetch All Dashboard Filter Data
    public function fetchDashboardData($params)
    {
        $commonservice = new CommonService();
        $user_id = session('userId');
        $data = $params->all();
        $start_date = '';
        $end_date = '';
        if (isset($data['searchDate']) && $data['searchDate'] != '') {
            $sDate = explode("to", $data['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        DB::enableQueryLog();
        $query = DB::table('monthly_reports')
            ->select('monthly_reports.latitude', 'monthly_reports.longitude', 'test_sites.site_name')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->join('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
            ->where('users_testsite_map.user_id', $user_id)
            ->where('monthly_reports.latitude', '!=', null)->where('monthly_reports.longitude', '!=', null)
            ->groupby('monthly_reports.mr_id');
        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where('monthly_reports_pages.start_test_date', '>=', $start_date)->where('monthly_reports_pages.end_test_date', '<=', $end_date);
        }
        if (isset($data['provinceId']) && $data['provinceId'] != '') {
            $query = $query->where('monthly_reports.province_id', '=', $data['provinceId']);
        }
        $salesResult = $query->get();
        if (count($salesResult) == 0) {
            $query = DB::table('monthly_reports')
                ->select('monthly_reports.latitude', 'monthly_reports.longitude', 'test_sites.site_name')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
                ->join('provinces', 'provinces.province_id', '=', 'monthly_reports.province_id')
                ->where('monthly_reports.latitude', '!=', null)->where('monthly_reports.longitude', '!=', null)
                ->groupby('monthly_reports.mr_id');

            if (trim($start_date) != "" && trim($end_date) != "") {
                $query = $query->where('monthly_reports_pages.start_test_date', '>=', $start_date)->where('monthly_reports_pages.end_test_date', '<=', $end_date);
            }
            if (isset($data['provinceId']) && $data['provinceId'] != '') {
                $query = $query->where('monthly_reports.province_id', '=', $data['provinceId']);
            }
            //echo $query;
            $salesResult = $query->get();
        }
        //dd(DB::getQueryLog());die;
        return $salesResult;
    }

    // Fetch All MonthlyReport List
    public function fetchTotalCountOfMonthlyReport()
    {
        //DB::enableQueryLog();

        $user_id = session('userId');
        $data = DB::table('monthly_reports')
            ->selectRaw('count(monthly_reports.mr_id) as total')
            //->value('count(monthly_reports.mr_id) as total')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id)->value('total');
        if ($data == 0) {
            $data = DB::table('monthly_reports')
                ->selectRaw('count(monthly_reports.mr_id) as total')
                ->value('total');
        }
        //dd(DB::getQueryLog());
        return $data;
    }
    // Fetch All Dashboard count value
    public function fetchCountOfMonthlyReport()
    {
        $dateS = Carbon::now()->subMonth(12);
        $dateE = Carbon::now();
        DB::enableQueryLog();
        $user_id = session('userId');
        $data = DB::table('monthly_reports')
            ->select(DB::raw('count(mr_id) as total'))
            ->whereBetween('date_of_data_collection', [$dateS, $dateE])
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id)->value('total');
        // ->value('count(monthly_reports.mr_id) as total');
        if ($data == 0) {
            $data = DB::table('monthly_reports')
                ->select(DB::raw('count(mr_id) as total'))
                ->whereBetween('date_of_data_collection', [$dateS, $dateE])
                ->value('total');
        }
        // dd(DB::getQueryLog());die;
        return $data;
    }

    // Fetch All Dashboard Site count value
    public function fetchSiteCountOfMonthlyReport()
    {
        $dateS = Carbon::now()->subMonth(12);
        $dateE = Carbon::now();
        DB::enableQueryLog();
        $data = DB::table('monthly_reports')
            ->select(DB::raw('count(distinct ts_id) as monthlytotal'))
            ->whereBetween('date_of_data_collection', [$dateS, $dateE])
            ->value('count(distinct monthly_reports.ts_id) as monthlytotal');
        //dd(DB::getQueryLog());die;
        return $data;
    }

    // Fetch All Dashboard MonthlyReport List
    public function fetchMonthlyData()
    {

        $user_id = session('userId');
        DB::enableQueryLog();
        $data = DB::table('monthly_reports')
            ->select('monthly_reports.mr_id', 'monthly_reports.reporting_month', 'monthly_reports.date_of_data_collection', DB::raw('sum(m1.test_1_reactive + m1.test_1_nonreactive) as total_test'), 'test_sites.site_name', 'site_types.site_type_name', DB::raw('MIN(m1.start_test_date) as start_test_date'), DB::raw('MAX(m1.end_test_date) as end_test_date'))
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('monthly_reports_pages as m1', 'm1.mr_id', '=', 'monthly_reports.mr_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id)
            ->limit(10)
            ->orderBy('date_of_data_collection', 'desc')
            ->groupBy('monthly_reports.mr_id')
            ->get();
        if (count($data) == 0) {
            $data = DB::table('monthly_reports')
                ->select('monthly_reports.mr_id', 'monthly_reports.reporting_month', 'monthly_reports.date_of_data_collection', DB::raw('sum(m1.test_1_reactive + m1.test_1_nonreactive) as total_test'), 'test_sites.site_name', 'site_types.site_type_name', DB::raw('MIN(m1.start_test_date) as start_test_date'), DB::raw('MAX(m1.end_test_date) as end_test_date'))
                ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->join('monthly_reports_pages as m1', 'm1.mr_id', '=', 'monthly_reports.mr_id')
                ->limit(10)
                ->orderBy('date_of_data_collection', 'desc')
                ->groupBy('monthly_reports.mr_id')
                ->get();
        }
        // dd(DB::getQueryLog($data));die;
        return $data;
    }

    public function insertTrackTable()
    {
        $GlobalConfigService = new GlobalConfigService();
        $result = $GlobalConfigService->getAllGlobalConfig();
        $arr = array();
        // now we create an associative array so that we can easily create view variables
        for ($i = 0; $i < sizeof($result); $i++) {
            $arr[$result[$i]->global_name] = $result[$i]->global_value;
        }
        $user_name = session('name');
        $commonservice = new CommonService();
        $commonservice->eventLog('download-sample-monthly-excel-sheet', $user_name . ' has downloaded the sample monthly excel sheet for ' . $arr['no_of_test'] . '', 'monthly-report', $id = null);
    }

    public function trendReportTrackTable()
    {
        $user_name = session('name');
        $commonservice = new CommonService();
        $commonservice->eventLog('export-trend-report', $user_name . ' has exported the trend report', 'trend-report', $id = null);
    }

    public function logBookReportTrackTable()
    {
        $user_name = session('name');
        $commonservice = new CommonService();
        $commonservice->eventLog('export-logbook-report', $user_name . ' has exported the logbook report', 'logbook-report', $id = null);
    }

    public function testKitReportTrackTable()
    {
        $user_name = session('name');
        $commonservice = new CommonService();
        $commonservice->eventLog('export-testkit-report', $user_name . ' has exported the testkit report', 'test-kit-report', $id = null);
    }

    public function invalidReportTrackTable()
    {
        $user_name = session('name');
        $commonservice = new CommonService();
        $commonservice->eventLog('export-invalid-results-report', $user_name . ' has exported the invalid results report', 'invalid-results-report', $id = null);
    }

    public function customReportTrackTable()
    {
        $user_name = session('name');
        $commonservice = new CommonService();
        $commonservice->eventLog('export-custom-report', $user_name . ' has exported the custom report', 'custom-report', $id = null);
    }

    public function fetchExistingReportingMonth($params)
    {
        $data = DB::table('monthly_reports')
            ->where('reporting_month', '=', $params['reportingDate'])
            ->where('ts_id', '=', $params['siteName'])
            ->get();
        return count($data);
    }

    public function fetchIdExistingReportingMonth($params)
    {
        $data = DB::table('monthly_reports')
            ->where('mr_id', '=', $params['mr_id'])
            ->where('reporting_month', '=', $params['reportingDate'])
            ->where('ts_id', '=', $params['siteName'])
            ->get();
        return count($data);
    }
}
