<?php

namespace App\Model\TestKit;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class TestKitTable extends Model
{
    protected $table = 'test_kit_information';

    //add TestKit
    public function saveTestKit($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        if ($request->input('kit_name')!=null && trim($request->input('kit_name')) != '') {
            $expiry = $commonservice->dateFormat($data['kit_expiry_date']);
            $id = DB::table('test_kit_information')->insertGetId(
                ['test_kit_name_id' => $data['kit_name_id'],
                'test_kit_name_id_1' => $data['kit_name_id1'],
                'test_kit_name_short' => $data['kit_name_short'],
                'test_kit_name' => $data['kit_name'],
                'test_kit_comments' => $data['kit_name_comments'],
                'test_kit_manufacturer' => $data['kit_manufacturer'],
                'test_kit_expiry_date' => $expiry,
                'Installation_id' => $data['installation_id'],
                'test_kit_status' => $data['testKitStatus'],
                'created_by' => session('userId'),
                'created_on' => $commonservice->getDateTime(),
                ]
            );
        }

        return $id;
    }

    // Fetch All TestKit List
    public function fetchAllTestKit()
    {
        $data = DB::table('test_kit_information')
                ->get();
        return $data;
    }

    // Fetch All Active TestKit List
    public function fetchAllActiveTestKit()
    {
        $data = DB::table('test_kit_information')
                ->where('test_kit_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular TestKit details
     public function fetchTestKitById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('test_kit_information')
                ->where('test_kit_information.tk_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular TestKit details
    public function updateTestKit($params,$id)
    {
        $commonservice = new CommonService();
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
                'Installation_id' => $data['installation_id'],
                'test_kit_status' => $data['testKitStatus'],
                'updated_by' => session('userId'),
                'updated_on' => $commonservice->getDateTime()
            );
            $response = DB::table('test_kit_information')
                ->where('tk_id', '=',base64_decode($id))
                ->update(
                        $testData
                    );
        return $response;
    }

    
}
