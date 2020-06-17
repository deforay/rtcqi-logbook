<?php

namespace App\Http\Controllers\BranchType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\BranchTypeService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class BranchTypeController extends Controller
{
    //View BranchType main screen
    public function index()
    {
        // if(session('login')==true)
        // {
            return view('branchtype.index');
        // }
        // else
        //     return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add BranchType (display add screen and add the BranchType values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addBranchType = new BranchTypeService();
            $addBranch = $addBranchType->saveBranchType($request);
            return Redirect::route('branchtype.index')->with('status', $addBranch);
        }
        else
        {
            return view('branchtype.add');
        }
    }

    // Get all the BranchType list
    public function getAllBranchType(Request $request)
    {
        $branchType = new BranchTypeService();
        $data = $branchType->getAllBranchType();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/branchtype/edit/'. base64_encode($data->branch_type_id).'" name="edit" id="'.$data->branch_type_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        if($data->status == 'active'){
                            $buttonStatus="changeStatus('branch_types','branch_type_id',$data->branch_type_id,'status', 'inactive')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->branch_type_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('branch_types','branch_type_id',$data->branch_type_id,'status', 'active')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->branch_type_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
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
            $branchTypeService = new BranchTypeService();
            $edit = $branchTypeService->updateBranchType($request,$id);
            return Redirect::route('branchtype.index')->with('status', $edit);
        }
        else
        {
            $branchTypeService = new BranchTypeService();
            $result = $branchTypeService->getBranchTypeById($id);
            return view('branchtype.edit',array('result'=>$result));
        }
    }
}
