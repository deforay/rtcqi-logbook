<?php
/*

Date               : 31 May 2021
Description        : Province Service Page
Last Modified Date : 31 May 2021

*/

namespace App\Service;

use App\Model\ImplementingPartners\ImplementingPartnersTable;
use DB;

class ImplementingPartnersService
{

	public function saveImplementingPartners($request)
	{
		$data =  $request->all();
		DB::beginTransaction();
		try {
			$model = new ImplementingPartnersTable();
			$add = $model->saveImplementingPartners($request);
			if ($add > 0) {
				DB::commit();
				return 'Implementing Partner Added Successfully';
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	//Get All Implementing Partners List
	public function getAllImplementingPartners()
	{
		$model = new ImplementingPartnersTable();
		return $model->fetchAllImplementingPartners();
	}

	//Get All Province List
	public function getAllActiveImplementingPartners()
	{
		$model = new ImplementingPartnersTable();
		return $model->fetchAllActiveImplementingPartners();
	}
	//Get Particular Implementing Partners Details
	public function getImplementingPartnersById($id)
	{

		$model = new ImplementingPartnersTable();
		return $model->fetchImplementingPartnersById($id);
	}
	//Update Particular Implementing Partners Details
	public function updateImplementingPartners($params, $id)
	{
		DB::beginTransaction();
		try {
			$model = new ImplementingPartnersTable();
			$add = $model->updateImplementingPartners($params, $id);
			if ($add > 0) {
				DB::commit();
				return 'Implementing Partners Updated Successfully';
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}
}
