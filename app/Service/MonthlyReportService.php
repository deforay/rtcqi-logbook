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
				return 'Monthly Report Added Successfully';
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
        return $model->fetchAllMonthlyReport($params);
	}

	//Get Selected Site Monthly Report List
	public function getSelectedSiteMonthlyReport($params)
    {
		$model = new MonthlyReportTable();
        return $model->fetchSelectedSiteMonthlyReport($params);
	}

	//Get All MonthlyReport List
	public function getAllActiveMonthlyReport()
    {
		$model = new MonthlyReportTable();
        return $model->fetchAllActiveMonthlyReport();
	}
	//Get Particular MonthlyReport Details
	public function getMonthlyReportById($id)
	{
		
		$model = new MonthlyReportTable();
        return $model->fetchMonthlyReportById($id);
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
				return 'Monthly Report Updated Successfully';
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
		return $model->fetchTrendMonthlyReport($params);
	}

	public function getTrendMonthlyReportChartData($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchTrendMonthlyReportChartData($params);
	}

	public function getLogbookReport($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchLogbookReport($params);
	}

	public function getPageSummary($id)
	{
		$model = new MonthlyReportTable();
		return $model->fetchPageSummary($id);
	}

	public function getTestKitMonthlyReport($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchTestKitMonthlyReport($params);
	}

	public function importMonthlyReportData($request)
    {
		$data =  $request->all();
		$model = new MonthlyReportTable();
		return $model->importMonthlyReportData($request);
	}

	public function getCustomMonthlyReport($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchCustomMonthlyReport($params);
	}

	public function getNotReportedSites($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchNotReportedSites($params);
	}

	public function getInvalidResultReport($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchInvalidResultReport($params);
	}
	public function getLatestValue()
	{
		$model = new MonthlyReportTable();
		return $model->getLatestValue();
	}

	public function CheckPreLot($params)
	{
		$model = new MonthlyReportTable();
		return $model->CheckPreLot($params);
	}

	public function getDashboardData($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchDashboardData($params);
	}

	//Get All TotalCountMonthlyReport List
	public function getTotalCountOfMonthlyReport()
    {
		$model = new MonthlyReportTable();
        return $model->fetchTotalCountOfMonthlyReport();
	}

	//Get All CountMonthlyReport List
	public function getCountOfMonthlyReport()
    {
		$model = new MonthlyReportTable();
        return $model->fetchCountOfMonthlyReport();
	}

	//Get All SiteCountMonthlyReport List
	public function getSiteCountOfMonthlyReport()
    {
		$model = new MonthlyReportTable();
        return $model->fetchSiteCountOfMonthlyReport();
	}

	//Get All MonthlyData List
	public function getMonthlyData()
    {
		$model = new MonthlyReportTable();
        return $model->fetchMonthlyData();
	}

	//Inserting Track Data
	public function insertData()
    {
		$model = new MonthlyReportTable();
        return $model->insertTrackTable();
	}
	
	//Inserting LogBook Track Data
	public function insertLogBookData()
    {
		$model = new MonthlyReportTable();
        return $model->logBookReportTrackTable();
	}

	//Inserting TestKit Track Data
	public function insertTestKitData()
    {
		$model = new MonthlyReportTable();
        return $model->testKitReportTrackTable();
	}

	//Inserting TestKit Summary Track Data
	public function insertTestKitSummaryData()
    {
		$model = new MonthlyReportTable();
        return $model->testKitSummaryReportTrackTable();
	}

	//Inserting Invalid Results Track Data
	public function invalidReportData()
    {
		$model = new MonthlyReportTable();
        return $model->invalidReportTrackTable();
	}

	//Inserting Trend Track Data
	public function insertTrendData()
    {
		$model = new MonthlyReportTable();
        return $model->trendReportTrackTable();
	}
	
	//Inserting Custom Track Data
	public function customReportData()
    {
		$model = new MonthlyReportTable();
        return $model->customReportTrackTable();
	}

	public function getExistingReportingMonth($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchExistingReportingMonth($params);
	}

	public function getIdExistingReportingMonth($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchIdExistingReportingMonth($params);
	}
	
	//Get All Not Upload MonthlyReport List
	public function getAllNotUploadMonthlyReport($params, $isExport=false)
    {
		
		$model = new NotUploadMonthlyReportTable();
        return $model->fetchAllNotUploadMonthlyReport($params, $isExport);
	}
	
	//Get All Not Upload Test Sites
	public function getAllNotUploadActiveTestSite()
    {
		$model = new NotUploadMonthlyReportTable();
        return $model->fetchAllNotUploadActiveTestSite();
	}

	//Get All Not Upload Provinces
	public function getAllNotUploadActiveProvince()
    {
		$model = new NotUploadMonthlyReportTable();
        return $model->fetchAllNotUploadActiveProvince();
	}

	public function getSiteWiseReport($params)
	{
		$model = new MonthlyReportTable();
		return $model->fetchSiteWiseReport($params);
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

	public function getTestWiseMonthlyReportCount()
    {
		$model = new MonthlyReportTable();
        return $result = $model->fetchTestWiseMonthlyReportCount();
	}

	public function sendSiteWiseReminderEmail($params)
    {
		$model = new MonthlyReportTable();
        return $result = $model->sendSiteWiseReminderEmail($params);
	}
}
