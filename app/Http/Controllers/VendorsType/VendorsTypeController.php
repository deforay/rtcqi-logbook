<?php

namespace App\Http\Controllers\VendorsType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\VendorsTypeService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class VendorsTypeController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['role-authorization'])->except('getVendors');        

    }
    //View Vendor type main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('vendorstype.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Vendor type (display add screen )
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $AddVendorType = new VendorsTypeService();
            $addvenodrstype = $AddVendorType->saveVendorsType($request);
            return Redirect::route('vendorstype.index')->with('status', $addvenodrstype);
        }else{
            return view('vendorstype.add');
        }
    }

    // Get all the Vendor list
    public function getAllVendorType(Request $request)
    {
        $vendorsTypeService = new VendorsTypeService();
        $data = $vendorsTypeService->getAllVendorsType();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $button = '<div style="width: 180px;">';
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\VendorsType\\VendorsTypeController']['edit']) && ($role['App\\Http\\Controllers\\VendorsType\\VendorsTypeController']['edit'] == "allow")) {
                    $button .= '<a href="/vendorstype/edit/' . base64_encode($data->vendor_type_id) . '" name="edit" id="' . $data->vendor_type_id . '" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                } else {
                    $button .= '';
                }

                if ($data->vendor_type_status == 'active') {
                    $buttonStatus="changeStatus('vendor_types','vendor_type_id',$data->vendor_type_id,'vendor_type_status', 'inactive', 'vendorsTypeList')";
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus' . $data->vendor_type_id . '" onclick="' . $buttonStatus . '" class="btn btn-outline-warning btn-sm">Inactivate</button>';
                } else {
                    $buttonStatus="changeStatus('vendor_types','vendor_type_id',$data->vendor_type_id,'vendor_type_status', 'active', 'vendorsTypeList')";

                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus' . $data->vendor_type_id . '" onclick="' . $buttonStatus . '" class="btn btn-outline-success btn-sm">Activate</button>';
                }
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Edit vendor type Screen
    public function edit($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $vendorsTypeService = new VendorsTypeService();
            $editVendors = $vendorsTypeService->updateVendorsType($request, $id);
            return Redirect::route('vendorstype.index')->with('status', $editVendors);
        } else {
            $vendorsTypeService = new VendorsTypeService();
            $result = $vendorsTypeService->getVendorsTypeById($id);
            return view('vendorstype.edit', array('vendorsType' => $result));
        }
    }
}
