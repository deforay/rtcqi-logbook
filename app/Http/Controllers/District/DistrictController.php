<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\DistrictService;
use App\Service\ProvinceService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class DistrictController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllDistrict');        
       
    }
    //View District main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('district.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add District (display add screen and add the District values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addDistrict = new DistrictService();
            $result = $addDistrict->saveDistrict($request);
            return Redirect::route('district.index')->with('status', $result);
        }
        else
        {
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();   
            return view('district.add',array('province'=>$province));
        }
    }

    // Get all the  District list
    public function getAllDistrict(Request $request)
    {
        $service = new DistrictService();
        $data = $service->getAllDistrict();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\District\\DistrictController']['edit']) && ($role['App\\Http\\Controllers\\District\\DistrictController']['edit'] == "allow")){
                        $button .= '<a href="/district/edit/'. base64_encode($data->district_id).'" name="edit" id="'.$data->district_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit District
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $DistrictService = new DistrictService();
            $edit = $DistrictService->updateDistrict($request,$id);
            return Redirect::route('district.index')->with('status', $edit);
        }
        else
        {
            $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            $DistrictService = new DistrictService();
            $result = $DistrictService->getDistrictById($id);
            return view('district.edit',array('result'=>$result,'province'=>$province,'id'=>$id));
        }
    }
}

