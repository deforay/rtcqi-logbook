<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\TestSiteService;
use App\Service\UserService;
use App\Service\RolesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class UserController extends Controller
{
    public function __construct()
    {      
        $this->middleware(['role-authorization'])->except('getAllUser');        
       
    }
    //View user main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('user.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
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
            $TestSiteService = new TestSiteService();
            $RoleService = new RolesService();
            $testSite = $TestSiteService->getAllActiveTestSite();     
            $resourceResult = $RoleService->getAllRole();
            return view('user.add',array('test'=>$testSite,'roleId'=>$resourceResult));
        }
    }

    // Get all the User list
    public function getAllUser(Request $request)
    {
        $user = new UserService();
        $data = $user->getAllUser();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\User\\UserController']['edit']) && ($role['App\\Http\\Controllers\\User\\UserController']['edit'] == "allow")){
                        $button .= '<a href="/user/edit/'. base64_encode($data->user_id).'" name="edit" id="'.$data->user_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
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
            $TestSiteService = new TestSiteService();
            $RoleService = new RolesService();
            $testSite = $TestSiteService->getAllActiveTestSite();    
            $result = $UserService->getUserById($id);
            $resourceResult = $RoleService->getAllRole();
            $testSiteId = array(); 
            foreach($result as $value) {
                array_push($testSiteId,$value->ts_id);
            }
            // dd($result);die;
            return view('user.edit',array('result'=>$result,'id'=>$id,'test'=>$testSite,'testSiteId' => $testSiteId,'roleId'=>$resourceResult));
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

