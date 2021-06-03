<?php

namespace App\Model\AllowedTestKit;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

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
        $data = DB::table('allowed_testkits')
            ->select(DB::raw("group_concat(test_kits.test_kit_name) as test_kit_name, allowed_testkits.test_kit_no"))
            ->join('test_kits', 'test_kits.tk_id', '=', 'allowed_testkits.testkit_id')
            ->groupBy('allowed_testkits.testkit_id')
            ->get();
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
}