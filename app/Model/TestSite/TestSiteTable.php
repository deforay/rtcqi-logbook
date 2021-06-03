<?php

namespace App\Model\TestSite;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class TestSiteTable extends Model
{
    protected $table = 'test_sites';

    //add TestSite
    public function saveTestSite($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        if ($request->input('siteName')!=null && trim($request->input('siteName')) != '') {
            $id = DB::table('test_sites')->insertGetId(
                ['site_ID' => $data['siteId'],
                'site_name' => $data['siteName'],
                'site_latitude' => $data['latitude'],
                'site_longitude' => $data['longitude'],
                'site_address1' => $data['address1'],
                'site_address2' => $data['address2'],
                'site_postal_code' => $data['postalCode'],
                'site_city' => $data['city'],
                'site_state' => $data['state'],
                'site_country' => $data['country'],
                'test_site_status' => $data['testSiteStatus'],
                'facility_id' => $data['facilityId'],
                'created_by' => session('userId'),
                'created_on' => $commonservice->getDateTime(),
                ]
            );
        }

        return $id;
    }

    // Fetch All TestSite List
    public function fetchAllTestSite()
    {
        $data = DB::table('test_sites')
                ->join('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
                ->get();
        return $data;
    }

    // Fetch All Active TestSite List
    public function fetchAllActiveTestSite()
    {
        $data = DB::table('test_sites')
                ->where('test_site_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular TestSite details
     public function fetchTestSiteById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('test_sites')
                ->where('test_sites.ts_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular TestSite details
    public function updateTestSite($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
            $testData = array(
                'site_ID' => $data['siteId'],
                'site_name' => $data['siteName'],
                'site_latitude' => $data['latitude'],
                'site_longitude' => $data['longitude'],
                'site_address1' => $data['address1'],
                'site_address2' => $data['address2'],
                'site_postal_code' => $data['postalCode'],
                'site_city' => $data['city'],
                'site_state' => $data['state'],
                'site_country' => $data['country'],
                'test_site_status' => $data['testSiteStatus'],
                'facility_id' => $data['facilityId'],
                'updated_by' => session('userId'),
                'updated_on' => $commonservice->getDateTime()
            );
            $response = DB::table('test_sites')
                ->where('ts_id', '=',base64_decode($id))
                ->update(
                        $testData
                    );
        return $response;
    }

    
}
