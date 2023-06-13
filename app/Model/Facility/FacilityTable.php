<?php

namespace App\Model\Facility;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\ProvinceService;
use App\Service\DistrictService;
use Illuminate\Support\Facades\Session;

class FacilityTable extends Model
{
    protected $table = 'facilities';

    //add Facility
    public function saveFacility($request)
    {
        //to get all request values
        $userId = null;
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        $latLng=$this->getLatitudeLongitude($data);

        if ($request->input('facilityName') != null && trim($request->input('facilityName')) != '') {
            $id = DB::table('facilities')->insertGetId(
                [
                    'facility_name' => $data['facilityName'],
                    'facility_latitude' => $latLng['lat'],
                    'facility_longitude' => $latLng['lng'],
                    'facility_address1' => $data['address1'],
                    'facility_address2' => $data['address2'],
                    'facility_postal_code' => $data['postalCode'],
                    'facility_city' => $data['city'],
                    'facility_country' => $data['country'],
                    'contact_name' => $data['contactName'],
                    'contact_email' => $data['contactEmail'],
                    'contact_phoneno' => $data['contactPhone'],
                    'facility_status' => $data['facilityStatus'],
                    'facility_province' => $data['provincesssId'],
                    'facility_district' => $data['districtId'],
                    'created_by' => session('userId'),
                    'created_on' => $commonservice->getDateTime(),
                ]
            );
            $commonservice->eventLog('add-facility-request', $user_name . ' has added the facility information for ' . $data['facilityName'] . ' Name', 'facility',$userId);
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


    // Fetch All Facility List
    public function fetchAllFacility()
    {
        $data = DB::table('facilities')
            ->get();
        return $data;
    }

    // Fetch All Active Facility List
    public function fetchAllActiveFacility()
    {
        $data = DB::table('facilities')
            ->where('facility_status', '=', 'active')
            ->get();
        return $data;
    }

    // fetch particular Facility details
    public function fetchFacilityById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('facilities')
            ->where('facilities.facility_id', '=', $id)
            ->get();
        return $data;
    }

    // Update particular Facility details
    public function updateFacility($params, $id)
    {
        $userId = null;
        $commonservice = new CommonService();
        $user_name = session('name');
        $data = $params->all();
        $latLng=$this->getLatitudeLongitude($data);
        $testData = array(
            'facility_name' => $data['facilityName'],
            'facility_latitude' => $latLng['lat'],
            'facility_longitude' => $latLng['lng'],
            'facility_address1' => $data['address1'],
            'facility_address2' => $data['address2'],
            'facility_postal_code' => $data['postalCode'],
            'facility_city' => $data['city'],
            'facility_country' => $data['country'],
            'contact_name' => $data['contactName'],
            'contact_email' => $data['contactEmail'],
            'contact_phoneno' => $data['contactPhone'],
            'facility_status' => $data['facilityStatus'],
            'facility_province' => $data['provincesssId'],
            'facility_district' => $data['districtId'],
            'updated_by' => session('userId')
        );
        $response = DB::table('facilities')
            ->where('facility_id', '=', base64_decode($id))
            ->update(
                $testData
            );
        if ($response == 1) {
            $response = DB::table('facilities')
                ->where('facility_id', '=', base64_decode($id))
                ->update(
                    array(
                        'updated_on' => $commonservice->getDateTime()
                    )
                );
            $commonservice->eventLog('update-facility-request', $user_name . ' has updated the facility information for ' . $data['facilityName'] . ' Name', 'facility',$userId);
        }
        return $response;
    }
}
