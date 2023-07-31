<?php

namespace App\Model\TestSite;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\ProvinceService;
use App\Service\DistrictService;
use Illuminate\Support\Facades\Session;

class TestSiteTable extends Model
{
    protected $table = 'test_sites';

    //add TestSite
    public function saveTestSite($request)
    {
        //to get all request values
        $userId = null;
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        $latLng=$this->getLatitudeLongitude($data);
        if ($request->input('siteName') != null && trim($request->input('siteName')) != '') {
            $id = DB::table('test_sites')->insertGetId(
                [
                    'site_ID' => $data['siteId'],
                    'site_name' => $data['siteName'],
                    'site_latitude' => $latLng['lat'],
                    'site_longitude' => $latLng['lng'],
                    'site_address1' => $data['address1'],
                    'site_address2' => $data['address2'],
                    'site_postal_code' => $data['postalCode'],
                    'site_city' => $data['city'],
                    'site_country' => $data['country'],
                    'test_site_status' => $data['testSiteStatus'],
                    'facility_id' => $data['facilityId'],
                    'site_province' => $data['provincesssId'],
                    'site_district' => $data['districtId'],
                    'site_sub_district' => $data['subDistrictId'],
                    'created_by' => session('userId'),
                    'created_on' => $commonservice->getDateTime(),
                ]
            );
            $commonservice->eventLog('add-test-site-request', $user_name . ' has added the test site information for ' . $data['siteName'] . ' Name', 'test-site',$userId);
        }

        return $id;
    }

    private function getLatitudeLongitude($data){

        $commonservice = new CommonService();
        $provinceservice = new ProvinceService();
        $districtservice = new DistrictService();
        $latLng=array();

        $latLng['lat']=$data['latitude'];
        $latLng['lng']=$data['longitude'];   
        
        if($latLng['lat']=='' || $latLng['lng']==''){
            $address='';
            
                if(!empty($data["address1"])){
                    $address.=$data["address1"].",";
                }
                if(!empty($data['address2'])){
                    $address.=$data['address2'].',';
                }
                if(!empty($data['city'])){
                    $address.=$data['city'].',';
                }
                if(!empty($data['provincesssId'])){
                    $provinceId = base64_encode($data['provincesssId']);
                    $address.=$provinceservice->getProvinceById($provinceId)[0]->province_name.',';
                }
                if(!empty($data['districtId'])){
                    $districtid = base64_encode($data['districtId']);
                    $address.=$districtservice->getDistrictById($districtid)[0]->district_name.',';
                }
                if(!empty($data['postalCode'])){
                    $address.=$data['postalCode'];
                }
                if(!empty($data['country'])){
                    $address.=$data['country'];
                }
                //echo 'formatted address '.$address.'<br>';
                $formattedAddress=str_replace(' ', '+', $address);
                
                if($formattedAddress!=''){
            
                    $latLng=$commonservice->getSiteLatLon($formattedAddress);
                }                
                
        }
        return $latLng;
        
    }

    // Fetch All TestSite List
    public function fetchAllTestSite()
    {
        $data = DB::table('test_sites')
            ->leftjoin('facilities', 'facilities.facility_id', '=', 'test_sites.facility_id')
            ->leftjoin('districts', 'districts.district_id', '=', 'test_sites.site_district')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'test_sites.site_province')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'test_sites.site_sub_district')
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
        $userId = null;
        $user_name = session('name');
        $commonservice = new CommonService();
        $data = $params->all();
        $latLng=$this->getLatitudeLongitude($data);
        $testData = array(
            'site_ID' => $data['siteId'],
            'site_name' => $data['siteName'],
            'site_latitude' => $latLng['lat'],
            'site_longitude' => $latLng['lng'],
            'site_address1' => $data['address1'],
            'site_address2' => $data['address2'],
            'site_postal_code' => $data['postalCode'],
            'site_city' => $data['city'],
            'site_country' => $data['country'],
            'test_site_status' => $data['testSiteStatus'],
            'facility_id' => $data['facilityId'],
            'site_province' => $data['provincesssId'],
            'site_district' => $data['districtId'],
            'site_sub_district' => $data['subDistrictId'],
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
            $commonservice->eventLog('update-test-site-request', $user_name . ' has updated the test site information for ' . $data['siteName'] . ' Name', 'test-site',$userId);
        }
        return $response;
    }

    // Fetch Current User Active TestSite List
    public function fetchAllCurrentUserActiveTestSite()
    { 
        if(Session::get('tsId')!='') {
        $data = DB::table('test_sites')
            ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'test_sites.ts_id')
            ->whereIn('users_testsite_map.ts_id', Session::get('tsId'))
            ->get();
        }
            else {
                $data = DB::table('test_sites')
            ->where('test_site_status', '=', 'active')
            ->get();
            }
        return $data;
    }

    //Fetch some particular test site values
    public function fetchTestSiteData($id)
    {
         
        $data = DB::table('test_sites')
            ->select('monthly_reports.site_manager', 'monthly_reports.tester_name', 'monthly_reports.contact_no','test_sites.ts_id', 'test_sites.site_id', 'test_sites.site_latitude', 'test_sites.site_longitude', 'test_sites.site_province', 'provinces.province_name','provinces.province_id',  'districts.district_name','districts.district_id',  'sub_districts.sub_district_name','sub_districts.sub_district_id')
            ->leftjoin('monthly_reports', 'monthly_reports.ts_id', '=', 'test_sites.ts_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'test_sites.site_province')
            ->leftjoin('districts', 'districts.district_id', '=', 'test_sites.site_district')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'test_sites.site_sub_district')
            ->where('test_sites.ts_id', '=', $id)
            ->orWhere('monthly_reports.ts_id', '=', $id)
            ->orderBy('mr_id', 'desc')
            ->limit(1)
            ->get();            
        return $data;
    }

    //Fetch some particular site district values
    public function fetchDistrictId($id)
    {
        $data = DB::table('test_sites')
            ->select('site_district')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_district');
        return $data;
    }
    //Fetch some particular site sub district values
    public function fetchSubDistrictId($id)
    {
        $data = DB::table('test_sites')
            ->select('site_Sub_district')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_Sub_district');
        return $data;
    }

    //Fetch some particular latitude values
    public function fetchLatitudeValue($id)
    {
        $data = DB::table('test_sites')
            ->select('site_latitude')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_latitude');
        return $data;
    }
    //Fetch some particular longitude values
    public function fetchLongitudeValue($id)
    {
        $data = DB::table('test_sites')
            ->select('site_longitude')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_longitude');
        return $data;
    }
}
