<?php

namespace App\Model\District;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class DistrictTable extends Model
{
    protected $table = 'districts';

    //add District
    public function saveDistrict($request)
    {
        //to get all request values
        $user_name = session('name');
        $commonservice = new CommonService();
        $data = $request->all();
        if ($request->input('districtName') != null && trim($request->input('districtName')) != '') {
            $id = DB::table('districts')->insertGetId(
                [
                    'district_name' => $data['districtName'],
                    'provincesss_id' => $data['provinceId'],
                ]
            );
            $userTracking = DB::table('track')->insertGetId(
                [
                    'event_type' => 'add-district-request',
                    'action' => $user_name . ' has added the district information for ' . $data['districtName'] . ' Name',
                    'resource' => 'district',
                    'date_time' => $commonservice->getDateTime(),
                    'ip_address' => request()->ip(),
                ]
            );
        }

        return $id;
    }

    // Fetch All District List
    public function fetchAllDistrict()
    {
        $data = DB::table('districts')
            ->join('provinces', 'provinces.province_id', '=', 'districts.provincesss_id')
            ->get();
        return $data;
    }

    // fetch particular District details
    public function fetchDistrictById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('districts')
            ->where('districts.district_id', '=', $id)
            ->get();
        return $data;
    }

    // Update particular District details
    public function updateDistrict($params, $id)
    {
        $data = $params->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        $upData = array(
            'district_name' => $data['districtName'],
            'provincesss_id' => $data['provinceId'],
        );
        $response = DB::table('districts')
            ->where('district_id', '=', base64_decode($id))
            ->update(
                $upData
            );
        $userTracking = DB::table('track')->insertGetId(
            [
                'event_type' => 'update-district-request',
                'action' => $user_name . ' has updated the district information for ' . $data['districtName'] . ' Name',
                'resource' => 'district',
                'date_time' => $commonservice->getDateTime(),
                'ip_address' => request()->ip(),
            ]
        );
        return $response;
    }

    // fetch particular District Name
    public function fetchDistrictName($id)
    {
        $data = DB::table('districts')
            ->where('districts.provincesss_id', '=', $id)
            ->get();
        return $data;
    }

    public function fetchDistrictId($id)
    {
        $result = $id[0]->facility_province;
        $data = DB::table('districts')
            ->where('districts.provincesss_id', '=', $result)
            ->get();
        return $data;
    }

    public function fetchDistrictData($id)
    {
        $result = $id[0]->provincesss_id;
        $data = DB::table('districts')
            ->where('districts.provincesss_id', '=', $result)
            ->get();
        return $data;
    }
}
