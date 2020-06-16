<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\RolesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;
use Illuminate\Support\Facades\File;

class RolesController extends Controller
{
    //View Roles main screen
    public function index()
    {
        // return view('roles.index');
        // if(session('login')==true)
        // {
            return view('roles.index');
        // }
        // else
        //     return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add roles (display add screen and add the roles values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $AddRoles = new RolesService();
            $addRoles = $AddRoles->saveRoles($request);
            return Redirect::route('roles.index')->with('status', $addRoles);
        }
        else
        {
            $RoleService = new RolesService();
            $resourceResult = $RoleService->getAllResource();
            return view('roles.add',array('resourceResult'=>$resourceResult));
        }
    }

    // Get all the Role list
    public function getRole(Request $request)
    {
        $RoleService = new RolesService();
        $data = $RoleService->getAllRole();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/roles/edit/'. base64_encode($data->role_id).'" name="edit" id="'.$data->role_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        if($data->role_status == 'active'){
                            $buttonStatus="changeStatus('roles','role_id',$data->role_id,'role_status', 'inactive')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->role_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('roles','role_id',$data->role_id,'role_status', 'active')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->role_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit roles
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $RolesService = new RolesService();
            $editRoles = $RolesService->updateRoles($request,$id);
            return Redirect::route('roles.index')->with('status', $editRoles);
        }
        else
        {
            $configFile =  "acl.config.json";
            if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile))
                $config = json_decode(File::get( getcwd() . DIRECTORY_SEPARATOR . $configFile),true);
            else
                $config = array();
            $RoleService = new RolesService();
            $resourceResult = $RoleService->getAllResource();
            // dd($resourceResult);
            $result = $RoleService->getRolesById($id);
            return view('roles.edit',array('role'=>$result,'resourceResult'=>$resourceResult,'resourcePrivilegeMap' => $config));
        }
    }
}
