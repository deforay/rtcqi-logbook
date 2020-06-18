<?php

namespace App\Service;
use App\Model\Vendors\VendorsTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class VendorsService
{
   
    public function saveVendors($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$vendorsmodel = new VendorsTable();
        	$addvendors = $vendorsmodel->saveVendors($request);
			if($addvendors>0){
				DB::commit();
				$msg = 'Vendors Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Vendors List
	public function getAllVendors()
    {
		$vendorsmodel = new VendorsTable();
        $result = $vendorsmodel->fetchAllVendors();
        return $result;
	}

	//Get Particular Vendors Details
	public function getVendorsById()
	{
		$vendorsmodel = new VendorsTable();
        $result = $vendorsmodel->fetchVendorsById();
        return $result;
	}
	//Update Particular Vendors Details
	public function updateVendors($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$vendorsmodel = new VendorsTable();
        	$updateVendors = $vendorsmodel->updateCustomers($params,$id);
			if($updateVendors>0){
				DB::commit();
				$msg = 'Vendors Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
}
