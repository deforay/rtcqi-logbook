<?php
/*
Author             : Prasath M
Date               : 18 june 2020
Description        : Item  Service Page
Last Modified Date : 18 june 2020
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\Item\ItemTable;
use DB;
use Redirect;

class ItemService
{
   
    public function saveItem($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new ItemTable();
        	$add = $model->saveItem($request);
			if($add>0){
                DB::commit();
				$msg = 'Item  Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Item List
	public function getAllItem()
    {
		$model = new ItemTable();
        $result = $model->fetchAllItem();
        return $result;
	}

	//Get Particular Item Details
	public function getItemById($id)
	{
		$model = new ItemTable();
        $result = $model->fetchItemById($id);
        return $result;
	}
	//Update Particular Item Details
	public function updateItem($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new ItemTable();
        	$add = $model->updateItem($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Item  Updated Successfully';
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