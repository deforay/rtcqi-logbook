<?php

namespace App\Model\ImplementingPartners;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class ImplementingPartnersTable extends Model
{
    protected $table = 'implementing_partners';

    //add Implementing Partners
    public function saveImplementingPartners($request)
    {
        //to get all request values
        $userId = null;
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        if ($request->input('implementingPartnerName')!=null && trim($request->input('implementingPartnerName')) != '') {
            $id = DB::table('implementing_partners')->insertGetId(
                [
                'implementing_partner_name' => $data['implementingPartnerName'],
                'implementing_partner_status' => $data['implementingPartnerStatus'],
                ]
            );
        $userId = null;
            $commonservice->eventLog('add-implementing-partners-request', $user_name . ' has added the implementing partners information for ' . $data['implementingPartnerName'] . ' Name', 'implementing-partners',$userId);
        }

        return $id;
    }

    // Fetch All Implementing Partners List
    public function fetchAllImplementingPartners()
    {
        return DB::table('implementing_partners')
                ->get();
    }

    // Fetch All Active Implementing Partners List
    public function fetchAllActiveImplementingPartners()
    {
        return DB::table('implementing_partners')
                ->where('implementing_partner_status','=','active')
                ->get();
    }

     // fetch particular Implementing Partner details
     public function fetchImplementingPartnersById($id)
     {

         $id = base64_decode($id);
         return DB::table('implementing_partners')
                ->where('implementing_partners.implementing_partner_id', '=',$id )
                ->get();
     }

     // Update particular Implementing Partner details
    public function updateImplementingPartners($params,$id)
    {
        $userId = null;
        $data = $params->all();
        $user_name = session('name');
        $commonservice = new CommonService();
            $upData = array(
                'implementing_partner_name' => $data['implementingPartnerName'],
                'implementing_partner_status' => $data['implementingPartnerStatus'],
            );
            $response = DB::table('implementing_partners')
                ->where('implementing_partner_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
            $commonservice->eventLog('update-implementing-partner-request', $user_name . ' has updated the implementing partner information for ' . $data['implementingPartnerName'] . ' Name', 'implementing-partner',$userId);
        return $response;
    }

    
}
