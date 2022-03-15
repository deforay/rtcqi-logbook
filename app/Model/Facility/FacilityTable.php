<?php

namespace App\Model\Facility;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class FacilityTable extends Model
{
    protected $table = 'facilities';

    //add Facility
    public function saveFacility($request)
    {
        //to get all request values
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();

        if ($request->input('facilityName') != null && trim($request->input('facilityName')) != '') {
            $id = DB::table('facilities')->insertGetId(
                [
                    'facility_name' => $data['facilityName'],
                    'facility_latitude' => $data['latitude'],
                    'facility_longitude' => $data['longitude'],
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
            $commonservice->eventLog('add-facility-request', $user_name . ' has added the facility information for ' . $data['facilityName'] . ' Name', 'facility',$id=null);
        }

        return $id;
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
        $commonservice = new CommonService();
        $user_name = session('name');
        $data = $params->all();
        $testData = array(
            'facility_name' => $data['facilityName'],
            'facility_latitude' => $data['latitude'],
            'facility_longitude' => $data['longitude'],
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
            $commonservice->eventLog('update-facility-request', $user_name . ' has updated the facility information for ' . $data['facilityName'] . ' Name', 'facility',$id=null);
        }
        return $response;
    }
}
