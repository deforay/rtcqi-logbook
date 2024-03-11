<?php
/*
Author             : Sakthivel P
Date               : 3 June 2021
Description        : Allowed Test Kit Service Page
Last Modified Date : 3 June 2021
Last Modified Name : Sakthivel P
*/

namespace App\Service;
use App\Model\AllowedTestKit\AllowedTestKitTable;
use DB;

class AllowedTestKitService
{
   
    public function saveAllowedTestKit($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new AllowedTestKitTable();
        	$add = $model->saveAllowedTestKit($request);
			if($add>0){
                DB::commit();
				return 'Allowed Test Kit Added Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All AllowedTestKit List
	public function getAllAllowedKitTest()
    {
		$model = new AllowedTestKitTable();
        return $model->fetchAllAllowedKitTest();
	}

	//Get Particular AllowedTestKit Details
	public function getAllowedKitTestByValue($id)
	{
		
		$model = new AllowedTestKitTable();
        return $model->fetchAllowedKitTestByValue($id);
	}
	//Update Particular AllowedTestKit Details
	public function updateAllowedTestKit($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new AllowedTestKitTable();
        	$add = $model->updateAllowedTestKit($params,$id);
			if($add>0){
                DB::commit();
				return 'Allowed Test Kit Updated Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//Get All AllowedTestKit No Details
	public function getAllKitNo($id)
	{
		
		$model = new AllowedTestKitTable();
        return $model->fetchAllAllowedKitTestByNo($id);
	}
	
}

?>