<?php

namespace App\Model\MonthlyReport;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\GlobalConfigService;
use Illuminate\Support\Facades\Session;
use App\Imports\MonthlyReportDataUpload;
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
        // print_r($data);die;
        $commonservice = new CommonService();
        $DateOfCollect = $commonservice->dateFormat($data['DateOfCollect']);
        $reportingMon = ($data['reportingMon']);
        $recency = '';
        if (isset($data['isRecency']))
            $recency = $data['isRecency'];
        if ($request->input('provinceId') != null && trim($request->input('provinceId')) != '') {
            $id = DB::table('monthly_reports')->insertGetId(
                [
                    'provincesss_id' => $data['provinceId'],
                    'site_unique_id' => $data['siteUniqueId'],
                    'ts_id' => $data['testsiteId'],
                    'st_id' => $data['sitetypeId'],
                    'site_manager' => $data['siteManager'],
                    'is_flc' => $data['isFlu'],
                    'is_recency' => $recency,
                    'contact_no' => $data['contactNo'],
                    // 'latitude' => $data['latitude'],
                    // 'longitude' => $data['longitude'],
                    'algorithm_type' => $data['algoType'],
                    'date_of_data_collection' => $DateOfCollect,
                    'reporting_month' => $reportingMon,
                    'book_no' => $data['bookNo'],
                    'name_of_data_collector' => $data['nameOfDataCollect'],
                    'source' => 'web-form',
                    'added_on' => date('Y-m-d'),
                    'added_by' => session('userId'),
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

                $insMonthlyArr = array(
                    'mr_id' => $id,
                    'page_no' => $data['pageNO'][$p],
                    'start_test_date' => $data['startDate'][$p],
                    'end_test_date' => $data['endDate'][$p],
                    'final_positive' => $data['totalPositive'][$p],
                    'final_negative' => $data['totalNegative'][$p],
                    'final_undetermined' => $data['finalUndetermined'][$p],
                );
                for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                    $m = $l;
                    $insMonthlyArr['test_' . $m . '_kit_id'] = $data['testkitId' . $l][$p];
                    $insMonthlyArr['lot_no_' . $m] = $data['lotNO' . $l][$p];
                    $insMonthlyArr['expiry_date_' . $m] = $data['expiryDate' . $l][$p];
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
        }

        return $id;
    }

    // Fetch All MonthlyReport List
    public function fetchAllMonthlyReport()
    {
        $user_id = session('userId');
        $data = DB::table('monthly_reports')
            ->join('provinces', 'provinces.provincesss_id', '=', 'monthly_reports.provincesss_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id)
            ->get();
        return $data;
    }

    // Fetch All Active MonthlyReport List
    public function fetchAllActiveMonthlyReport()
    {
        $data = DB::table('monthly_reports')
            // ->where('province_status','=','active')
            ->get();
        return $data;
    }

    // fetch particular MonthlyReport details
    public function fetchMonthlyReportById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('monthly_reports')
            ->join('provinces', 'provinces.provincesss_id', '=', 'monthly_reports.provincesss_id')
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
        $data = $params->all();
        $commonservice = new CommonService();
        $DateOfCollect = $commonservice->dateFormat($data['DateOfCollect']);
        $reportingMon = ($data['reportingMon']);
        $recency = '';
        if (isset($data['isRecency']))
            $recency = $data['isRecency'];
        $upData = array(
            'provincesss_id' => $data['provinceId'],
            'site_unique_id' => $data['siteUniqueId'],
            'ts_id' => $data['testsiteId'],
            'st_id' => $data['sitetypeId'],
            'site_manager' => $data['siteManager'],
            'is_flc' => $data['isFlu'],
            'is_recency' => $recency,
            'contact_no' => $data['contactNo'],
            // 'latitude' => $data['latitude'],
            // 'longitude' => $data['longitude'],
            'algorithm_type' => $data['algoType'],
            'date_of_data_collection' => $DateOfCollect,
            'reporting_month' => $reportingMon,
            'book_no' => $data['bookNo'],
            'name_of_data_collector' => $data['nameOfDataCollect'],
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

            $insMonthlyArr = array(
                'mr_id' => base64_decode($id),
                'page_no' => $data['pageNO'][$p],
                'start_test_date' => $data['startDate'][$p],
                'end_test_date' => $data['endDate'][$p],
                'final_positive' => $data['totalPositive'][$p],
                'final_negative' => $data['totalNegative'][$p],
                'final_undetermined' => $data['finalUndetermined'][$p],
            );
            for ($l = 1; $l <= $arr['no_of_test']; $l++) {
                $m = $l;
                $insMonthlyArr['test_' . $m . '_kit_id'] = $data['testkitId' . $l][$p];
                $insMonthlyArr['lot_no_' . $m] = $data['lotNO' . $l][$p];
                $insMonthlyArr['expiry_date_' . $m] = $data['expiryDate' . $l][$p];
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
        return 1;
    }

    public function fetchTrendMonthlyReport($params)
    {
        $user_id = session('userId');
        $result = array();
        $data = $params;
        DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'facilities.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id);

        if (trim($data['startDate']) != "" && trim($data['endDate']) != "") {
            $query = $query->where(function ($query) use ($data) {
                $query->where('monthly_reports_pages.end_test_date',  '>=', $data['startDate'])
                    ->orWhere('monthly_reports_pages.end_test_date', '<=', $data['endDate']);
            });
        }
        if (isset($data['facilityId']) && $data['facilityId'] != '') {
            $query = $query->whereIn('test_sites.facility_id', $data['facilityId']);
            $query = $query->groupBy(DB::raw('test_sites.facility_id'));
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
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive) as test_1_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_nonreactive) as test_1_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as test_1_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive) as test_2_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_nonreactive) as test_2_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_invalid) as test_2_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive) as test_3_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_nonreactive) as test_3_nonreactive');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as month');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_invalid) as test_3_invalid');
            $query = $query->groupBy(DB::raw('MONTH(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'yearly') {
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive) as test_1_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_nonreactive) as test_1_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as test_1_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive) as test_2_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_nonreactive) as test_2_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_invalid) as test_2_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive) as test_3_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_nonreactive) as test_3_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_invalid) as test_3_invalid');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as year');
            $query = $query->groupBy(DB::raw('YEAR(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'quaterly') {
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive) as test_1_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_nonreactive) as test_1_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as test_1_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive) as test_2_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_nonreactive) as test_2_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_invalid) as test_2_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive) as test_3_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_nonreactive) as test_3_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_invalid) as test_3_invalid');
            $query = $query->selectRaw('YEAR(monthly_reports_pages.end_test_date) as end_test_date');
            $query = $query->selectRaw("(CASE WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 1  AND 3  THEN 'Q4' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 4  AND 6  THEN 'Q1' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 7  AND 9  THEN 'Q2' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 10 AND 12 THEN 'Q3' END) AS quarterly");

            $query =  $query->selectRaw("DATE_FORMAT(monthly_reports_pages.end_test_date,'%Y') as quaYear");

            $query = $query->groupBy(DB::raw('QUARTER(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        $salesResult = $query->get();
        // dd(DB::getQueryLog($salesResult));die;
        $result['reportFrequency'] = $data['reportFrequency'];
        $result['res'] = $salesResult;

        return $result;
    }


    /// Logbook report display with filters

    public function fetchLogbookReport($params)
    {
        $user_id = session('userId');
        $data = $params;
        // DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'facilities.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id);

        if (trim($data['startDate']) != "" && trim($data['endDate']) != "") {
            $query = $query->where(function ($query) use ($data) {
                $query->where('monthly_reports_pages.end_test_date',  '>=', $data['startDate'])
                    ->orWhere('monthly_reports_pages.end_test_date', '<=', $data['endDate']);
            });
        }
        if (isset($data['facilityId']) && $data['facilityId'] != '') {
            $query = $query->whereIn('test_sites.facility_id', $data['facilityId']);
            $query = $query->groupBy(DB::raw('test_sites.facility_id'));
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
        $id = base64_decode($id);
        $data = DB::table('monthly_reports_pages')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->where('monthly_reports_pages.mrp_id', '=', $id)->get();
        return $data;
    }

    // Test Kit Use Data
    public function fetchTestKitMonthlyReport($params)
    {
        $user_id = session('userId');
        $result = array();
        $data = $params;
        DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'facilities.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id);

        if (trim($data['startDate']) != "" && trim($data['endDate']) != "") {
            $query = $query->where(function ($query) use ($data) {
                $query->where('monthly_reports_pages.end_test_date',  '>=', $data['startDate'])
                    ->orWhere('monthly_reports_pages.end_test_date', '<=', $data['endDate']);
            });
        }
        if (isset($data['facilityId']) && $data['facilityId'] != '') {
            $query = $query->whereIn('test_sites.facility_id', $data['facilityId']);
            $query = $query->groupBy(DB::raw('test_sites.facility_id'));
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
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive + monthly_reports_pages.test_1_nonreactive + monthly_reports_pages.test_1_invalid) as test_1_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive + monthly_reports_pages.test_2_nonreactive + monthly_reports_pages.test_2_invalid) as test_2_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive + monthly_reports_pages.test_3_nonreactive + monthly_reports_pages.test_3_invalid) as test_3_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid) as total_invalid');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as month');
            $query = $query->groupBy(DB::raw('MONTH(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'yearly') {
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive + monthly_reports_pages.test_1_nonreactive + monthly_reports_pages.test_1_invalid) as test_1_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive + monthly_reports_pages.test_2_nonreactive + monthly_reports_pages.test_2_invalid) as test_2_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive + monthly_reports_pages.test_3_nonreactive + monthly_reports_pages.test_3_invalid) as test_3_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid) as total_invalid');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as year');
            $query = $query->groupBy(DB::raw('YEAR(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'quaterly') {
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive + monthly_reports_pages.test_1_nonreactive + monthly_reports_pages.test_1_invalid) as test_1_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive + monthly_reports_pages.test_2_nonreactive + monthly_reports_pages.test_2_invalid) as test_2_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive + monthly_reports_pages.test_3_nonreactive + monthly_reports_pages.test_3_invalid) as test_3_kit_used');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid + monthly_reports_pages.test_2_invalid + monthly_reports_pages.test_3_invalid) as total_invalid');
            $query = $query->selectRaw('YEAR(monthly_reports_pages.end_test_date) as end_test_date');
            $query = $query->selectRaw("(CASE WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 1  AND 3  THEN 'Q4' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 4  AND 6  THEN 'Q1' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 7  AND 9  THEN 'Q2' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 10 AND 12 THEN 'Q3' END) AS quarterly");

            $query =  $query->selectRaw("DATE_FORMAT(monthly_reports_pages.end_test_date,'%Y') as quaYear");

            $query = $query->groupBy(DB::raw('QUARTER(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
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
        $user_id = session('userId');
        $result = array();
        $data = $params;
        DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'facilities.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->join('districts', 'districts.district_id', '=', 'monthly_reports.provincesss_id')
            ->join('provinces', 'provinces.provincesss_id', '=', 'monthly_reports.provincesss_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id);

        if (trim($data['startDate']) != "" && trim($data['endDate']) != "") {
            $query = $query->where(function ($query) use ($data) {
                $query->where('monthly_reports_pages.end_test_date',  '>=', $data['startDate'])
                    ->orWhere('monthly_reports_pages.end_test_date', '<=', $data['endDate']);
            });
        }
        if (isset($data['facilityId']) && $data['facilityId'] != '') {
            $query = $query->whereIn('test_sites.facility_id', $data['facilityId']);
            $query = $query->groupBy(DB::raw('test_sites.facility_id'));
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
            $query = $query->whereIn('provinces.provincesss_id', $data['provinceId']);
            $query = $query->groupBy(DB::raw('provinces.provincesss_id'));
        }
        if (isset($data['districtId']) && $data['districtId'] != '') {
            $query = $query->whereIn('districts.district_id', $data['districtId']);
            $query = $query->groupBy(DB::raw('districts.district_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'monthly') {
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive) as test_1_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_nonreactive) as test_1_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as test_1_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive) as test_2_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_nonreactive) as test_2_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_invalid) as test_2_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive) as test_3_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_nonreactive) as test_3_nonreactive');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as month');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_invalid) as test_3_invalid');
            $query = $query->groupBy(DB::raw('MONTH(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'yearly') {
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive) as test_1_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_nonreactive) as test_1_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as test_1_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive) as test_2_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_nonreactive) as test_2_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_invalid) as test_2_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive) as test_3_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_nonreactive) as test_3_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_invalid) as test_3_invalid');
            $query = $query->selectRaw('DATE_FORMAT(monthly_reports_pages.end_test_date,"%b-%Y") as year');
            $query = $query->groupBy(DB::raw('YEAR(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'quaterly') {
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_reactive) as test_1_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_nonreactive) as test_1_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_1_invalid) as test_1_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_reactive) as test_2_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_nonreactive) as test_2_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_2_invalid) as test_2_invalid');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_reactive) as test_3_reactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_nonreactive) as test_3_nonreactive');
            $query = $query->selectRaw('sum(monthly_reports_pages.test_3_invalid) as test_3_invalid');
            $query = $query->selectRaw('YEAR(monthly_reports_pages.end_test_date) as end_test_date');
            $query = $query->selectRaw("(CASE WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 1  AND 3  THEN 'Q4' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 4  AND 6  THEN 'Q1' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 7  AND 9  THEN 'Q2' WHEN MONTH(monthly_reports_pages.end_test_date) BETWEEN 10 AND 12 THEN 'Q3' END) AS quarterly");

            $query =  $query->selectRaw("DATE_FORMAT(monthly_reports_pages.end_test_date,'%Y') as quaYear");

            $query = $query->groupBy(DB::raw('QUARTER(monthly_reports_pages.end_test_date)', 'monthly_reports.ts_id'));
        }
        $salesResult = $query->get();
        // dd(DB::getQueryLog($salesResult));die;
        $result['reportFrequency'] = $data['reportFrequency'];
        $result['res'] = $salesResult;

        return $result;
    }

    public function importMonthlyReportData($request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'grade_excel'  => 'required|mimes:xls,xlsx'
        ]);
        // dd($data);
        $autoId = 0;
        $commonservice = new CommonService();
        $rslt = "";
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $dateTime = date('Ymd_His');
                $file = $request->file('grade_excel');
                $fileName = $dateTime . '-' . $file->getClientOriginalName();
                $savePath = public_path('/uploads/');
                $file->move($savePath, $fileName);
                // print_r($savePath.$fileName);die;
                $array =  Excel::toArray(new MonthlyReportDataUpload(), $savePath . $fileName);
                // $array = Excel::import(new InventoryStockUpload, $savePath.$fileName);
                // dd($array);die;
                $rowCnt = 1;
                $cnt = 0;
                $GlobalConfigService = new GlobalConfigService();
                $result = $GlobalConfigService->getAllGlobalConfig();
                $arr = array();
                // now we create an associative array so that we can easily create view variables
                for ($i = 0; $i < sizeof($result); $i++) {
                    $arr[$result[$i]->global_name] = $result[$i]->global_value;
                }
                foreach ($array[0] as $row) {
                    if ($rowCnt > 1) {
                        if ($row[0] != '') {
                            // print_r($row[0]);die;
                            // dd($row);
                            $test_site_name = $row[0];
                            $site_type = $row[1];
                            $facility = $row[2];
                            $province = $row[3];
                            $site_manager = $row[4];
                            $site_unique_id = $row[5];
                            $if_flc = $row[6];
                            $is_recency = $row[7];
                            $contact_no = $row[8];
                            $algo_type = $row[9];
                            $date_of_collection = date('Y-m-d', strtotime($row[10]));
                            $report_months = date('Y-m-d', strtotime($row[11]));
                            $book_no = $row[12];
                            $name_of_collector = $row[13];
                            $page_no = $row[14];
                            $start_date = date('Y-m-d', strtotime($row[15]));
                            $end_date = date('Y-m-d', strtotime($row[16]));
                            if ($arr['no_of_test'] >= 1) {
                                $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row[17]))
                                    ->get();
                                if (count($testkitData) > 0) {
                                    $testkitId = $testkitData[0]->tk_id;
                                } else {
                                    $testkitId = DB::table('test_kits')->insertGetId(
                                        [
                                            'test_kit_name' => trim($row[17]),
                                            'test_kit_status' => 'active',
                                        ]
                                    );
                                }
                                $test_kit1 = $testkitId;
                                $lot_no1 = $row[18];
                                $expiry_date1 = date('Y-m-d', strtotime($row[19]));
                                $testkit1_reactive = $row[20];
                                $testkit1_nonreactive = $row[21];
                                $testkit1_invalid = $row[22];
                            }
                            if ($arr['no_of_test'] >= 2) {
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
                                $expiry_date2 = date('Y-m-d', strtotime($row[25]));
                                $testkit2_reactive = $row[26];
                                $testkit2_nonreactive = $row[27];
                                $testkit2_invalid = $row[28];
                            }
                            if ($arr['no_of_test'] >= 3) {
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
                                $expiry_date3 = date('Y-m-d', strtotime($row[31]));
                                $testkit3_reactive = $row[32];
                                $testkit3_nonreactive = $row[33];
                                $testkit3_invalid = $row[34];
                            }
                            if ($arr['no_of_test'] >= 4) {
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
                                $expiry_date4 = date('Y-m-d', strtotime($row[37]));
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
                            $facilitiesData = DB::table('facilities')
                                ->where('facility_name', '=', trim($facility))
                                ->get();
                            if (count($facilitiesData) > 0) {
                                $facilityId = $facilitiesData[0]->facility_id;
                            } else {
                                $facilityId = DB::table('facilities')->insertGetId(
                                    [
                                        'facility_name' => trim($facility),
                                        'facility_status' => 'active',
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
                                        'facility_id' => $facilityId,
                                    ]
                                );
                            }

                            $provinceData = DB::table('provinces')
                                ->where('province_name', '=', trim($province))
                                ->get();
                            if (count($provinceData) > 0) {
                                $provinceId = $provinceData[0]->provincesss_id;
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
                                ->where('reporting_month', '=', $report_months)
                                ->where('book_no', '=', $book_no)
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
                                            'provincesss_id' => $provinceId,
                                            'site_unique_id' => $site_unique_id,
                                            'ts_id' => $testSiteId,
                                            'st_id' => $siteTypeId,
                                            'site_manager' => $site_manager,
                                            'is_flc' => $if_flc,
                                            'is_recency' => $is_recency,
                                            'contact_no' => $contact_no,
                                            'algorithm_type' => $algo_type,
                                            'date_of_data_collection' => $date_of_collection,
                                            'reporting_month' => $report_months,
                                            'book_no' => $book_no,
                                            'name_of_data_collector' => $name_of_collector,
                                            'source' => 'excel',
                                            'added_on' => date('Y-m-d'),
                                            'added_by' => session('userId')
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
                                $monthly_reports_pages = DB::table('monthly_reports_pages')->insertGetId(
                                    $insMonthlyArr
                                );
                                if ($monthly_reports_pages) {
                                    $cnt++;
                                }
                            }
                        }
                    }
                    $rowCnt++;
                }
                DB::commit();
                $rslt = $cnt . " rows Updated";
            } catch (Exception $exc) {
                DB::rollBack();
                $exc->getMessage();
                $rslt .= "Nothing Updated <br>";
            }
        }
        // print($invStkId);die;
        return $rslt;
    }

    // Invalid Result Report 

    public function fetchInvalidResultReport($params)
    {
        $user_id = session('userId');
        $data = $params;
        // DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'facilities.*', 'test_sites.*', 'site_types.*', 'tk1.test_kit_name as testKit_1_name', 'tk2.test_kit_name as testKit_2_name', 'tk3.test_kit_name as testKit_3_name')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports_pages.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('test_kits as tk1', 'tk1.tk_id', '=', 'monthly_reports_pages.test_1_kit_id')
            ->join('test_kits as tk2', 'tk2.tk_id', '=', 'monthly_reports_pages.test_2_kit_id')
            ->join('test_kits as tk3', 'tk3.tk_id', '=', 'monthly_reports_pages.test_3_kit_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id);

        if (trim($data['startDate']) != "" && trim($data['endDate']) != "") {
            $query = $query->where(function ($query) use ($data) {
                $query->where('monthly_reports_pages.end_test_date',  '>=', $data['startDate'])
                    ->orWhere('monthly_reports_pages.end_test_date', '<=', $data['endDate']);
            });
        }
        if (isset($data['facilityId']) && $data['facilityId'] != '') {
            $query = $query->whereIn('test_sites.facility_id', $data['facilityId']);
            $query = $query->groupBy(DB::raw('test_sites.facility_id'));
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
            ->join('test_sites', 'test_sites.provincesss_id', '=', 'monthly_reports.provincesss_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->join('provinces', 'provinces.provincesss_id', '=', 'monthly_reports.provincesss_id')
            ->where('users_testsite_map.user_id', $user_id);

        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where('monthly_reports.reporting_month', '>=', $start_date)->where('monthly_reports.reporting_month', '<=', $end_date);
        }
        if (isset($data['provinceId']) && $data['provinceId'] != '') {
            $query = $query->where('monthly_reports.provincesss_id', '=', $data['provinceId']);
        }
        $salesResult = $query->get();
        //dd(DB::getQueryLog());die;

        return $salesResult;
    }

    // Fetch All MonthlyReport List
    public function fetchTotalCountOfMonthlyReport()
    {
        $data = DB::table('monthly_reports')
            ->selectRaw('count(monthly_reports.mr_id) as total')
            ->value('count(monthly_reports.mr_id) as total');
        return $data;
    }
    public function fetchCountOfMonthlyReport()
    {
        $dateS = Carbon::now()->subMonth(12);
        $dateE = Carbon::now();
        DB::enableQueryLog();
        $data = DB::table('monthly_reports')
            ->select(DB::raw('count(mr_id) as total'))
            ->whereBetween('date_of_data_collection', [$dateS, $dateE])
            ->value('count(monthly_reports.mr_id) as total');
        // dd(DB::getQueryLog());die;
        return $data;
    }

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

    // Fetch All MonthlyReport List
    public function fetchMonthlyData()
    {
        $user_id = session('userId');
        $data = DB::table('monthly_reports')
            ->select('monthly_reports.reporting_month', 'monthly_reports.date_of_data_collection', DB::raw('sum(monthly_reports_pages.test_1_reactive + monthly_reports_pages.test_1_nonreactive) as total'), 'test_sites.site_name', 'site_types.site_type_name', 'monthly_reports_pages.start_test_date', 'monthly_reports_pages.end_test_date')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'monthly_reports.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id)
            ->limit(10)
            ->orderBy('date_of_data_collection', 'desc')
            ->get();
        return $data;
    }
}
