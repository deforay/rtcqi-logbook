<?php

namespace App\Exports;

use App\Service\MonthlyReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Service\GlobalConfigService;
use Illuminate\Contracts\View\View;

class NotUploadExport implements FromView, ShouldAutoSize
{
    protected $requestdata;

 function __construct($requestdata) {
        $this->requestdata = $requestdata;
 }

    public function view(): View
    {
        $GlobalConfigService = new GlobalConfigService();
        $globalValue = $GlobalConfigService->getGlobalConfigValue('no_of_test');
        $monthlyReportService = new MonthlyReportService();
        //print_r($this->requestdata); exit();
        $data = $monthlyReportService->getAllNotUploadMonthlyReport($this->requestdata, true);
        
        //$insertData = $monthlyReportService->insertTrendData();
        return view('exports.notuploadexport', array('report'=>$data,'globalValue'=>$globalValue
        ));
    }
}


?>