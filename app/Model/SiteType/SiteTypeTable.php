<?php

namespace App\Model\SiteType;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class SiteTypeTable extends Model
{
    protected $table = 'site_types';

    //add SiteType
    public function saveSiteType($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        if ($request->input('siteTypeName')!=null && trim($request->input('siteTypeName')) != '') {
            $id = DB::table('site_types')->insertGetId(
                [
                'site_type_name' => $data['siteTypeName'],
                'site_type_status' => $data['siteTypeStatus'],
                ]
            );
        }

        return $id;
    }

    // Fetch All SiteType List
    public function fetchAllSiteType()
    {
        $data = DB::table('site_types')
                ->get();
        return $data;
    }

    // Fetch All Active SiteType List
    public function fetchAllActiveSiteType()
    {
        $data = DB::table('site_types')
                ->where('site_type_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular SiteType details
     public function fetchSiteTypeById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('site_types')
                ->where('site_types.st_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular SiteType details
    public function updateSiteType($params,$id)
    {
        $data = $params->all();
            $upData = array(
                'site_type_name' => $data['siteTypeName'],
                'site_type_status' => $data['siteTypeStatus'],
            );
            $response = DB::table('site_types')
                ->where('st_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
        return $response;
    }

    
}
