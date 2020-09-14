<?php

namespace App\Service;
use App\Model\AssetTag\AssetTagTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class AssetTagService
{
   
    public function saveAssetTag($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new AssetTagTable();
        	$addModel = $model->saveAssetTag($request);
			if($addModel>0){
				DB::commit();
				$msg = 'Asset Tag Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Asset Tag List
	public function getAllAssetTag()
    {
		$model = new AssetTagTable();
        $result = $model->fetchAllAssetTag();
        return $result;
	}

	//Get All Active Asset Tag List
	public function getAllActiveInventoryOutwards()
    {
		$model = new AssetTagTable();
        $result = $model->fetchAllActiveInventoryOutwards();
        return $result;
	}

	//Get Particular Asset Tag Details
	public function getAssetTagById($id)
	{
		$model = new AssetTagTable();
        $result = $model->fetchAssetTagById($id);
        return $result;
	}
	//Update Asset Tag Details
	public function updateAssetTag($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$assetTagmodel = new AssetTagTable();
        	$updateAssetTag = $assetTagmodel->updateAssetTag($params,$id);
			if($updateAssetTag>0){
				DB::commit();
				$msg = 'Asset Tag Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	public function getAssetId($request)
	{
		$inventoryOutwardsmodel = new AssetTagTable();
        $result = $inventoryOutwardsmodel->fetchAssetId($request);
        return $result;
	}
}
