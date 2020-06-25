<?php

namespace App\Model\VendorsType;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\VendorsTypeService;
use App\Service\CommonService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class VendorsTypeTable extends Model
{
    //
    protected $table = 'vendor_types';

    public function saveVendorsType($request)
    {
        $data = $request->all();
        $id = ' ';
        $common = new CommonService();
        if ($request->input('vendorType') != null && trim($request->input('vendorType')) != '') {
            $id = DB::table('vendor_types')->insertGetId(
                [
                    'vendor_type'    => $data['vendorType'],
                    'vendor_type_status' => $data['status'],
                    'created_on'     => $common->getDateTime(),
                    'created_by' => session('userId'),
                ]
            );
            if ($id) {
                //Event Log
                $commonservice = new CommonService();
                $commonservice->eventLog(session('userId'), $id, 'Vendortype-add', 'Added Vendor Type ' . $data['vendorType'], 'vendor_type');
            }
        }

        return $id;
        // }
    }

    // Fetch All Vendor List
    public function fetchAllVendorsType()
    {
        $data = DB::table('vendor_types')
            ->orderBy('vendor_type', 'asc')
            ->get();
        return $data;
    }

    // Fetch All Vendor List
    public function fetchAllActiveVendorsType()
    {
        $data = DB::table('vendor_types')
            ->where('vendor_types.vendor_type_status', '=', 'active')
            ->orderBy('vendor_type', 'asc')
            ->get();    
        return $data;
    }

    // fetch particular Vendor details(edit)
    public function fetchVendorsTypeById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('vendor_types')
            ->where('vendor_types.vendor_type_id', '=', $id)->get();
        return $data;
    }

    // Update particular Vendor details
    public function updateVendorsType($params, $id)
    {

        $response = 0;
        $data = $params->all();
        $vendorUp = '';
        //Vendor details
        $commonservice = new CommonService();
        if ($params->input('vendorType') != null && trim($params->input('vendorType')) != '') {
            $params = array(
                'vendor_type'    => $data['vendorType'],
                'vendor_type_status'         => $data['status'],
                'updated_on'     => $commonservice->getDateTime(),
                'updated_by' => session('userId'),
            );
            $vendorUp = DB::table('vendor_types')
                ->where('vendor_type_id', '=', base64_decode($id))
                ->update(
                    $params
                );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Vendor-Type-update', 'Update Vendor Type ' . $data['vendorType'], 'vendor_type');
        }
        if ($vendorUp) {
            $response = 1;
        }
        return $response;
    }
}
