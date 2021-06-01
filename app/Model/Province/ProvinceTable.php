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
        $commonservice = new CommonService();
        if ($request->input('provinceName')!=null && trim($request->input('provinceName')) != '') {
            $id = DB::table('provinces')->insertGetId(
                [
                'province_name' => $data['provinceName'],
                'province_status' => $data['provinceStatus'],
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
                ->where('provinces.provincesss_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular Province details
    public function updateProvince($params,$id)
    {
        $data = $params->all();
            $upData = array(
                'province_name' => $data['provinceName'],
                'province_status' => $data['provinceStatus'],
            );
            $response = DB::table('provinces')
                ->where('provincesss_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
        return $response;
    }

    
}
