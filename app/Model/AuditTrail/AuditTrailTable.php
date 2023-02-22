<?php

namespace App\Model\AuditTrail;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use App\Model\MonthlyReport\MonthlyReportTable;

class AuditTrailTable extends Model
{
    protected $table = 'audit_monthly_reports';

    // Fetch All Audit Trail List
    public function fetchAllAudit($params)
    {
        $reportingMon = $params['reportingMon'];
        $testingSiteId = $params['testsiteId'];
        $model = new MonthlyReportTable();
        //$auditCols = DB::getSchemaBuilder()->getColumnListing($this->table);
       // $$result['auditColumns'] = array_keys($auditCols->getAttributes());
        $result['auditColumns'] = collect(\DB::select('describe audit_monthly_reports'))->pluck('Field')->toArray();

        $query = DB::table('audit_monthly_reports')
            ->where('reporting_month', '=', trim($reportingMon))
            ->where('ts_id', '=', trim($testingSiteId));
           
        $result['auditValues'] = $query->get();
        $result['currentColumns'] = collect(\DB::select('describe monthly_reports'))->pluck('Field')->toArray();
        $result['currentRecord'] = $model->fetchUniqueActiveMonthlyReport($testingSiteId,$reportingMon);
        return $result;
    }

    // Fetch All MonthlyReport Audit
    public function fetchMonthlyAuditReportById($id)
    {
        $data = DB::table('track')
            ->where('action_id','=',base64_decode($id))
            ->get();
        return $data;
    }
}
