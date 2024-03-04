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
        $userId = null;
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        if ($request->input('provinceName')!=null && trim($request->input('provinceName')) != '') {
            $id = DB::table('provinces')->insertGetId(
                [
                'province_name' => $data['provinceName'],
                'province_external_id' => $data['externalId'],
                'province_status' => $data['provinceStatus'],
                ]
            );
        $userId = null;
            $commonservice->eventLog('add-province-request', $user_name . ' has added the province information for ' . $data['provinceName'] . ' Name', 'province',$userId);
        }

        return $id;
    }

    // Fetch All Province List
    public function fetchAllProvince()
    {
        return DB::table('provinces')
                ->get();
    }

    // Fetch All Active Province List
    public function fetchAllActiveProvince()
    {
        return DB::table('provinces')
                ->where('province_status','=','active')
                ->get();
    }

     // fetch particular Province details
     public function fetchProvinceById($id)
     {

         $id = base64_decode($id);
         return DB::table('provinces')
                ->where('provinces.province_id', '=',$id )
                ->get();
     }

     // Update particular Province details
    public function updateProvince($params,$id)
    {
        $userId = null;
        $data = $params->all();
        $user_name = session('name');
        $commonservice = new CommonService();
            $upData = array(
                'province_name' => $data['provinceName'],
                'province_external_id' => $data['externalId'],
                'province_status' => $data['provinceStatus'],
            );
            $response = DB::table('provinces')
                ->where('province_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
            $commonservice->eventLog('update-province-request', $user_name . ' has updated the province information for ' . $data['provinceName'] . ' Name', 'province',$userId);
        return $response;
    }

    
}
