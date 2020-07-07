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

	//Get All Active Vendors List
	public function getAllActiveVendors()
    {
		$vendorsmodel = new VendorsTable();
        $result = $vendorsmodel->fetchAllActiveVendors();
        return $result;
	}

	//Get Particular Vendors Details
	public function getVendorsById($id)
	{
		$vendorsmodel = new VendorsTable();
        $result = $vendorsmodel->fetchVendorsById($id);
        return $result;
	}
	//Update Particular Vendors Details
	public function updateVendors($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$vendorsmodel = new VendorsTable();
        	$updateVendors = $vendorsmodel->updateVendorsDetails($params,$id);
			if($updateVendors==1){
				DB::commit();
				$msg = 'Vendors Updated Successfully';
				return $msg;
			}else{
				DB::commit();
				$msg = '2';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//Get Add Vendors 
	public function addVendor($params)
    {
		$vendorsmodel = new VendorsTable();
		$result = $vendorsmodel->addVendor($params);
        return $result;
	}
	
}
