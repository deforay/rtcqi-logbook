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

    public function saveVendorsType($request)
    {
        $data = $request->all();
        $common = new CommonService();

        if ($request->input('customerName') != null && trim($request->input('customerName')) != '') {
            $customerId = DB::table('customers')->insertGetId(
                [
                    'vendor_type' => $data['customerName'],
                ]
            );
        }
        if ($customerId) {
            //Event Log
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $customerId, 'Customer-add', 'Add Customer ' . $data['customerName'], 'Customer');
        }
        return $customerId;
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
    public function getVendorsById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('vendors')
            ->where('vendors.vendor_id', '=', $id)->get();
        return $data;
    }
    // Update particular Vendor details
    public function updateVendors($params, $id)
    {

        $response = 0;
        $data = $params->all();
        $customerUp = ''; 
        //Vendor details
        if ($params->input('ecustomerName') != null && trim($params->input('ecustomerName')) != '') {
            $endProductList = implode(', ', $data['endProductId']);
            $params = array(
                'customer_name' => $data['ecustomerName'],
                'customer_SAP_code' => $data['ecustomerSapcode'],
                'customer_gstinno' => $data['ecustomerGstno'],
                'customer_email' => $data['ecustomerEmail'],
                'customer_phno' => $data['ecutomerPhoneNo'],
                'customer_city' => $data['ecustomerCity'],
                'customer_location' => $data['ecustomerLocation'],
                'customer_state' => $data['ecustomerState'],
                'customer_pincode' => $data['ecustomerPincode'],
                'customer_status' => $data['ecustomerStatus'],
                'customer_address_one' => $data['eaddrline1'],
                'customer_address_two' => $data['eaddrline2'],
                'customer_address_three' => $data['eaddrline3'],
                'customer_address_four' => $data['eaddrline4'],
                'customer_pan' => $data['ecustomerPan'],
                'agent_id' => $data['eagentId'],
                'customer_group_id' => $data['ecustomerGroupId'],
                'end_product_id' => $endProductList
            );

            if (trim($data['password']))
                $params['customer_password'] = Hash::make($data['password']); // Hashing passwords,
            $customerUp = DB::table('vendors')
                ->where('customer_id', '=', base64_decode($id))
                ->update(
                    $params
                );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Customer-update', 'Update Customer ' . $data['ecustomerName'], 'Customer');
        }
        if ($customerUp) {
            $response = 1;
        }
        return $response;
    }
}
