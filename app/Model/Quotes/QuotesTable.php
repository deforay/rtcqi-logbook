<?php
/*
Author             : Sriram V
Date               : 25 June 2020
Description        : Quotes Table Page
Last Modified Date : 
Last Modified Name : 
*/

namespace App\Model\Quotes;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\QuotesService;
use App\Service\CommonService;
use Session;

class QuotesTable extends Model
{
    protected $table = 'quotes';

    // Fetch All Quotes List
    public function fetchAllQuotes()
    {
        if(session('loginType')=='users'){
            $data = DB::table('quotes')
                ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
                ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                ->where('quotes.approve_status', '=', 'no')
                ->where('quotes.quotes_status', '!=', 'pending')
                ->get();
            }else{
               $userId=session('userId');
                $data = DB::table('quotes')
                    ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
                    ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                    ->where('quotes.vendor_id', '=', $userId)
                    ->where('quotes.quotes_status', '!=', 'pending')
                    // ->where('quotes.approve_status', '=', 'yes')
                    ->get();
            }
        return $data;
    }

    // fetch particular Quotes  details
    public function fetchQuotesById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quotes')
            ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->where('quote_id', '=', $id)->get();
        $data['quotesdetails'] =  DB::table('quote_details')
            ->join('quotes', 'quotes.quote_id', '=', 'quote_details.quote_id')
            ->join('items', 'items.item_id', '=', 'quote_details.item_id')
            ->where('quote_details.quote_id', '=', $id)->get();
        return $data;
    }

    // Update particular Quotes  details
    public function updateQuotes($params, $id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('quoteNumber') != null && trim($params->input('quoteNumber')) != '') {
            
            for($i=0;$i<count($data['quoteQty']);$i++){
                $quoteDetailsData = array(
                    'quantity'=>$data['quoteQty'][$i],
                    'unit_price'=>$data['unitPrice'][$i],
                    'updated_on' => $commonservice->getDateTime(),
                );
                
                $ordUp = DB::table('quote_details') ->where('qd_id','=', $data['qdId'][$i])
                ->update($quoteDetailsData);
            }
            
            $response = DB::table('quotes')
            ->where('quote_id', '=', base64_decode($id))
            ->update(
                [
                    'quote_number' => $data['quoteNumber'],
                        'description' => $data['description'],
                        'quotes_status' => 'responded',
                        'responded_on' => $commonservice->getDateTime(),
                        'stock_available' => $data['stockable'],
                        'eta_if_no_stock' => $data['notInStock'],
                        'vendor_notes' => $data['vendorNotes'],
                        'mode_of_delivery' => $data['deliveryMode'],
                        'estimated_date_of_delivery' => $commonservice->dateFormat($data['estimatedDate']),
                        ]
                    );
                    
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Quote-update', 'Update Quaote ' . $data['quoteNumber'], 'Item');
        }
        
        $data = DB::table('rfq')
        ->join('quotes', 'quotes.rfq_id', '=', 'rfq.rfq_id')
        ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
        ->where('quotes.quote_id', '=', base64_decode($id))
        ->get();
        $rfqNumber=$data[0]->rfq_number;
        $quoteNumber=$data[0]->quote_number;
        $vendorName=$data[0]->vendor_name;
        $email='admin@gmail.com';
        // $email=$data[0]->email;
        
        $mailData = DB::table('mail_template')
        ->where('mail_temp_id', '=', 2)
        ->get();
        if(count($mailData)>0)
        {
            $mailSubject = trim($mailData[0]->mail_subject);
            $subject = $mailSubject;
            $subject = str_replace("&nbsp;", "", strval($subject));
            $subject = str_replace("&amp;nbsp;", "", strval($subject));
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $mainContent = array('##VENDOR-NAME##', '##QUOTES-NUMBAER##');
            $mainReplace = array($vendorName, $quoteNumber);
            $mailContent = trim($mailData[0]->mail_content);
            $message = str_replace($mainContent, $mainReplace, $mailContent);
            $message = str_replace("&nbsp;", "", strval($message));
            $message = str_replace("&amp;nbsp;", "", strval($message));
            $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
            $createdon = date('Y-m-d H:i:s');

            $response = DB::table('temp_mail')
            ->insertGetId(
                [
                    'from_mail' => $data[0]->email,
                    'to_email' => $email,
                    'subject' => $mailData[0]->mail_subject,
                    'cc' => $mailData[0]->mail_cc,
                    'bcc' => $mailData[0]->mail_bcc,
                    'from_full_name' => $mailData[0]->from_name,
                    'status' => 'pending',
                    'datetime' => $createdon,
                    'message' => $message,
                    'customer_name' => $vendorName
                ]);
        }
        return $response;
    }
}
