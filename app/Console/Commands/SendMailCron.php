<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\CommonService;
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
     * @return int
     */
    public function handle()
    {
        $commonservice = new CommonService();
        $tempMail = DB::table('temp_mail')
            ->where('status', '=', 'pending')
            ->offset(0) // Starting position of records
            ->limit(10)
            ->get()->toArray();
    
        if (count($tempMail) > 0) {
            foreach ($tempMail as $mail) {
                // Update mail status
                $commonservice->updateTempMailStatus($mail->temp_id, 'not-sent');
    
                $msg['msg'] =  $mail->message;
                if (isset($mail->to_email) && $mail->to_email != '') {
                    try {
                        Mail::send('email.emailCron', $msg, function ($message) use ($mail) {
                            $toMail = explode(',', $mail->to_email);
                            $message->to($toMail[0], $mail->from_full_name)
                                ->subject($mail->subject);
                            unset($toMail[0]);
                            foreach ($toMail as $cc) {
                                $message->cc(trim($cc));
                            }
                        });
    
                        // If no exception, consider the email sent successfully
                        $commonservice->updateTempMailStatus($mail->temp_id, 'sent');
                        $commonservice->deleteTempMail($mail->temp_id);
                    } catch (\Exception $e) {
                        \Log::error('Mail sent failed for - ' . $mail->temp_id . '. Error: ' . $e->getMessage());
                    }
                }
            }
        }
    }
    
}
