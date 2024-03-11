<?php
/*
Author             : Prasath M
Date               : 28 May 2021
Description        : Test Kit Service Page
Last Modified Date : 28 May 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\TestKit\TestKitTable;
use DB;

class TestKitService
{
   
    public function saveTestKit($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new TestKitTable();
        	$add = $model->saveTestKit($request);
			if($add>0){
                DB::commit();
				return 'TestKit Added Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All TestKit List
	public function getAllTestKit()
    {
		$model = new TestKitTable();
        return $model->fetchAllTestKit();
	}

	//Get All TestKit List
	public function getAllActiveTestKit()
    {
		$model = new TestKitTable();
        return $model->fetchAllActiveTestKit();
	}

	//Get Test Kit Summary
	public function getTestKitSummary($data){
		$model = new TestKitTable();
        return $model->fetchAllTestKitSummary($data);
	}

	//Get Particular TestKit Details
	public function getTestKitById($id)
	{
		$model = new TestKitTable();
        return $model->fetchTestKitById($id);
	}
	//Update Particular TestKit Details
	public function updateTestKit($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new TestKitTable();
        	$add = $model->updateTestKit($params,$id);
			if($add>0){
                DB::commit();
				return 'TestKit Updated Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
}

?>