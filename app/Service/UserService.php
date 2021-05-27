<?php
/*
Author             : Prasath M
Date               : 27 May 2021
Description        : User Service Page
Last Modified Date : 27 May 2021
Last Modified Name : Prasath M
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
	
	//Validate User Login
	public function validateLogin($params)
	{
		$model = new UserTable();
        $result = $model->validateLogin($params);
        return $result;
	}
	
	//Update Particular User Profile Details
	public function updateProfile($params,$id)
	{
		DB::beginTransaction();
		try {
			$model = new UserTable();
			$add = $model->updateProfile($params,$id);
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