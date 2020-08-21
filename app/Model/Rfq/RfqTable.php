<?php

namespace App\Model\Rfq;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\RfqService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class RfqTable extends Model
{
    //add Rfq
    public function saveRfq($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($_FILES['uploadFile']['name']);
        // dd($data);
        $filePath = '';
        $fileName = '';
        $issuedOn = '';
        if ($request->input('rfqNumber')!=null && trim($request->input('rfqNumber')) != '') {
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $lastDate = $commonservice->dateFormat($data['lastdate']);
            $id = DB::table('rfq')->insertGetId(
                ['rfq_number' => $data['rfqNumber'],
                'rfq_issued_on' => $issuedOn,
                'last_date' => $lastDate,
                'description' => $data['description'],
                'rfq_status' => 'draft',
                'created_by' => session('userId'),
                'created_on' => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'RFQ-add', 'Add Rfq '.$data['rfqNumber'], 'Rfq');
        }
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
                    
                    if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "rfq") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "rfq")) {
                        mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "rfq", 0755);
                    }
        
                    $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "rfq" . DIRECTORY_SEPARATOR . $id;
                    
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
    
                $uploadData = array('rfq_upload_file' => $filePathName);
                $rfqUp = DB::table('rfq')
                        ->where('rfq_id', '=', $id)
                        ->update(
                            $uploadData
                        );
            }
        }
        
        if ($request->input('vendors')!=null) {
            for($k=0;$k<count($data['vendors']);$k++){
                 $quotes = DB::table('quotes')->insertGetId(
                        [
                        'rfq_id' => $id,
                        'vendor_id' => $data['vendors'][$k],
                        'stock_available' => 'yes',
                        'invited_on' =>  $issuedOn
                        ]
                    );
                if ($request->input('item')!=null) {
                    for($j=0;$j<count($data['item']);$j++){
                        $quotesDetails = DB::table('quote_details')->insertGetId(
                            [
                            'quote_id' => $quotes,
                            'item_id' => $data['item'][$j],
                            'uom' => $data['unitId'][$j],
                            'quantity' => $data['qty'][$j],
                            'description' => $data['rfqDesc'][$j],
                            ]
                        );
                    }
                }
                // if (file_exists($filePath)) {
                //     if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes")) {
                //         mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes", 0755);
                //     }
        
                //     $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "quotes" . DIRECTORY_SEPARATOR . $quotes;
                    
                //     if (!file_exists($pathname) && !is_dir($pathname)) {
                //         mkdir($pathname);
                //     }
                    
                //     $quotesFilePath = $pathname . DIRECTORY_SEPARATOR .$fileName;
                //     if (copy($filePath, $quotesFilePath)) {
                //         $uploadData = array('quotes_upload_file' => $quotesFilePath);
                //         $quotesUp = DB::table('quotes')
                //                 ->where('quote_id', '=', $quotes)
                //                 ->update(
                //                     $uploadData
                //                 );
                //     }
                // }
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'quotes-add', 'add quotes '.$id, 'quotes');
        }

        if ($request->input('item')!=null) {
            for($j=0;$j<count($data['item']);$j++){
                $rfqDetails = DB::table('rfq_details')->insertGetId(
                                [
                                'rfq_id' => $id,
                                'item_id' => $data['item'][$j],
                                'uom' => $data['unitId'][$j],
                                'quantity' => $data['qty'][$j],
                                'item_description' => $data['rfqDesc'][$j],
                                ]
                            );
            }
        }
        return $id;
    }

    // Fetch All Rfq List
    public function fetchAllRfq()
    {
        $userId=session('userId');
        if(session('loginType')=='users'){
            $data = DB::table('rfq')
                    ->orderBy('rfq_issued_on', 'desc')
                    ->get();
        }
        else{
            $data = DB::table('rfq')
                ->join('quotes', 'quotes.rfq_id', '=', 'rfq.rfq_id')
                ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                ->where('quotes.vendor_id', '=', $userId)
                ->orderBy('rfq.rfq_issued_on', 'desc')
                ->get();
        }
        
        return $data;
    }

    // Fetch All rfq List
    public function fetchAllActiveRfq()
    {
        $userId=session('userId');
        if(session('loginType')=='users'){
            $data = DB::table('rfq')
                ->where('rfq_status','=','active')
                ->orderBy('rfq_issued_on', 'desc')
                ->get();
        }
        else{
            $data = DB::table('rfq')
                ->join('quotes', 'quotes.rfq_id', '=', 'rfq.rfq_id')
                ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                ->where('quotes.vendor_id', '=', $userId)
                ->where('rfq.rfq_status','=','active')
                ->orderBy('rfq.rfq_issued_on', 'desc')
                ->get();
        }
        return $data;
    }

    // fetch particular rfq details(edit)
    public function fetchRfqById($id)
    {
        $id = base64_decode($id);
        // dd($id);
        $data['rfq'] = DB::table('rfq')
                        ->join('rfq_details', 'rfq_details.rfq_id', '=', 'rfq.rfq_id')
                        ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'rfq_details.uom')
                        ->where('rfq.rfq_id', '=', $id)->get();

        $data['quotes'] = DB::table('quotes')
                            ->join('quote_details', 'quote_details.quote_id', '=', 'quotes.quote_id')
                            ->where('quotes.rfq_id', '=', $id)->get();
        return $data;
    }

    // Update particular rfq details
    public function updateRfq($params, $id)
    {
        $id = base64_decode($id);
        $response = 0;
        $data = $params->all();
        // dd($data);
        $commonservice = new CommonService();
        if(isset($data['vendorDetail']) && ($data['vendorDetail']!=null) && trim($data['vendorDetail'])!=''){

            $delVen = explode(",",$data['vendorDetail']);
            if(isset($data['vendors']) && ($data['vendors']!=null)){
                $diffVendor = array_diff($delVen, $data['vendors']);
            }
            else{
                $diffVendor = $delVen;
            }
           
            foreach($diffVendor as $key=>$value){
                $quoteDeleteId = DB::table('quotes')
                                ->where('quotes.vendor_id', '=', $value)
                                ->where('quotes.rfq_id', '=', $id)->select('quote_id')->get();

                if($quoteDeleteId){
                    $delQuoteByVendor = DB::table('quotes')
                                        ->where('quotes.vendor_id', '=', $value)
                                        ->where('quotes.rfq_id', '=', $id)->delete();
                    $delQuoteDetailByVendor = DB::table('quote_details')
                                ->where('quote_id', '=', $quoteDeleteId[0]->quote_id)->delete();
                }
            }

        }
        $quoteId = DB::table('quotes')
                    ->where('quotes.rfq_id', '=', $id)->select('quote_id')->get();
        if(isset($data['deleteRfqDetail']) && ($data['deleteRfqDetail']!=null) && trim($data['deleteRfqDetail'])!=''){
                        // dd($quoteId);
            $delRfq = explode(",",$data['deleteRfqDetail']);
            // dd($delRfq);
            for($s = 0;$s<count($delRfq);$s++){
                $itemDetails = DB::table('rfq_details')
                                ->where('rfq_details.rfqd_id', '=', $delRfq[$s])
                                ->where('rfq_details.rfq_id', '=', $id)->get();
                                // dd($itemDetails);
                $delRfqItem = DB::table('rfq_details')
                                ->where('rfq_details.rfqd_id', '=', $delRfq[$s])
                                ->where('rfq_details.rfq_id', '=', $id)->delete();
                
                for($q=0;$q<count($quoteId);$q++){
                    if($itemDetails && $quoteId){
                        $delQuoteItem = DB::table('quote_details')
                                            ->where('quote_details.quote_id', '=', $quoteId[$q]->quote_id)
                                            ->where('quote_details.item_id', '=', $itemDetails[0]->item_id)->delete();
                    }
                }
            }
        }
        if ($params->input('rfqNumber') != null && trim($params->input('rfqNumber')) != '') {
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $lastDate = $commonservice->dateFormat($data['lastdate']);
            $rfq = array(
                'rfq_number' => $data['rfqNumber'],
                'description' => $data['description'],
                'rfq_issued_on' => $issuedOn,
                'last_date' => $lastDate,
                'rfq_status' => 'draft',
                'updated_by' => session('userId'),
                'updated_on' => $commonservice->getDateTime(),
            );
           
            $rfqUp = DB::table('rfq')
                    ->where('rfq_id', '=', $id)
                    ->update(
                        $rfq
                    );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'RFQ-update', 'Update Rfq ' . $data['rfqNumber'], 'Rfq');
        }

        // rfq detail
        for($i=0;$i<count($data['item']);$i++){
            $rfqItemDetails = array(
                                'rfq_id' => $id,
                                'item_id' => $data['item'][$i],
                                'uom' => $data['unitId'][$i],
                                'quantity' => $data['qty'][$i],
                                'item_description' => $data['rfqDesc'][$i],
                            );

            if(isset($data['rdId'][$i]) && $data['rdId'][$i]!=''){
                $rfqItemUp = DB::table('rfq_details') ->where('rfqd_id','=', $data['rdId'][$i])
                        ->update($rfqItemDetails);
            }else{
                $rfqItemIns = DB::table('rfq_details')->insert($rfqItemDetails);
            }
        }

        //quotes and quotes detail
        if(isset($data['vendors']) && ($data['vendors']!=null)){
            for($f=0;$f<count($data['vendors']);$f++){
                $result = DB::table('quotes')
                            ->where('quotes.vendor_id', '=', $data['vendors'][$f])
                            ->where('quotes.rfq_id', '=', $id)->get();
                $quotes = array(
                    'rfq_id' => $id,
                    'vendor_id' => $data['vendors'][$f],
                );
                if(count($result)>0){
                    for($i=0;$i<count($data['item']);$i++){
                        $quoteItemDetails = array(
                            'quote_id' => $result[0]->quote_id,
                            'item_id' => $data['item'][$i],
                            'uom' => $data['unitId'][$i],
                            'quantity' => $data['qty'][$i],
                            'description' => $data['rfqDesc'][$i],
                        );
                        if(isset($data['rdId'][$i]) && $data['rdId'][$i]!=''){
                            $itemDetails = DB::table('rfq_details')
                                            ->where('rfq_details.rfqd_id', '=', $data['rdId'][$i])
                                            ->where('rfq_details.rfq_id', '=', $id)->get();
            
                            if($itemDetails && $result[0]->quote_id){
                                $quoteItemUp = DB::table('quote_details')
                                                ->where('quote_details.quote_id', '=', $result[0]->quote_id)
                                                ->where('quote_details.item_id', '=', $itemDetails[0]->item_id)
                                                ->update($quoteItemDetails);
                            }
                        }else{
                            $quotesItemIns = DB::table('quote_details')->insert($quoteItemDetails);
                        }
                    }
                }
                else{
                    $quotesIns = DB::table('quotes')->insertGetId(
                                    [
                                    'rfq_id' => $id,
                                    'vendor_id' => $data['vendors'][$f],
                                    ]
                                );
                    if ($params->input('item')!=null) {
                        for($j=0;$j<count($data['item']);$j++){
                            $quotesDetails = DB::table('quote_details')->insertGetId(
                                [
                                'quote_id' => $quotesIns,
                                'item_id' => $data['item'][$j],
                                'uom' => $data['unitId'][$j],
                                'quantity' => $data['qty'][$j],
                                ]
                            );
                        }
                    }
                    $commonservice = new CommonService();
                    $commonservice->eventLog(session('userId'), $id, 'Quotes-update', 'Update Quotes ' . $id, 'Quotes');
                }
                
            }
        }
        if ($rfqUp || $delQuoteItem || $delRfqItem || $quotesDetails || $quotesIns || $quoteItemUp || $quotesItemIns || $rfqItemUp || $rfqItemIns) {
            $response = 1;
        }
        return $response;
    }

    public function changeQuotesStatus($request)
    {

        $tableName = $request['tableName'];
        $fieldIdName = $request['fieldIdName'];
        $fieldIdValue = $request['fieldIdValue'];
        $fieldName = $request['fieldName'];
        $fieldValue = $request['fieldValue'];
        
        $data = DB::table('rfq')
        ->join('quotes', 'quotes.rfq_id', '=', 'rfq.rfq_id')
        ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
        ->where('rfq.rfq_id', '=', $fieldIdValue)
        ->get();
        
        $rfqdata = DB::table('rfq')
        ->where('rfq_id', '=', $fieldIdValue)
        ->get();
      
        $rfqNumber=$data[0]->rfq_number;
        $vendorName=$data[0]->vendor_name;
        $email=$data[0]->email;
        $rfqdescription=$rfqdata[0]->description;
        $uploadfile=$data[0]->rfq_upload_file;


        try {
            if ($fieldValue != "") {
                $updateData = array($fieldName => $fieldValue);
                $updateQuotesData = array('quotes_status' => $fieldValue);
                DB::table($tableName)
                    ->where($fieldIdName, '=', $fieldIdValue)
                    // ->where('approve_status', '=', 'no')
                    ->update($updateData);
                DB::table('quotes')
                    ->where('rfq_id', '=', $fieldIdValue)
                    ->where('approve_status', '=', 'no')
                    ->update($updateQuotesData);
                //Event Log
                $commonservice = new CommonService();
                $commonservice->eventLog(session('userId'), $fieldIdValue, $tableName . '-' . $fieldValue, $tableName . ' changed to ' . $fieldValue, $tableName);

              //added in mail queue
                $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "rfq" . DIRECTORY_SEPARATOR . $fieldIdValue;
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
                // dd($attachment);
                
                $mailData = DB::table('mail_template')
                ->where('mail_temp_id', '=', 1)
                ->get();
                if(count($mailData)>0)
                {
                    $mailSubject = trim($mailData[0]->mail_subject);
                    $subject = $mailSubject;
                    $subject = str_replace("&nbsp;", "", strval($subject));
                    $subject = str_replace("&amp;nbsp;", "", strval($subject));
                    $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
                    $mainContent = array('##VENDOR-NAME##', '##RFQ-NUMBER##');
                    $mainReplace = array($vendorName, $rfqNumber);
                    $mailContent = trim($mailData[0]->mail_content);
                    $message = str_replace($mainContent, $mainReplace, $mailContent);
                    $message = str_replace("&nbsp;", "", strval($message));
                    $message = str_replace("&amp;nbsp;", "", strval($message));
                    $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
                    $createdon = date('Y-m-d H:i:s');
                    $response = DB::table('temp_mail')
                    ->insertGetId(
                        [
                            'from_mail' => $mailData[0]->mail_from,
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
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $fieldIdValue;
    }
}
