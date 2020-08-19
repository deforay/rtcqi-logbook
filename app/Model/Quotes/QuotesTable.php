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
    public function fetchAllQuotes($params)
    {
        $req = $params->all();
        // print_r($req);die;
        if(session('loginType')=='users'){
            $query = DB::table('quotes')
                ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
                ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                // ->where('quotes.approve_status', '=', 'no')
                ->where('quotes.quotes_status', '!=', 'pending')
                ->orderBy('quotes.responded_on', 'desc')
                ->orderBy('rfq.rfq_issued_on', 'desc')
                ;
                if(isset($req['rfqId']) && $req['rfqId'])
                    $query->where('quotes.rfq_id', '=', $req['rfqId']);
            }else{
               $userId=session('userId');
                $query = DB::table('quotes')
                    ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
                    ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                    ->where('quotes.vendor_id', '=', $userId)
                    ->where('quotes.quotes_status', '!=', 'pending')
                    ->orderBy('quotes.responded_on', 'desc')
                    ->orderBy('rfq.rfq_issued_on', 'desc');
                    // ->where('quotes.approve_status', '=', 'yes')
                    
            }
            $data = $query->get();
        return $data;
    }

        // Fetch Active All Quotes List
        public function fetchAllActiveQuotes()
        {
            // $req = $params->all();
            // print_r($req);die;
            if(session('loginType')=='users'){
                $query = DB::table('quotes')
                ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
                ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                ->where('quotes.approve_status', '=', 'no')
                ->where('quotes.quotes_status', '=', 'active');
                // if(isset($req['rfqId']) && $req['rfqId'])
                //     $query->where('quotes.rfq_id', '=', $req['rfqId']);
            }else{
                $userId=session('userId');
                $query = DB::table('quotes')
                    ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
                    ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                    ->where('quotes.vendor_id', '=', $userId)
                    ->where('quotes.quotes_status', '=', 'active');
                    // ->where('quotes.approve_status', '=', 'yes')
                    
            }
                $data = $query->get();
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
            ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'quote_details.uom')
            ->join('items', 'items.item_id', '=', 'quote_details.item_id')
            ->where('quote_details.quote_id', '=', $id)->get();
        return $data;
    }

    // Update particular Quotes  details
    public function updateQuotes($params, $id)
    {
        $id = base64_decode($id);
        $commonservice = new CommonService();
        $data = $params->all();
        // dd($data);
        if ($params->input('quoteNumber') != null && trim($params->input('quoteNumber')) != '') {
            
            for($i=0;$i<count($data['quoteQty']);$i++){
                $quoteDetailsData = array(
                    'quantity'=>$data['quoteQty'][$i],
                    'unit_price'=>$data['unitPrice'][$i],
                    'description'=>$data['quoteDesc'][$i],
                    'updated_on' => $commonservice->getDateTime(),
                );
                
                $ordUp = DB::table('quote_details') ->where('qd_id','=', $data['qdId'][$i])
                ->update($quoteDetailsData);
            }
            $response = DB::table('quotes')
            ->where('quote_id', '=', $id)
            ->update(
                [
                    'quote_number' => $data['quoteNumber'],
                    'quote_description' => $data['description'],
                    'quotes_status' => 'responded',
                    'responded_on' => $commonservice->getDateTime(),
                    'stock_available' => $data['stockable'],
                    'eta_if_no_stock' => $data['notInStock'],
                    'vendor_notes' => $data['vendorNotes'],
                    'mode_of_delivery' => $data['deliveryMode'],
                    'estimated_date_of_delivery' => $commonservice->dateFormat($data['estimatedDate']),
                ]
            );

            $filePathName='';
            $fileName='';
            $extension='';
            if(isset($data['uploadFile'])){

                for($i=0;$i<count($data['uploadFile']);$i++)
                {
        
                    if (isset($_FILES['uploadFile']['name'][$i]) && $_FILES['uploadFile']['name'][$i] != '') {
                        if (!file_exists(public_path('uploads')) && !is_dir(public_path('uploads'))) {
                            mkdir(public_path('uploads'),0755,true);
                            // chmod (getcwd() .public_path('uploads'), 0755 );
                        }
                        
                        if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes")) {
                            mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes", 0755);
                        }
            
                        $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "quotes" . DIRECTORY_SEPARATOR . $id;
                        
                        if (!file_exists($pathname) && !is_dir($pathname)) {
                            mkdir($pathname);
                        }
                        // print_r($_FILES['uploadFile']['name'][$i]);die;
                        $extension = strtolower(pathinfo($pathname . DIRECTORY_SEPARATOR . $_FILES['uploadFile']['name'][$i], PATHINFO_EXTENSION));
                        $ext = '.'.$extension;
                        $orgFileName = explode($ext,$_FILES['uploadFile']['name'][$i])[0];
                        $fileName = $orgFileName.'@@'.time(). "." . $extension;
                        // print_r($fileName);die;

                        $filePath = $pathname . DIRECTORY_SEPARATOR .$fileName;
                        
                        move_uploaded_file($_FILES["uploadFile"]["tmp_name"][$i], $pathname . DIRECTORY_SEPARATOR .$fileName);
                        $filePathName .=$filePath.','; 
                    }
                }
                if($filePathName!=''){
        
                    $uploadData = array('quotes_upload_file' => $filePathName);
                    $quotesUp = DB::table('quotes')
                            ->where('quote_id', '=', $id)
                            ->update(
                                $uploadData
                            );
                }
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Quote-update', 'Update Quote ' . $data['quoteNumber'], 'Item');
        }
        
        $data = DB::table('rfq')
        ->join('quotes', 'quotes.rfq_id', '=', 'rfq.rfq_id')
        ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
        ->where('quotes.quote_id', '=', $id)
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
            $mainContent = array('##VENDOR-NAME##', '##QUOTES-NUMBER##');
            $mainReplace = array($vendorName, $quoteNumber);
            $mailContent = trim($mailData[0]->mail_content);
            $message = str_replace($mainContent, $mainReplace, $mailContent);
            // $message = str_replace("&nbsp;", "", strval($message));
            $message = str_replace("&amp;nbsp;", "", strval($message));
            $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
            $createdon = date('Y-m-d H:i:s');
            // dd($message);
            $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "quotes" . DIRECTORY_SEPARATOR . $id;
            if(file_exists($pathname)){
                $scan = scandir($pathname,1);
                $scannedDirectory = array_diff($scan, array('..', '.'));
                foreach($scannedDirectory as $sc=>$value){
                    $scanDir[$sc] = $pathname.'/'.$value;
                }
                $attachment = implode(',',$scanDir);
            }
            else{
                $attachment = '' ;
            }
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
                    'customer_name' => $vendorName,
                    'attachment' => $attachment,
                ]);
        }
        return $response;
    }

    public function fetchAllDashboardDetails(){
        $count = array();
        if(session('loginType')=='users'){
            $vendorsCount = DB::table('quotes')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->distinct('quotes.vendor_id')
            ->count('quotes.vendor_id');
            $count['vendorsCount'] = $vendorsCount;

            $quotesCount = DB::table('quotes')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->where('quotes.approve_status', '=', 'no')
            ->where('quotes.quotes_status', '=', 'active')
            ->distinct('quotes.quote_id')
            ->count('quotes.quote_id');
            $count['quotesCount'] = $quotesCount;

            $rfqCount = DB::table('rfq')
            ->where('rfq.rfq_status', '=', 'active')
            ->distinct('rfq.rfq_id')
            ->count('rfq.rfq_id');
            $count['rfqCount'] = $rfqCount;

            $poCount = DB::table('purchase_orders')
            ->where('purchase_orders.order_status', '=', 'active')
            ->distinct('purchase_orders.po_id')
            ->count('purchase_orders.po_id');
            $count['poCount'] = $poCount;

        }else{
            $userId=session('userId');
          
            $quotesCount = DB::table('quotes')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->where('quotes.approve_status', '=', 'no')
            ->where('quotes.quotes_status', '=', 'active')
            ->where('quotes.vendor_id', '=', $userId)
            ->distinct('quotes.quote_id')
            ->count('quotes.quote_id');
            $count['quotesCount'] = $quotesCount;

            $rfqCount = DB::table('rfq')
            ->join('quotes', 'quotes.rfq_id', '=', 'rfq.rfq_id')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->where('rfq.rfq_status', '=', 'active')
            ->where('quotes.vendor_id', '=', $userId)
            ->distinct('rfq.rfq_id')
            ->count('rfq.rfq_id');
            $count['rfqCount'] = $rfqCount;

            $poCount = DB::table('purchase_orders')
            ->join('vendors', 'vendors.vendor_id', '=', 'purchase_orders.vendor')
            ->where('purchase_orders.order_status', '=', 'active')
            ->where('purchase_orders.vendor', '=', $userId)
            ->distinct('purchase_orders.po_id')
            ->count('purchase_orders.po_id');
            $count['poCount'] = $poCount;
        }
        
        // dd($count);
        return $count;
    }
}
