<?php

namespace App\Http\Controllers\SubDistrict;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\DistrictService;
use App\Service\SubDistrictService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class SubDistrictController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllSubDistrict');        
       
    }
    //View Sub District main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('subdistrict.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Sub District (display add screen and add the Sub District values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addSubDistrict = new SubDistrictService();
            $result = $addSubDistrict->saveSubDistrict($request);
            return Redirect::route('subdistrict.index')->with('status', $result);
        }
        else
        {
            $districtService = new DistrictService();
            $district = $districtService->getAllDistrict();   
            return view('subdistrict.add',array('district'=>$district));
        }
    }

    // Get all the  Sub District list
    public function getAllSubDistrict(Request $request)
    {
        $service = new SubDistrictService();
        $data = $service->getAllSubDistrict();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['edit']) && ($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['edit'] == "allow")){
                        $button .= '<a href="/subdistrict/edit/'. base64_encode($data->sub_district_id).'" name="edit" id="'.$data->sub_district_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit Sub District
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $SubDistrictService = new SubDistrictService();
            $edit = $SubDistrictService->updateSubDistrict($request,$id);
            return Redirect::route('subdistrict.index')->with('status', $edit);
        }
        else
        {
            $DistrictService = new DistrictService();
            $district = $DistrictService->getAllDistrict();
            $SubDistrictService = new SubDistrictService();
            $result = $SubDistrictService->getSubDistrictById($id);
            return view('subdistrict.edit',array('result'=>$result,'district'=>$district,'id'=>$id));
        }
    }
}

