<?php

namespace App\Service;

use App\Model\VendorsType\VendorsTypeTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class VendorsTypeService
{

	public function saveVendorsType($request)
	{
		$data =  $request->all();
		DB::beginTransaction();
		try {
			$vendorsmodel = new VendorsTypeTable();
			$addvendors = $vendorsmodel->saveVendorsType($request);
			if ($addvendors > 0) {
				DB::commit();
				$msg = 'Vendors Added Successfully';
				return $msg;
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	//Get All Vendors List
	public function getAllVendorsType()
	{
		$vendorsmodel = new VendorsTypeTable();
		$result = $vendorsmodel->fetchAllVendorsType();
		return $result;
	}

	//Get All Active Vendors Type
	public function getActiveVendorsType()
	{
		$vendorsmodel = new VendorsTypeTable();
		$result = $vendorsmodel->fetchAllActiveVendorsType();
		return $result;
	}

	//Get Particular Vendors Details
	public function getVendorsTypeById($id)
	{
		$vendorsmodel = new VendorsTypeTable();
		$result = $vendorsmodel->fetchVendorsTypeById($id);
		return $result;
	}
	//Update Particular Vendors Details
	public function updateVendorsType($params, $id)
	{
		DB::beginTransaction();
		try {
			$vendorsmodel = new VendorsTypeTable();
			$updateVendors = $vendorsmodel->updateVendorsType($params, $id);
			if ($updateVendors > 0) {
				DB::commit();
				$msg = 'Vendors Type Updated Successfully';
				return $msg;
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}
}
