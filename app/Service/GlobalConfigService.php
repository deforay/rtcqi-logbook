<?php

namespace App\Service;
use App\Model\GlobalConfig\GlobalConfigTable;
// use App\EventLog\EventLog;
use DB;
use Redirect;

class GlobalConfigService
{
	
	//Get All Global Config List
	public function getAllGlobalConfig()
    {
		$configModel = new GlobalConfigTable();
        $result = $configModel->fetchAllConfig();
        return $result;
    }
    
    //Get All Global Config List edit screen
	public function getAllGlobalConfigEdit()
    {
		$configModel = new GlobalConfigTable();
        $result = $configModel->fetchAllConfigEdit();
        return $result;
	}
	
	//Update Particular Global Config Details
	public function updateGlobalConfig($params)
    {
    	DB::beginTransaction();
    	try {
			$globalConfigModel = new GlobalConfigTable();
        	$addGlobalConfig = $globalConfigModel->updateGlobalConfig($params);
			if($addGlobalConfig>0){
				DB::commit();
				$msg = 'Global Config Updated Successfully';
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