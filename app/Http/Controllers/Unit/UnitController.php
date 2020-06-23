<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UnitService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class UnitController extends Controller
{
    //View Unit main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('unit.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Unit (display add screen and add the Unit values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new UnitService();
            $add = $service->saveUnit($request);
            return Redirect::route('unit.index')->with('status', $add);
        }
        else
        {
            return view('unit.add');
        }
    }

    // Get all the Unit list
    public function getAllUnit(Request $request)
    {
        $service = new UnitService();
        $data = $service->getAllUnit();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/unit/edit/'. base64_encode($data->uom_id).'" name="edit" id="'.$data->uom_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        if($data->unit_status == 'active'){
                            $buttonStatus="changeStatus('units_of_measure','uom_id',$data->uom_id,'unit_status', 'inactive', 'unitList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->uom_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('units_of_measure','uom_id',$data->uom_id,'unit_status', 'active', 'unitList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->uom_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit roles
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new UnitService();
            $edit = $service->updateUnit($request,$id);
            return Redirect::route('unit.index')->with('status', $edit);
        }
        else
        {
            $service = new UnitService();
            $result = $service->getUnitById($id);
            return view('unit.edit',array('result'=>$result));
        }
    }
}
