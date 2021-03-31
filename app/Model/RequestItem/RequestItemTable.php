<?php

namespace App\Model\RequestItem;

use Illuminate\Database\Eloquent\Model;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;
use DB;
use File;

class RequestItemTable extends Model
{
    public function saveRequestItem($request)
    {
        $data = $request->all();
        // dd($data);
        $autoId = 0;
        $commonservice = new CommonService();
        // dd($commonservice->getDateTime());
        $reqId = DB::table('requested_items')->orderBy('request_id','desc')->limit('1')->get();
        $loc = array();
        $mailItemDetails = '';
        $mailItemDetails .= '<table border="1" style="width:100%; border-collapse: collapse;">
                                        <thead>
                                        <tr>
                                            <th><strong>Item</strong></th>
                                            <th><strong>Quantity</strong></th>
                                            <th><strong>Requested<br/>On</strong></th>
                                            <th><strong>Needed<br/>On</strong></th>
                                            <th><strong>Location</strong></th>
                                            <th><strong>Reason</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        // dd($reqId);
        if(count($reqId)>0){
            $rqstId = $reqId[0]->request_id + 1;
        }
        else{
            $rqstId = 1;
        }
        for ($j = 0; $j < count($data['item']); $j++) {
            $neededOn = $commonservice->dateFormat($data['neededOn'][$j]);
            $autoId = DB::table('requested_items')->insertGetId(
                [
                    'item_id' => $data['item'][$j],
                    'request_item_qty' => $data['itemQty'][$j],
                    'need_on' => $neededOn,
                    'branch_id' => $data['location'][$j],
                    'reason'  => $data['reason'][$j],
                    'requested_by' => session('userId'),
                    'requested_on' => $commonservice->getDateTime(),
                    'request_item_status' => 'pending',
                    'request_id' => $rqstId,
                ]
            );
            if(!in_array($data['location'][$j],$loc)){
                array_push($loc,$data['location'][$j]);
            }
            // print_r($loc);die;
            $branchEmail = DB::table('branches')
                            ->where('branch_id','=', $data['location'][$j])->get();
            $itemName = DB::table('items')
                            ->where('item_id','=', $data['item'][$j])->get();

            $mailItemDetails .= '<tr>
                                    <td>'.$itemName[0]->item_name.'</td>
                                    <td style="text-align:right;">'.$data['itemQty'][$j].'</td>
                                    <td>'.$data['neededOn'][$j].'</td>
                                    <td>'.date('d-M-Y').'</td>
                                    <td>'.$branchEmail[0]->branch_name.'</td>
                                    <td>'.$data['reason'][$j].'</td>
                                </tr>';
        }
        $mailItemDetails .= '</tbody></table>';
        $role = DB::table('roles')->where('role_status','=', 'active')->get();
        $configFile =  "acl.config.json";
        if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile))
        {
            $acl = json_decode(File::get(public_path($configFile)),true);
        }
        // print_r($acl);die;
        
        $userName = session('name').' '.session('lastName');
        $fromMail = session('email');
        $mailData = DB::table('mail_template')
                    ->where('mail_temp_id', '=', 11)
                    ->get();
        $userMail = "";
        for($m=0;$m<count($role);$m++){
            if(isset($role[$m]->role_code)){
                // print_r($acl['ADM']['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem']);die;
                if(isset($acl[$role[$m]->role_code]['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem']) && $acl[$role[$m]->role_code]['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem'] == "allow" ){
                    $userData = DB::table('users')
                                ->leftjoin('user_branch_map', 'user_branch_map.user_id', '=', 'users.user_id')
                                ->where('users.role', '=', $role[$m]->role_id)
                                ->whereIn('user_branch_map.branch_id', $loc)
                                ->get();
                                // dd($userData);
                    for($u=0;$u<count($userData);$u++){
                        if($userMail == ""){
                            $userMail = $userData[$u]->email;
                        }
                        else{
                            $userMail = $userMail.','.$userData[$u]->email;
                        }
                    }
                    
                }
            }
        }
        if(count($mailData)>0)
        {
            $labAdm = array();
            
            $mailSubject = trim($mailData[0]->mail_subject);
            $subject = $mailSubject;
            $subject = str_replace("&nbsp;", "", strval($subject));
            $subject = str_replace("&amp;nbsp;", "", strval($subject));
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $mainContent = array('##LAB-USER##','##ITEM-DETAILS##');
            $mainReplace = array($userName,$mailItemDetails);
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
                    'from_mail' => $fromMail,
                    'to_email' => $userMail,
                    'subject' => $subject,
                    'cc' => $mailData[0]->mail_cc,
                    'bcc' => $mailData[0]->mail_bcc,
                    'from_full_name' => $userName,
                    'status' => 'pending',
                    'datetime' => $createdon,
                    'message' => $message,
                    'customer_name' => $userName,
                ]);
            // dd($userData);
        }
        return $autoId;
    }

    public function fetchRequestItemByLogin()
    {
        $role = session('role');
        // dd($role);
        $item = DB::raw('group_concat(items.item_name) as item_name');
        $data = DB::table('requested_items')
                ->leftjoin('items', 'requested_items.item_id', '=', 'items.item_id')
                ->leftjoin('branches', 'requested_items.branch_id', '=', 'branches.branch_id')
                ->select('requested_items.*', $item,'branches.branch_name');
        if (isset($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem']) && ($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem'] == "allow")){
            if(strtolower(session('roleName'))!= 'admin'){
                $data = $data->leftjoin('user_branch_map', 'branches.branch_id', '=', 'user_branch_map.branch_id')->where('user_branch_map.user_id', '=', session('userId'));
            }
        }
        else{
            $data = $data ->where('requested_by', '=', session('userId'));
        }
        $data = $data->groupBy('requested_items.request_id')->get();
        return $data;
    }

    public function changeApproveStatus($request,$id)
    {
        $commonservice = new CommonService();
        $data = $request->all();
        $id = base64_decode($id);
        // dd($data);
        // $id = $request['id'];
        try {
            if ($id != "") {
                $loc = array();
                $mailItemDetails = '';
                $mailItemDetails .= '<table border="1" style="width:100%; border-collapse: collapse;">
                                                <thead>
                                                <tr>
                                                    <th><strong>Item</strong></th>
                                                    <th><strong>Quantity</strong></th>
                                                    <th><strong>Requested<br/>On</strong></th>
                                                    <th><strong>Needed<br/>On</strong></th>
                                                    <th><strong>Location</strong></th>
                                                    <th><strong>Reason</strong></th>
                                                    <th><strong>Status</strong></th>
                                                    <th><strong>Approve/Decline <br> Reason</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                for ($k = 0; $k < count($data['status']); $k++) {
                    $otherReason = "";
                    if($data['rejReason'][$k]!=null){
                        $otherReason = $data['otherReason'][$k];
                    }
                    $updateData = array(
                                    'request_item_status' => $data['status'][$k],
                                    'rejection_reason_id' => $data['rejReason'][$k],
                                    'rejection_reason_other' => $otherReason,
                                    'approved_by' => session('userId'),
                                    'approved_on' => $commonservice->getDateTime(),
                                    'updated_on' => $commonservice->getDateTime(),
                                    'updated_by' => session('userId'),
                                );
                                // dd($updateData);
                    DB::table('requested_items')
                        ->where('requested_item_id', '=', $data['requestItemId'][$k])
                        ->update($updateData);
                }
                $reqItem = DB::table('requested_items')->where('request_id', '=', $id)->get();
                // dd($reqItem);
                $requestBy = "";
                for($j=0;$j<count($reqItem);$j++){
                    if(!in_array($reqItem[$j]->branch_id,$loc)){
                        array_push($loc,$reqItem[$j]->branch_id);
                    }
                    // print_r($loc);die;
                    $branchEmail = DB::table('branches')
                                    ->where('branch_id','=', $reqItem[$j]->branch_id)->get();
                    $itemName = DB::table('items')
                                    ->where('item_id','=', $reqItem[$j]->item_id)->get();
                    $requestBy =  $reqItem[$j]->requested_by;
                    if($reqItem[$j]->rejection_reason_id){
                        $rejReason = DB::table('rejection_reason')->where('rejection_reason_id','=', $reqItem[$j]->rejection_reason_id)->get();
                        // dd($rejReason);
                        if($rejReason[0]->rejection_reason == "others"){
                            $rej = $reqItem[$j]->rejection_reason_other;
                        }
                        else{
                            $rej = $rejReason[0]->rejection_reason;
                        }
                    }
                    else{
                        $rej = "";
                    }
                    $mailItemDetails .= '<tr>
                                            <td>'.$itemName[0]->item_name.'</td>
                                            <td style="text-align:right;">'.$reqItem[$j]->request_item_qty.'</td>
                                            <td>'.$commonservice->humanDateFormat($reqItem[$j]->need_on).'</td>
                                            <td>'.date('d-M-Y').'</td>
                                            <td>'.$branchEmail[0]->branch_name.'</td>
                                            <td>'.$reqItem[$j]->reason.'</td>
                                            <td>'.$reqItem[$j]->request_item_status.'</td>
                                            <td>'.$rej.'</td>
                                        </tr>';
                }
                $mailItemDetails .= '</tbody></table>';
                $userName = session('name').' '.session('lastName');
                $fromMail = session('email');
                $mailData = DB::table('mail_template')
                            ->where('mail_temp_id', '=', 12)
                            ->get();
                $userMail = "";
                $userData = DB::table('users')
                            ->leftjoin('user_branch_map', 'user_branch_map.user_id', '=', 'users.user_id')
                            ->where('users.user_id', '=', $requestBy)
                            ->whereIn('user_branch_map.branch_id', $loc)
                            ->get();
               
                $userMail = $userData[0]->email;
                  
                if(count($mailData)>0)
                {
                    $labAdm = array();
                    
                    $mailSubject = trim($mailData[0]->mail_subject);
                    $subject = $mailSubject;
                    $subject = str_replace("##STATUS##", ucfirst($request['sts']), strval($subject));
                    $subject = str_replace("&nbsp;", "", strval($subject));
                    $subject = str_replace("&amp;nbsp;", "", strval($subject));
                    $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
                    // dd($subject);
                    $mainContent = array('##LAB-ADMIN##','##ITEM-DETAILS##','##STATUS##');
                    $mainReplace = array($userName,$mailItemDetails,ucfirst($request['sts']));
                    $mailContent = trim($mailData[0]->mail_content);
                    $message = str_replace($mainContent, $mainReplace, $mailContent);
                    // $message = str_replace("&nbsp;", "", strval($message));
                    $message = str_replace("&amp;nbsp;", "", strval($message));
                    $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
                    $createdon = date('Y-m-d H:i:s');
                
                    $response = DB::table('temp_mail')
                    ->insertGetId(
                        [
                            'from_mail' => $fromMail,
                            'to_email' => $userMail,
                            'subject' => $subject,
                            'cc' => $mailData[0]->mail_cc,
                            'bcc' => $mailData[0]->mail_bcc,
                            'from_full_name' => $userName,
                            'status' => 'pending',
                            'datetime' => $createdon,
                            'message' => $message,
                            'customer_name' => $userName,
                        ]);
                    // dd($userData);
                }
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $id;
    }

    public function fetchRequestItemById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('requested_items')
                ->leftjoin('items', 'requested_items.item_id', '=', 'items.item_id')
                ->leftjoin('branches', 'requested_items.branch_id', '=', 'branches.branch_id')
                ->where('requested_items.request_id', '=', $id)
                ->get();
        return $data;
    }

    // Update particular Item  details
    public function updateRequestItem($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        // dd($data);
        $loc = array();
        $mailItemDetails = '';
        $mailItemDetails .= '<table border="1" style="width:100%; border-collapse: collapse;">
                                        <thead>
                                        <tr>
                                            <th><strong>Item</strong></th>
                                            <th><strong>Quantity</strong></th>
                                            <th><strong>Requested<br/>On</strong></th>
                                            <th><strong>Needed<br/>On</strong></th>
                                            <th><strong>Location</strong></th>
                                            <th><strong>Reason</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>';

         if(isset($data['deleteItemDetail']) && $data['deleteItemDetail']!=null && trim($data['deleteItemDetail'])!=''){
            $delReqItemId = explode(",",$data['deleteItemDetail']);
            for($e = 0;$e<count($delReqItemId);$e++){
               $delUp = DB::table('requested_items')->where('requested_item_id', '=', $delReqItemId[$e])->delete();
            }
        }
        for ($j = 0; $j < count($data['item']); $j++) {
            $requestId = $data['requestId'];
            $neededOn = $commonservice->dateFormat($data['neededOn'][$j]);
            if (isset($data['requestItemId'][$j]) && ($data['requestItemId'][$j]!=null)) {
                $response = DB::table('requested_items')
                    ->where('requested_item_id', '=',$data['requestItemId'][$j])
                    ->update(
                        ['item_id' => $data['item'][$j],
                        'request_item_qty' => $data['itemQty'][$j],
                        'need_on' => $neededOn,
                        'branch_id' => $data['location'][$j],
                        'reason'  => $data['reason'][$j],
                        'request_id' => $requestId,
                        'updated_on' => $commonservice->getDateTime(),
                        'updated_by' => session('userId'),
                        'request_item_status' => $data['status'][$j],
                        'rejection_reason_id' => $data['rejReason'][$j],
                        'rejection_reason_other' => $data['otherReason'][$j],
                        ]);
            }
            else{
                $autoId = DB::table('requested_items')->insertGetId(
                    [
                        'item_id' => $data['item'][$j],
                        'request_item_qty' => $data['itemQty'][$j],
                        'need_on' => $neededOn,
                        'branch_id' => $data['location'][$j],
                        'reason'  => $data['reason'][$j],
                        'requested_by' => session('userId'),
                        'requested_on' => $commonservice->getDateTime(),
                        'request_item_status' => 'pending',
                        'request_id' => $requestId,
                    ]
                );
            }
            if(!in_array($data['location'][$j],$loc)){
                array_push($loc,$data['location'][$j]);
            }
            // print_r($loc);die;
            $branchEmail = DB::table('branches')
                            ->where('branch_id','=', $data['location'][$j])->get();
            $itemName = DB::table('items')
                            ->where('item_id','=', $data['item'][$j])->get();
            // dd($itemName);
            $mailItemDetails .= '<tr>
                                    <td>'.$itemName[0]->item_name.'</td>
                                    <td style="text-align:right;">'.$data['itemQty'][$j].'</td>
                                    <td>'.$data['neededOn'][$j].'</td>
                                    <td>'.date('d-M-Y').'</td>
                                    <td>'.$branchEmail[0]->branch_name.'</td>
                                    <td>'.$data['reason'][$j].'</td>
                                </tr>';
        }
        $mailItemDetails .= '</tbody></table>';
        $role = DB::table('roles')->where('role_status','=', 'active')->get();
        $configFile =  "acl.config.json";
        if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile))
        {
            $acl = json_decode(File::get(public_path($configFile)),true);
        }
        // print_r($acl);die;
        
        $userName = session('name').' '.session('lastName');
        $fromMail = session('email');
        $mailData = DB::table('mail_template')
                    ->where('mail_temp_id', '=', 11)
                    ->get();
        $userMail = "";
        for($m=0;$m<count($role);$m++){
            if(isset($role[$m]->role_code)){
                // print_r($acl['ADM']['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem']);die;
                if(isset($acl[$role[$m]->role_code]['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem']) && $acl[$role[$m]->role_code]['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem'] == "allow" ){
                    $userData = DB::table('users')
                                ->leftjoin('user_branch_map', 'user_branch_map.user_id', '=', 'users.user_id')
                                ->where('users.role', '=', $role[$m]->role_id)
                                ->whereIn('user_branch_map.branch_id', $loc)
                                ->get();
                                // dd($userData);
                    for($u=0;$u<count($userData);$u++){
                        if($userMail == ""){
                            $userMail = $userData[$u]->email;
                        }
                        else{
                            $userMail = $userMail.','.$userData[$u]->email;
                        }
                    }
                    
                }
            }
        }
        if(count($mailData)>0)
        {
            $labAdm = array();
            
            $mailSubject = trim($mailData[0]->mail_subject);
            $subject = $mailSubject;
            $subject = str_replace("&nbsp;", "", strval($subject));
            $subject = str_replace("&amp;nbsp;", "", strval($subject));
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
            $mainContent = array('##LAB-USER##','##ITEM-DETAILS##');
            $mainReplace = array($userName,$mailItemDetails);
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
                    'from_mail' => $fromMail,
                    'to_email' => $userMail,
                    'subject' => $subject,
                    'cc' => $mailData[0]->mail_cc,
                    'bcc' => $mailData[0]->mail_bcc,
                    'from_full_name' => $userName,
                    'status' => 'pending',
                    'datetime' => $createdon,
                    'message' => $message,
                    'customer_name' => $userName,
                ]);
            // dd($userData);
        }
        return $response;
    }

    public function getRejectionReason(){
        $data = DB::table('rejection_reason')
                ->get();
        return $data;
    }

}
