<?php

namespace App\Http\Controllers\ImplementingPartners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ImplementingPartnersService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class ImplementingPartnersController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllImplementingPartners');        
       
    }
    //View Implementing Partners main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('implementingpartners.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Implementing Partners (display add screen and add the Implementing Partners values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addProvince = new ImplementingPartnersService();
            $result = $addProvince->saveImplementingPartners($request);
            return Redirect::route('implementingpartners.index')->with('status', $result);
        }
        else
        {
            
            return view('implementingpartners.add');
        }
    }

    // Get all the  implementing partners list
    public function getAllImplementingPartners(Request $request)
    {
        $service = new ImplementingPartnersService();
        $data = $service->getAllImplementingPartners();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController']['edit']) && ($role['App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController']['edit'] == "allow")){
                        $button .= '<a href="/implementingpartners/edit/'. base64_encode($data->implementing_partner_id).'" name="edit" id="'.$data->implementing_partner_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
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
            $ImplementingPartnersService = new ImplementingPartnersService();
            $edit = $ImplementingPartnersService->updateImplementingPartners($request,$id);
            return Redirect::route('implementingpartners.index')->with('status', $edit);
        }
        else
        {
            $ImplementingPartnersService = new ImplementingPartnersService();
            $result = $ImplementingPartnersService->getImplementingPartnersById($id);
            return view('implementingpartners.edit',array('result'=>$result,'id'=>$id));
        }
    }
}

