<?php
/*
Author             : Prasath M
Date               : 31 May 2021
Description        : District Service Page
Last Modified Date : 31 May 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\SubDistrict\SubDistrictTable;
use DB;

class SubDistrictService
{
   
    public function saveSubDistrict($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new SubDistrictTable();
        	$add = $model->saveSubDistrict($request);
			if($add>0){
                DB::commit();
				$msg = 'Sub District Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Sub District List
	public function getAllSubDistrict()
    {
		$model = new SubDistrictTable();
        $result = $model->fetchAllSubDistrict();
        return $result;
	}

	public function getSubDistrictByDistrictId($id)
	{
		$model = new SubDistrictTable();
        $result = $model->fetchSubDistrictNameByDistrictId($id);
		return $result;
	}

	//Get Particular Sub District Details
	public function getSubDistrictById($id)
	{
		
		$model = new SubDistrictTable();
        $result = $model->fetchSubDistrictById($id);
        return $result;
	}
	//Update Particular Sub District Details
	public function updateSubDistrict($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new SubDistrictTable();
        	$add = $model->updateSubDistrict($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Sub District Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}


	//Get Particular Sub District Name
	public function getSubDistictName($id)
    {
		$model = new SubDistrictTable();
        $result = $model->fetchSubDistrictName($id);
        return $result;
	}
	
	public function getSubDistictByData($id)
    {
		$model = new SubDistrictTable();
        $result = $model->fetchSubDistrictData($id);
        return $result;
	}

	
}

?>