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
use App\Model\NotUploadMonthlyReport\NotUploadMonthlyReportTable;
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
	public function getAllMonthlyReport($params)
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchAllMonthlyReport($params);
        return $result;
	}

	//Get Selected Site Monthly Report List
	public function getSelectedSiteMonthlyReport($params)
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchSelectedSiteMonthlyReport($params);
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

	public function getCustomMonthlyReport($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchCustomMonthlyReport($params);
		return $result;
	}

	public function getNotReportedSites($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchNotReportedSites($params);
		return $result;
	}

	public function getInvalidResultReport($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchInvalidResultReport($params);
		return $result;
	}
	public function getLatestValue()
	{
		$model = new MonthlyReportTable();
		$result = $model->getLatestValue();
		return $result;
	}

	public function CheckPreLot($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->CheckPreLot($params);
		return $result;
	}

	public function getDashboardData($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchDashboardData($params);
		return $result;
	}

	//Get All TotalCountMonthlyReport List
	public function getTotalCountOfMonthlyReport()
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchTotalCountOfMonthlyReport();
        return $result;
	}

	//Get All CountMonthlyReport List
	public function getCountOfMonthlyReport()
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchCountOfMonthlyReport();
        return $result;
	}

	//Get All SiteCountMonthlyReport List
	public function getSiteCountOfMonthlyReport()
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchSiteCountOfMonthlyReport();
        return $result;
	}

	//Get All MonthlyData List
	public function getMonthlyData()
    {
		$model = new MonthlyReportTable();
        $result = $model->fetchMonthlyData();
        return $result;
	}

	//Inserting Track Data
	public function insertData()
    {
		$model = new MonthlyReportTable();
        $result = $model->insertTrackTable();
        return $result;
	}

	//Inserting Trend Track Data
	public function insertTrendData()
    {
		$model = new MonthlyReportTable();
        $result = $model->trendReportTrackTable();
        return $result;
	}
	
	//Inserting LogBook Track Data
	public function insertLogBookData()
    {
		$model = new MonthlyReportTable();
        $result = $model->logBookReportTrackTable();
        return $result;
	}

	//Inserting TestKit Track Data
	public function insertTestKitData()
    {
		$model = new MonthlyReportTable();
        $result = $model->testKitReportTrackTable();
        return $result;
	}

	//Inserting Invalid Results Track Data
	public function invalidReportData()
    {
		$model = new MonthlyReportTable();
        $result = $model->invalidReportTrackTable();
        return $result;
	}
	
	//Inserting Custom Track Data
	public function customReportData()
    {
		$model = new MonthlyReportTable();
        $result = $model->customReportTrackTable();
        return $result;
	}

	public function getExistingReportingMonth($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchExistingReportingMonth($params);
		return $result;
	}

	public function getIdExistingReportingMonth($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchIdExistingReportingMonth($params);
		return $result;
	}
	
	//Get All Not Upload MonthlyReport List
	public function getAllNotUploadMonthlyReport($params, $isExport=false)
    {
		
		$model = new NotUploadMonthlyReportTable();
        $result = $model->fetchAllNotUploadMonthlyReport($params, $isExport);
        return $result;
	}
	
	//Get All Not Upload Test Sites
	public function getAllNotUploadActiveTestSite()
    {
		$model = new NotUploadMonthlyReportTable();
		$result = $model->fetchAllNotUploadActiveTestSite();
        return $result;
	}

	//Get All Not Upload Provinces
	public function getAllNotUploadActiveProvince()
    {
		$model = new NotUploadMonthlyReportTable();
		$result = $model->fetchAllNotUploadActiveProvince();
        return $result;
	}

	public function getSiteWiseReport($params)
	{
		$model = new MonthlyReportTable();
		$result = $model->fetchSiteWiseReport($params);
		return $result;
	}

	//Get Month Wise Report Count List
	public function getMonthlyWiseReportCount()
    {
		$model = new MonthlyReportTable();
        return $result = $model->fetchMonthlyWiseReportCount();
	}

	public function getSiteWiseMonthlyReportCount()
    {
		$model = new MonthlyReportTable();
        return $result = $model->fetchSiteWiseMonthlyReportCount();
	}
}
