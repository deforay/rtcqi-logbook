<?php
/*
Author             : Sudarmathi M
Date               : 26 Mar 2020
Description        : Rsc Service Page
Last Modified Date : 26 Mar 2020
Last Modified Name : Sudarmathi M
*/

namespace App\Service;
use App\Model\MailTemplate\MailTemplateTable;
// use App\EventLog\EventLog;
use DB;
use Redirect;

class MailTemplateService
{
    //Get Mail Template
	public function getMailTemplate()
    {
		$mailTemplateModel = new MailTemplateTable();
        $result = $mailTemplateModel->fetchMailTemplate();
        return $result;
	}
	
	   
    public function saveTemplate($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$mailTemplateModel = new MailTemplateTable();
        	$addTemplate = $mailTemplateModel->addMailTemplate($request);
			if($addTemplate>0){
				DB::commit();
				$msg = 'Template Added Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}
    
    //Update Mail Template
	public function updateMailTemplate($params)
    {
    	DB::beginTransaction();
    	try {
			$mailTemplateModel = new MailTemplateTable();
        	$mailTemp = $mailTemplateModel->updateMailTemplate($params);
			if($mailTemp>0){
				DB::commit();
				$msg = 'Mail Template Updated Successfully';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
	}

		//Get Mail Templates Details
		public function getAllTemplates()
		{
			$mailTemplateModel = new MailTemplateTable();
			$result = $mailTemplateModel->fetchAllTemplates();
			return $result;
		}


		public function getTemplateById($id)
		{
			$mailTemplateModel = new MailTemplateTable();
			$result = $mailTemplateModel->fetchTemplateById($id);
			return $result;
		}

		
	
}