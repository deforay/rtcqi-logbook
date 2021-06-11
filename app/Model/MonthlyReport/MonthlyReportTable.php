<?php

namespace App\Model\MonthlyReport;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\GlobalConfigService;
use Illuminate\Support\Facades\Session;

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
        $reportingMon = $commonservice->dateFormat($data['reportingMon']);
        if ($request->input('provinceId') != null && trim($request->input('provinceId')) != '') {
            $id = DB::table('monthly_reports')->insertGetId(
                [
                    'provincesss_id' => $data['provinceId'],
                    'site_unique_id' => $data['siteUniqueId'],
                    'ts_id' => $data['testsiteId'],
                    'st_id' => $data['sitetypeId'],
                    'site_manager' => $data['siteManager'],
                    'is_flc' => $data['isFlu'],
                    'is_recency' => $data['isRecency'],
                    'contact_no' => $data['contactNo'],
                    // 'latitude' => $data['latitude'],
                    // 'longitude' => $data['longitude'],
                    'algorithm_type' => $data['algoType'],
                    'date_of_data_collection' => $DateOfCollect,
                    'reporting_month' => $reportingMon,
                    'book_no' => $data['bookNo'],
                    'name_of_data_collector' => $data['nameOfDataCollect'],
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
        $data = DB::table('monthly_reports')
            ->join('provinces', 'provinces.provincesss_id', '=', 'monthly_reports.provincesss_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
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
        $reportingMon = $commonservice->dateFormat($data['reportingMon']);
        $upData = array(
            'provincesss_id' => $data['provinceId'],
            'site_unique_id' => $data['siteUniqueId'],
            'ts_id' => $data['testsiteId'],
            'st_id' => $data['sitetypeId'],
            'site_manager' => $data['siteManager'],
            'is_flc' => $data['isFlu'],
            'is_recency' => $data['isRecency'],
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
        $month = array();
        $data = $params->all();
        $commonservice = new CommonService();
        // DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'facilities.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id');
        // ->where('monthly_reports.mr_id', '=', $data['algorithmType']);
        if (trim($data['startDate']) != "" && trim($data['endDate']) != "") {
            $query = $query->where('monthly_reports_pages.start_test_date', '>=', $data['endDate'])
                ->where('monthly_reports_pages.end_test_date', '<=', $data['endDate']);
        }
        if (isset($data['facilityId']) && $data['facilityId'] != '') {
            $query = $query->where('facilities.facility_id', '=', $data['facilityId']);
        }
        if (isset($data['algorithmType']) && $data['algorithmType'] != '') {
            $query = $query->where('monthly_reports.mr_id', '=', $data['algorithmType']);
        }
        if (isset($data['testSiteId']) && $data['testSiteId'] != '') {
            $query = $query->where('test_sites.ts_id', '=', $data['testSiteId']);
        }
        // dd($query->toSql());
        $salesResult = $query->get();


        if (isset($data['reportFrequency']) && $data['reportFrequency'] == 'monthly') {
            foreach ($salesResult as $sRes) {
                $month[$sRes->end_test_date] = $sRes->end_test_date;
                $query = date('M', strtotime($sRes->end_test_date));
                // dd($query);die;
            }
        }
        return $salesResult;
    }


    /// Logbook report display with filters

    public function fetchLogbookReport($params)
    {
        $month = array();
        $data = $params->all();
        $commonservice = new CommonService();
        // DB::enableQueryLog();
        $query = DB::table('monthly_reports_pages')
            ->select('monthly_reports.*', 'monthly_reports_pages.*', 'facilities.*', 'test_sites.*', 'site_types.*')
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id');
        // ->where('monthly_reports.mr_id', '=', $data['algorithmType']);
        if (trim($data['startDate']) != "" && trim($data['endDate']) != "") {
                $query = $query->where(function($query) use($data){
                    $query->where('monthly_reports_pages.end_test_date',  '>=', $data['startDate'])
                        ->orWhere('monthly_reports_pages.end_test_date', '<=', $data['endDate']);
                });
        }
        if (isset($data['facilityId']) && $data['facilityId'] != '') {
            $query = $query->where('monthly_reports.facility_id', '=', $data['facilityId']);
        }
        if (isset($data['algorithmType']) && $data['algorithmType'] != '') {
            $query = $query->where('monthly_reports.algorithm_type', '=', $data['algorithmType']);
        }
        if (isset($data['testSiteId']) && $data['testSiteId'] != '') {
            $query = $query->where('monthly_reports.ts_id', '=', $data['testSiteId']);
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
            ->join('monthly_reports', 'monthly_reports.mr_id', '=', 'monthly_reports.mr_id')
            ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
            ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
            ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->where('monthly_reports_pages.mrp_id', '=', $id)->get();
        return $data;
    }
}
