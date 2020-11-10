<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\CommonService;
use DB;
use Mail;

class SendQuoteExpiryAlertMailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendquoteexpiryalertmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Quote Expiry Alert Mail';

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
       
        // $branches = DB::table('branches')->get();
        $commonservice = new CommonService();
        // $branches = $branches->toArray();
        // if (count($branches) > 0) {
        //     foreach($branches as $loc){
                $ccEmail = '';
                $toEmail = '';
                $expected_date_of_delivery = '';
                $po_issued_on = '';
                $rfq = DB::table('rfq')->where('rfq_status','=', 'closed')->get();
                // print_r(url('/'));die;
                $url =  url('/');
                foreach($rfq as $rfqs){
                    $mailItemDetails = '';
                    // print_r($rfqs->rfq_id);die;
                    $tempMail = DB::table('rfq')
                    ->join('quotes', 'rfq.rfq_id', '=', 'quotes.rfq_id')
                    ->whereRaw('quotes.quote_expiry_date <= (DATE(NOW()) + INTERVAL 2 DAY)')
                    ->where('quotes.quotes_status','!=', 'closed')
                    ->where('quotes.rfq_id','=', $rfqs->rfq_id)
                    ->get();
                    // print_r($tempMail);
                    $tempMail = $tempMail->toArray();
                    $global = DB::table('global_config')
                                ->where('global_config.global_name', '=', 'email')
                                ->select('global_value')
                                ->get();
                    $adminMail = $global[0]->global_value;
                    $toEmail = $adminMail;
                    $toEmail = 'sudarmathi@deforay.com';
                    $msg = array();
                    if (count($tempMail) > 0) {
                        $cnt = 0;
                        $mailItemDetails .= '<table border="1" style="border-collapse: collapse;width:100%">
                                                <tbody>';
                        foreach($tempMail as $mail){
                            // print_r($mail);die;
                            $cnt++;
                            if($mail->quote_expiry_date){
                                $quote_expiry_date = $commonservice->humanDateFormat($mail->quote_expiry_date);
                            }
                            else{
                                $quote_expiry_date = '';
                            }
                            if($mail->responded_on){
                                $responded_on = $commonservice->humanDateFormat($mail->responded_on);
                            }
                            else{
                                $responded_on = '';
                            }
                            if($mail->rfq_issued_on){
                                $rfq_issued_on = $commonservice->humanDateFormat($mail->rfq_issued_on);
                            }
                            else{
                                $rfq_issued_on = '';
                            }
                            if($mail->rfq_number){
                                $rfq_number = $mail->rfq_number;
                            }
                            else{
                                $rfq_number = '';
                            }
                            
                            $mailItemDetails .= '<tr>
                                                    <td>'.$cnt.'</td>
                                                    <td>Quote number '.$mail->quote_number.' ('.$responded_on.')&nbsp;expiring on&nbsp;'.$quote_expiry_date.'</td>
                                                    <td><a href="'.$url.'/quotes/edit/'.base64_encode($mail->quote_id).'">click here</a></td>
                                                </tr>';
                        }
                        $mailItemDetails .= '</tbody></table>';
                        $mailData = DB::table('mail_template')
                            ->where('mail_temp_id', '=', 10)
                            ->get();
                        // dd($mailItemDetails);
                        if(count($mailData)>0)
                        {
                            // if($mailData[0]->mail_cc){
                            //     if($adminMail){
                            //         $ccEmail = $adminMail.','.$mailData[0]->mail_cc;
                            //     }
                            //     else{
                            //         $ccEmail = $mailData[0]->mail_cc;
                            //     }
                            // }
                            // else{
                            //     $ccEmail = $adminMail;
                            // }
                            $mailSubject = trim($mailData[0]->mail_subject);
                            $subject = $mailSubject;
                            $subject = str_replace("&nbsp;", "", strval($subject));
                            $subject = str_replace("&amp;nbsp;", "", strval($subject));
                            // $subject = str_replace("##LOCATION##", $mail->branch_name, strval($subject));
                            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
                            $mainContent = array( '##QUOTE-EXPIRY-DETAILS##','##RFQ-NUMBER##','##RFQ-DATE##');
                            $mainReplace = array( $mailItemDetails,$rfq_number,$rfq_issued_on);
                            $mailContent = trim($mailData[0]->mail_content);
                            $message = str_replace($mainContent, $mainReplace, $mailContent);
                            // $message = str_replace("&nbsp;", "", strval($message));
                            // $message = str_replace("##RFQ-NUMBER##", $rfq_number, strval($subject));
                            $message = str_replace("&amp;nbsp;", "", strval($message));
                            $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
                            // print_r($message);die;
                            $msg['msg'] =  $message;
                            $msg['toEmail'] = $toEmail;
                            $msg['from_full_name'] = $mailData[0]->from_name;
                            $msg['subject'] = $subject;
                            $msg['ccEmail'] = $ccEmail;
                            Mail::send('mailtemplate.email', $msg, function ($message) use ($msg) {
                                $toEmail = explode(',',$msg['toEmail']);
                                // $ccMail = explode(',',$msg['ccEmail']);
                                $send = $message->to($toEmail,$msg['from_full_name'] )
                                                ->subject($msg['subject']);
                                // if($ccMail){
                                //     $send->cc($ccMail);
                                // }
                            });

                            if (Mail::failures()) {
                                \Log::info('Mail sent failed for - '.$mail->quote_id);
                            }
                            else {
                                \Log::info('Mail sent successfully - '.$mail->quote_id.'to '.$mail->quote_number);
                                // echo "mail send";
                            }
                        }
                       
                    } else {
                        \Log::info('No pending mails are there in temp_mail ');
                    }
                }
        //     }
        // }
        
    }
}
