<?php

namespace App\Service;
use App\Model\PurchaseOrder\DeliveryScheduleTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class DeliveryScheduleService
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

	
	
}
