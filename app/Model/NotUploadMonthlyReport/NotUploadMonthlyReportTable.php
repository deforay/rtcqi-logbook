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
    public function fetchAllNotUploadMonthlyReport($params)
    {
        $commonservice = new CommonService();
        
        $user_id = session('userId');
        $query = DB::table('not_uploaded_monthly_reports')
                ->where('added_by', '=', $user_id);
        
        
        //dd($query->toSql());die;
        $salesResult = $query->get();
        
        return $salesResult;
    }
}
