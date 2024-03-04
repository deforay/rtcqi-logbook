<?php

namespace App\Model\SubDistrict;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class SubDistrictTable extends Model
{
    protected $table = 'sub_districts';

    //add Sub District
    public function saveSubDistrict($request)
    {
        //to get all request values
        $userId = null;
        $user_name = session('name');
        $commonservice = new CommonService();
        $data = $request->all();
        if ($request->input('subDistrictName') != null && trim($request->input('subDistrictName')) != '') {
            $id = DB::table('sub_districts')->insertGetId(
                [
                    'sub_district_name' => $data['subDistrictName'],
                    'sub_district_external_id' => $data['externalId'],
                    'sub_district_status' => $data['subDistrictStatus'],
                    'district_id' => $data['districtId'],
                ]
            );
            $commonservice->eventLog('add-sub-district-request', $user_name . ' has added the subdistrict information for ' . $data['subDistrictName'] . ' Name', 'subdistrict',$userId);
        }

        return $id;
    }

    // Fetch All Sub District List
    public function fetchAllSubDistrict()
    {
        return DB::table('sub_districts')
            ->join('districts', 'districts.district_id', '=', 'sub_districts.district_id')
            ->join('provinces', 'provinces.province_id', '=', 'districts.province_id')
            ->get();
    }

    // fetch particular Sub District details
    public function fetchSubDistrictById($id)
    {

        $id = base64_decode($id);
        return DB::table('sub_districts')
            ->where('sub_districts.sub_district_id', '=', $id)
            ->get();
    }

    // Update particular Sub District details
    public function updateSubDistrict($params, $id)
    {
        $userId = null;
        $data = $params->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        $upData = array(
            'sub_district_name' => $data['subDistrictName'],
            'sub_district_external_id' => $data['externalId'],
            'sub_district_status' => $data['subDistrictStatus'],
            'district_id' => $data['districtId'],
        );
        $response = DB::table('sub_districts')
            ->where('sub_district_id', '=', base64_decode($id))
            ->update(
                $upData
            );
        $commonservice->eventLog('update-sub-district-request', $user_name . ' has updated the subdistrict information for ' . $data['subDistrictName'] . ' Name', 'subdistrict',$userId);
        return $response;
    }

    // fetch particular Sub District Name
    public function fetchSubDistrictName($id)
    {
        return DB::table('sub_districts')
            ->where('sub_districts.district_id', '=', $id)
            ->get();
    }

    public function fetchSubDistrictNameByDistrictId($id)
    {
        return DB::table('sub_districts')
            ->whereIn('sub_districts.district_id', $id)
            ->get();
    }

    public function fetchSubDistrictData($id)
    {
        $result = $id[0]->site_district;
        return DB::table('sub_districts')
            ->where('sub_districts.district_id', '=', $result)
            ->get();
    }
    
}
