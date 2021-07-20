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
        $id = 0;
        $data = $request->all();

        if ($request->input('testKitNo') != null && trim($request->input('testKitNo')) != '') {

            for ($x = 0; $x < count($data['testKitName']); $x++) {
                $id = DB::table('allowed_testkits')->insert(
                    [
                        'test_kit_no' => $data['testKitNo'],
                        'testkit_id' => $data['testKitName'][$x],
                    ]
                );
            }
        }
        return $id;
    }

    // Fetch All AllowedKitTest List
    public function fetchAllAllowedKitTest()
    {
        DB::enableQueryLog();
        $data = DB::table('allowed_testkits')
            ->select(DB::raw("group_concat(test_kits.test_kit_name) as test_kit_name, allowed_testkits.test_kit_no"))
            ->join('test_kits', 'test_kits.tk_id', '=', 'allowed_testkits.testkit_id')
            ->groupBy('allowed_testkits.test_kit_no')
            ->get();
        // dd(DB::getQueryLog($data));die;
        return $data;
    }

    // fetch particular AllowedKitTest details
    public function fetchAllowedKitTestByValue($id)
    {

        $id = base64_decode($id);
        $data = DB::table('allowed_testkits')
            ->where('allowed_testkits.test_kit_no', '=', $id)
            ->get();
        return $data;
    }

    // Update particular AllowedKitTest details
    public function updateAllowedTestKit($params, $id)
    {
        $data = $params->all();
        DB::delete('delete from allowed_testkits where test_kit_no = ?',[base64_decode($id)]);
        for ($x = 0; $x < count($data['testKitName']); $x++) {
            $id = DB::table('allowed_testkits')->insert(
                [
                    'test_kit_no' => $data['testKitNo'],
                    'testkit_id' => $data['testKitName'][$x],
                ]
            );
        }

        return $id;
    }

    public function fetchAllAllowedKitTestByNo($kitNo)
    {
        // dd($kitNo);die;
        $testKitList = array();
        $model = new TestKitTable();
        DB::enableQueryLog();
        $data = DB::table('allowed_testkits')
            ->select('allowed_testkits.*','test_kits.test_kit_name')
            ->join('test_kits', 'test_kits.tk_id', '=', 'allowed_testkits.testkit_id')
            ->where('allowed_testkits.test_kit_no' ,'<=',$kitNo)
            ->where('test_kits.test_kit_status', '=' ,'active')
            ->get();
        // dd(DB::getQueryLog($data));die;
        // dd($data);die;
        foreach($data as $row)
        {
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