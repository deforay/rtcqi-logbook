<?php
/*
Author             : Sakthi
Date               : 10 Mar 2022
Description        : Audit Trail Service Page
Last Modified Date : 10 Mar 2022
Last Modified Name : Sakthi 
*/

namespace App\Service;
use App\Model\AuditTrail\AuditTrailTable;
use DB;

class AuditTrailService
{	
	//Get All User List
	public function getAllAudit($params)
    {
		$model = new AuditTrailTable();
        return $model->fetchAllAudit($params);
	}
	//Get All MonthlyAuditReportById
	public function getAllMonthlyAuditReportById($id)
    {
		$model = new AuditTrailTable();
        return $model->fetchMonthlyAuditReportById($id);
	}
}

?>