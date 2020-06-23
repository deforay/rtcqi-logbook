<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\BranchTypeService;
use App\Service\BranchesService;
use App\Service\CountriesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class BranchesController extends Controller
{
    //View branches main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('branches.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add branches (display add screen and add the branches values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $add = new BranchesService();
            $added = $add->saveBranches($request);
            return Redirect::route('branches.index')->with('status', $added);
        }
        else
        {
            $branchTypeService = new BranchTypeService();
            $branchType = $branchTypeService->getAllActiveBranchType();
            $countryService = new CountriesService();
            $country = $countryService->getAllActiveCountries();
            return view('branches.add',array('country'=>$country,'branchType'=>$branchType));
        }
    }

    // Get all the branches list
    public function getAllBranches(Request $request)
    {
        $all = new BranchesService();
        $data = $all->getAllBranches();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/branches/edit/'. base64_encode($data->branch_id).'" name="edit" id="'.$data->branch_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        if($data->branch_status == 'active'){
                            $buttonStatus="changeStatus('branches','branch_id',$data->branch_id,'branch_status', 'inactive', 'branchList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->branch_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('branches','branch_id',$data->branch_id,'branch_status', 'active', 'branchList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->branch_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
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
            $branch = new BranchesService();
            $edit = $branch->updateBranches($request,$id);
            return Redirect::route('branches.index')->with('status', $edit);
        }
        else
        {
            $branch = new BranchesService();
            $result = $branch->getBranchesById($id);
            $branchTypeService = new BranchTypeService();
            $branchType = $branchTypeService->getAllActiveBranchType();
            $countryService = new CountriesService();
            $country = $countryService->getAllActiveCountries();
            return view('branches.edit',array('result'=>$result,'country'=>$country,'branchType'=>$branchType));
        }
    }
}
