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
        $data = $request->all();
        if ($request->input('districtName')!=null && trim($request->input('districtName')) != '') {
            $id = DB::table('districts')->insertGetId(
                [
                'district_name' => $data['districtName'],
                'provincesss_id' => $data['provinceId'],
                ]
            );
        }

        return $id;
    }

    // Fetch All District List
    public function fetchAllDistrict()
    {
        $data = DB::table('districts')
                ->join('provinces', 'provi7nces.provincesss_id', '=', 'districts.provincesss_id')
                ->get();
        return $data;
    }

     // fetch particular District details
     public function fetchDistrictById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('districts')
                ->where('districts.district_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular District details
    public function updateDistrict($params,$id)
    {
        $data = $params->all();
            $upData = array(
                'district_name' => $data['districtName'],
                'provincesss_id' => $data['provinceId'],
            );
            $response = DB::table('districts')
                ->where('district_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
        return $response;
    }

    
}
