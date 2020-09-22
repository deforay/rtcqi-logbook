<?php
/*
Author             : Sriram V
Date               : 25 June 2020
Description        : Quotes Service Page
Last Modified Date : 
Last Modified Name : 
*/
namespace App\Service;
use App\Model\Quotes\QuotesTable;
use DB;
use Redirect;

class QuotesService
{
   	//Get All Quotes List
	public function getAllQuotes($request)
    {
		$model = new QuotesTable();
        $result = $model->fetchAllQuotes($request);
        return $result;
	}

	//Get All active Quotes List
	public function getAllActiveQuotes()
    {
		$model = new QuotesTable();
        $result = $model->fetchAllActiveQuotes();
        return $result;
	}

	//Get All responded Quotes List
	public function getAllRespondedQuotesNew()
    {
		$model = new QuotesTable();
        $result = $model->fetchAllRespondedQuotes();
        return $result;
	}

	//Get Particular Quotes Details
	public function getQuotesById($id)
	{
		$model = new QuotesTable();
        $result = $model->fetchQuotesById($id);
        return $result;
	}
	//Update Particular Quotes Details
	public function updateQuotes($params,$id)
    {
    	DB::beginTransaction();
    	try {
			$model = new QuotesTable();
        	$add = $model->updateQuotes($params,$id);
			if($add>0){
                DB::commit();
				$msg = 'Quotes  Updated Successfully';
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