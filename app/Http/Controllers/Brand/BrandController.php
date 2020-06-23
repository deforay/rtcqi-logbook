<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\BrandService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class BrandController extends Controller
{
    //View Brand main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('brand.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Brand (display add screen and add the Brand values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new BrandService();
            $add = $service->saveBrand($request);
            return Redirect::route('brand.index')->with('status', $add);
        }
        else
        {
            return view('brand.add');
        }
    }

    // Get all the Brand list
    public function getAllBrand(Request $request)
    {
        $service = new BrandService();
        $data = $service->getAllBrand();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Brand\\BrandController']['edit']) && ($role['App\\Http\\Controllers\\Brand\\BrandController']['edit'] == "allow")){
                           $button .= '<a href="/brand/edit/'. base64_encode($data->brand_id).'" name="edit" id="'.$data->brand_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        }else{
                            $button .= '';
                        }
                        if($data->brand_status == 'active'){
                            $buttonStatus="changeStatus('brands','brand_id',$data->brand_id,'brand_status', 'inactive', 'brandList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->brand_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('brands','brand_id',$data->brand_id,'brand_status', 'active', 'brandList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->brand_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit brand
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new BrandService();
            $edit = $service->updateBrand($request,$id);
            return Redirect::route('brand.index')->with('status', $edit);
        }
        else
        {
            $service = new BrandService();
            $result = $service->getBrandById($id);
            return view('brand.edit',array('result'=>$result));
        }
    }
}
