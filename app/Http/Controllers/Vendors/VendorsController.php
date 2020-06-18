<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\VendorsService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class VendorsController extends Controller
{
    public function __construct()
    {      
        // $this->middleware(['role-authorization'])->except('getVendors');        
       
    }
    //View Customers main screen
    public function index()
    {
        // if(session('login')==true)
        // {
            return view('vendors.index');
        // }
        // else
            // return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add customers (display add screen )
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $AddVendor = new VendorsService();
            $addvenodrs = $AddVendor->saveVendors($request);
            return Redirect::route('vendors.index')->with('status', $addvenodrs);
        }
        else
        {
            $vendorsService = new VendorsService();
            $vendorResult = $vendorsService->getVendorsById();
            return view('vendors.add',array('vendorsResult'=>$vendorResult));
        }
    }

    // Get all the Customer list
    public function getVendors(Request $request)
    {
        $vendorsService = new VendorsService();
        $data = $vendorsService->getAllVendors();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Vendors\\VendorsController']['edit']) && ($role['App\\Http\\Controllers\\Vendors\\VendorsController']['edit'] == "allow")){
                            $button .= '<a href="/vendors/edit/'. base64_encode($data->vendor_id).'" name="edit" id="'.$data->vendor_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            
                        }else{
                            $button .= '';
                        }

                        if($data->status == 'active'){
                            $buttonStatus="changeStatus('vendors','vendor_id',$data->vendor_id,'status', 'inactive')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->vendor_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('vendors','vendor_id',$data->vendor_id,'status', 'active')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->vendor_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    // Edit Customer Screen
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $vendorsService = new VendorsService();
            $editVendors = $vendorsService->updateVendors($request,$id);
            return Redirect::route('vendors.index')->with('status', $editVendors);
        }
        else
        {
            $vendorsService = new VendorsService();
            $result = $vendorsService->getVendorsById($id);
            return view('vendors.edit',array('vendors'=>$result));
        }
    }
  
}
