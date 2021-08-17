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
        $user_name = session('name');
        $commonservice = new CommonService();
        if ($request->input('siteName') != null && trim($request->input('siteName')) != '') {
            $id = DB::table('test_sites')->insertGetId(
                [
                    'site_ID' => $data['siteId'],
                    'site_name' => $data['siteName'],
                    'site_latitude' => $data['latitude'],
                    'site_longitude' => $data['longitude'],
                    'site_address1' => $data['address1'],
                    'site_address2' => $data['address2'],
                    'site_postal_code' => $data['postalCode'],
                    'site_city' => $data['city'],
                    'site_country' => $data['country'],
                    'test_site_status' => $data['testSiteStatus'],
                    'facility_id' => $data['facilityId'],
                    'provincesss_id' => $data['provincesssId'],
                    'district_id' => $data['districtId'],
                    'created_by' => session('userId'),
                    'created_on' => $commonservice->getDateTime(),
                ]
            );
            $userTracking = DB::table('track')->insertGetId(
                [
                    'event_type' => 'add-test-site-request',
                    'action' => $user_name . ' has added the test site information for ' . $data['siteName'] . ' Name',
                    'resource' => 'test-site',
                    'date_time' => $commonservice->getDateTime(),
                    'ip_address' => request()->ip(),
                ]
            );
        }

        return $id;
    }

    // Fetch All TestSite List
    public function fetchAllTestSite()
    {
        $data = DB::table('test_sites')
            ->leftjoin('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'test_sites.district_id')
            ->leftjoin('provinces', 'provinces.provincesss_id', '=', 'test_sites.provincesss_id')
            ->get();
        return $data;
    }

    // Fetch All Active TestSite List
    public function fetchAllActiveTestSite()
    {
        $data = DB::table('test_sites')
            ->where('test_site_status', '=', 'active')
            ->get();
        return $data;
    }

    // fetch particular TestSite details
    public function fetchTestSiteById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('test_sites')
            ->where('test_sites.ts_id', '=', $id)
            ->get();
        return $data;
    }

    // Update particular TestSite details
    public function updateTestSite($params, $id)
    {
        $user_name = session('name');
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
            'site_country' => $data['country'],
            'test_site_status' => $data['testSiteStatus'],
            'facility_id' => $data['facilityId'],
            'provincesss_id' => $data['provincesssId'],
            'district_id' => $data['districtId'],
            'updated_by' => session('userId')
        );
        $response = DB::table('test_sites')
            ->where('ts_id', '=', base64_decode($id))
            ->update(
                $testData
            );
        if ($response == 1) {
            $response = DB::table('test_sites')
                ->where('ts_id', '=', base64_decode($id))
                ->update(
                    array(
                        'updated_on' => $commonservice->getDateTime()
                    )
                );
            $userTracking = DB::table('track')->insertGetId(
                [
                    'event_type' => 'update-test-site-request',
                    'action' => $user_name . ' has updated the test site information for ' . $data['siteName'] . ' Name',
                    'resource' => 'test-site',
                    'date_time' => $commonservice->getDateTime(),
                    'ip_address' => request()->ip(),
                ]
            );
        }
        return $response;
    }

    // Fetch Current User Active TestSite List
    public function fetchAllCurrentUserActiveTestSite()
    {
        $user_id = session('userId');
        $data = DB::table('test_sites')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'test_sites.ts_id')
            ->where('users_testsite_map.user_id', '=', $user_id)
            ->where('test_site_status', '=', 'active')
            ->get();
        return $data;
    }

    public function fetchTestSiteData($id)
    {
        $data = DB::table('test_sites')
            ->select('test_sites.ts_id', 'test_sites.site_id', 'test_sites.site_latitude', 'test_sites.site_longitude', 'test_sites.provincesss_id', 'provinces.province_name')
            ->leftjoin('provinces', 'provinces.provincesss_id', '=', 'test_sites.provincesss_id')
            ->where('test_sites.ts_id', '=', $id)
            ->get();
        return $data;
    }

    public function fetchDistrictId($id)
    {
        $data = DB::table('test_sites')
            ->select('district_id')
            ->where('test_sites.ts_id', '=', $id)
            ->value('district_id');
        return $data;
    }

    public function fetchLatitudeValue($id)
    {
        $data = DB::table('test_sites')
            ->select('site_latitude')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_latitude');
        return $data;
    }
    public function fetchLongitudeValue($id)
    {
        $data = DB::table('test_sites')
            ->select('site_longitude')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_longitude');
        return $data;
    }
}
