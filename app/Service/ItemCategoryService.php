<?php
/*
Author             : Prasath M
Date               : 18 june 2020
Description        : Item Category Service Page
Last Modified Date : 18 june 2020
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\ItemCategory\ItemCategoryTable;
use DB;
use Redirect;

class ItemCategoryService
{
   
    public function saveItemCategory($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new ItemCategoryTable();
        	$add = $model->saveItemCategory($request);
			if($add>0){
                DB::commit();
				$msg = 'Item Category Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All ItemCategory List
	public function getAllItemCategory()
    {
		$model = new ItemCategoryTable();
        $result = $model->fetchAllItemCategory();
        return $result;
	}

	//Get All ItemCategory List
	public function getAllActiveItemCategory()
    {
		$model = new ItemCategoryTable();
        $result = $model->fetchAllActiveItemCategory();
        return $result;
	}
	//Get Particular ItemCategory Details
	public function getItemCategoryById($id)
	{
		$model = new ItemCategoryTable();
        $result = $model->fetchItemCategoryById($id);
        return $result;
	}
	//Update Particular ItemCategory Details
	public function updateItemCategory($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new ItemCategoryTable();
        	$add = $model->updateItemCategory($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Item Category Updated Successfully';
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