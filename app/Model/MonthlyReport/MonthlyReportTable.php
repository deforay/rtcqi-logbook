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
        if ($request->input('provinceName')!=null && trim($request->input('provinceName')) != '') {
            $id = DB::table('monthly_reports')->insertGetId(
                [
                'province_name' => $data['provinceName'],
                'province_status' => $data['provinceStatus'],
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
            $upData = array(
                'province_name' => $data['provinceName'],
                'province_status' => $data['provinceStatus'],
            );
            $response = DB::table('monthly_reports')
                ->where('mr_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
        return $response;
    }

    
}
