<?php

namespace App\Service;
use App\Model\InventoryStock\InventoryStockTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class InventoryStockService
{
   
    public function importInventoryStock($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new InventoryStockTable();
			$add = $model->importInventoryStock($request);
			// print_r($add);die;
			if($add>0){
				DB::commit();
				$msg = 'Inventory Stock Imported Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	

}
