<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\CommonService;
use DB;
use Mail;

class SendNonConformityMailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendnonconformitymail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Non Conformity Mail';

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
                $tempMail = DB::table('inventory_stock')
                ->join('branches', 'branches.branch_id', '=', 'inventory_stock.branch_id')
                ->join('items', 'items.item_id', '=', 'inventory_stock.item_id')
                ->join('delivery_schedule', 'delivery_schedule.delivery_id', '=', 'inventory_stock.delivery_id')
                ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'inventory_stock.pod_id')
                ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
                ->select('vendors.email AS vendor_email','vendors.vendor_name','inventory_stock.updated_on AS reported_on','branches.email AS branch_email','branches.branch_name','purchase_orders.po_number','purchase_orders.po_issued_on','purchase_order_details.*','vendors.vendor_name','inventory_stock.*','delivery_schedule.*','items.*')
                ->where('delivery_schedule.delivery_schedule_status','=', 'Non Conformity')
                ->where('inventory_stock.branch_id','=', $loc->branch_id)
                ->get();
                $tempMail = $tempMail->toArray();
                // dd($tempMail);
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
                                            <th><strong>Item Name</strong></th>
                                            <th><strong>Quantity Ordered</strong></th>
                                            <th><strong>Non Conformity<br/>Quantity</strong></th>
                                            <th><strong>Location</strong></th>
                                            <th><strong>Reason for Non Conformity</strong></th>
                                            <th><strong>Scheduled <br/>Delivery Date</strong></th>
                                            <th><strong>Reported On</strong></th>
                                            <th><strong>Received On</strong></th>
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
                        if($mail->received_date){
                            $received_date = $commonservice->humanDateFormat($mail->received_date);
                        }
                        else{
                            $received_date = '';
                        }
                        if($mail->reported_on){
                            $reported_on = date("d-M-Y",strtotime($mail->reported_on));
                        }
                        else{
                            $reported_on = '';
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
                        if($mail->item_code){
                            $itemName = $mail->item_name.'('.$mail->item_code .')';
                        }
                        else{
                            $itemName = $mail->item_name;
                        }
                        $mailItemDetails .= '<tr>
                                            <td>'.$mail->po_number.'</td>
                                            <td>'.$po_issued_on.'</td>
                                            <td>'.$itemName.'</td>
                                            <td style="text-align:right;">'.$mail->quantity.'</td>
                                            <td style="text-align:right;">'.$mail->delivery_qty.'</td>
                                            <td>'.$mail->branch_name.'</td>
                                            <td>'.$mail->non_conformity_comments.'</td>
                                            <td>'.$expected_date_of_delivery.'</td>
                                            <td>'.$reported_on.'</td>
                                            <td>'.$received_date.'</td>
                                        </tr>';
                    }
                    $mailItemDetails .= '</tbody></table>';
                    $mailData = DB::table('mail_template')
                        ->where('mail_temp_id', '=', 8)
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
                        $mainContent = array( '##ITEM-DETAILS##');
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
