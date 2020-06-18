<?php
/*
Author             : Sudarmathi M
Date               : 18 june 2020
Description        : User Service Page
Last Modified Date : 18 june 2020
Last Modified Name : Sudarmathi M
*/

namespace App\Service;
use App\Model\User\UserTable;
use DB;
use Redirect;

class UserService
{
   
    public function saveUser($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$model = new UserTable();
        	$add = $model->saveUser($request);
			if($add>0){
                DB::commit();
				$msg = 'User Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
	
	//Get All User List
	public function getAllUser()
    {
		$model = new UserTable();
        $result = $model->fetchAllUser();
        return $result;
	}

	//Get All User List
	public function getAllActiveUser()
    {
		$model = new UserTable();
        $result = $model->fetchAllActiveUser();
        return $result;
	}
	//Get Particular User Details
	public function getUserById($id)
	{
		$model = new UserTable();
        $result = $model->fetchUserById($id);
        return $result;
	}
	//Update Particular User Details
	public function updateUser($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new UserTable();
        	$add = $model->updateUser($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'User Updated Successfully';
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