<?php

namespace App\Service;

use DB;
use Redirect;
use Illuminate\Support\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use DateTimeZone;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Hash;
use App\Model\User\UserTable;
use App\Model\Vendors\VendorsTable;

class CommonService
{
    public function duplicateValidation($request)
    {

        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $user = array();
        try {
            if ($value != "") {
                $user = DB::table($tableName)
                    ->where($fieldName, '=', $value)
                    ->get();
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        $countVal = count($user);

        return $countVal;
    }
    public function mobileDuplicateValidation($request)
    {
        $tableName1 = $request['tableName1'];
        $tableName2 = $request['tableName2'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $user = array();
        try {
            if ($value != "") {
                $user = DB::table($tableName1)
                    ->where($fieldName, '=', $value)
                    ->get();
                if (count($user) == 0) {
                    $user = DB::table($tableName2)
                        ->where($fieldName, '=', $value)
                        ->get();
                }
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        $countVal = count($user);
        return $countVal;
    }
    public function checkMobileValidation($request)
    {
        $tableName1 = $request['tableName1'];
        $tableName2 = $request['tableName2'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $fnct = $request['fnct'];
        $user = array();
        try {
            if (isset($fnct) && trim($fnct) !== '') {
                $fields = explode("##", $fnct);
                $primaryName = $fields[0];
                $primaryValue = trim($fields[1]);
                if ($value != "") {
                    $user = DB::table($tableName1)
                        ->where($primaryName, '!=', $primaryValue)
                        ->where($fieldName, '=', $value)
                        ->get();
                    if (count($user) == 0) {
                        $user = DB::table($tableName2)
                            ->where($fieldName, '=', $value)
                            ->get();
                    }
                }
            } else {
                if ($value != "") {
                    $user = DB::table($tableName1)
                        ->where($fieldName, '=', $value)
                        ->get();
                    if (count($user) == 0) {
                        $user = DB::table($tableName2)
                            ->where($fieldName, '=', $value)
                            ->get();
                    }
                }
            }
            $countVal = count($user);
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return count($user);
    }

    public function dateFormat($date)
    {
        if (!isset($date) || $date == null || $date == "" || $date == "0000-00-00") {
            return "0000-00-00";
        } else {
            $dateArray = explode('-', $date);
            if (sizeof($dateArray) == 0) {
                return;
            }
            $newDate = $dateArray[2] . "-";

            $monthsArray = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $mon = 1;
            $mon += array_search(ucfirst($dateArray[1]), $monthsArray);

            if (strlen($mon) == 1) {
                $mon = "0" . $mon;
            }
            return $newDate .= $mon . "-" . $dateArray[0];
        }
    }

    public function humanDateFormat($date)
    {
        if ($date == null || $date == "" || $date == "0000-00-00" || $date == "0000-00-00 00:00:00") {
            return "";
        } else {
            $dateArray = explode('-', $date);
            $newDate = $dateArray[2] . "-";

            $monthsArray = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $mon = $monthsArray[$dateArray[1] - 1];

            return $newDate .= $mon . "-" . $dateArray[0];
        }
    }

    public function moneyFormatIndia($num)
    {
        $explrestunits = "";
        if (strlen($num) > 3) {
            $lastthree = substr($num, strlen($num) - 3, strlen($num));
            $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
            $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for ($i = 0; $i < sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if ($i == 0) {
                    $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i] . ",";
                }
            }
            $thecash = $explrestunits . $lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }

    public function checkNameValidation($request)
    {
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $fnct = $request['fnct'];
        $user = array();
        try {
            if (isset($fnct) && trim($fnct) !== '') {
                $fields = explode("##", $fnct);
                $primaryName = $fields[0];
                $primaryValue = trim($fields[1]);
                if ($value != "") {
                    $user = DB::table($tableName)
                        ->where($primaryName, '!=', $primaryValue)
                        ->where($fieldName, '=', $value)
                        ->get();
                }
            } else {
                if ($value != "") {
                    $user = DB::table($tableName)
                        ->where($fieldName, '=', $value)
                        ->get();
                }
            }
            $countVal = count($user);
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return count($user);
    }
    
    public function monthYear($start_date, $end_date)
    {
        $start    = new DateTime($start_date);
        $start->modify('first day of this month');
        $end      = new DateTime($end_date);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        $monthYear = array();
        foreach ($period as $dt) {
            $monthYear[] = $dt->format("M-Y");
        }
        return $monthYear;
    }

    public function changeStatus($request)
    {

        $tableName = $request['tableName'];
        $fieldIdName = $request['fieldIdName'];
        $fieldIdValue = $request['fieldIdValue'];
        $fieldName = $request['fieldName'];
        $fieldValue = $request['fieldValue'];
        try {
            if ($fieldValue != "") {
                $updateData = array($fieldName => $fieldValue);
                DB::table($tableName)
                ->where($fieldIdName, '=', $fieldIdValue)
                ->update($updateData);
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $fieldIdValue;
    }

    public function allowDisplay($resource,$view){
        $role = session('role');
        if ((isset($role[$resource][$view]) && (trim($role[$resource][$view]) == "deny")) || (!isset($role[$resource][$view]))){
              
           return false;
        }
        
        return true;
        
    }
    
    public function eventLog($event_type, $action, $resource,$id)
    {
        $eventData = array(
            'event_type' => $event_type,
            'action' => $action,
            'resource' => $resource,
            'user_id' => session('userId'),
            'action_id' => $id,
            'date_time' => date('Y-m-d H:i:s'),
            'ip_address' => request()->ip()
        );
        $eventResult = DB::table('track')->insert($eventData);
        return $eventResult;
    }
    
    public function getDateTime($timezone = 'Asia/Kolkata')
    {
        $date = new \DateTime('now', new \DateTimeZone($timezone));
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateAndTime($timezone = 'Asia/Kolkata')
    {
        $date = new \DateTime('now', new \DateTimeZone($timezone));
        return $date->format('d-M-Y-H-i-s');
    }
    
    public function addNewField($request)
    {
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $itemCat = $request['itemCat'];
        $sts = $request['sts'];
        $commonservice = new CommonService();
        // dd($request->all());
        $user = array();
        $opt = '';
        $data = array();
        $id = '';
        try {
            if ($value != "") {
                $user = DB::table($tableName)
                    ->where($fieldName, '=', $value)
                    ->get();
                }
                $countVal = count($user);
            // if($countVal == 0){
                
                if($tableName == 'item_categories'){
                    if($countVal == 0){
                        $id = DB::table($tableName)->insertGetId(
                            [$fieldName => $value,
                            $sts => 'active',
                            'created_on' => $commonservice->getDateTime(),
                            'created_by' => session('userId'),
                            ]
                        );
                        $data['id'] = $id;
                        $data['item'] = $value;
                    }
                    $item = DB::table($tableName)
                            ->where($sts,'=','active')
                            ->get();
                            
                    $opt = '';
                    foreach ($item as $items){
                        if($items->item_category_id == $id || $items->item_category==$value ){
                            $opt .= '<option value="'.$items->item_category_id.'" selected>'.$items->item_category.'</option>';
                        }
                        else{
                            $opt .= '<option value="'.$items->item_category_id.'">'.$items->item_category.'</option>';
                        }
                    }
                }
                else if($tableName == 'item_types'){
                    if($countVal == 0){
                        $id = DB::table($tableName)->insertGetId(
                            [$fieldName => $value,
                            'item_category' => $itemCat,
                            $sts => 'active',
                            'created_on' => $commonservice->getDateTime(),
                            'created_by' => session('userId'),
                            ]
                        );
                        $data['id'] = $id;
                        $data['item'] = $value;
                    }
                    $item = DB::table($tableName)
                    ->where($sts,'=','active')
                            ->get();
                            
                            $opt = '';
                    foreach ($item as $items){
                        if($items->item_type_id == $id || $items->item_type==$value ){
                            $opt .= '<option value="'.$items->item_type_id.'" selected>'.$items->item_type.'</option>';
                        }
                        else{
                            $opt .= '<option value="'.$items->item_type_id.'">'.$items->item_type.'</option>';
                        } 
                    }
                }
                else{
                    if($countVal == 0){
                        $id = DB::table($tableName)->insertGetId(
                            [$fieldName => $value,
                            $sts => 'active',
                            'created_on' => $commonservice->getDateTime(),
                            'created_by' => session('userId'),
                            ]
                        );
                        $data['id'] = $id;
                        $data['item'] = $value;
                    }
                    $item = DB::table($tableName)
                            ->where($sts,'=','active')
                            ->get();

                            $opt = '';
                            
                            if($tableName == 'units_of_measure'){
                        foreach ($item as $items){
                            if($items->uom_id == $id || $items->unit_name==$value ){
                                $opt .= '<option value="'.$items->uom_id.'" selected>'.$items->unit_name.'</option>';
                            }
                            else{
                                $opt .= '<option value="'.$items->uom_id.'">'.$items->unit_name.'</option>';
                            }
                        }
                    }
                    else if($tableName == 'brands'){
                        foreach ($item as $items){
                            if($items->brand_id == $id || $items->brand_name==$value ){
                                $opt .= '<option value="'.$items->brand_id.'" selected>'.$items->brand_name.'</option>';
                            }
                            else{
                                $opt .= '<option value="'.$items->brand_id.'">'.$items->brand_name.'</option>';
                            }
                        }
                    }
                }
                $data['option'] = $opt;

                // }
                // dd($countVal);
            } catch (Exception $exc) {
                error_log($exc->getMessage());
            }
            return $data;
    }
    
    public function addNewUnitField($request)
    {
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $item = $request['item'];
        $sts = $request['sts'];
        $commonservice = new CommonService();
        // dd($request->all());
        $user = array();
        $opt = '';
        $data = array();
        $id = '';
        try {
            if ($value != "") {
                $user = DB::table($tableName)
                ->where($fieldName, '=', $value)
                ->get();
            }
            $countVal = count($user);
            if($countVal == 0){
                    $id = DB::table($tableName)->insertGetId(
                        [$fieldName => $value,
                        $sts => 'active',
                        'item' => $item,
                        'created_on' => $commonservice->getDateTime(),
                        'created_by' => session('userId'),
                        ]
                    );
                    $data['id'] = $id;
                    $data['item'] = $value;
                }
                $item = DB::table($tableName)
                ->where($sts,'=','active')
                        ->get();
                        
                $opt = '';
                
                if($tableName == 'units_of_measure'){
                    foreach ($item as $items){
                        if($items->uom_id == $id ||$items->unit_name==$value ){
                            $opt .= '<option value="'.$items->uom_id.'" selected>'.$items->unit_name.'</option>';
                        }
                        else{
                            $opt .= '<option value="'.$items->uom_id.'">'.$items->unit_name.'</option>';
                        }
                    }
                }
                
            $data['option'] = $opt;
            
            // dd($countVal);
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $data;
    }
    
    public function updatePassword($params,$id){
        DB::beginTransaction();
    	try {
            // if(session('loginType')=='users'){
                $model = new UserTable();
                $addUser = $model->updatePassword($params,$id);
                return $addUser;
                // dd($addUser);
                
            //}
             if(session('loginType')=='vendor'){
                $model = new VendorsTable();
                $addVendors = $model->updatePassword($params,$id);
                if($addVendors>0){
                    DB::commit();
                    $msg = 'Password Updated Successfully';
                    return $msg;
                }else{
                    // dd('addVendors');
                    $msg = '1';
                    return $msg;
                }
            }
	    }
	    catch (Exception $exc) {
            DB::rollBack();
	    	$exc->getMessage();
	    }
    }
    

    public function addNewBranchType($request)
    {
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $sts = $request['sts'];
        $commonservice = new CommonService();
        // dd($request->all());
        $user = array();
        $opt = '';
        $data = array();
        $id = '';
        try {
            if ($value != "") {
                $user = DB::table($tableName)
                ->where($fieldName, '=', $value)
                ->get();
            }
            $countVal = count($user);
            if($countVal == 0){
                    $id = DB::table($tableName)->insertGetId(
                        [$fieldName => $value,
                        $sts => 'active',
                        ]
                    );
                    $data['id'] = $id;
                    $data['item'] = $value;
                }
                $item = DB::table($tableName)
                ->where($sts,'=','active')
                ->get();
                
                $opt = '';
                foreach ($item as $items){
                    if($items->branch_type_id == $id ||$items->branch_type==$value ){
                        $opt .= '<option value="'.$items->branch_type_id.'" selected>'.$items->branch_type.'</option>';
                    }
                        else{
                            $opt .= '<option value="'.$items->branch_type_id.'">'.$items->branch_type.'</option>';
                        }
                    }
                    $data['option'] = $opt;
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $data;
    }

    public function checkItemNameValidation($request)
    {
        $itemName = trim($request['itemName']);
        $itemTypeId = trim($request['itemTypeId']);
        $brandId = trim($request['brandId']);
        $unitId = trim($request['unitId']);
        $primaryValue = $request['fnct'];
        $items = array();
        try {
            if (isset($primaryValue) && trim($primaryValue) !== '') {
                  $items = DB::table('items')
                    ->where('item_name','=',$itemName)
                    ->where('item_type','=',$itemTypeId)
                    ->where('brand','=',$brandId)
                    ->where('base_unit','=',$unitId)
                    ->where('item_id','!=',$primaryValue)
                    ->get();
            
            } else {
                $items = DB::table('items')
                ->where('item_name','=',$itemName)
                ->where('item_type','=',$itemTypeId)
                ->where('brand','=',$brandId)
                ->where('base_unit','=',$unitId)
                ->get();
            }
            
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return count($items);
    }
}
