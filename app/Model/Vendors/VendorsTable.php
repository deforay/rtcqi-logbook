<?php

namespace App\Model\Vendors;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\VendorsService;
use App\Service\CommonService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class VendorsTable extends Model
{
    protected $table = 'vendors';

    public function saveVendors($request)
    {
        $data = $request->all();
        $commonservice = new CommonService();
        $vendorsId = '';
        $role = DB::table('roles')
            ->where('role_name', '=', 'vendor')
            ->get();
        if (count($role) == 0) {
            $roleId = DB::table('roles')->insertGetId(
                [
                    'role_name' => 'vendor',
                    'role_code' => 'VDR',
                    'role_description' => 'vendor role',
                    'role_status' => 'active',
                    'created_on' => $commonservice->getDateTime(),
                    'created_by' => session('userId'),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $roleId, 'Role-add', 'Add Role vendor', 'Role');
        } else {
            $roleId = $role[0]->role_id;
        }
        if ($request->input('vendorName') != null && trim($request->input('vendorName')) != '') {
            $vendorRegisterOn = $commonservice->dateFormat($data['vendorRegisterOn']);
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
                    'created_on'     => $commonservice->getDateTime(),
                    'role'           => $roleId,
                    'password'       => Hash::make($data['password']), // Hashing passwords

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
            ->join('countries', 'countries.country_id', '=', 'vendors.country')
            ->join('vendor_types', 'vendor_types.vendor_type_id', '=', 'vendors.vendor_type')
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
        $commonservice = new CommonService();
        if ($params->input('vendorName') != null && trim($params->input('vendorName')) != '') {
            if ($data['vendorRegisterOn'] != '') {
                $vendorRegisterOn = $commonservice->dateFormat($data['vendorRegisterOn']);
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
                'updated_on'     => $commonservice->getDateTime(),
                'updated_by'     => session('userId'),
            );
            if (trim($data['password']))
                $params['password'] = Hash::make($data['password']); // Hashing passwords

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
