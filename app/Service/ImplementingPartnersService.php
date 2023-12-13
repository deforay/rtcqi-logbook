<?php
/*
Author             : Prasath M
Date               : 31 May 2021
Description        : Province Service Page
Last Modified Date : 31 May 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\ImplementingPartners\ImplementingPartnersTable;
use DB;

class ImplementingPartnersService
{
   
    public function saveImplementingPartners($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new ImplementingPartnersTable();
        	$add = $model->saveImplementingPartners($request);
			if($add>0){
                DB::commit();
				$msg = 'Implementing Partner Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Implementing Partners List
	public function getAllImplementingPartners()
    {
		$model = new ImplementingPartnersTable();
        $result = $model->fetchAllImplementingPartners();
        return $result;
	}

	//Get All Province List
	public function getAllActiveImplementingPartners()
    {
		$model = new ImplementingPartnersTable();
        $result = $model->fetchAllActiveImplementingPartners();
        return $result;
	}
	//Get Particular Implementing Partners Details
	public function getImplementingPartnersById($id)
	{
		
		$model = new ImplementingPartnersTable();
        $result = $model->fetchImplementingPartnersById($id);
        return $result;
	}
	//Update Particular Implementing Partners Details
	public function updateImplementingPartners($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new ImplementingPartnersTable();
        	$add = $model->updateImplementingPartners($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Implementing Partners Updated Successfully';
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