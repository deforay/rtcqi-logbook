<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\CommonService;
use DB;
use Mail;

class SendDeliveryDelayMailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'senddeliverydelaymail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Delivery Delay Mail';

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
       
        $branches = DB::table('branches')->get();
        $commonservice = new CommonService();
        // dd($branches);
        $branches = $branches->toArray();
        if (count($branches) > 0) {
            foreach($branches as $loc){
                $ccEmail = '';
                $toEmail = '';
                $mailItemDetails = '';
                $expected_date_of_delivery = '';
                $po_issued_on = '';
                $tempMail = DB::table('delivery_schedule')
                ->join('branches', 'branches.branch_id', '=', 'delivery_schedule.branch_id')
                ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
                ->select('vendors.email AS vendor_email','vendors.vendor_name','branches.email AS branch_email','branches.branch_name','purchase_orders.po_number','purchase_orders.po_issued_on','purchase_order_details.*','vendors.vendor_name','delivery_schedule.*','items.*')
                ->where('delivery_schedule.expected_date_of_delivery','<', DB::raw('CURDATE()'))
                ->where('delivery_schedule.delivery_schedule_status','=', 'pending for shipping')
                ->where('delivery_schedule.branch_id','=', $loc->branch_id)
                ->get();
                $tempMail = $tempMail->toArray();
                $global = DB::table('global_config')
                            ->where('global_config.global_name', '=', 'email')
                            ->select('global_value')
                            ->get();
                $adminMail = $global[0]->global_value;
                $toEmail = $adminMail;
                $msg = array();

                if (count($tempMail) > 0) {
                    $mailItemDetails .= '<table border="1" style="width:100%; border-collapse: collapse;">
                                        <thead>
                                        <tr>
                                            <th><strong>PO Number</strong></th>
                                            <th><strong>PO Date</strong></th>
                                            <th><strong>Vendor Name</strong></th>
                                            <th><strong>Item</strong></th>
                                            <th><strong>Quantity</strong></th>
                                            <th><strong>Delivery<br/>Date</strong></th>
                                            <th><strong>Delivery<br/>Quantity</strong></th>
                                            <th><strong>Delivery<br/>Mode</strong></th>
                                            <th><strong>Location</strong></th>
                                            <th><strong>Comments</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                    foreach($tempMail as $mail){
                        // print_r($mail);die;
                        if($mail->expected_date_of_delivery){
                            $expected_date_of_delivery = $commonservice->humanDateFormat($mail->expected_date_of_delivery);
                        }
                        else{
                            $expected_date_of_delivery = '';
                        }
                        if($mail->po_issued_on){
                            $po_issued_on = $commonservice->humanDateFormat($mail->po_issued_on);
                        }
                        if($toEmail){
                            if($mail->branch_email){
                                $toEmail = $toEmail.','.$mail->branch_email;
                            }
                        }
                        else{
                            if($mail->branch_email){
                                $toEmail = $mail->branch_email;
                            }
                        }
                        $mailItemDetails .= '<tr>
                                            <td>'.$mail->po_number.'</td>
                                            <td>'.$po_issued_on.'</td>
                                            <td>'.$mail->vendor_name.'</td>
                                            <td>'.$mail->item_name.'</td>
                                            <td style="text-align:right;">'.$mail->quantity.'</td>
                                            <td>'.$expected_date_of_delivery.'</td>
                                            <td style="text-align:right;">'.$mail->delivery_qty.'</td>
                                            <td>'.$mail->delivery_mode.'</td>
                                            <td>'.$mail->branch_name.'</td>
                                            <td>'.$mail->comments.'</td>
                                        </tr>';
                    }
                    $mailItemDetails .= '</tbody></table>';
                    $mailData = DB::table('mail_template')
                        ->where('mail_temp_id', '=', 7)
                        ->get();
                    // dd($mailData);
                    if(count($mailData)>0)
                    {
                        if($mailData[0]->mail_cc){
                            if($adminMail){
                                $ccEmail = $adminMail.','.$mailData[0]->mail_cc;
                            }
                            else{
                                $ccEmail = $mailData[0]->mail_cc;
                            }
                        }
                        else{
                            $ccEmail = $adminMail;
                        }
                        $mailSubject = trim($mailData[0]->mail_subject);
                        $subject = $mailSubject;
                        $subject = str_replace("&nbsp;", "", strval($subject));
                        $subject = str_replace("&amp;nbsp;", "", strval($subject));
                        $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
                        $mainContent = array( '##DELIVERY-DETAILS##');
                        $mainReplace = array( $mailItemDetails);
                        $mailContent = trim($mailData[0]->mail_content);
                        $message = str_replace($mainContent, $mainReplace, $mailContent);
                        // $message = str_replace("&nbsp;", "", strval($message));
                        $message = str_replace("&amp;nbsp;", "", strval($message));
                        $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');

                        $msg['msg'] =  $message;
                        $msg['toEmail'] = $toEmail;
                        $msg['from_full_name'] = $mailData[0]->from_name;
                        $msg['subject'] = $subject;
                        $msg['ccEmail'] = $ccEmail;
                        Mail::send('mailtemplate.email', $msg, function ($message) use ($msg) {
                            $toEmail = explode(',',$msg['toEmail']);
                            $ccMail = explode(',',$msg['ccEmail']);
                            $send = $message->to($toEmail,$msg['from_full_name'] )
                                            ->subject($msg['subject']);
                                    if($ccMail){
                                        $send->cc($ccMail);
                                    }
                        });

                        if (Mail::failures()) {
                            \Log::info('Mail sent failed for - '.$mail->delivery_id);
                        }
                        else {
                            \Log::info('Mail sent successfully - '.$mail->delivery_id.'to '.$mail->branch_name);
                        }
                    }

                    // print_r($mailItemDetails);die;
                } else {
                    \Log::info('No pending mails are there in temp_mail ');
                }
            }
        }
        
    }
}
