<?php

namespace App\Http\Controllers\Province;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProvinceService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class ProvinceController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllProvince');        
       
    }
    //View Province main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('province.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Province (display add screen and add the Province values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addProvince = new ProvinceService();
            $result = $addProvince->saveProvince($request);
            return Redirect::route('province.index')->with('status', $result);
        }
        else
        {
            
            return view('province.add');
        }
    }

    // Get all the  province list
    public function getAllProvince(Request $request)
    {
        $service = new ProvinceService();
        $data = $service->getAllProvince();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Province\\ProvinceController']['edit']) && ($role['App\\Http\\Controllers\\Province\\ProvinceController']['edit'] == "allow")){
                        $button .= '<a href="/province/edit/'. base64_encode($data->province_id).'" name="edit" id="'.$data->province_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit province
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $ProvinceService = new ProvinceService();
            $edit = $ProvinceService->updateProvince($request,$id);
            return Redirect::route('province.index')->with('status', $edit);
        }
        else
        {
            $ProvinceService = new ProvinceService();
            $result = $ProvinceService->getProvinceById($id);
            return view('province.edit',array('result'=>$result,'id'=>$id));
        }
    }
}

