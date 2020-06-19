<?php
/*
Author             : Prasath M
Date               : 18 june 2020
Description        : Brand Service Page
Last Modified Date : 18 june 2020
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\Brand\BrandTable;
use DB;
use Redirect;

class BrandService
{
   
    public function saveBrand($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new BrandTable();
        	$add = $model->saveBrand($request);
			if($add>0){
                DB::commit();
				$msg = 'Brand Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Brand List
	public function getAllBrand()
    {
		$model = new BrandTable();
        $result = $model->fetchAllBrand();
        return $result;
	}

	//Get All Brand List
	public function getAllActiveBrand()
    {
		$model = new BrandTable();
        $result = $model->fetchAllActiveBrand();
        return $result;
	}
	//Get Particular Brand Details
	public function getBrandById($id)
	{
		$model = new BrandTable();
        $result = $model->fetchBrandById($id);
        return $result;
	}
	//Update Particular Brand Details
	public function updateBrand($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new BrandTable();
        	$add = $model->updateBrand($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Brand Updated Successfully';
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