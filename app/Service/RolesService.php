<?php
/*
Author             : Sakthi
Date               : 28 Feb 2022
Description        : Roles Service Page
Last Modified Date : 28 Feb 2022
Last Modified Name : Sakthi
*/

namespace App\Service;
use App\Model\Roles\RolesTable;
// use App\EventLog\EventLog;
use DB;
use Redirect;

class RolesService
{
   
    public function saveRoles($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$Rolesmodel = new RolesTable();
        	$addRoles = $Rolesmodel->saveRoles($request);
			if($addRoles>0){
				$Rolesmodel->mapRolePrivilege($request,$addRoles);
				DB::commit();
				$msg = 'Roles Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All Role List
	public function getAllRole()
    {
		$RoleModel = new RolesTable();
        $result = $RoleModel->fetchAllRole();
        return $result;
	}

	//Get All Role List
	public function getAllActiveRole()
    {
		$RoleModel = new RolesTable();
        $result = $RoleModel->fetchAllActiveRole();
        return $result;
	}
	//Get Particular Roles Details
	public function getRolesById($id)
	{
		$RolesModel = new RolesTable();
        $result = $RolesModel->fetchRolesById($id);
        return $result;
	}
	//Update Particular Roles Details
	public function updateRoles($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$RolesModel = new RolesTable();
        	$addRoles = $RolesModel->updateRoles($params,$id);
			if($addRoles>0){
				$RolesModel->mapRolePrivilege($params,base64_decode($id));
				DB::commit();
				$msg = 'Roles Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

	//Fetch All resource
	public function getAllResource(){
		$RolesModel = new RolesTable();
		$result = $RolesModel->fetchAllResource();
        return $result;
	}
}

?>