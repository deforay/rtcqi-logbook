<?php
/*
Author             : Prasath M
Date               : 28 May 2021
Description        : Facility Service Page
Last Modified Date : 28 May 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\Facility\FacilityTable;
use DB;

class FacilityService
{
   
    public function saveFacility($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new FacilityTable();
        	$add = $model->saveFacility($request);
			if($add>0){
                DB::commit();
				$msg = 'Facility Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Facility List
	public function getAllFacility()
    {
		$model = new FacilityTable();
        $result = $model->fetchAllFacility();
        return $result;
	}

	//Get All Facility List
	public function getAllActiveFacility()
    {
		$model = new FacilityTable();
        $result = $model->fetchAllActiveFacility();
        return $result;
	}
	//Get Particular Facility Details
	public function getFacilityById($id)
	{
		
		$model = new FacilityTable();
        $result = $model->fetchFacilityById($id);
        return $result;
	}
	//Update Particular Facility Details
	public function updateFacility($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new FacilityTable();
        	$add = $model->updateFacility($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Facility Updated Successfully';
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