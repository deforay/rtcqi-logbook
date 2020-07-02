<?php

namespace App\Service;

use DB;
use Redirect;
use Illuminate\Support\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Hash;

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

        if (($fieldName == 'customer_phno' || $fieldName == 'mobile_no') && ($countVal == '0' || $countVal == '')) {
            if ($fieldName == 'customer_phno') {
                $employeeResult = DB::table('agent_keyperson')
                    ->where('mobile_no', '=', $value)
                    ->get();
                $countVal = count($employeeResult);
            } else {
                $customerResult = DB::table('customers')
                    ->where('customer_phno', '=', $value)
                    ->get();
                $countVal = count($customerResult);
            }
        }

        if (($fieldName == 'customer_email' || $fieldName == 'email') && ($countVal == '0' || $countVal == '')) {
            if ($fieldName == 'customer_email') {
                $employeeResult = DB::table('agent_keyperson')
                    ->where('email', '=', $value)
                    ->get();
                $countVal = count($employeeResult);
            } else {
                $customerResult = DB::table('customers')
                    ->where('customer_email', '=', $value)
                    ->get();
                $countVal = count($customerResult);
            }
        }

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
        dd($tableName);
        try {
            if ($fieldValue != "") {
                $updateData = array($fieldName => $fieldValue);
                DB::table($tableName)
                    ->where($fieldIdName, '=', $fieldIdValue)
                    ->update($updateData);

                //Event Log
                $commonservice = new CommonService();
                $commonservice->eventLog(session('userId'), $fieldIdValue, $tableName . '-' . $fieldValue, $tableName . ' changed to ' . $fieldValue, $tableName);
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $fieldIdValue;
    }


    public function eventLog($userId, $subjectId, $event_type, $action, $resource_name)
    {
        $eventData = array(
            'actor' => $userId,
            'subject' => $subjectId,
            'event_type' => $event_type,
            'action' => $action,
            'resource_name' => $resource_name,
            'added_on' => date('Y-m-d H:i:s')
        );
        $eventResult = DB::table('event_log')->insert($eventData);
        return $eventResult;
    }

    public function getDateTime($timezone = 'Asia/Calcutta')
    {
        $date = new \DateTime(date('Y-m-d H:i:s'), new \DateTimeZone($timezone));
        return $date->format('Y-m-d H:i:s');
    }
}
