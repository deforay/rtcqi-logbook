<?php

namespace App\Exports;

use App\Service\MonthlyReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Service\GlobalConfigService;
use Illuminate\Contracts\View\View;

class LogBookExport implements FromView, ShouldAutoSize
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
        $data = $monthlyReportService->getLogbookReport($this->requestdata);
        $insertData = $monthlyReportService->insertLogBookData();
        return view('exports.logbookexport', array('report'=>$data,'globalValue'=>$globalValue
        ));
    }
}


?>