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
use App\Model\User\UserLoginHistoryTable;
use App\Model\track\TrackTable;
use DB;

class UserService
{

    public function saveUser($request)
    {
        $data =  $request->all();
        DB::beginTransaction();
        try {
            $model = new UserTable();
            $add = $model->saveUser($request);
            if ($add > 0) {
                DB::commit();
                return 'User Added Successfully';
            }
        } catch (Exception $exc) {
            DB::rollBack();
            $exc->getMessage();
        }
    }
	//Register User
	public function registerUser($request)
    {
        $data =  $request->all();
        DB::beginTransaction();
        try {
            $model = new UserTable();
            $add = $model->saveNewUser($request);
            if ($add > 0) {
                DB::commit();
                return 'New User Added Successfully!!!';
            }
        } catch (Exception $exc) {
            DB::rollBack();
            $exc->getMessage();
        }
    }


    //Get All User List
    public function getAllUser()
    {
        $model = new UserTable();
        return $model->fetchAllUser();
    }

    //Get All User List
    public function getAllActiveUser()
    {
        $model = new UserTable();
        return $model->fetchAllActiveUser();
	}

	public function getUserLoginHistory($params)
	{
		$model = new UserLoginHistoryTable();
        return $model->fetchUserLoginHistory($params);
	}
	//Get Particular User Details
	public function getUserById($id)
	{
		
		$model = new UserTable();
        return $model->fetchUserById($id);
	}

	public function getUserByEmail($email)
	{
		
		$model = new UserTable();
        return $model->fetchUserByEmail($email);
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
				return 'User Updated Successfully';
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
        return $model->validateLogin($params);
	}

	public function loggedInHistory($data,$status)
	{
		$model = new UserLoginHistoryTable();
        return $model->loggedInHistory($data,$status);
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
				return 'User Updated Successfully';
			}
		}
		catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	public function getAllActivity($params)
    {
		$model = new TrackTable();			
        return $model->fetchAllActivity($params);
	}

	//Get All ActivityById
	public function getAllActivityById($id)
    {
		$model = new TrackTable();
        return $model->fetchAllActivityById($id);
	}

	//Update Particular User Details
	public function resetForgotPassword($email,$newpassword)
    {
    	DB::beginTransaction();
    	try {
			$model = new UserTable();
        	$change = $model->resetForgotPassword($email,$newpassword);
			if($change>0){
                DB::commit();
				return 1;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
}

?>