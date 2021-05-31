<?php

namespace App\Model\District;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class DistrictTable extends Model
{
    protected $table = 'district';

    //add District
    public function saveDistrict($request)
    {
        //to get all request values
        $data = $request->all();
        if ($request->input('districtName')!=null && trim($request->input('districtName')) != '') {
            $id = DB::table('district')->insertGetId(
                [
                'district_name' => $data['districtName'],
                'province_id' => $data['provinceId'],
                ]
            );
        }

        return $id;
    }

    // Fetch All District List
    public function fetchAllDistrict()
    {
        $data = DB::table('district')
                ->join('province', 'province.province_id', '=', 'district.province_id')
                ->get();
        return $data;
    }

     // fetch particular District details
     public function fetchDistrictById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('district')
                ->where('district.district_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular District details
    public function updateDistrict($params,$id)
    {
        $data = $params->all();
            $upData = array(
                'district_name' => $data['districtName'],
                'province_id' => $data['provinceId'],
            );
            $response = DB::table('district')
                ->where('district_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
        return $response;
    }

    
}
