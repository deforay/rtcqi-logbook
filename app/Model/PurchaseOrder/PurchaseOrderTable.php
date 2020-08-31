<?php

namespace App\Model\PurchaseOrder;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\PurchaseOrderService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class PurchaseOrderTable extends Model
{
    //add Purchase Order
    public function savePurchaseOrder($id, $request)
    {
        //to get all request values
        $data = $request->all();
        // dd($data);
        $commonservice = new CommonService();

        $params = array(
            'approve_status' => 'yes',
            'updated_on' => $commonservice->getDateTime(),
            'quotes_status' => 'closed'
        );
        $response = DB::table('quotes')
            ->where('quote_id', '=', base64_decode($id))
            ->update(
                $params
            );

            $rfqdata = DB::table('rfq')
            ->join('quotes', 'quotes.rfq_id', '=', 'rfq.rfq_id')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->where('quotes.quote_id', '=', base64_decode($id))
            ->get();
            // dd($rfqdata[0]);
            $rfqNumber=$rfqdata[0]->rfq_number;
            $rfqId=$rfqdata[0]->rfq_id;
            $quoteNumber=$rfqdata[0]->quote_number;
            $vendorName=$rfqdata[0]->vendor_name;
            $email=$rfqdata[0]->email;
            $rfqdescription=$rfqdata[0]->description;
            $uploadfile=$rfqdata[0]->rfq_upload_file;
            $quoteId = $rfqdata[0]->quote_id;

            if($data['description']!=''){
                $rfqdescription=$data['description'];
            }

        if ($request->input('poNumber') != null && trim($request->input('poNumber')) != '') {
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $lastDelDate = $commonservice->dateFormat($data['lastDeliveryDate']);
            if(isset($data['poNotes']) && $data['poNotes']!=''){
                $poNotes = $data['poNotes'];
            }
            else{
                $poNotes = '';
            }
            $poId = DB::table('purchase_orders')->insertGetId(
                [
                    'po_number'      => $data['poNumber'],
                    'po_issued_on'    => $issuedOn,
                    'vendor'          => $data['vendorId'],
                    'total_amount'    => $data['totalAmount'],
                    'order_status'    => $data['orderStatus'],
                    'payment_status'  => $data['paymentStatus'],
                    'description' => $rfqdescription,
                    'created_by'      => session('userId'),
                    'created_on'      => $commonservice->getDateTime(),
                    'purchase_order_upload_file'      => $uploadfile,
                    'quote_id'         => $quoteId,
                    'last_date_of_delivery' => $lastDelDate,
                    'delivery_location' => $data['deliveryLoc'],
                    'purchase_order_description' => $data['description'],
                    'purchase_order_notes'       => $poNotes,
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $poId, 'Purchaseorder-add', 'Add Purchase Order ' . $data['poNumber'], 'Purchase Order');

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
                        
                        if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders")) {
                            mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders", 0755);
                        }
            
                        $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders" . DIRECTORY_SEPARATOR . $poId;
                        
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
        
                    $uploadData = array('purchase_order_upload_file' => $filePathName);
                    $quotesUp = DB::table('purchase_orders')
                            ->where('po_id', '=', $poId)
                            ->update(
                                $uploadData
                            );
                }
            }
        }

        if ($request->input('item') != null) {
            for ($k = 0; $k < count($data['item']); $k++) {
                $purchaseOrderDetailsId = DB::table('purchase_order_details')->insertGetId(
                    [
                        'po_id'         =>  $poId,
                        'item_id'       => $data['item'][$k],
                        'uom'           => $data['unitId'][$k],
                        'unit_price'    => $data['unitPrice'][$k],
                        'quantity'      => $data['qty'][$k],
                        'description'   =>  $data['quoteDesc'][$k],
                        // 'order_status'      => 'pending',
                        'created_on'    => $commonservice->getDateTime(),
                    ]
                );
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $purchaseOrderDetailsId, 'Purchaseorderdetails-add', 'add Purchase Order Details ' . $purchaseOrderDetailsId, 'Purchase Order Details');
        }

        $paramsRfq = array(
            'rfq_status' => 'closed'
        );
        $responseRfq = DB::table('rfq')
            ->where('rfq_id', '=', $rfqId)
            ->update(
                $paramsRfq
            );


        $mailData = DB::table('mail_template')
        ->where('mail_temp_id', '=', 3)
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
            $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "quotes" . DIRECTORY_SEPARATOR . base64_decode($id);
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
        $mailData = DB::table('mail_template')
        ->where('mail_temp_id', '=', 4)
        ->get();
        if(count($mailData)>0)
        {
            $mailSubject = trim($mailData[0]->mail_subject);
            $subject = $mailSubject;
            $subject = str_replace("&nbsp;", "", strval($subject));
            $subject = str_replace("&amp;nbsp;", "", strval($subject));
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $mainContent = array('##VENDOR-NAME##', '##PO-NUMBER##');
            $mainReplace = array($vendorName, $data['poNumber']);
            $mailContent = trim($mailData[0]->mail_content);
            $pomessage = str_replace($mainContent, $mainReplace, $mailContent);
            // $pomessage = str_replace("&nbsp;", "", strval($pomessage));
            $pomessage = str_replace("&amp;nbsp;", "", strval($pomessage));
            $pomessage = html_entity_decode($pomessage, ENT_QUOTES, 'UTF-8');
            $createdon = date('Y-m-d H:i:s');
            $poPathname = public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders" . DIRECTORY_SEPARATOR . $poId;
            if(file_exists($poPathname)){
                $scan = scandir($poPathname,1);
                $scannedDirectory = array_diff($scan, array('..', '.'));
                foreach($scannedDirectory as $sc=>$value){
                    $scanDir[$sc] = $poPathname.'/'.$value;
                }
                $poattachment = implode(',',$scanDir);
            }
            else{
                $poattachment = '' ;
            }
            // print_r($attachment);die;
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
                    'message' => $pomessage,
                    'customer_name' => $vendorName,
                    'attachment' => $poattachment,
                ]);
        }
        return $poId;
    }



    public function savePurchaseorderDirectPo($request)
    {
        //to get all request values
        $data = $request->all();
        // dd($data);
        $commonservice = new CommonService();
        $vendorData = DB::table('vendors')
            ->where('vendors.vendor_id', '=', $data['vendorId'])
            ->get();
            $vendorName = $vendorData[0]->vendor_name;
            $email      = $vendorData[0]->email;
        if ($request->input('poNumber') != null && trim($request->input('poNumber')) != '') {
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $lastDelDate = $commonservice->dateFormat($data['lastDeliveryDate']);
            if(isset($data['poNotes']) && $data['poNotes']!=''){
                $poNotes = $data['poNotes'];
            }
            else{
                $poNotes = '';
            }
            $poId = DB::table('purchase_orders')->insertGetId(
                [
                    'po_number'                  => $data['poNumber'],
                    'po_issued_on'               => $issuedOn,
                    'vendor'                     => $data['vendorId'],
                    'total_amount'               => $data['totalAmount'],
                    'order_status'               => $data['orderStatus'],
                    'payment_status'             => $data['paymentStatus'],
                    // 'description'             => $rfqdescription,
                    'created_by'                 => session('userId'),
                    'created_on'                 => $commonservice->getDateTime(),
                    // 'upload_path'             => $uploadfile,
                    'quote_id'                   => 0,
                    'last_date_of_delivery'      => $lastDelDate,
                    'delivery_location'          => $data['deliveryLoc'],
                    'purchase_order_description' => $data['description'],
                    'purchase_order_notes'       => $poNotes,
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $poId, 'Purchaseorder-add', 'Add Purchase Order ' . $data['poNumber'], 'Purchase Order');

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
                        
                        if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders")) {
                            mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders", 0755);
                        }
            
                        $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders" . DIRECTORY_SEPARATOR . $poId;
                        
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
        
                    $uploadData = array('purchase_order_upload_file' => $filePathName);
                    $quotesUp = DB::table('purchase_orders')
                            ->where('po_id', '=', $poId)
                            ->update($uploadData);
                }
            }
        }

        if ($request->input('item') != null) {
            for ($k = 0; $k < count($data['item']); $k++) {
                $purchaseOrderDetailsId = DB::table('purchase_order_details')->insertGetId(
                    [
                        'po_id'             =>  $poId,
                        'item_id'           => $data['item'][$k],
                        'uom'               => $data['unitId'][$k],
                        'unit_price'        => $data['unitPrice'][$k],
                        'quantity'          => $data['qty'][$k],
                        'description'       =>  $data['quoteDesc'][$k],
                        // 'order_status'   => 'pending',
                        'created_on'        => $commonservice->getDateTime(),
                    ]
                );
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $purchaseOrderDetailsId, 'Purchaseorderdetails-add', 'add Purchase Order Details ' . $purchaseOrderDetailsId, 'Purchase Order Details');
        }
        
        $mailData = DB::table('mail_template')
                    ->where('mail_temp_id', '=', 4)
                    ->get();
        if(count($mailData)>0)
        {
            $mailSubject = trim($mailData[0]->mail_subject);
            $subject = $mailSubject;
            $subject = str_replace("&nbsp;", "", strval($subject));
            $subject = str_replace("&amp;nbsp;", "", strval($subject));
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $mainContent = array('##VENDOR-NAME##', '##PO-NUMBER##');
            $mainReplace = array($vendorName, $data['poNumber']);
            $mailContent = trim($mailData[0]->mail_content);
            $pomessage = str_replace($mainContent, $mainReplace, $mailContent);
            // $pomessage = str_replace("&nbsp;", "", strval($pomessage));
            $pomessage = str_replace("&amp;nbsp;", "", strval($pomessage));
            $pomessage = html_entity_decode($pomessage, ENT_QUOTES, 'UTF-8');
            $createdon = date('Y-m-d H:i:s');
            $poPathname = public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders" . DIRECTORY_SEPARATOR . $poId;
            if(file_exists($poPathname)){
                $scan = scandir($poPathname,1);
                $scannedDirectory = array_diff($scan, array('..', '.'));
                foreach($scannedDirectory as $sc=>$value){
                    $scanDir[$sc] = $poPathname.'/'.$value;
                }
                $poattachment = implode(',',$scanDir);
            }
            else{
                $poattachment = '' ;
            }
            // print_r($attachment);die;
            $response = DB::table('temp_mail')
            ->insertGetId(
                [
                    'from_mail'      => $mailData[0]->mail_from,
                    'to_email'       => $email,
                    'subject'        => $mailData[0]->mail_subject,
                    'cc'             => $mailData[0]->mail_cc,
                    'bcc'            => $mailData[0]->mail_bcc,
                    'from_full_name' => $mailData[0]->from_name,
                    'status'         => 'pending',
                    'datetime'       => $createdon,
                    'message'        => $pomessage,
                    'customer_name'  => $vendorName,
                    'attachment'     => $poattachment,
                ]);
        }
        return $poId;
    }


    // Fetch All Purchase Order List
    public function fetchAllPurchaseOrder()
    {
        if(session('loginType')=='users'){
            $data = DB::table('purchase_orders')
                    ->join('vendors', 'vendors.vendor_id', '=', 'purchase_orders.vendor')
                    ->leftjoin('quotes', 'quotes.quote_id', '=', 'purchase_orders.quote_id')
                    ->get();
        }
        else{
            $userId=session('userId');
            $data = DB::table('purchase_orders')
                    ->join('vendors', 'vendors.vendor_id', '=', 'purchase_orders.vendor')
                    ->leftjoin('quotes', 'quotes.quote_id', '=', 'purchase_orders.quote_id')
                    ->where('vendors.vendor_id', '=', $userId)
                    ->get();
        }
        return $data;
    }

    // Fetch All PurchaseOrder List
    public function fetchAllActivePurchaseOrder()
    {
        $data = DB::table('purchase_orders')
            ->where('order_status', '=', 'active')
            ->orderBy('po_number', 'asc')
            ->get();
        return $data;
    }

    //fetchAllNotScheduledPurchaseOrder
    public function fetchAllNotScheduledPurchaseOrder()
    {
        $data = DB::table('purchase_orders')
            ->where('order_status', '!=', 'delivery scheduled')
            ->orderBy('po_number', 'asc')
            ->get();
        return $data;
    }

    // fetch particular Vendor details
    public function fetchVendorDetailById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quotes')
        ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
        ->where('quotes.quote_id', '=', $id)->get();
        return $data;
    }
    public function fetchSumOfQuoteById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quote_details')
            ->select(DB::raw('SUM(quote_details.unit_price) as tot'))
            ->where('quote_details.quote_id', '=', $id)->get();
        $data['quotes'] =  DB::table('quotes')
                    ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
                    ->where('quotes.quote_id', '=', $id)->get();
        return $data;
    }
    public function fetchAllQuoteDetailsId($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quotes')
            ->join('quote_details','quote_details.quote_id','=','quotes.quote_id')
            ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'quote_details.uom')
            ->where('quotes.quote_id', '=', $id)->get();
        return $data;
    }

    public function fetchPurchaseOrderDetailsId($id)
    {
        $id = base64_decode($id);
        $data = DB::table('purchase_order_details')
            ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'purchase_order_details.uom')
            ->where('purchase_order_details.po_id', '=', $id)->get();
        return $data;
    }
    public function fetchPurchaseorderById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('purchase_orders')
                ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
                ->join('purchase_order_details', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                ->join('items', 'items.item_id', '=', 'purchase_order_details.item_id')
                ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'purchase_order_details.uom')
                ->where('purchase_orders.po_id', '=', $id)
                ->get();
        if(isset($data[0]->po_issued_on)){
            $issueDate = $data[0]->po_issued_on;
            $issuedOn = date("d-M-Y", strtotime($issueDate));
            $data[0]->po_issued_on = $issuedOn;
        }
        return $data;
    }
    public function fetchPurchaseorderByIdForDelivery($id)
    {
        $id = base64_decode($id);
        $data = DB::table('purchase_orders')
                ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
                ->join('purchase_order_details', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                ->join('items', 'items.item_id', '=', 'purchase_order_details.item_id')
                ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'purchase_order_details.uom')
                ->where('purchase_orders.po_id', '=', $id)
                ->where('purchase_orders.order_status', '!=', 'delivery scheduled')
                ->get();
        if(isset($data[0]->po_issued_on)){
            $issueDate = $data[0]->po_issued_on;
            $issuedOn = date("d-M-Y", strtotime($issueDate));
            $data[0]->po_issued_on = $issuedOn;
        }
        return $data;
    }
    public function updatePurchaseOrderDetails($params, $id)
    {

        $response = 0;
        $data = $params->all();
        // $delMap = '';
        // $delivUp = '';
        // $delUp = '';
        $purchaseOrder = '';
        $purchaseOrderDetailsData = '';
        // delete Consumption 
        //  if(isset($data['deleteConsumptionDetail']) && $data['deleteConsumptionDetail']!=null && trim($data['deleteConsumptionDetail'])!=''){
        //     $delConsumptionId = explode(",",$data['deleteConsumptionDetail']);
        //     for($e = 0;$e<count($delConsumptionId);$e++){

        //        $delUp = DB::table('customer_consumption_quantity')->where('customer_consumption_id', '=', $delConsumptionId[$e])->delete();
        //     }
        // }
        //$purchase Order details 
        $commonservice = new CommonService();
        for ($j = 0; $j < count($data['item']); $j++) {
            $purchaseOrderDetailsData = array(
                'po_id'             => base64_decode($id),
                'item_id'           => $data['item'][$j],
                'uom'               => $data['unitId'][$j],
                'unit_price'        => $data['unitPrice'][$j],
                'quantity'          => $data['qty'][$j],
                'description'       => $data['quoteDesc'][$j],
                'created_on'        => $commonservice->getDateTime(),
            );
            if(isset($data['podId'][$j]) && $data['podId'][$j]!=''){
                $purchaseOrderdetailsUp = DB::table('purchase_order_details')
                ->where('pod_id', '=', $data['podId'][$j])
                    ->update($purchaseOrderDetailsData);
            }else{
                $purchaseOrderdetailsUp = DB::table('purchase_order_details')
                    ->insert($purchaseOrderDetailsData);
            }
        }

        //$purchase Order
        if ($params->input('poNumber') != null && trim($params->input('poNumber')) != '') {
            $commonservice = new CommonService();
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $lastDelDate = $commonservice->dateFormat($data['lastDeliveryDate']);
            if(isset($data['poNotes']) && $data['poNotes']!=''){
                $poNotes = $data['poNotes'];
            }
            else{
                $poNotes = '';
            }
            $params = array(
                'po_number' => $data['poNumber'],
                'po_issued_on'    => $issuedOn,
                'vendor'          => $data['vendorId'],
                'total_amount'    => $data['totalAmount'],
                'order_status'    => $data['orderStatus'],
                'payment_status'  => $data['paymentStatus'],
                'description' => $data['description'],
                'updated_by'      => session('userId'),
                'updated_on'      => $commonservice->getDateTime(),
                'last_date_of_delivery' => $lastDelDate,
                'delivery_location' => $data['deliveryLoc'],
                'purchase_order_description' => $data['description'],
                'purchase_order_notes'       => $poNotes,
            );

            $purchaseOrder = DB::table('purchase_orders')
                ->where('po_id', '=', base64_decode($id))
                ->update(
                    $params
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
                        
                        if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders")) {
                            mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders", 0755);
                        }
            
                        $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "purchaseorders" . DIRECTORY_SEPARATOR . base64_decode($id);
                        
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
        
                    $uploadData = array('purchase_order_upload_file' => $filePathName);
                    $quotesUp = DB::table('purchase_orders')
                            ->where('po_id', '=', base64_decode($id))
                            ->update($uploadData);
                }
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Purchase Order-update', 'Update Purchase Order ' . $data['poNumber'], 'Customer');
        }
        if ($purchaseOrderdetailsUp || $purchaseOrder) {
            $response = 1;
        }
        return $response;
    }
}
