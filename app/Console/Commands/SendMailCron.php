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
        $msg = array();
        if (count($tempMail) > 0) {
            $mailData = array('status'=>'notsend');
            $updateTempMail = DB::table('temp_mail')->where('status','=', 'pending')
                                ->update($mailData);
            foreach($tempMail as $mail){
                $msg['msg'] =  $mail->message;
                Mail::send('mailtemplate.email', $msg, function ($message) use ($mail) {
                    $send = $message->to($mail->to_email, $mail->from_full_name)
                                    ->subject($mail->subject);
                            if($mail->cc){
                                $send->cc($mail->cc);
                            }
                            if($mail->bcc){
                                $send->cc($mail->bcc);
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
