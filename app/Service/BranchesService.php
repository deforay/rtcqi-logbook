<?php
/*
Author             : Sudarmathi M
Date               : 18 june 2020
Description        : Branch Service Page
Last Modified Date : 18 june 2020
Last Modified Name : Sudarmathi M
*/

namespace App\Service;
use App\Model\Branches\BranchesTable;
use DB;
use Redirect;

class BranchesService
{
   
    public function saveBranches($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new BranchesTable();
        	$add = $model->saveBranches($request);
			if($add>0){
                DB::commit();
				$msg = 'Branches Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Branches List
	public function getAllBranches()
    {
		$model = new BranchesTable();
        $result = $model->fetchAllBranches();
        return $result;
	}

	//Get All Branches List
	public function getAllActiveBranches()
    {
		$model = new BranchesTable();
        $result = $model->fetchAllActiveBranches();
        return $result;
	}
	//Get Particular Branches Details
	public function getBranchesById($id)
	{
		$model = new BranchesTable();
        $result = $model->fetchBranchesById($id);
        return $result;
	}
	//Update Particular Branches Details
	public function updateBranches($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new BranchesTable();
        	$add = $model->updateBranches($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Branches Updated Successfully';
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