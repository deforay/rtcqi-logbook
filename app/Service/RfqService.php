<?php

namespace App\Service;
use App\Model\Rfq\RfqTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class RfqService
{
   
    public function saveRfq($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$rfqmodel = new RfqTable();
        	$addRfq = $rfqmodel->saveRfq($request);
			if($addRfq>0){
				DB::commit();
				$msg = 'RFQ Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Rfq List
	public function getAllRfq()
    {
		$rfqmodel = new RfqTable();
        $result = $rfqmodel->fetchAllRfq();
        return $result;
	}

	//Get All Active Rfq List
	public function getAllActiveRfq()
    {
		$rfqmodel = new RfqTable();
        $result = $rfqmodel->fetchAllActiveRfq();
        return $result;
	}

	//Get Particular Rfq Details
	public function getRfqById($id)
	{
		$rfqmodel = new RfqTable();
        $result = $rfqmodel->fetchRfqById($id);
        return $result;
	}
	//Update Particular Rfq Details
	public function updateRfq($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$rfqmodel = new RfqTable();
        	$updateRfq = $rfqmodel->updateRfq($params,$id);
			if($updateRfq>0){
				DB::commit();
				$msg = 'RFQ Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
}
