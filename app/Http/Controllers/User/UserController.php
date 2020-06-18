<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;
use App\Service\RolesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class UserController extends Controller
{
    //View user main screen
    public function index()
    {
        // if(session('login')==true)
        // {
            return view('user.index');
        // }
        // else
        //     return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add user (display add screen and add the user values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addUser = new UserService();
            $addBranch = $addUser->saveUser($request);
            return Redirect::route('user.index')->with('status', $addBranch);
        }
        else
        {
            $RoleService = new RolesService();
            $role = $RoleService->getAllActiveRole();
            return view('user.add',array('role'=>$role));
        }
    }

    // Get all the User list
    public function getAllUser(Request $request)
    {
        $user = new UserService();
        $data = $user->getAllUser();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/user/edit/'. base64_encode($data->user_id).'" name="edit" id="'.$data->user_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        if($data->user_status == 'active'){
                            $buttonStatus="changeStatus('users','user_id',$data->user_id,'user_status', 'inactive', 'userList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->user_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('users','user_id',$data->user_id,'user_status', 'active', 'userList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->user_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
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
            $UserService = new UserService();
            $edit = $UserService->updateUser($request,$id);
            return Redirect::route('user.index')->with('status', $edit);
        }
        else
        {
            $UserService = new UserService();
            $result = $UserService->getUserById($id);
            $RoleService = new RolesService();
            $role = $RoleService->getAllActiveRole();
            return view('user.edit',array('result'=>$result,'role'=>$role));
        }
    }
}

