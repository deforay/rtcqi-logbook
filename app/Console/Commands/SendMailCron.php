<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;

class SendMailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        
        $tempMail = DB::table('temp_mail')
                    ->where('status','=', 'pending')
                    ->get();
        $tempMail = $tempMail->toArray();
        // print_r($tempMail);die;
        $msg = array();
        if (count($tempMail) > 0) {
            $mailData = array('status'=>'notsend');
            $updateTempMail = DB::table('temp_mail')->where('status','=', 'pending')
                                ->update($mailData);
            foreach($tempMail as $mail){
                
                // dd($toEmail);
                $msg['msg'] =  $mail->message;
                Mail::send('mailtemplate.email', $msg, function ($message) use ($mail) {
                    $toEmail = explode(',',$mail->to_email);
                    $send = $message->to($toEmail, $mail->from_full_name)
                                    ->subject($mail->subject);
                            if($mail->cc){
                                $send->cc($mail->cc);
                            }
                            if($mail->bcc){
                                $send->cc($mail->bcc);
                            }
                            if($mail->attachment){
                                // print_r($mail->attachment);
                                $files = explode(',',$mail->attachment);
                                for($k=0;$k<count($files);$k++){
                                    $attach = explode('/',$files[$k])[8];
                                    $attachext = explode('.',$attach);
                                    $attachext = end($attachext);
                                    $attachfile = explode('@@',$attach)[0];
                                    // print_r($attachfile);die;
                                    if($attachfile){
                                        if($attachext){
                                            $attachmentFile = $attachfile.'.'.$attachext;
                                        }
                                        else{
                                            $attachmentFile = $attachfile;
                                        }
                                    }
                                    // print_r($attachmentFile);
                                    $send->attach($files[$k], [
                                        'as' => $attachmentFile, 
                                        // 'mime' => 'application/pdf'
                                    ]);
                                }
                            }
                });

                if (Mail::failures()) {
                    \Log::info('Mail sent failed for - '.$mail->temp_id);
                }
                else {
                    \Log::info('Mail sent successfully - '.$mail->temp_id.'to '.$mail->customer_name);
                    DB::table('temp_mail')->where('temp_id','=', $mail->temp_id)->delete();
                }
            }
            
        } else {
            \Log::info('No pending mails are there in temp_mail ');
        }
    }
}
