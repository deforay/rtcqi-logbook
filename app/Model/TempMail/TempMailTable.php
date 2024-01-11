<?php

namespace App\Model\TempMail;

use Illuminate\Database\Eloquent\Model;
use App\Service\CommonService;
use DB;

class TempMailTable extends Model
{
    protected $table = 'temp_mail';

    public function insertTempMailDetails($to,$subject,$message,$fromMail,$fromName) {
        $commonservice = new CommonService();
        if(trim($to)!=""){
            $id = DB::table('temp_mail')->insertGetId(
                [
                    'message' => $message,
                    'from_mail' => $fromMail,
                    'to_email' => $to,
                    'subject' => $subject,
                    'from_full_name' => $fromName,
                    'created_on' => $commonservice->getDateTime(),
                ]
            );
            return $id;
        }
    }

    public function deleteTempMail($id){
        DB::table('temp_mail')->where('temp_id','=',$id)->delete();
    }

    public function updateTempMailStatus($id,$status){
        $response = DB::table('temp_mail')
                ->where('temp_id', '=', $id)
                ->update(
                    ['status' => $status]
                );
    }
}
