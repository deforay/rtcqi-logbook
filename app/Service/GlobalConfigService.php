<?php
/*
Author             : Prasath M
Date               : 03 Jun 2021
Description        : Global Config Service Page
Last Modified Date : 03 Jun 2021
Last Modified Name : Prasath M
*/

namespace App\Service;
use App\Model\GlobalConfig\GlobalConfigTable;
use DB;

class GlobalConfigService
{
   
	//Get All GlobalConfig List
	public function getAllGlobalConfig()
    {
		$model = new GlobalConfigTable();
        $result = $model->fetchAllGlobalConfig();
        return $result;
	}

	//Update Particular GlobalConfig Details
	public function updateGlobalConfig($params)
    {
    	DB::beginTransaction();
    	try {
			$model = new GlobalConfigTable();
        	$add = $model->updateGlobalConfig($params);
			if($add>0){
                DB::commit();
				$msg = 'GlobalConfig Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//Fetch GlobalConfig 
	public function getGlobalConfigValue($configName)
    {
		$model = new GlobalConfigTable();
        $result = $model->fetchGlobalConfigValue($configName);
        return $result;
	}

	
}

?>