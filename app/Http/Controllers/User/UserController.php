<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;
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
            
            return view('user.add');
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
                        $button .= '<a href="/user/edit/'. base64_encode($data->user_id).'" name="edit" id="'.$data->user_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit user
    public function edit($id,Request $request)
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
            return view('user.edit',array('result'=>$result,'id'=>$id));
        }
    }

    //edit profile
    public function profile(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $UserService = new UserService();
            $edit = $UserService->updateProfile($request,$id);
            return Redirect::to('/dashboard')->with('status', $edit);
        }
        else
        {
            
            $UserService = new UserService();
            $result = $UserService->getUserById($id);
            return view('user.profile',array('result'=>$result));
        }
    }
}

