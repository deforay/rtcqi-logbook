<?php
/*
Author             : Prasath M
Date               : 02 Jun 2021
Description        : MonthlyReport Service Page
Last Modified Date : 02 Jun 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\MonthlyReport\MonthlyReportTable;
use DB;

class MonthlyReportService
{
   
    public function saveMonthlyReport($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new MonthlyReportTable();
        	$add = $model->saveMonthlyReport($request);
			if($add>0){
                DB::commit();
				$msg = 'Monthly Report Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All MonthlyReport List
	public function getAllMonthlyReport()
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchAllMonthlyReport();
        return $result;
	}

	//Get All MonthlyReport List
	public function getAllActiveMonthlyReport()
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchAllActiveMonthlyReport();
        return $result;
	}
	//Get Particular MonthlyReport Details
	public function getMonthlyReportById($id)
	{
		
		$model = new MonthlyReportTable();
        $result = $model->fetchMonthlyReportById($id);
        return $result;
	}
	//Update Particular MonthlyReport Details
	public function updateMonthlyReport($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new MonthlyReportTable();
        	$add = $model->updateMonthlyReport($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Monthly Report Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	public function getTrendMonthlyReport($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchTrendMonthlyReport($params);
		return $result;
	}

	public function getLogbookReport($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchLogbookReport($params);
		return $result;
	}

	public function getPageSummary($id)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchPageSummary($id);
		return $result;
	}

	public function getTestKitMonthlyReport($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchTestKitMonthlyReport($params);
		return $result;
	}

	public function importMonthlyReportData($request)
    {
		$data =  $request->all();
		$model = new MonthlyReportTable();
		$add = $model->importMonthlyReportData($request);
		return $add;
	}
	
}

?>