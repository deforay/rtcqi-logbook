<?php

namespace App\Model\NotUploadMonthlyReport;

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

class NotUploadMonthlyReportTable extends Model
{
    protected $table = 'not_uploaded_monthly_reports';

    
    // Fetch All Not Upload MonthlyReport List
    public function fetchAllNotUploadMonthlyReport($params, $isExport)
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
        $query = DB::table('not_uploaded_monthly_reports')
                ->where('added_by', '=', $user_id)
                ->where('status','=', 1);
        if (trim($start_date) != "" && trim($end_date) != "") {
            $query->whereDate('not_uploaded_monthly_reports.added_on',  '>=', $start_date)
                    ->whereDate('not_uploaded_monthly_reports.added_on', '<=', $end_date)
                    ->whereDate('not_uploaded_monthly_reports.added_on', '>=', $start_date);
                    
        }
        if (isset($params['provinceName']) && $params['provinceName'] != '') {
            $query->whereIn('not_uploaded_monthly_reports.province_name', $params['provinceName']);            
        }
        if (isset($params['testSiteName']) && $params['testSiteName'] != '') {
            $query->whereIn('not_uploaded_monthly_reports.test_site_name', $params['testSiteName']);
            
        }
        $query->orderBy('not_uploaded_monthly_reports.nu_mr_id', 'Desc');
        
        
        //dd($query->toSql());die;
        $salesResult = $query->get();
        $id=array();

        if(count($salesResult) > 0 && $isExport){
            foreach($salesResult as $row){
                array_push($id, $row->nu_mr_id);
            }
            //delete exported rows from not uploaded reports table
            $updateQuery = DB::table('not_uploaded_monthly_reports')
            ->whereIn('nu_mr_id', $id)
            ->Update(['status'=>0]);
                

        }
        
        return $salesResult;
    }

    // Fetch All Not Upload MonthlyReport List
    public function fetchAllNotUploadActiveTestSite()
    {
        $commonservice = new CommonService();
        
        
        $query = DB::table('not_uploaded_monthly_reports')
        ->where('status', '=', 1)
                ->where('test_site_name', '<>', null)->groupBy('test_site_name');
        
        
        //dd($query->toSql());die;
        $salesResult = $query->get();
        
        return $salesResult;
    }

    // Fetch All Not Upload Province List
    public function fetchAllNotUploadActiveProvince()
    {
        $commonservice = new CommonService();
        
        $user_id = session('userId');
        $query = DB::table('not_uploaded_monthly_reports')
                ->where('status', '=', 1)
                ->where('province_name', '<>', NULL)->groupBy('province_name');
        
        
        //dd($query->toSql());die;
        $salesResult = $query->get();        
        
        return $salesResult;
    }
}
