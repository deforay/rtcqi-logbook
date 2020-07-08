<?php

namespace App\Model\MailTemplate;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;

class MailTemplateTable extends Model
{
    //fetch all mail template
    public function fetchMailTemplate()
    {
        $data = DB::table('mail_template')
                ->get();
        return $data;
    }


    public function addMailTemplate($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        if ($request->input('templateName')!=null && trim($request->input('templateName')) != '') {
            $id = DB::table('mail_template')->insertGetId(
                [ 'mail_purpose' => $data['mailPurpose'],
                'template_name' => $data['templateName'],
                'from_name' => $data['fromName'],
                'mail_from' => $data['fromMail'],
                'mail_cc' => $data['mailCc'],
                'mail_bcc' => $data['mailBcc'],
                'mail_subject' => $data['subject'],
                'mail_content' => $data['mainContent'],
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'mail_template', 'Add mail template '.$data['templateName'], 'User');
        }
        return $id;
    }
    // Update mail template details
    public function updateMailTemplate($params)
    {
        $response = 0;
        $data = $params->all();
        // dd($data);

        if ($params->input('mailTempId')!=null && trim($params->input('mailTempId')) != '') {
            $response = DB::table('mail_template')
                ->where('mail_temp_id', '=',$data['mailTempId'])
                ->update(
                    [
                        'mail_purpose' => $data['mailPurpose'],
                        'template_name' => $data['templateName'],
                        'from_name' => $data['fromName'],
                        'mail_from' => $data['fromMail'],
                        'mail_cc' => $data['mailCc'],
                        'mail_bcc' => $data['mailBcc'],
                        'mail_subject' => $data['subject'],
                        'mail_content' => $data['mainContent'],
                    ]);

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $data['mailTempId'], 'MailTemplate-update', 'Update MailTemplate '.$data['subject'], 'MailTemplate');
        }

        return $response;
    }


        // Fetch All Templates List
 
    public function fetchAllTemplates()
    {
        $data = DB::table('mail_template')
            ->orderBy('template_name', 'asc')
            ->get();
        return $data;
    }

    public function fetchTemplateById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('mail_template')
            ->where('mail_temp_id', '=', $id)->get();
        return $data;
    }
}
