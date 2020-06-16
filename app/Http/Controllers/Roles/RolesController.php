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
}
