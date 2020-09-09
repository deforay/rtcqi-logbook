<?php

namespace App\Model\DeliverySchedule;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\DeliveryScheduleService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class DeliveryScheduleTable extends Model
{
    //Add Delivery Schedule
    public function saveDeliverySchedule($request)
    {
        //to get all request values
        $data = $request->all();
        
        $commonservice = new CommonService();

        $expectedDelivery = $commonservice->dateFormat($data['expectedDelivery']);
        $autoId = DB::table('delivery_schedule')->insertGetId(
            [
                'pod_id'      => $data['po_id'],
                'expected_date_of_delivery'    => $expectedDelivery,
                'item_id'          => $data['item'],
                'delivery_qty'    => $data['deliverQty'],
                'delivery_mode'    => $data['deliveryMode'],
                'comments'  => $data['comments'],
                'branch_id'       => $data['branches'],
                'created_by'      => session('userId'),
                'created_on'      => $commonservice->getDateTime(),
                'delivery_schedule_status' => 'pending for shipping',
            ]
        );
            $totalDelQty = 0;
            $totalPodQty = 0;
            $delQtySum = DB::raw('SUM(delivery_schedule.delivery_qty) as totQty');
            $purchase = DB::table('purchase_order_details')
                        // ->select($qtySum)
                        ->where('po_id','=', $data['po'])->get();
            $poNum = $purchase[0]->po_number;
            // dd($poNum);
            for($k=0;$k<count($purchase);$k++){
                $delQty = DB::table('delivery_schedule')
                        ->select($delQtySum)
                        ->where('pod_id','=', $purchase[$k]->pod_id)->get();
                $totalDelQty += intval($delQty[0]->totQty);
                $totalPodQty += intval($purchase[$k]->quantity);
            }

            if($totalPodQty == $totalDelQty){
                $sts = 'delivery scheduled';
            }
            else{
                $sts = 'some items scheduled for delivery';
            }
            $stsUp = DB::table('purchase_orders')
                    ->where('po_id', '=', $data['po'])
                    ->update(
                        [
                            'order_status'    => $sts,
                        ]
                    );

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), $autoId, 'Delivery Scheduler-add', 'Add Delivery Schedule ' . $data['po_id'], 'Add Delivery Schedule');
        
        return $autoId;
    }

    public function addDeliverySchedule($request){
        $data = $request->all();
        $mailItemDetails = '';
        $locEmail = '';
        // dd($data);
        $commonservice = new CommonService();
        $mailItemDetails .= '<table border="1" style="width:100%; border-collapse: collapse;">
                                        <thead>
                                        <tr>
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
        for($k=0;$k<count($data['expectedDelivery']);$k++){
            // print_r("ex".$k);
            if(isset($data['expectedDelivery'][$k]) && $data['expectedDelivery'][$k]!=null){
                $expectedDelivery = $commonservice->dateFormat($data['expectedDelivery'][$k]);
                $autoId = DB::table('delivery_schedule')->insertGetId(
                    [
                        'pod_id'      => $data['podId'][$k],
                        'expected_date_of_delivery'    => $expectedDelivery,
                        'item_id'          => $data['item'][$k],
                        'delivery_qty'    => $data['deliverQty'][$k],
                        'delivery_mode'    => $data['deliveryMode'][$k],
                        'comments'  => $data['comments'][$k],
                        'branch_id'       => $data['dbranches'][$k],
                        'created_by'      => session('userId'),
                        'created_on'      => $commonservice->getDateTime(),
                        'delivery_schedule_status' => 'pending for shipping',
                    ]);

                $branchEmail = DB::table('branches')
                            ->where('branch_id','=', $data['dbranches'][$k])->get();
                
                if($locEmail){
                    $locEmail .= $locEmail.','.$branchEmail[0]->email;
                }
                else{
                    $locEmail = $branchEmail[0]->email;
                }
                // dd($locEmail);

                $mailItemDetails .= '<tr>
                                    <td>'.$data['itemNames'][$k].'</td>
                                    <td style="text-align:right;">'.$data['quantityM'][$k].'</td>
                                    <td>'.$data['expectedDelivery'][$k].'</td>
                                    <td style="text-align:right;">'.$data['deliverQty'][$k].'</td>
                                    <td>'.$data['deliveryMode'][$k].'</td>
                                    <td>'.$branchEmail[0]->branch_name.'</td>
                                    <td>'.$data['comments'][$k].'</td>
                                </tr>';
                

                    $totalDelQty = 0;
                    $totalPodQty = 0;
                    $delQtySum = DB::raw('SUM(delivery_schedule.delivery_qty) as totQty');
                    $purchase = DB::table('purchase_order_details')
                                // ->select($qtySum)
                                ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                                ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
                                ->where('purchase_order_details.po_id','=', $data['purchaseOrder'])->get();
                    $poNum = $purchase[0]->po_number;
                    $poDate = $commonservice->humanDateFormat($purchase[0]->po_issued_on);
                    $vendorName = $purchase[0]->vendor_name;
                    // dd($poNum);
                    for($j=0;$j<count($purchase);$j++){
                        $delQty = DB::table('delivery_schedule')
                                ->select($delQtySum)
                                ->where('pod_id','=', $purchase[$j]->pod_id)->get();
                        $totalDelQty += intval($delQty[0]->totQty);
                        $totalPodQty += intval($purchase[$j]->quantity);
                    }

                    if($totalPodQty == $totalDelQty){
                        $sts = 'delivery scheduled';
                    }
                    else{
                        $sts = 'some items scheduled for delivery';
                    }
                    $stsUp = DB::table('purchase_orders')
                            ->where('po_id', '=', $data['purchaseOrder'])
                            ->update(
                                [
                                    'order_status'    => $sts,
                                ]
                            );

                $commonservice = new CommonService();
                $commonservice->eventLog(session('userId'), $autoId, 'Delivery Scheduler-add', 'Add Delivery Schedule ' . $data['podId'][$k], 'Add Delivery Schedule');
            }
        }
        $mailItemDetails .= '</tbody></table>';
        $global = DB::table('global_config')
        ->where('global_config.global_name', '=', 'email')
        ->select('global_value')
        ->get();
        $adminMail = $global[0]->global_value;
        $toEmail = $locEmail.','.$adminMail;
        // dd($toEmail);
        $mailData = DB::table('mail_template')
        ->where('mail_temp_id', '=', 5)
        ->get();
        // dd($mailData);

        if(count($mailData)>0)
        {
            $mailSubject = trim($mailData[0]->mail_subject);
            $subject = $mailSubject;
            $subject = str_replace("&nbsp;", "", strval($subject));
            $subject = str_replace("&amp;nbsp;", "", strval($subject));
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $mainContent = array( '##PO-NUMBER##','##ITEM-DETAILS##','##PO-DATE##','##VENDOR-NAME##');
            $mainReplace = array( $poNum,$mailItemDetails,$poDate,$vendorName);
            $mailContent = trim($mailData[0]->mail_content);
            $message = str_replace($mainContent, $mainReplace, $mailContent);
            // $message = str_replace("&nbsp;", "", strval($message));
            $message = str_replace("&amp;nbsp;", "", strval($message));
            $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
            $createdon = date('Y-m-d H:i:s');
            
            // dd($message);
            $response = DB::table('temp_mail')
            ->insertGetId(
                [
                    'from_mail' => $mailData[0]->mail_from,
                    'to_email' => $toEmail,
                    'subject' => $mailData[0]->mail_subject,
                    'cc' => $mailData[0]->mail_cc,
                    'bcc' => $mailData[0]->mail_bcc,
                    'from_full_name' => $mailData[0]->from_name,
                    'status' => 'pending',
                    'datetime' => $createdon,
                    'message' => $message,
                    'customer_name' => $vendorName,
                    // 'attachment' => $attachment,
                ]);
        }
        // die;
        return $autoId;
    }

    public function saveDeliveryScheduleByDate($request)
    {
        //to get all request values
        $data = $request->all();
        // dd($data);
        $autoId = 0;
        $commonservice = new CommonService();

        $expectedDelivery = $commonservice->dateFormat($data['expectedDelivery']);
        for ($j = 0; $j < count($data['item']); $j++) {
        $autoId = DB::table('delivery_schedule')->insertGetId(
                [
                    'pod_id'      => $data['podId'][$j],
                    'expected_date_of_delivery'    => $expectedDelivery,
                    'item_id'          => $data['item'][$j],
                    'delivery_qty'    => $data['deliverQty'][$j],
                    'delivery_mode'    => $data['deliveryMode'][$j],
                    'comments'  => $data['comments'][$j],
                    'branch_id'       => $data['branches'][$j],
                    'created_by'      => session('userId'),
                    'created_on'      => $commonservice->getDateTime(),
                    'delivery_schedule_status' => 'pending for shipping',
                ]
            );
                $totalDelQty = 0;
                $totalPodQty = 0;
                $delQtySum = DB::raw('SUM(delivery_schedule.delivery_qty) as totQty');
                $purchase = DB::table('purchase_order_details')
                            // ->select($qtySum)
                            ->where('po_id','=', $data['po'])->get();
                for($k=0;$k<count($purchase);$k++){
                    $delQty = DB::table('delivery_schedule')
                            ->select($delQtySum)
                            ->where('pod_id','=', $purchase[$k]->pod_id)->get();
                    $totalDelQty += intval($delQty[0]->totQty);
                    $totalPodQty += intval($purchase[$k]->quantity);
                }
                
                if($totalPodQty == $totalDelQty){
                    $sts = 'delivery scheduled';
                }
                else{
                    $sts = 'some items scheduled for delivery';
                }
                // dd($sts);
                $stsUp = DB::table('purchase_orders')
                        ->where('po_id', '=', $data['po'])
                        ->update(
                            [
                                'order_status'    => $sts,
                            ]
                        );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $autoId, 'Delivery Scheduler-add', 'Add Delivery Schedule ' . $data['po'], 'Add Delivery Schedule');
        }
        
        return $autoId;
    }

    //all delivery schedule
    public function fetchAllDeliverySchedule($params){
        $req = $params->all();
        if(session('loginType')=='users'){
            $data = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id');
                    if(isset($req['poId']) && $req['poId'])
                       $data = $data->where('purchase_order_details.po_id', '=', $req['poId']);
                    // ->where('purchase_order_details.delivery_status', '=', 'pending')
            $data = $data->get();
        }
        else{
            $userId=session('userId');
            $data = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                    // ->where('purchase_order_details.delivery_status', '=', 'pending')
                    ->where('purchase_orders.vendor', '=', $userId)
                    ->get();
        }
        return $data;
    }

    public function fetchAllPendingDeliverySchedule(){
        if(session('loginType')=='users'){
            $data = DB::table('delivery_schedule')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id');
                    // ->where('delivery_schedule.delivery_schedule_status', '=', 'pending for shipping');
            $data = $data->get();
        }
        else{
            $userId=session('userId');
            $data = DB::table('delivery_schedule')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                    // ->where('delivery_schedule.delivery_schedule_status', '=', 'pending for shipping')
                    // ->where('purchase_order_details.delivery_status', '=', 'pending')
                    ->where('purchase_orders.vendor', '=', $userId)
                    ->get();
        }
        return $data;
    }

    // delivery schedule by id
    public function fetchDeliveryScheduleById($id){
        $id = base64_decode($id);
        $data = DB::table('delivery_schedule')
                ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
                ->where('delivery_schedule.delivery_schedule_status', '=', 'pending for shipping')
                ->where('delivery_schedule.delivery_id', '=', $id)->get();
        return $data;
    }

    //Update Delivery Schedule
    public function updateDeliverySchedule($id,$request)
    {
        //to get all request values
        $data = $request->all();
        // dd($data);
        $commonservice = new CommonService();
        $expectedDelivery = $commonservice->dateFormat($data['expectedDelivery']);
        $locEmail = '';
        $mailItemDetails = '';
        $mailItemDetails .= '<table border="1" style="width:100%; border-collapse: collapse;">
                                        <thead>
                                        <tr>
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
        $branchEmail = DB::table('branches')
                        ->where('branch_id','=', $data['branches'])->get();
                        
        if($locEmail){
            $locEmail .= $locEmail.','.$branchEmail[0]->email;
        }
        else{
            $locEmail = $branchEmail[0]->email;
        }
        $mailItemDetails .= '<tr>
                                <td>'.$data['itemNames'].'</td>
                                <td>'.$data['quantityM'].'</td>
                                <td>'.$data['expectedDelivery'].'</td>
                                <td>'.$data['deliverQty'].'</td>
                                <td>'.$data['deliveryMode'].'</td>
                                <td>'.$branchEmail[0]->branch_name.'</td>
                                <td>'.$data['comments'].'</td>
                            </tr>';
        $mailItemDetails .= '</tbody></table>';
        $purchase = DB::table('purchase_order_details')
                    // ->select($qtySum)
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                    ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
                    ->where('purchase_order_details.po_id','=', $data['poId'])->get();
        $poNum = $purchase[0]->po_number;
        $poDate = $commonservice->humanDateFormat($purchase[0]->po_issued_on);
        $vendorName = $purchase[0]->vendor_name;
        // $totalDelQty = 0;
        // $totalPodQty = 0;
        // $delQtySum = DB::raw('SUM(delivery_schedule.delivery_qty) as totQty');
        // $purchase = DB::table('purchase_order_details')
        //             // ->select($qtySum)
        //             ->where('po_id','=', $data['poId'])->get();
        // for($k=0;$k<count($purchase);$k++){
        //     $delQty = DB::table('delivery_schedule')
        //             ->select($delQtySum)
        //             ->where('pod_id','=', $purchase[$k]->pod_id)->get();
        //     $totalDelQty += intval($delQty[0]->totQty);
        //     $totalPodQty += intval($purchase[$k]->quantity);
        // }
        // dd($totalPodQty);
        // if($totalPodQty == $totalDelQty){
        //     $sts = 'delivery scheduled';
        // }
        // else{
        //     $sts = 'some items scheduled for delivery';
        // }
        // $stsUp = DB::table('purchase_orders')
        //         ->where('po_id', '=', $data['po'])
        //         ->update(
        //             [
        //                 'order_status'    => $sts,
        //             ]
        //         );
        $autoId = DB::table('delivery_schedule')
                    ->where('delivery_id', '=', base64_decode($id))
                    ->update(
                        [
                            'pod_id'      => $data['pod_id'],
                            'expected_date_of_delivery'    => $expectedDelivery,
                            'item_id'          => $data['ItemId'],
                            'delivery_qty'    => $data['deliverQty'],
                            'delivery_mode'    => $data['deliveryMode'],
                            'branch_id'       => $data['branches'],
                            'updated_by'      => session('userId'),
                            'updated_on'      => $commonservice->getDateTime(),
                        ]
                    );

        $commentId = DB::table('delivery_schedule_edit_comments')->insertGetId(
            [
                'delivery_id'      => base64_decode($id),
                'edit_comments'  => $data['comments'],
                'created_by'      => session('userId'),
                'created_on'      => $commonservice->getDateTime(),
            ]
        );

        $global = DB::table('global_config')
                    ->where('global_config.global_name', '=', 'email')
                    ->select('global_value')
                    ->get();
        $adminMail = $global[0]->global_value;
        $toEmail = $locEmail.','.$adminMail;
        // dd($toEmail);
        $mailData = DB::table('mail_template')
                    ->where('mail_temp_id', '=', 6)
                    ->get();
        // dd($mailData);

        if(count($mailData)>0)
        {
            $mailSubject = trim($mailData[0]->mail_subject);
            $subject = $mailSubject;
            $subject = str_replace("&nbsp;", "", strval($subject));
            $subject = str_replace("&amp;nbsp;", "", strval($subject));
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $mainContent = array( '##PO-NUMBER##','##ITEM-DETAILS##','##PO-DATE##','##VENDOR-NAME##');
            $mainReplace = array( $poNum,$mailItemDetails,$poDate,$vendorName);
            $mailContent = trim($mailData[0]->mail_content);
            $message = str_replace($mainContent, $mainReplace, $mailContent);
            // $message = str_replace("&nbsp;", "", strval($message));
            $message = str_replace("&amp;nbsp;", "", strval($message));
            $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
            $createdon = date('Y-m-d H:i:s');
            
            // dd($message);
            $response = DB::table('temp_mail')
            ->insertGetId(
                [
                    'from_mail' => $mailData[0]->mail_from,
                    'to_email' => $toEmail,
                    'subject' => $mailData[0]->mail_subject,
                    'cc' => $mailData[0]->mail_cc,
                    'bcc' => $mailData[0]->mail_bcc,
                    'from_full_name' => $mailData[0]->from_name,
                    'status' => 'pending',
                    'datetime' => $createdon,
                    'message' => $message,
                    'customer_name' => $vendorName,
                    // 'attachment' => $attachment,
                ]);
        }
        
        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Delivery Scheduler-edit', 'Update Delivery Schedule ' . $data['pod_id'], 'Purchase Order details');
        
        return $commentId;
    }
    
    public function fetchDeliverySchedule($request){
        $data = $request->all();
        // dd($data);
        $delDate = DB::raw("DATE_FORMAT(delivery_schedule.expected_date_of_delivery,'%d-%b-%Y') as delivery_date");
        $query = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->where('delivery_schedule.pod_id', '=', $data['po_id'])
                    ->where('delivery_schedule.item_id', '=', $data['item'])
                    ->select('*',$delDate)
                    ->get();
        return $query;
    }

    public function updateItemReceive($id,$request)
    {
        $data = $request->all();
        // dd($data);
        $manufacturingDate='';
        $expiryDate='';
        $commonservice = new CommonService();

        $autoId = DB::table('delivery_schedule')
                    ->where('delivery_id', '=', base64_decode($id))
                    ->update(
                        [
                            'received_qty'      => $data['receivedQtySum'],
                            'damaged_qty'    => $data['damagedQtySum'],
                            // 'short_description' => $data['description'],
                            'delivery_schedule_status' => $data['status'],
                            'updated_by'      => session('userId'),
                            'updated_on'      => $commonservice->getDateTime(),
                        ]
                    );

        for($i=0;$i<count($data['branches']);$i++){
            if($data['description'][$i] && $data['description'][$i]!=null ){
                $desc = $data['description'][$i];
            }
            else{
                $desc='';
            }
            if($data['expiryDate'][$i]){
                $expiryDate = $commonservice->dateFormat($data['expiryDate'][$i]);
            }
            else{
                $expiryDate = null;
            }
            if($data['manufacturingDate'][$i]){
                $manufacturingDate  = $commonservice->dateFormat($data['manufacturingDate'][$i]);
            }
            else{
                $manufacturingDate = null;
            }if($data['receiveDate'][$i]){
                $receivedDate  = $commonservice->dateFormat($data['receiveDate'][$i]);
            }
            else{
                $receivedDate = null;
            }
            if($expiryDate){
                $stk = DB::table('inventory_stock')
                    ->where('expiry_date', '=', $expiryDate)
                    ->where('branch_id', '=', $data['branches'][$i])
                    ->where('item_id', '=', $data['itemId'])->get();
                    if(count($stk)>0){
                        $rQty = $data['receivedQty'][$i] + $stk[0]->stock_quantity;
                        $stockId = DB::table('inventory_stock')
                                ->where('expiry_date', '=', $expiryDate)
                                ->where('branch_id', '=', $data['branches'][$i])
                                ->where('item_id', '=', $data['itemId'])
                                ->update(
                                    [
                                        'batch_number'            => $data['batchNo'][$i],
                                        'sl_number'               => $data['slNumber'][$i],
                                        'manufacturing_date'      => $manufacturingDate,
                                        'stock_quantity'          => $rQty,
                                        'updated_by'              => session('userId'),
                                        'updated_on'              => $commonservice->getDateTime(),
                                        'non_conformity_comments' => $desc,
                                        'received_date' => $receivedDate,
                                        'pod_id' => $data['pod_id'],
                                        'delivery_id' => base64_decode($id),
                                    ]
                                );
                    }else{
                        $stockId = DB::table('inventory_stock')->insertGetId(
                                    [
                                        'item_id'                 => $data['itemId'],
                                        'sl_number'               => $data['slNumber'][$i],
                                        'manufacturing_date'      => $manufacturingDate,
                                        'expiry_date'             => $expiryDate,
                                        'batch_number'            => $data['batchNo'][$i],
                                        'stock_quantity'          => $data['receivedQty'][$i],
                                        'created_by'              => session('userId'),
                                        'created_on'              => $commonservice->getDateTime(),
                                        'branch_id'               => $data['branches'][$i],
                                        'non_conformity_comments' => $desc,
                                        'received_date' => $receivedDate,
                                        'pod_id' => $data['pod_id'],
                                        'delivery_id' => base64_decode($id),
                                    ]
                                );
                    }
            }
            else{
                $stk = DB::table('inventory_stock')
                    ->where('branch_id', '=', $data['branches'][$i])
                    ->where('item_id', '=', $data['itemId'])->get();
                if(count($stk)>0){
                    $rQty = $data['receivedQty'][$i] + $stk[0]->stock_quantity;
                    $stockId = DB::table('inventory_stock')
                            ->where('branch_id', '=', $data['branches'][$i])
                            ->where('item_id', '=', $data['itemId'])
                            ->update(
                                [
                                    'batch_number'            => $data['batchNo'][$i],
                                    'sl_number'               => $data['slNumber'][$i],
                                    'manufacturing_date'      => $manufacturingDate,
                                    'stock_quantity'          => $rQty,
                                    'updated_by'              => session('userId'),
                                    'updated_on'              => $commonservice->getDateTime(),
                                    'non_conformity_comments' => $desc,
                                    'received_date' => $receivedDate,
                                    'pod_id' => $data['pod_id'],
                                    'delivery_id' => base64_decode($id),
                                ]
                            );
                }else{
                    $stockId = DB::table('inventory_stock')->insertGetId(
                                [
                                    'item_id'                 => $data['itemId'],
                                    'sl_number'               => $data['slNumber'][$i],
                                    'manufacturing_date'      => $manufacturingDate,
                                    'expiry_date'             => $expiryDate,
                                    'batch_number'            => $data['batchNo'][$i],
                                    // 'service_date'         => $serviceDate,
                                    'stock_quantity'          => $data['receivedQty'][$i],
                                    'created_by'              => session('userId'),
                                    'created_on'              => $commonservice->getDateTime(),
                                    'branch_id'               => $data['branches'][$i],
                                    'non_conformity_comments' => $desc,
                                    'received_date' => $receivedDate,
                                    'pod_id' => $data['pod_id'],
                                    'delivery_id' => base64_decode($id),
                                ]
                            );
                }
            }

            if($desc){
                $autoCom = DB::table('autocomplete_comments')
                        ->where('description', '=',  $desc)
                        ->get();
                if(count($autoCom)==0){
                    $autoComIns = DB::table('autocomplete_comments')->insertGetId(
                                    [
                                        'description'      => $desc,
                                        'created_by'      => session('userId'),
                                        'created_on'      => $commonservice->getDateTime(),
                                    ]
                                );
                }
            }
        }
        
        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Delivery Scheduler-edit', 'Update Delivery Schedule ' . $data['pod_id'], 'Purchase Order details');

        $filePathName='';
        $fileName='';
        $extension='';
        if(isset($data['uploadFile'])){

            for($i=0;$i<count($data['uploadFile']);$i++)
            {
// print_r($_FILES['uploadFile']['name'][$i]);die;
       
                if (isset($_FILES['uploadFile']['name'][$i]) && $_FILES['uploadFile']['name'][$i] != '') {
                    if (!file_exists(public_path('uploads')) && !is_dir(public_path('uploads'))) {
                        mkdir(public_path('uploads'),0755,true);
                        // chmod (getcwd() .public_path('uploads'), 0755 );
                    }
                    
                    if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "recieveitem") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "recieveitem")) {
                        mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "recieveitem", 0755);
                    }
        
                    $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "recieveitem" . DIRECTORY_SEPARATOR . $stockId;
                    
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
    
                $uploadData = array('inventory_upload_file' => $filePathName);
                $invUp = DB::table('inventory_stock')
                        ->where('stock_id', '=', $stockId)
                        ->update($uploadData);
            }
        }
        return $autoId;
    }

    // Fetch All autocomplete comments list
    public function fetchAutoCompleteComments($searchTerm)
    {
        $arr = array();
        $data = DB::table('autocomplete_comments')
                ->where('description', 'LIKE',  "%{$searchTerm}%")
                ->get();
        for ($k = 0; $k < count($data); $k++) {
            $temp['value'] = $data[$k]->description;
            array_push($arr, $temp);
        }
        return json_encode($arr);
    }
}
