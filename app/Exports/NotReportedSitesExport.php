<?php

namespace App\Exports;

use App\Service\MonthlyReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Service\GlobalConfigService;
use Illuminate\Contracts\View\View;

class NotReportedSitesExport implements FromView, ShouldAutoSize
{
    protected $requestdata;

 function __construct($requestdata) {
        $this->requestdata = $requestdata;
 }

    public function view(): View
    {
        $monthlyReportService = new MonthlyReportService();
        $insertData = $monthlyReportService->notReportedSitesData();
        $data = $monthlyReportService->getNotReportedSites($this->requestdata);
        return view('exports.notreportedsitesexport', array('report'=>$data));
    }
}

?>