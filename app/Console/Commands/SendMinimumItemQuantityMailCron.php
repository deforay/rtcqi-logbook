<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\CommonService;
use DB;
use Mail;

class SendMinimumItemQuantityMailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendminimumitemquantitymail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Minimum Item Quantity Mail';

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
                ->join('items', 'items.item_id', '=', 'inventory_stock.item_id')
                ->join('branches', 'branches.branch_id', '=', 'inventory_stock.branch_id')
                ->join('brands', 'brands.brand_id', '=', 'items.brand')
                ->join('item_types', 'item_types.item_type_id', '=', 'items.item_type')
                ->select('items.item_code','items.item_name','brands.brand_name','brands.brand_name','items.minimum_quantity','item_types.item_type','inventory_stock.stock_quantity','branches.email AS branch_email','branches.branch_name','inventory_stock.stock_id')
                ->where('inventory_stock.stock_quantity','<=', 'items.minimum_quantity')
                // ->where('inventory_stock.stock_quantity','<=', 'items.minimum_quantity')
                ->where('items.minimum_quantity','!=', null)
                ->where('items.item_status','=', 'active')
                ->where('inventory_stock.branch_id','=', $loc->branch_id)
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
                                            <th><strong>Item Code</strong></th>
                                            <th><strong>Item Name</strong></th>
                                            <th><strong>Brand Name</strong></th>
                                            <th><strong>Item Type</strong></th>
                                            <th><strong>Stock Quantity</strong></th>
                                            <th><strong>Minimum Quantity</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                    foreach($tempMail as $mail){
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
                                            <td>'.$mail->item_code.'</td>
                                            <td>'.$mail->item_name.'</td>
                                            <td>'.$mail->brand_name.'</td>
                                            <td>'.$mail->item_type.'</td>
                                            <td style="text-align:right;">'.$mail->stock_quantity.'</td>
                                            <td style="text-align:right;">'.$mail->minimum_quantity.'</td>
                                        </tr>';
                    }
                    $mailItemDetails .= '</tbody></table>';
                    $mailData = DB::table('mail_template')
                        ->where('mail_temp_id', '=', 10)
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
                        $subject = str_replace("##LOCATION##", $mail->branch_name, strval($subject));
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
                            \Log::info('Mail sent failed for - '.$mail->stock_id);
                        }
                        else {
                            \Log::info('Mail sent successfully - '.$mail->stock_id.'to '.$mail->branch_name);
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
