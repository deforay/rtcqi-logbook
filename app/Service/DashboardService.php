<?php
/*
Author             : Sudarmathi M
Date               : 14 July 2020
Description        : Dashboard Service Page
Last Modified Date : 
Last Modified Name : 
*/
namespace App\Service;
use App\Model\Quotes\QuotesTable;
use DB;
use Redirect;

class DashboardService
{
   	//Get All Dashboard Details
	public function getAllDashboardDetails()
    {
		$model = new QuotesTable();
        $result = $model->fetchAllDashboardDetails();
        return $result;
	}

}

?>