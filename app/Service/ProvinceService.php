<?php
/*

Date               : 31 May 2021
Description        : Province Service Page
Last Modified Date : 31 May 2021

*/

namespace App\Service;

use App\Model\Province\ProvinceTable;
use DB;

class ProvinceService
{

	public function saveProvince($request)
	{
		$data =  $request->all();
		DB::beginTransaction();
		try {
			$model = new ProvinceTable();
			$add = $model->saveProvince($request);
			if ($add > 0) {
				DB::commit();
				return 'Province Added Successfully';
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	//Get All Province List
	public function getAllProvince()
	{
		$model = new ProvinceTable();
		return $model->fetchAllProvince();
	}

	//Get All Province List
	public function getAllActiveProvince()
	{
		$model = new ProvinceTable();
		return $model->fetchAllActiveProvince();
	}
	//Get Particular Province Details
	public function getProvinceById($id)
	{

		$model = new ProvinceTable();
		return $model->fetchProvinceById($id);
	}
	//Update Particular Province Details
	public function updateProvince($params, $id)
	{
		DB::beginTransaction();
		try {
			$model = new ProvinceTable();
			$add = $model->updateProvince($params, $id);
			if ($add > 0) {
				DB::commit();
				return 'Province Updated Successfully';
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}
}
