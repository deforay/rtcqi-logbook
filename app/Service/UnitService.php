<?php
/*
Author             : Prasath M
Date               : 18 june 2020
Description        : Unit Service Page
Last Modified Date : 18 june 2020
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\Unit\UnitTable;
use DB;
use Redirect;

class UnitService
{
   
    public function saveUnit($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new UnitTable();
        	$add = $model->saveUnit($request);
			if($add>0){
                DB::commit();
				$msg = 'Unit Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Unit List
	public function getAllUnit()
    {
		$model = new UnitTable();
        $result = $model->fetchAllUnit();
        return $result;
	}

	//Get All Unit List
	public function getAllActiveUnit()
    {
		$model = new UnitTable();
        $result = $model->fetchAllActiveUnit();
        return $result;
	}
	//Get Particular Unit Details
	public function getUnitById($id)
	{
		$model = new UnitTable();
        $result = $model->fetchUnitById($id);
        return $result;
	}
	//Update Particular Unit Details
	public function updateUnit($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new UnitTable();
        	$add = $model->updateUnit($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Unit Updated Successfully';
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