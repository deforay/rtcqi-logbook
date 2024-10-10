<?php

namespace App\Model\AllowedTestKit;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;
use App\Model\TestKit\TestKitTable;


class AllowedTestKitTable extends Model
{
    protected $table = 'allowed_testkits';

    //add AllowedKitTest
    public function saveAllowedTestKit($request)
    {
        //to get all request values
        $userId = null;
        $id = 0;
        $user_name = session('name');
        $commonservice = new CommonService();
        $data = $request->all();
        if ($data['testKitNo'] != null && trim($data['testKitNo']) != '') {
            foreach ($data['testKitName'] as $key => $val) {
                $id = DB::table('allowed_testkits')->insertOrIgnore(
                    [
                        'test_kit_no' => $data['testKitNo'],
                        'testkit_id' => $val,
                    ]
                ); 
            }
            $commonservice->eventLog('add-allowed-testkits-request', $user_name . ' has added the allowed testkits information for ' . $data['testKitNo'] . ' No', 'allowed-testkits',$userId);
        }
        return $id;
    }

    // Fetch All AllowedKitTest List
    public function fetchAllAllowedKitTest()
    {
        DB::enableQueryLog();
        // dd(DB::getQueryLog($data));die;
        return DB::table('allowed_testkits')
            ->select(DB::raw("group_concat(test_kits.test_kit_name) as test_kit_name, allowed_testkits.test_kit_no"))
            ->join('test_kits', 'test_kits.tk_id', '=', 'allowed_testkits.testkit_id')
            ->groupBy('allowed_testkits.test_kit_no')
            ->get();
    }

    // fetch particular AllowedKitTest details
    public function fetchAllowedKitTestByValue($id)
    {

        $id = base64_decode($id);
        return DB::table('allowed_testkits')
            ->where('allowed_testkits.test_kit_no', '=', $id)
            ->get();
    }

    // Update particular AllowedKitTest details
    public function updateAllowedTestKit($params, $id)
    {
        $userId = null;
        $data = $params->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        DB::delete('delete from allowed_testkits where test_kit_no = ?', [base64_decode($id)]);
        foreach ($data['testKitName'] as $key => $val) {
            $id = DB::table('allowed_testkits')->insertOrIgnore(
                [
                    'test_kit_no' => $data['testKitNo'],
                    'testkit_id' => $val,
                ]
            ); 
        }
        $commonservice->eventLog('update-allowed-testkits-request', $user_name . ' has updated the allowed testkits information for ' . $data['testKitNo'] . ' No', 'allowed-testkits',$userId);
        return $id;
    }

    public function fetchAllAllowedKitTestByNo($kitNo)
    {
        // dd($kitNo);die;
        $testKitList = array();
        $model = new TestKitTable();
        DB::enableQueryLog();
        $data = DB::table('allowed_testkits')
            ->select('allowed_testkits.*', 'test_kits.test_kit_name')
            ->join('test_kits', 'test_kits.tk_id', '=', 'allowed_testkits.testkit_id')
            ->where('allowed_testkits.test_kit_no', '<=', $kitNo)
            ->where('test_kits.test_kit_status', '=', 'active')
            ->get();
        // dd(DB::getQueryLog($data));die;
        // dd($data);die;
        foreach ($data as $row) {
            $testKitList[$row->test_kit_no][$row->testkit_id] = $row->test_kit_name;
            // $testKitList['name'][$row->test_kit_no] = $row->test_kit_name;?
        }
        // dd($testKitList);die;

        // if(sizeof($data) == 0)
        // {
        //     $data=$model->fetchAllActiveTestKit();
        // }
        return $testKitList;
    }
}
