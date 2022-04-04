<?php

namespace App\Model\UserFacilityMap;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class UserFacilityMapTable extends Model
{
    protected $table = 'users_facility_map';

    //add District
    public function saveUserFacility($request)
    {
        //to get all request values
        $id = 0;
        $data = $request->all();

        if ($request->input('userId') != null && trim($request->input('userId')) != '') {
            for ($x = 0; $x < count($data['facilityId']); $x++) {
                // echo($data['facilityId'][$x]);
                $id = DB::table('users_facility_map')->insertGetId(
                    [
                        'user_id' => $data['userId'],
                        'facility_id' => $data['facilityId'][$x],
                    ]
                );
            }
        }
        // die;
        return $id;
    }

    // Fetch All UserFacilityMap List
    public function fetchAllUserFacility()
    {
        // $response = array();
        // $data = DB::table('users_facility_map')
        //         ->join('users', 'users.user_id', '=', 'users_facility_map.user_id')
        //         ->join('facilities', 'facilities.facility_id', '=', 'users_facility_map.facility_id')
        //         ->get();
        // dd($data);die;
        // foreach($data as $value) {
        //     $response[$value['first_name'].' '.$value['last_name']] = $value['facility_name'].',';
        // }
        // $i=0;
        // foreach($response as $key => $row) {
        //     $return[$i]['first_name'] = $key;
        //     $return[$i]['facility_name'] = $row;
        //     $i++;
        // }
        // dd($data);die;
        $data = DB::table('users_facility_map')
            ->select(DB::raw("group_concat(facilities.facility_name) as facility_name,CONCAT_WS(' ', users.first_name, users.last_name) as user_name,users_facility_map.ufm_id"))
            ->join('users', 'users.user_id', '=', 'users_facility_map.user_id')
            ->join('facilities', 'facilities.facility_id', '=', 'users_facility_map.facility_id')
            ->groupBy('users_facility_map.user_id')
            ->get();
        return $data;
    }

    // fetch particular UserFacility details
    public function fetchUserFacilityById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('users_facility_map')
            ->where('users_facility_map.ufm_id', '=', $id)
            ->get();
        return $data;
    }

    // Update particular UserFacility details
    public function updateUserFacility($params, $id)
    {
        $data = $params->all();
        $facilityId = implode(',', $data['facilityId']);
        $upData = array(
            'user_id' => $data['userId'],
            'facility_id' => $facilityId,
        );
        $response = DB::table('users_facility_map')
            ->where('ufm_id', '=', base64_decode($id))
            ->update(
                $upData
            );
        return $response;
    }
    public function fetchUserSiteById($id)
    {
        $data = DB::table('users_testsite_map')
            ->join('test_sites', 'test_sites.ts_id', '=', 'users_testsite_map.ts_id')
            ->where('users_testsite_map.user_id', '=', base64_decode($id))
            ->get();
        return $data;
    }
}
