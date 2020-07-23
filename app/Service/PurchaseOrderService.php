<?php

namespace App\Service;
use App\Model\PurchaseOrder\PurchaseOrderTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class PurchaseOrderService
{
   
    public function savePurchaseOrder($id,$request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$purchaseOrdermodel = new PurchaseOrderTable();
        	$addPurchaseOrder = $purchaseOrdermodel->savePurchaseOrder($id,$request);
			if($addPurchaseOrder>0){
				DB::commit();
				$msg = 'Purchase Order Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Purchase Order List
	public function getAllPurchaseOrder()
    {
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchAllPurchaseOrder();
        return $result;
	}

	//Get All Active Purchase Order List
	public function getAllActivePurchaseOrder()
    {
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchAllActivePurchaseOrder();
        return $result;
	}

	//Get Particular Vendor Order Details
	public function getAllVendorDetailById($id)
	{
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchVendorDetailById($id);
        return $result;
	}

	public function getSumOfQuoteById($id)
	{
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchSumOfQuoteById($id);
        return $result;
	}
	
	public function getAllQuoteDetailsId($id)
	{
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchAllQuoteDetailsId($id);
        return $result;
	}

	public function getPurchaseorderById($id)
	{
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchPurchaseorderById($id);
        return $result;
	}

	public function getPurchaseorderByIdForDelivery($id)
	{
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchPurchaseorderByIdForDelivery($id);
        return $result;
	}

	public function getPurchaseOrderDetailsId($id)
	{
		$purchaseOrdermodel = new PurchaseOrderTable();
        $result = $purchaseOrdermodel->fetchPurchaseOrderDetailsId($id);
        return $result;
	}	
	
	//Update Particular Purchase Order Details
	public function updatePurchaseOrder($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$purchaseOrdermodel = new PurchaseOrderTable();
        	$updatepurchaseOrder = $purchaseOrdermodel->updatePurchaseOrderDetails($params,$id);
			if($updatepurchaseOrder>0){
				DB::commit();
				$msg = 'Purchase Order Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
}
