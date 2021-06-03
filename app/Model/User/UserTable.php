<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class UserTable extends Model
{
    protected $table = 'users';

    //add User
    public function saveUser($request)
    {
        //to get all request values
        $data = $request->all();
        // dd($data);die;
        $commonservice = new CommonService();
        if ($request->input('firstName')!=null && trim($request->input('firstName')) != '') {
            $id = DB::table('users')->insertGetId(
                ['first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'password' => Hash::make($data['password']), // Hashing passwords
                'email' => $data['email'],
                'phone' => $data['mobileNo'],
                'user_status' => $data['userStatus'],
                'created_by' => session('userId'),
                'created_on' => $commonservice->getDateTime(),
                ]
            );
            for ($x = 0; $x < count($data['testSiteId']); $x++){
            $userFacility = DB::table('users_facility_map')->insertGetId(
                [
                'user_id' => $id,
                'ts_id' => $data['testSiteId'][$x],
                ]
            );
        }
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
                ->join('users_facility_map', 'users_facility_map.user_id', '=', 'users.user_id')
                ->where('users.user_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular User details
    public function updateUser($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
            $user = array(
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
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
                    DB::delete('delete from users_facility_map where user_id = ?',[base64_decode($id)]);

                    for ($x = 0; $x < count($data['testSiteId']); $x++){
                    $userFacility = DB::table('users_facility_map')->insertGetId(
                        [
                        'user_id' => base64_decode($id),
                        'ts_id' => $data['testSiteId'][$x],
                        ]
                    );
                }
        return $response;
    }

    // Validate Employee login
    public function validateLogin($params)
    {
        $data = $params->all();
        $result = json_decode(DB::table('users')
        ->where('users.email', '=',$data['username'] )
        ->where('user_status','=','active')->get(),true);
        if(count($result)>0)
        {
            $hashedPassword = $result[0]['password'];
            if (Hash::check($data['password'], $hashedPassword)) {
                session(['name' => $result[0]['first_name']]);
                session(['lastName' => $result[0]['last_name']]);
                session(['email' => $result[0]['email']]);
                session(['phone' => $result[0]['phone']]);
                session(['userId' => $result[0]['user_id']]);
                session(['login' => true]);
                return 1;
            }
        }
        else
        {
            return 0;
        }
    }



     // Update particular User details
     public function updateProfile($params,$id)
     {
         $commonservice = new CommonService();
         $data = $params->all();
         if ($params->input('firstName')!=null && trim($params->input('firstName')) != '') {
             $user = array(
                 'first_name' => $data['firstName'],
                 'last_name' => $data['lastName'],
                 'email' => $data['email'],
                 'phone' => $data['mobileNo'],
                 'updated_by' => session('userId'),
                 'updated_on' => $commonservice->getDateTime()
             );

             $response = DB::table('users')
                 ->where('user_id', '=',base64_decode($id))
                 ->update(
                         $user
                     );
         }
         return $response;
     }

     //Update Password
    public function updatePassword($params,$id)
    {
        $data = $params->all();
        $newPassword= Hash::make($data['newPassword']);
        $result = json_decode(DB::table('users')->where('user_id', '=',base64_decode($id) )->get(),true);
        if(count($result)>0)
        {
            $hashedPassword = $result[0]['password'];
            if (Hash::check($data['currentPassword'], $hashedPassword)) {
                $response = DB::table('users')
                ->where('user_id', '=',base64_decode($id))
                ->update([
                    'password'=> $newPassword
                    ]
                );
                return $response;
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(base64_decode($id),base64_decode($id), 'Change Password', 'User Change Password', 'Change Password');

        }
        else
        {
            return 0;
        }
    }

}
