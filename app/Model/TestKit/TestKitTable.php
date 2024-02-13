<?php

namespace App\Model\TestKit;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\GlobalConfigService;
use Illuminate\Support\Facades\Session;

class TestKitTable extends Model
{
    protected $table = 'test_kits';

    //add TestKit
    public function saveTestKit($request)
    {
        //to get all request values
        $userId = null;
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        if ($request->input('kit_name') != null && trim($request->input('kit_name')) != '') {
            $expiry = $commonservice->dateFormat($data['kit_expiry_date']);
            $id = DB::table('test_kits')->insertGetId(
                [
                    'test_kit_name_id' => $data['kit_name_id'],
                    'test_kit_name_id_1' => $data['kit_name_id1'],
                    'test_kit_name_short' => $data['kit_name_short'],
                    'test_kit_name' => $data['kit_name'],
                    'test_kit_comments' => $data['kit_name_comments'],
                    'test_kit_manufacturer' => $data['kit_manufacturer'],
                    'test_kit_expiry_date' => $expiry,
                    'test_kit_status' => $data['testKitStatus'],
                    'created_by' => session('userId'),
                    'created_on' => $commonservice->getDateTime(),
                ]
            );
            $commonservice->eventLog('add-test-kit-request', $user_name . ' has added the test kit information for ' . $data['kit_name'] . ' Name', 'test-kit',$userId);
        }

        return $id;
    }

    // Fetch All TestKit List
    public function fetchAllTestKit()
    {
        $data = DB::table('test_kits')
            ->get();
    
            return $data;
    }

    // Fetch All Active TestKit List
    public function fetchAllActiveTestKit()
    {
        $data = DB::table('test_kits')
            ->where('test_kit_status', '=', 'active')
            ->get();
        return $data;
    }

    // Fetch All Active TestKit List
        public function fetchAllTestKitSummary($params)
        {
            $commonservice = new CommonService();
            $start_date = '';
            $end_date = '';

            if (isset($params['searchDate']) && $params['searchDate'] != '') {
                $sDate = explode("to", $params['searchDate']);
                if (isset($sDate[0]) && trim($sDate[0]) != "") {
                    $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                    $start_date = $commonservice->dateFormat(trim($monthYr));
                }
                if (isset($sDate[1]) && trim($sDate[1]) != "") {
                    $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                    $end_date = $commonservice->dateFormat(trim($monthYr2));
                }
            }
            $GlobalConfigService = new GlobalConfigService();
            $kitNo = $GlobalConfigService->getGlobalConfigValue('no_of_test');

            $data = DB::table('test_kits')->where('test_kit_status', '=', 'active')->get();
            $summary = array();
            $query = DB::table('monthly_reports_pages');
            if (trim($start_date) != "" && trim($end_date) != "") {
                $query = $query->where(function ($query) use ($start_date, $end_date) {
                    $query->where('monthly_reports_pages.start_test_date', '>=', $start_date)
                        ->where('monthly_reports_pages.end_test_date', '<=', $end_date);
                });
            }
            $records = $query->get();

            for ($i = 0; $i < sizeof($data); $i++) {
                //print_r($data);exit();
                $summary[$i]['test_kit_id'] = $data[$i]->tk_id;
                $summary[$i]['test_kit_name'] = $data[$i]->test_kit_name;

                $summary[$i]['test_kit_total'] = 0;

                for ($j = 1; $j <= $kitNo; $j++) {
                    $summary[$i]['test_kit_'.$j.'_total']=$records->where('test_' . $j . '_kit_id', (int) $data[$i]->tk_id)->count();
                    $summary[$i]['test_kit_total'] += $records->where('test_' . $j . '_kit_id', (int) $data[$i]->tk_id)->count();
                }

            }
            array_multisort(
                array_map(
                    static function ($element) {
                        return $element['test_kit_total'];
                    },
                    $summary
                ),
                SORT_DESC,
                $summary
            );
            return $summary;

        }


    // fetch particular TestKit details
    public function fetchTestKitById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('test_kits')
            ->where('test_kits.tk_id', '=', $id)
            ->get();
        return $data;
    }

    // Update particular TestKit details
    public function updateTestKit($params, $id)
    {
        $commonservice = new CommonService();
        $userId = null;
        $user_name = session('name');
        $data = $params->all();
        $expiry = $commonservice->dateFormat($data['kit_expiry_date']);
        $testData = array(
            'test_kit_name_id' => $data['kit_name_id'],
            'test_kit_name_id_1' => $data['kit_name_id1'],
            'test_kit_name_short' => $data['kit_name_short'],
            'test_kit_name' => $data['kit_name'],
            'test_kit_comments' => $data['kit_name_comments'],
            'test_kit_manufacturer' => $data['kit_manufacturer'],
            'test_kit_expiry_date' => $expiry,
            'test_kit_status' => $data['testKitStatus'],
            'updated_by' => session('userId')
        );
        $response = DB::table('test_kits')
            ->where('tk_id', '=', base64_decode($id))
            ->update(
                $testData
            );
        if ($response == 1) {
            $response = DB::table('test_kits')
                ->where('tk_id', '=', base64_decode($id))
                ->update(
                    array(
                        'updated_on' => $commonservice->getDateTime()
                    )
                );
            $commonservice->eventLog('update-test-kit-request', $user_name . ' has updated the test kit information for ' . $data['kit_name'] . ' Name', 'test-kit',$userId);
        }
        return $response;
    }
}
