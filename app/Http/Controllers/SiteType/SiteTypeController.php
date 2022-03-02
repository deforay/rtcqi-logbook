<?php

namespace App\Http\Controllers\SiteType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\SiteTypeService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class SiteTypeController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllSiteType');        
       
    }
    //View SiteType main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('sitetype.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add SiteType (display add screen and add the SiteType values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addSiteType = new SiteTypeService();
            $result = $addSiteType->saveSiteType($request);
            return Redirect::route('sitetype.index')->with('status', $result);
        }
        else
        {
            
            return view('sitetype.add');
        }
    }

    // Get all the  SiteType list
    public function getAllSiteType(Request $request)
    {
        $service = new SiteTypeService();
        $data = $service->getAllSiteType();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['edit']) && ($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['edit'] == "allow")){
                        $button .= '<a href="/sitetype/edit/'. base64_encode($data->st_id).'" name="edit" id="'.$data->st_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit SiteType
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $SiteTypeService = new SiteTypeService();
            $edit = $SiteTypeService->updateSiteType($request,$id);
            return Redirect::route('sitetype.index')->with('status', $edit);
        }
        else
        {
            $SiteTypeService = new SiteTypeService();
            $result = $SiteTypeService->getSiteTypeById($id);
            return view('sitetype.edit',array('result'=>$result,'id'=>$id));
        }
    }
}

