<?php

namespace App\Http\Controllers\UnitConversion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UnitConversionService;
use App\Service\UnitService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class UnitConversionController extends Controller
{
    //View Unit conversion main screen
    public function index()
    {
        // if(session('login')==true)
        // {
            return view('unitconversion.index');
        // }
        // else
        //     return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Unit (display add screen and add the Unit Conversion values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new UnitConversionService();
            $add = $service->saveUnitConversion($request);
            return Redirect::route('unitconversion.index')->with('status', $add);
        }
        else
        {
            $unitService = new UnitService();
            $unitResult = $unitService->getAllActiveUnit();
            return view('unitconversion.add',array('unit_type'=>$unitResult));
        }
    }

    // Get all the Unit Conversion list
    public function getAllUnitConversion(Request $request)
    {
        $service = new UnitConversionService();
        $data = $service->getAllUnitConversion();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/unitconversion/edit/'. base64_encode($data->conversion_id).'" name="edit" id="'.$data->conversion_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        if($data->unit_conversion_status == 'active'){
                            $buttonStatus="changeStatus('uom_conversion','conversion_id',$data->conversion_id,'unit_conversion_status', 'inactive', 'unitConversionList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->conversion_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('uom_conversion','conversion_id',$data->conversion_id,'unit_conversion_status', 'active', 'unitConversionList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->conversion_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit Conversion 
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new UnitConversionService();
            $edit = $service->updateUnitConversion($request,$id);
            return Redirect::route('unitconversion.index')->with('status', $edit);
        }
        else
        {
            $unitService = new UnitService();
            $unitResult = $unitService->getAllActiveUnit();
            $service = new UnitConversionService();
            $result = $service->getUnitConversionById($id);
            return view('unitconversion.edit',array('result'=>$result,'unit_type'=>$unitResult));
        }
    }
}
