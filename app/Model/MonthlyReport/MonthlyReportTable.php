<?php

namespace App\Model\MonthlyReport;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class MonthlyReportTable extends Model
{
    protected $table = 'monthly_reports';

    //add MonthlyReport
    public function saveMonthlyReport($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        $DateOfCollect = $commonservice->dateFormat($data['DateOfCollect']);
        $reportingMon = $commonservice->dateFormat($data['reportingMon']);
        if ($request->input('provinceId')!=null && trim($request->input('provinceId')) != '') {
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
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'algorithm_type' => $data['algoType'],
                'date_of_data_collection' => $DateOfCollect,
                'reporting_month' => $reportingMon,
                'book_no' => $data['bookNo'],
                'name_of_data_collector' => $data['nameOfDataCollect'],
                'signature' => $data['signature'],
                ]
            );
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
                ->where('province_status','=','active')
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
                ->where('monthly_reports.mr_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular MonthlyReport details
    public function updateMonthlyReport($params,$id)
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
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'algorithm_type' => $data['algoType'],
                'date_of_data_collection' => $DateOfCollect,
                'reporting_month' => $reportingMon,
                'book_no' => $data['bookNo'],
                'name_of_data_collector' => $data['nameOfDataCollect'],
                'signature' => $data['signature'],
            );
            $response = DB::table('monthly_reports')
                ->where('mr_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
        return $response;
    }

    
}
