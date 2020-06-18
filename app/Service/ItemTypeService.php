<?php
/*
Author             : Prasath M
Date               : 18 june 2020
Description        : Item Type Service Page
Last Modified Date : 18 june 2020
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\ItemType\ItemTypeTable;
use DB;
use Redirect;

class ItemTypeService
{
   
    public function saveItemType($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new ItemTypeTable();
        	$add = $model->saveItemType($request);
			if($add>0){
                DB::commit();
				$msg = 'Item Type Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All ItemType List
	public function getAllItemType()
    {
		$model = new ItemTypeTable();
        $result = $model->fetchAllItemType();
        return $result;
	}

	//Get All ItemType List
	public function getAllActiveItemType()
    {
		$model = new ItemTypeTable();
        $result = $model->fetchAllActiveItemType();
        return $result;
	}
	//Get Particular ItemType Details
	public function getItemTypeById($id)
	{
		$model = new ItemTypeTable();
        $result = $model->fetchItemTypeById($id);
        return $result;
	}
	//Update Particular ItemType Details
	public function updateItemType($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new ItemTypeTable();
        	$add = $model->updateItemType($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Item Type Updated Successfully';
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