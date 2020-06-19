<?php

namespace App\Model\Vendors;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\VendorsService;
use App\Service\CommonService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Mail;

class VendorsTable extends Model
{
    protected $table = 'vendors';

    public function saveVendors($request)
    {
        $data = $request->all();
        $common = new CommonService();
        $vendorsId = '';
        if ($request->input('vendorName') != null && trim($request->input('vendorName')) != '') {
            $vendorRegisterOn = $common->dateFormat($data['vendorRegisterOn']);
            $vendorsId = DB::table('vendors')->insertGetId(
                [
                    'vendor_name'    => $data['vendorName'],
                    'vendor_code'    => $data['vendorCode'],
                    'vendor_type'    => $data['vendorType'],
                    'registered_on'  => $vendorRegisterOn,
                    'address_line_1' => $data['addressline1'],
                    'address_line_2' => $data['addressline2'],
                    'city'           => $data['vendorCity'],
                    'state'          => $data['vendorState'],
                    'pincode'        => $data['vendorPincode'],
                    'country'        => $data['vendorCountry'],
                    'email'          => $data['vendorEmail'],
                    'alt_email'      => $data['vendorAltEmail'],
                    'phone'          => $data['vendorPhone'],
                    'alt_phone'      => $data['vendorAltPhone'],
                    'vendor_status'  => $data['vendorStatus'],

                ]
            );
        }
        if ($vendorsId) {
            //Event Log
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $vendorsId, 'Vendors-add', 'Add Vendors ' . $data['vendorName'], 'Vendors');
        }
        return $vendorsId;
    }

    // Fetch All Vendor List
    public function fetchAllVendors()
    {
        $data = DB::table('vendors')
            ->orderBy('vendor_name', 'asc')
            ->get();
        return $data;
    }

    // fetch particular Vendor details(edit)
    public function fetchVendorsById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('vendors')
            ->where('vendors.vendor_id', '=', $id)->get();
        return $data;
    }
    // Update particular Vendor details
    public function updateVendorsDetails($params, $id)
    {

        $response = 0;
        $data = $params->all();
        $vendorUp = '';
        //Vendor details
        $common = new CommonService();
        if ($params->input('vendorName') != null && trim($params->input('vendorName')) != '') {
            if ($data['vendorRegisterOn'] != '') {
                $vendorRegisterOn = $common->dateFormat($data['vendorRegisterOn']);
            } else {
                $vendorRegisterOn = '';
            }
            $params = array(
                'vendor_name'    => $data['vendorName'],
                'vendor_code'    => $data['vendorCode'],
                'vendor_type'    => $data['vendorType'],
                'registered_on'  => $vendorRegisterOn,
                'address_line_1' => $data['addressline1'],
                'address_line_2' => $data['addressline2'],
                'city'           => $data['vendorCity'],
                'state'          => $data['vendorState'],
                'pincode'        => $data['vendorPincode'],
                'country'        => $data['vendorCountry'],
                'email'          => $data['vendorEmail'],
                'alt_email'      => $data['vendorAltEmail'],
                'phone'          => $data['vendorPhone'],
                'alt_phone'      => $data['vendorAltPhone'],
                'vendor_status'  => $data['vendorStatus'],
            );

            $vendorUp = DB::table('vendors')
                ->where('vendor_id', '=', base64_decode($id))
                ->update(
                    $params
                );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Vendor-update', 'Update Vendors ' . $data['vendorName'], 'Vendor');
        }
        if ($vendorUp) {
            $response = 1;
        }
        return $response;
    }
}
