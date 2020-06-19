<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\UserService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
                // 'created_by' => $data['firstName'],
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
                // 'updated_by' => $data['firstName'],
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
}
