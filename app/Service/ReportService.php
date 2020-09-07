<?php

namespace App\Service;
use App\Model\Report\ReportTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class ReportService
{
	
	//Get Inventory Report
	public function getInventoryReport()
    {
		$reportmodel = new ReportTable();
        $result = $reportmodel->fetchInventoryReport();
        return $result;
	}



}
