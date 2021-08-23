<?php

namespace App\Model\Province;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class ProvinceTable extends Model
{
    protected $table = 'provinces';

    //add Province
    public function saveProvince($request)
    {
        //to get all request values
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        if ($request->input('provinceName')!=null && trim($request->input('provinceName')) != '') {
            $id = DB::table('provinces')->insertGetId(
                [
                'province_name' => $data['provinceName'],
                'province_status' => $data['provinceStatus'],
                ]
            );
            $userTracking = DB::table('track')->insertGetId(
                [
                    'event_type' => 'add-province-request',
                    'action' => $user_name . ' has added the province information for ' . $data['provinceName'] . ' Name',
                    'resource' => 'province',
                    'date_time' => $commonservice->getDateTime(),
                    'ip_address' => request()->ip(),
                ]
            );
        }

        return $id;
    }

    // Fetch All Province List
    public function fetchAllProvince()
    {
        $data = DB::table('provinces')
                ->get();
        return $data;
    }

    // Fetch All Active Province List
    public function fetchAllActiveProvince()
    {
        $data = DB::table('provinces')
                ->where('province_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular Province details
     public function fetchProvinceById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('provinces')
                ->where('provinces.province_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular Province details
    public function updateProvince($params,$id)
    {
        $data = $params->all();
        $user_name = session('name');
        $commonservice = new CommonService();
            $upData = array(
                'province_name' => $data['provinceName'],
                'province_status' => $data['provinceStatus'],
            );
            $response = DB::table('provinces')
                ->where('province_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
                    $userTracking = DB::table('track')->insertGetId(
                        [
                            'event_type' => 'update-province-request',
                            'action' => $user_name . ' has updated the province information for ' . $data['provinceName'] . ' Name',
                            'resource' => 'province',
                            'date_time' => $commonservice->getDateTime(),
                            'ip_address' => request()->ip(),
                        ]
                    );
        return $response;
    }

    
}
