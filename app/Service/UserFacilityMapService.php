<?php
/*
Author             : Sakthivel P
Date               : 2 June 2021
Description        : User Facility Map Service Page
Last Modified Date : 2 June 2021
Last Modified Name : Sakthivel P
*/

namespace App\Service;
use App\Model\UserFacilityMap\UserFacilityMapTable;
use DB;

class UserFacilityMapService
{
   
    public function saveUserFacility($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new UserFacilityMapTable();
        	$add = $model->saveUserFacility($request);
			if($add>0){
                DB::commit();
				return 'User Facility Added Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All UserFacilityMap List
	public function getAllUserFacility()
    {
		$model = new UserFacilityMapTable();
        return $model->fetchAllUserFacility();
	}

	//Get Particular UserFacilityMap Details
	public function getUserFacilityById($id)
	{
		
		$model = new UserFacilityMapTable();
        return $model->fetchUserFacilityById($id);
	}
	//Update Particular UserFacilityMap Details
	public function updateUserFacility($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new UserFacilityMapTable();
        	$add = $model->updateUserFacility($params,$id);
			if($add>0){
                DB::commit();
				return 'User Facility Updated Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	//Get Particular UserFacilityMap Details
	public function getUserSiteById($id)
	{
		
		$model = new UserFacilityMapTable();
        return $model->fetchUserSiteById($id);
	}
	
}

?>