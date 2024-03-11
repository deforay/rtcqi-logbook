<?php
/*
Author             : Prasath M
Date               : 31 May 2021
Description        : SiteType Service Page
Last Modified Date : 31 May 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\SiteType\SiteTypeTable;
use DB;

class SiteTypeService
{
   
    public function saveSiteType($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new SiteTypeTable();
        	$add = $model->saveSiteType($request);
			if($add>0){
                DB::commit();
				return 'SiteType Added Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All SiteType List
	public function getAllSiteType()
    {
		$model = new SiteTypeTable();
        return $model->fetchAllSiteType();
	}

	//Get All SiteType List
	public function getAllActiveSiteType()
    {
		$model = new SiteTypeTable();
        return $model->fetchAllActiveSiteType();
	}
	//Get Particular SiteType Details
	public function getSiteTypeById($id)
	{
		
		$model = new SiteTypeTable();
        return $model->fetchSiteTypeById($id);
	}
	//Update Particular SiteType Details
	public function updateSiteType($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new SiteTypeTable();
        	$add = $model->updateSiteType($params,$id);
			if($add>0){
                DB::commit();
				return 'SiteType Updated Successfully';
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
}

?>