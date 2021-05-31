<?php
/*
Author             : Prasath M
Date               : 31 May 2021
Description        : Province Service Page
Last Modified Date : 31 May 2021
Last Modified Name : Prasath M
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
			if($add>0){
                DB::commit();
				$msg = 'Province Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Province List
	public function getAllProvince()
    {
		$model = new ProvinceTable();
        $result = $model->fetchAllProvince();
        return $result;
	}

	//Get All Province List
	public function getAllActiveProvince()
    {
		$model = new ProvinceTable();
        $result = $model->fetchAllActiveProvince();
        return $result;
	}
	//Get Particular Province Details
	public function getProvinceById($id)
	{
		
		$model = new ProvinceTable();
        $result = $model->fetchProvinceById($id);
        return $result;
	}
	//Update Particular Province Details
	public function updateProvince($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new ProvinceTable();
        	$add = $model->updateProvince($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Province Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
}

?>