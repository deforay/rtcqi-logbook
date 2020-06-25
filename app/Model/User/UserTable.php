<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\UserService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mail;

class UserTable extends Model
{
    protected $table = 'users';

    //add User
    public function saveUser($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('firstName')!=null && trim($request->input('firstName')) != '') {
            $id = DB::table('users')->insertGetId(
                ['first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'role' => $data['role'],
                'login_id' => $data['loginId'],
                'password' => Hash::make($data['password']), // Hashing passwords
                'email' => $data['email'],
                'phone' => $data['mobileNo'],
                'user_status' => $data['userStatus'],
                'created_by' => session('userId'),
                'created_on' => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'User-add', 'Add User '.$data['loginId'], 'User');
        }

        if ($request->input('branches')!=null) {
            for($k=0;$k<count($data['branches']);$k++){
                $map = DB::table('user_branch_map')->insertGetId(
                        [
                        'user_id' => $id,
                        'branch_id' => $data['branches'][$k],
                        ]
                    );
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'UserBranch-Map', 'Map  '.$data['loginId'], 'User Branch Map');
        }
        return $id;
    }

    // Fetch All User List
    public function fetchAllUser()
    {
        $data = DB::table('users')
                ->get();
        return $data;
    }

    // Fetch All Active User List
    public function fetchAllActiveUser()
    {
        $data = DB::table('users')
                ->where('user_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular User details
     public function fetchUserById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('users')
                ->join('user_branch_map', 'users.user_id', '=', 'user_branch_map.user_id')
                ->where('users.user_id', '=',$id )
                ->get();
         return $data;
     }
 
     // Update particular User details
    public function updateUser($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('loginId')!=null && trim($params->input('loginId')) != '') {
            $user = array(
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'role' => $data['role'],
                'login_id' => $data['loginId'],
                'email' => $data['email'],
                'phone' => $data['mobileNo'],
                'user_status' => $data['userStatus'],
                'updated_by' => session('userId'),
                'updated_on' => $commonservice->getDateTime()
            );
            if(trim($data['password']))
                $user['password'] = Hash::make($data['password']); // Hashing passwords
            $response = DB::table('users')
                ->where('user_id', '=',base64_decode($id))
                ->update(
                        $user
                    );

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'User-update', 'Update User '.$data['loginId'], 'User');
        }
        if ($params->input('branches')!=null) {
            $branches = $data['branches'];
            $users = DB::table('user_branch_map')
                    ->where('user_id','=', base64_decode($id))
                    ->get();
            $users = $users->toArray();
            if(count($users)>0){
                $userBranch = DB::table('user_branch_map')->where('user_id','=',base64_decode($id))->delete();
                if(count($branches)>0){
                    for($i=0;$i<count($branches);$i++){
                        $map = DB::table('user_branch_map')->insert(['user_id'=>base64_decode($id),'branch_id'=>$branches[$i]]);
                    }
                }
            }
            else{
                if(count($branches)>0){
                    for($i=0;$i<count($branches);$i++){
                        $map = DB::table('user_branch_map')->insert(['user_id'=>base64_decode($id),'branch_id'=>$branches[$i]]);
                    }
                }
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'UserBranch-Map', 'Map  '.$data['loginId'], 'User Branch Map');
        }
        return $response;
    }

    // Validate Employee login
    public function validateLogin($params)
    {
        $data = $params->all();
        $result = json_decode(DB::table('users')
        ->join('roles', 'roles.role_id', '=', 'users.role')
        ->where('users.phone', '=',$data['username'] )
        ->where('user_status','=','active')->get(),true);
        $vendor = json_decode(DB::table('vendors')
        ->join('roles', 'roles.role_id', '=', 'vendors.role')
        ->where('vendors.phone', '=',$data['username'] )
        ->where('vendor_status','=','active')->get(),true);
        $config = array();
        if(count($result)>0)
        {
            $hashedPassword = $result[0]['password'];
            if (Hash::check($data['password'], $hashedPassword)) {
                $configFile =  "acl.config.json";
                if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile)){
                    $config = json_decode(File::get( getcwd() . DIRECTORY_SEPARATOR . $configFile),true);
                    session(['username' => $result[0]['login_id']]);
                    session(['name' => $result[0]['first_name']]);
                    session(['lastName' => $result[0]['last_name']]);
                    session(['email' => $result[0]['email']]);
                    session(['phone' => $result[0]['phone']]);
                    session(['userId' => $result[0]['user_id']]);
                    session(['roleId' => $result[0]['role']]);
                    session(['role' => $config[$result[0]['role_code']]]);
                    session(['login' => true]);

                    $commonservice = new CommonService();
                    $commonservice->eventLog($result[0]['user_id'], $result[0]['user_id'], 'Login', 'User Login '.$result[0]['login_id'], 'Login');
                
                    return 1;
                }
                else{
                    return 2;
                }
            }
        }
        elseif(count($vendor)>0)
        {
            $hashedPassword = $vendor[0]['password'];
            if (Hash::check($data['password'], $hashedPassword)) {
                $configFile =  "acl.config.json";
                if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile)){
                    $config = json_decode(File::get( getcwd() . DIRECTORY_SEPARATOR . $configFile),true);
                    session(['username' => $vendor[0]['vendor_name']]);
                    session(['name' => $vendor[0]['vendor_name']]);
                    session(['email' => $vendor[0]['email']]);
                    session(['phone' => $vendor[0]['phone']]);
                    session(['userId' => $vendor[0]['vendor_id']]);
                    session(['roleId' => $vendor[0]['role']]);
                    session(['role' => $config[$vendor[0]['role_code']]]);
                    session(['login' => true]);

                    $commonservice = new CommonService();
                    $commonservice->eventLog($vendor[0]['vendor_id'], $vendor[0]['vendor_id'], 'Login', 'Vendor Login '.$vendor[0]['vendor_name'], 'Login');
                
                    return 1;
                }
                else{
                    return 2;
                }
            }
        }
        else
        {
            return 0;
        }
    }
}
