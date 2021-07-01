<?php

namespace App\Exports;

use App\Model\MonthlyReport\MonthlyReportTable;
use App\Service\MonthlyReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestKitExport implements FromView, ShouldAutoSize
{
    protected $requestdata;

 function __construct($requestdata) {
        $this->requestdata = $requestdata;
 }

    public function view(): View
    {
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getTestKitMonthlyReport($this->requestdata);
        return view('exports.testkitexport', ['report'=>$data
        ]);
    }
}


?>