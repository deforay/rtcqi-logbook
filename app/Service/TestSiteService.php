<?php
/*
Author             : Prasath M
Date               : 28 May 2021
Description        : Test Site Service Page
Last Modified Date : 28 May 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\TestSite\TestSiteTable;
use DB;

class TestSiteService
{
   
    public function saveTestSite($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new TestSiteTable();
        	$add = $model->saveTestSite($request);
			if($add>0){
                DB::commit();
				$msg = 'TestSite Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All TestSite List
	public function getAllTestSite()
    {
		$model = new TestSiteTable();
        $result = $model->fetchAllTestSite();
        return $result;
	}

	//Get All TestSite List
	public function getAllActiveTestSite()
    {
		$model = new TestSiteTable();
        $result = $model->fetchAllActiveTestSite();
        return $result;
	}
	//Get Particular TestSite Details
	public function getTestSiteById($id)
	{
		
		$model = new TestSiteTable();
        $result = $model->fetchTestSiteById($id);
        return $result;
	}
	//Update Particular TestSite Details
	public function updateTestSite($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new TestSiteTable();
        	$add = $model->updateTestSite($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'TestSite Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//Get Current User All TestSite List
	public function getAllCurrentUserActiveTestSite()
    {
		$model = new TestSiteTable();
        $result = $model->fetchAllCurrentUserActiveTestSite();
        return $result;
	}

	//Get Particular TestSite
	public function getTestSiteData($id)
    {
		$model = new TestSiteTable();
        $result = $model->fetchTestSiteData($id);
        return $result;
	}
	
}

?>