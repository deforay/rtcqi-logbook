<?php
/*

Date               : 03 Jun 2021
Description        : Global Config Service Page
Last Modified Date : 03 Jun 2021

*/

namespace App\Service;

use App\Model\GlobalConfig\GlobalConfigTable;
use DB;

class GlobalConfigService
{

	//Get All GlobalConfig List
	public function getAllGlobalConfig()
	{
		$model = new GlobalConfigTable();
		return $model->fetchAllGlobalConfig();
	}

	//Update Particular GlobalConfig Details
	public function updateGlobalConfig($params)
	{
		DB::beginTransaction();
		try {
			$model = new GlobalConfigTable();
			$add = $model->updateGlobalConfig($params);
			if ($add > 0) {
				DB::commit();
				return 'GlobalConfig Updated Successfully';
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	//Fetch GlobalConfig
	public function getGlobalConfigValue($configName)
	{
		$model = new GlobalConfigTable();
		return $model->fetchGlobalConfigValue($configName);
	}

	//Fetch GlobalConfig
	public function getGlobalConfigData($configName)
	{
		$model = new GlobalConfigTable();
		return $model->fetchGlobalConfigData($configName);
	}

	//Fetch GlobalConfig
	public function getGlobalConfigLatitude($latitute)
	{
		$model = new GlobalConfigTable();
		return $model->fetchGlobalConfigLatitide($latitute);
	}

	public function getGlobalConfigLongitude($longitude)
	{
		$model = new GlobalConfigTable();
		return $model->fetchGlobalConfigLongitude($longitude);
	}

	public function getGlobalConfigMapZoomLevel($mapZoomLevel)
	{
		$model = new GlobalConfigTable();
		return $model->fetchGlobalConfigMapZoomLevel($mapZoomLevel);
	}
}
