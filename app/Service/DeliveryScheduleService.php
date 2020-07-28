<?php

namespace App\Service;
use App\Model\DeliverySchedule\DeliveryScheduleTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class DeliveryScheduleService
{
	
	//Get All Delivery Schedule List
	public function getAllDeliverySchedule($request)
    {
		$deliverySchedulemodel = new DeliveryScheduleTable();
        $result = $deliverySchedulemodel->fetchAllDeliverySchedule($request);
        return $result;
	}

	public function saveDeliverySchedule($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new DeliveryScheduleTable();
			$result = $model->saveDeliverySchedule($request);
			if($result > 0){
				DB::commit();
				return $result;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//Update Delivery Schedule List By Id
	public function getDeliveryScheduleById($id)
    {
		$deliverySchedulemodel = new DeliveryScheduleTable();
        $result = $deliverySchedulemodel->fetchDeliveryScheduleById($id);
        return $result;
	}


	public function updateDeliverySchedule($id,$request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$deliverySchedulemodel = new DeliveryScheduleTable();
        	$result = $deliverySchedulemodel->updateDeliverySchedule($id,$request);
			if($result>0){
				DB::commit();
				$msg = 'Delivery Schedule Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	public function getDeliverySchedule($request){
		$deliverySchedulemodel = new DeliveryScheduleTable();
        $result = $deliverySchedulemodel->fetchDeliverySchedule($request);
        return $result;
	}
}
