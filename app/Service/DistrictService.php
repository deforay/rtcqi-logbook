<?php
/*
Author             : Prasath M
Date               : 31 May 2021
Description        : District Service Page
Last Modified Date : 31 May 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\District\DistrictTable;
use DB;

class DistrictService
{
   
    public function saveDistrict($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new DistrictTable();
        	$add = $model->saveDistrict($request);
			if($add>0){
                DB::commit();
				$msg = 'District Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All District List
	public function getAllDistrict()
    {
		$model = new DistrictTable();
        $result = $model->fetchAllDistrict();
        return $result;
	}

	//Get Particular District Details
	public function getDistrictById($id)
	{
		
		$model = new DistrictTable();
        $result = $model->fetchDistrictById($id);
        return $result;
	}
	//Update Particular District Details
	public function updateDistrict($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new DistrictTable();
        	$add = $model->updateDistrict($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'District Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}


	//Get Particular District Name
	public function getDistictName($id)
    {
		$model = new DistrictTable();
        $result = $model->fetchDistrictName($id);
        return $result;
	}
}

?>