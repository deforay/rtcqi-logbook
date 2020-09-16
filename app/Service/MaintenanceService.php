<?php
namespace App\Service;
use App\Model\Maintenance\MaintenanceTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class MaintenanceService
{
	
	//Get All Maintenance List
	public function getAllMaintenance()
	{
		$model = new MaintenanceTable();
		$result = $model->fetchAllMaintenance();
		return $result;
	}

	//Save Maintenance Details

    public function saveMaintenance($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new MaintenanceTable();
        	$addModel = $model->saveMaintenance($request);
			if($addModel>0){
				DB::commit();
				$msg = 'Maintenance Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	

	//Get All Active Maintenance List
	// public function getAllActiveMaintenance()
    // {
	// 	$model = new MaintenanceTable();
    //     $result = $model->fetchAllActiveInventoryOutwards();
    //     return $result;
	// }

	//Get Particular Maintenance Details
	public function getMaintenanceById($id)
	{
		$model = new MaintenanceTable();
        $result = $model->fetchMaintenanceById($id);
        return $result;
	}

	//Update Maintenance Details
	public function updateMaintenance($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$assetTagmodel = new MaintenanceTable();
        	$updateAssetTag = $assetTagmodel->updateMaintenance($params,$id);
			if($updateAssetTag>0){
				DB::commit();
				$msg = 'Maintenance Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	// public function getAssetId($request)
	// {
	// 	$inventoryOutwardsmodel = new MaintenanceTable();
    //     $result = $inventoryOutwardsmodel->fetchAssetId($request);
    //     return $result;
	// }
}
