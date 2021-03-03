<?php

namespace App\Service;
use App\Model\RequestItem\RequestItemTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class RequestItemService
{
   
    public function saveRequestItem($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$reqmodel = new RequestItemTable();
        	$add = $reqmodel->saveRequestItem($request);
			if($add>0){
				DB::commit();
				$msg = 'Request Item Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All RequestItem List
	public function getRequestItemByLogin()
    {
		$reqmodel = new RequestItemTable();
        $result = $reqmodel->fetchRequestItemByLogin();
        return $result;
	}

	//Get All Active RequestItem List
	public function getAllActiveRequestItem()
    {
		$reqmodel = new RequestItemTable();
        $result = $reqmodel->fetchAllActiveRequestItem();
        return $result;
	}

	//Get Particular RequestItem Details
	public function getRequestItemById($id)
	{
		$reqmodel = new RequestItemTable();
        $result = $reqmodel->fetchRequestItemById($id);
        return $result;
	}
	//Update Particular RequestItem Details
	public function updateRequestItem($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$reqmodel = new RequestItemTable();
        	$updateRequestItem = $reqmodel->updateRequestItem($params,$id);
			if($updateRequestItem>0){
				DB::commit();
				$msg = 'Request Item Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//change Particular quotes status
	public function changeApproveStatus($params)
	{
		$reqmodel = new RequestItemTable();
        $result = $reqmodel->changeApproveStatus($params);
        return $result;
	}
	
	
}
