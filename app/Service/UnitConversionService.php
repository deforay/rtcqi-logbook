<?php
/*
Author             : sriram v
Date               : 22 june 2020
Description        : Unit Conversion Service Page
Last Modified Date : 
Last Modified Name : 
*/

namespace App\Service;
use App\Model\UnitConversion\UnitConversionTable;
use DB;
use Redirect;

class UnitConversionService
{
   
    public function saveUnitConversion($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new UnitConversionTable();
        	$add = $model->saveUnitConversion($request);
			if($add>0){
                DB::commit();
				$msg = 'Unit Conversion Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Unit Conversion List
	public function getAllUnitConversion()
    {
		$model = new UnitConversionTable();
        $result = $model->fetchAllUnitConversion();
        return $result;
	}

	//Get All Unit Conversion List
	public function getAllActiveUnitConversion()
    {
		$model = new UnitConversionTable();
        $result = $model->fetchAllActiveUnitConversion();
        return $result;
	}
	//Get Particular Unit Details
	public function getUnitConversionById($id)
	{
		$model = new UnitConversionTable();
        $result = $model->fetchUnitConversionById($id);
        return $result;
	}
	//Update Particular Unit Details
	public function updateUnitConversion($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new UnitConversionTable();
        	$add = $model->updateUnitConversion($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Unit Conversion Updated Successfully';
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