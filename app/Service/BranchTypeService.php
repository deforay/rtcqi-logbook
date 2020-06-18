<?php
/*
Author             : Sudarmathi M
Date               : 17 june 2020
Description        : Branch Type Service Page
Last Modified Date : 17 june 2020
Last Modified Name : Sudarmathi M
*/

namespace App\Service;
use App\Model\BranchType\BranchTypeTable;
use DB;
use Redirect;

class BranchTypeService
{
   
    public function saveBranchType($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new BranchTypeTable();
        	$add = $model->saveBranchType($request);
			if($add>0){
                DB::commit();
				$msg = 'Branch Type Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All BranchType List
	public function getAllBranchType()
    {
		$model = new BranchTypeTable();
        $result = $model->fetchAllBranchType();
        return $result;
	}

	//Get All BranchType List
	public function getAllActiveBranchType()
    {
		$model = new BranchTypeTable();
        $result = $model->fetchAllActiveBranchType();
        return $result;
	}
	//Get Particular BranchType Details
	public function getBranchTypeById($id)
	{
		$model = new BranchTypeTable();
        $result = $model->fetchBranchTypeById($id);
        return $result;
	}
	//Update Particular BranchType Details
	public function updateBranchType($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new BranchTypeTable();
        	$add = $model->updateBranchType($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Branch Type Updated Successfully';
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