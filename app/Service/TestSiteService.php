<?php
/*

Date               : 28 May 2021
Description        : Test Site Service Page
Last Modified Date : 28 May 2021

*/

namespace App\Service;

use App\Model\TestSite\TestSiteTable;
use DB;

class TestSiteService
{

	public function saveTestSite($request)
	{
		$data =  $request->all();
		DB::beginTransaction();
		try {
			$model = new TestSiteTable();
			$add = $model->saveTestSite($request);
			if ($add > 0) {
				DB::commit();
				return 'TestSite Added Successfully';
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	//Get All TestSite List
	public function getAllTestSite()
	{
		$model = new TestSiteTable();
		return $model->fetchAllTestSite();
	}

	//Get All TestSite List
	public function getAllActiveTestSite()
	{
		$model = new TestSiteTable();
		return $model->fetchAllActiveTestSite();
	}
	//Get Particular TestSite Details
	public function getTestSiteById($id)
	{

		$model = new TestSiteTable();
		return $model->fetchTestSiteById($id);
	}
	//Update Particular TestSite Details
	public function updateTestSite($params, $id)
	{
		DB::beginTransaction();
		try {
			$model = new TestSiteTable();
			$add = $model->updateTestSite($params, $id);
			if ($add > 0) {
				DB::commit();
				return 'TestSite Updated Successfully';
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	//Get Current User All TestSite List
	public function getAllCurrentUserActiveTestSite()
	{
		$model = new TestSiteTable();
		return $model->fetchAllCurrentUserActiveTestSite();
	}

	//Get Particular TestSite
	public function getTestSiteData($id)
	{
		$model = new TestSiteTable();
		return $model->fetchTestSiteData($id);
	}

	public function getAllTestSiteList($params)
	{
		$model = new TestSiteTable();
		return $model->fetchAllTestSiteList($params);
	}

	public function bulkUploadTestSite($params)
	{
		$model = new TestSiteTable();
		return $model->bulkUploadTestSite($params);
	}
}
