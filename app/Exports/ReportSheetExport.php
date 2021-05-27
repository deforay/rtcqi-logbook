<?php

namespace App\Exports;

use App\Model\InventoryOutwards\InventoryOutwardsTable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportSheetExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $sheets;

    public function __construct(array $sheets,$report)
    {
        $this->report = $report;
        $this->sheets = $sheets;
    }

    public function array(): array
    {
        return $this->sheets;
    }

    public function sheets(): array
    {
        $sheets = [
            new ReportAllDataExport($this->sheets['report_all_values'],$this->report),
            new ReportDataExport($this->sheets['report_values'],$this->report),
        ];

        return $sheets;
    }
}
