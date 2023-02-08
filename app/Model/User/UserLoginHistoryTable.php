<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;
use Illuminate\Support\Facades\File;
use LDAP\Result;

class UserLoginHistoryTable extends Model
{
    protected $table = 'user_login_history';

    //add User
   
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
            ->where('user_status', '=', 'active')
            ->get();
        return $data;
    }

    public function fetchUserLoginHistory($params)
    {
        // print_r($params);die;
        $commonservice = new CommonService();
        $start_date = '';
        $end_date = '';
        if (isset($params['searchDate']) && $params['searchDate'] != '') {
            $sDate = explode("to", $params['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        $query = DB::table('user_login_history')
                    ->join('users', 'users.user_id', '=', 'user_login_history.user_id');

        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->where(DB::raw('date(user_login_history.login_attempted_datetime)'),  '>=', $start_date)
                    ->where(DB::raw('date(user_login_history.login_attempted_datetime)'), '<=', $end_date);
            });
        }
        if (isset($params['userId']) && $params['userId'] != '') {
            $query = $query->whereIn('users.user_id', $params['userId']);
        }

        $salesResult = $query->get();
        return $salesResult;
    }

    // fetch particular User details
    public function fetchUserById($id)
    {

        $id = base64_decode($id);
        $data = DB::table('users')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->leftjoin('users_testsite_map', 'users_testsite_map.user_id', '=', 'users.user_id')
            ->where('users.user_id', '=', $id)
            ->get();
        return $data;
    }

    // Update particular User details
    public function updateUser($params, $id)
    {
        $commonservice = new CommonService();
        $userId = null;
        $user_name = session('name');
        $data = $params->all();
        //dd($data);die;
        $user = array(
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['mobileNo'],
            'user_status' => $data['userStatus'],
            'role_id' => $data['roleId'],
            'updated_by' => session('userId')
        );
        $response = DB::table('users')
            ->where('user_id', '=', base64_decode($id))
            ->update(
                $user
            );
        if (trim($data['password'])) {
        $user['password'] = Hash::make($data['password']); // Hashing passwords
        $response = DB::table('users')
            ->where('user_id', '=', base64_decode($id))
            ->update(
                $user
            );
        }
        if ($response == 1) {
            if($data['password'] == '') {
                $forcePassword = 0;
            }
            else {
                $forcePassword = 1;
            }
            $response = DB::table('users')
                ->where('user_id', '=', base64_decode($id))
                ->update(
                    array(
                        'force_password_reset' => $forcePassword,
                        'updated_on' => $commonservice->getDateTime()
                    )
                );
                $commonservice->eventLog('update-user-request', $user_name . ' has updated the user information for - ' . $data['firstName'], 'user',$userId);
        }
        $response=DB::delete('delete from users_testsite_map where user_id = ?', [base64_decode($id)]);
        if (base64_decode($id) != '' && trim($data['testSiteName']) != '') {
            $selectedSiteName = explode(",", $data['testSiteName']);
            $uniqueSiteId = array_unique($selectedSiteName);
            for ($x = 0; $x < count($selectedSiteName); $x++) {
                if (isset($uniqueSiteId[$x])) {
                    $response = DB::table('users_testsite_map')->insertGetId(
                    [
                        'user_id' => base64_decode($id),
                        'ts_id' => $selectedSiteName[$x],
                    ]
                );
                }
            }
        }
        return $response;
    }

    // Validate Employee login
    public function validateLogin($params)
    {
        $config = '';
        $userId = null;
        $data = $params->all();
        $commonservice = new CommonService();
        $result = json_decode(DB::table('users')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->join('users_testsite_map', 'users_testsite_map.user_id', '=', 'users.user_id')
            ->where('users.email', '=', $data['username'])
            ->where('user_status', '=', 'active')
            ->get(), true);
            if(count($result) !=0) {
                foreach($result as $value) {                             
                    Session::push('tsId',$value['ts_id']);
                }
            }
            
            if(count($result) == 0) {
                $result = json_decode(DB::table('users')
                ->join('roles', 'roles.role_id', '=', 'users.role_id')
                ->where('users.email', '=', $data['username'])
                ->where('user_status', '=', 'active')
                ->get(), true);
            }
        if (count($result) > 0) {
            $hashedPassword = $result[0]['password'];
            if (Hash::check($data['password'], $hashedPassword)) {
                $configFile =  "acl.config.json";
                if (file_exists(config_path() . DIRECTORY_SEPARATOR . $configFile)) {
                    $config = json_decode(File::get(config_path() . DIRECTORY_SEPARATOR . $configFile), true);
                    session(['name' => $result[0]['first_name']]);
                    session(['lastName' => $result[0]['last_name']]);
                    session(['email' => $result[0]['email']]);
                    session(['phone' => $result[0]['phone']]);
                    session(['userId' => $result[0]['user_id']]);
                    session(['forcePasswordReset' => $result[0]['force_password_reset']]);
                    session(['role' => $config[$result[0]['role_id']]]);
                    session(['login' => true]);
                    $commonservice->eventLog('login', $result[0]['first_name'] . ' logged in', 'user',$userId);
                } else {
                    return 2;
                }
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }



    // Update particular User details
    public function updateProfile($params, $id)
    {
        $commonservice = new CommonService();
        $userId = null;
        $user_name = session('name');
        $data = $params->all();
        if ($params->input('firstName') != null && trim($params->input('firstName')) != '') {
            $user = array(
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'email' => $data['email'],
                'phone' => $data['mobileNo'],
                'updated_by' => session('userId')
            );

            $response = DB::table('users')
                ->where('user_id', '=', base64_decode($id))
                ->update(
                    $user
                );
            if ($response == 1) {
                $response = DB::table('users')
                    ->where('user_id', '=', base64_decode($id))
                    ->update(
                        array(
                            'updated_on' => $commonservice->getDateTime()
                        )
                    );
                    $commonservice->eventLog('update-user-profile-request', $user_name . ' has updated the user profile information', 'user-profile',$userId);
            }
        }
        return $response;
    }

    //Update Password
    public function updatePassword($params, $id)
    {
        $commonservice = new CommonService();
        $userId = null;
        $user_name = session('name');
        $data = $params->all();
        $newPassword = Hash::make($data['newPassword']);
        if (Hash::check($data['currentPassword'], $newPassword)) {
            return 0;
        } else {
            $result = json_decode(DB::table('users')->where('user_id', '=', base64_decode($id))->get(), true);
            if (count($result) > 0) {
                $hashedPassword = $result[0]['password'];
                if (Hash::check($data['currentPassword'], $hashedPassword)) {
                $response = DB::table('users')
                        ->where('user_id', '=', base64_decode($id))
                        ->update(
                            [
                                'password' => $newPassword,
                                'force_password_reset' => 0
                            ]
                        );
                        $commonservice->eventLog('change-password-request', $user_name . ' has changed the password information', 'change-password',$userId);
                    return $response;
                }
                // $commonservice = new CommonService();
                // $commonservice->eventLog(base64_decode($id), base64_decode($id), 'Change Password', 'User Change Password', 'Change Password');
            } else {
                return 0;
            }
        }
    }

    public function loggedInHistory($data,$status)
    {
       
        $browserAgent = $_SERVER['HTTP_USER_AGENT'];
        $os = PHP_OS;
        $common = new CommonService();
        $currentDateTime=$common->getDateTime();
        $loginData = array(
            'user_id'=>session('userId'),
            'login_id'=>$data['username'],
            'login_attempted_datetime'=>date('Y-m-d H:i:s'),
            'login_status'=>$status,
            'ip_address'=>request()->ip(),
            'browser'=>$browserAgent,
            'operating_system'=>$os,
        );
        $historyResult = DB::table('user_login_history')->insert($loginData);
        return $historyResult;
    }
}
