<?php

namespace App\Service;
use App\Model\InventoryOutwards\InventoryOutwardsTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class InventoryOutwardsService
{
   
    public function saveInventoryOutwards($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$inventoryOutwardsmodel = new InventoryOutwardsTable();
        	$addInventoryOutwards = $inventoryOutwardsmodel->saveInventoryOutwards($request);
			if($addInventoryOutwards>0){
				DB::commit();
				$msg = 'Inventory Outwards Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All InventoryOutwards List
	public function getAllInventoryOutwards()
    {
		$inventoryOutwardsmodel = new InventoryOutwardsTable();
        $result = $inventoryOutwardsmodel->fetchAllInventoryOutwards();
        return $result;
	}

	//Get All Active InventoryOutwards List
	public function getAllActiveInventoryOutwards()
    {
		$inventoryOutwardsmodel = new InventoryOutwardsTable();
        $result = $inventoryOutwardsmodel->fetchAllActiveInventoryOutwards();
        return $result;
	}

	//Get Particular InventoryOutwards Details
	public function getInventoryOutwardsById($id)
	{
		$inventoryOutwardsmodel = new InventoryOutwardsTable();
        $result = $inventoryOutwardsmodel->fetchInventoryOutwardsById($id);
        return $result;
	}
	//Update Particular InventoryOutwards Details
	public function updateInventoryOutwards($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$inventoryOutwardsmodel = new InventoryOutwardsTable();
        	$updateInventoryOutwards = $inventoryOutwardsmodel->updateInventoryOutwards($params,$id);
			if($updateInventoryOutwards>0){
				DB::commit();
				$msg = 'Inventory Outwards Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//change Particular quotes status
	public function getItemByLoc($request)
	{
		$inventoryOutwardsmodel = new InventoryOutwardsTable();
        $result = $inventoryOutwardsmodel->fetchItemByLoc($request);
        return $result;
	}

	//change Particular quotes status
	public function getItemByLocReturn($request)
	{
		$inventoryOutwardsmodel = new InventoryOutwardsTable();
        $result = $inventoryOutwardsmodel->fetchItemByLocReturn($request);
        return $result;
	}
	
	public function getInventoryReport($request){
		$inventoryOutwardsmodel = new InventoryOutwardsTable();
        $result = $inventoryOutwardsmodel->fetchInventoryReport($request);
        return $result;
	}

	public function returnInventoryOutwards($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$inventoryOutwardsmodel = new InventoryOutwardsTable();
        	$addInventoryOutwards = $inventoryOutwardsmodel->returnInventoryOutwards($request);
			if($addInventoryOutwards>0){
				DB::commit();
				$msg = 'Inventory Outwards returned Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	public function getDetailedInventoryReport($request){
		$inventoryOutwardsmodel = new InventoryOutwardsTable();
        $result = $inventoryOutwardsmodel->fetchDetailedInventoryReport($request);
        return $result;
	}
}
