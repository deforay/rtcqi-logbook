<?php

namespace App\Model\Facility;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class FacilityTable extends Model
{
    protected $table = 'facility';

    //add Facility
    public function saveFacility($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
       
        if ($request->input('facilityName')!=null && trim($request->input('facilityName')) != '') {
            $id = DB::table('facility')->insertGetId(
                [
                'facility_name' => $data['facilityName'],
                'facility_latitude' => $data['latitude'],
                'facility_longitude' => $data['longitude'],
                'facility_address1' => $data['address1'],
                'facility_address2' => $data['address2'],
                'facility_postal_code' => $data['postalCode'],
                'facility_city' => $data['city'],
                'facility_state' => $data['state'],
                'facility_country' => $data['country'],
                'facility_region' => $data['region'],
                'contact_name' => $data['contactName'],
                'contact_email' => $data['contactEmail'],
                'contact_phoneno' => $data['contactPhone'],
                'facility_status' => $data['facilityStatus'],
                'created_by' => session('userId'),
                'created_on' => $commonservice->getDateTime(),
                ]
            );
        }

        return $id;
    }

    // Fetch All Facility List
    public function fetchAllFacility()
    {
        $data = DB::table('facility')
                ->get();
        return $data;
    }

    // Fetch All Active Facility List
    public function fetchAllActiveFacility()
    {
        $data = DB::table('facility')
                ->where('facility_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular Facility details
     public function fetchFacilityById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('facility')
                ->where('facility.facility_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular Facility details
    public function updateFacility($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
            $testData = array(
                'facility_name' => $data['facilityName'],
                'facility_latitude' => $data['latitude'],
                'facility_longitude' => $data['longitude'],
                'facility_address1' => $data['address1'],
                'facility_address2' => $data['address2'],
                'facility_postal_code' => $data['postalCode'],
                'facility_city' => $data['city'],
                'facility_state' => $data['state'],
                'facility_country' => $data['country'],
                'facility_region' => $data['region'],
                'contact_name' => $data['contactName'],
                'contact_email' => $data['contactEmail'],
                'contact_phoneno' => $data['contactPhone'],
                'facility_status' => $data['facilityStatus'],
                'updated_by' => session('userId'),
                'updated_on' => $commonservice->getDateTime()
            );
            $response = DB::table('facility')
                ->where('facility_id', '=',base64_decode($id))
                ->update(
                        $testData
                    );
        return $response;
    }

    
}
