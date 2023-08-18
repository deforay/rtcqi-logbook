<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;
use Illuminate\Support\Facades\File;
use LDAP\Result;

class UserTable extends Model
{
    protected $table = 'users';

    //add User
    public function saveUser($request)
    {
        //to get all request values
        $userId = null;
        $data = $request->all();
        $user_name = session('name');
        //dd($data);die;
        $commonservice = new CommonService();
        if ($request->input('firstName') != null && trim($request->input('firstName')) != '') {
            $id = DB::table('users')->insertGetId(
                [
                    'first_name' => $data['firstName'],
                    'last_name' => $data['lastName'],
                    'password' => Hash::make($data['password']), // Hashing passwords
                    'email' => $data['email'],
                    'phone' => $data['mobileNo'],
                    'user_status' => $data['userStatus'],
                    'created_by' => session('userId'),
                    'created_on' => $commonservice->getDateTime(),
                    'force_password_reset' => 1,
                    'role_id' => $data['roleId']
                ]
            );
            if ($id > 0 && trim($data['testSiteName']) != '') {
                if ($id > 0 && trim($data['testSiteName']) != '') {
                    $selectedSiteName = explode(",", $data['testSiteName']);
                    $uniqueSiteId = array_unique($selectedSiteName);
                    for ($x = 0; $x < count($selectedSiteName); $x++) {
                        if (isset($uniqueSiteId[$x])) {
                            $userFacility = DB::table('users_testsite_map')->insertGetId(
                                [
                                    'user_id' => $id,
                                    'ts_id' => $selectedSiteName[$x],
                                ]
                            );
                        }
                    }
                }
            }
            $commonservice->eventLog('add-user-request', $user_name . ' added user ' . $data['firstName'] . ' User', 'user', $userId);
        }

        return $id;
    }

    public function saveNewUser($data)
    {
        $id=0;
        $commonservice = new CommonService();
        if ($data['firstName']!= null && trim($data['firstName']) != '') {
            $id = DB::table('users')->insertGetId(
                [
                    'first_name' => $data['firstName'],
                    'last_name' => $data['lastName'],
                    'password' => Hash::make($data['password']), // Hashing passwords
                    'email' => $data['email'],                    
                    'user_status' => 'active',
                    'created_by' => null ,
                    'created_on' => $commonservice->getDateTime(),
                    'force_password_reset' => 1,
                    'role_id' => 1
                ]
            );
            $result=DB::table('test_sites')->take(1)->get();
            if($result->count() > 0){
                $ts_id=$result[0]->ts_id;
                DB::table('users_testsite_map')->insert(
                [
                    'user_id' => $id,
                    'ts_id' => $ts_id,
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
            ->where('user_status', '=', 'active')
            ->get();
        return $data;
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

    public function fetchUserByEmail($email)
    {
        $data = DB::table('users')
            // ->join('roles', 'roles.role_id', '=', 'users.role_id')
            // ->leftjoin('users_testsite_map', 'users_testsite_map.user_id', '=', 'users.user_id')
            ->where('users.email', '=', $email)
            ->get();
        return $data;
    }

    public function updateUserLanguage($locale){
        $userid=session('userId');
        $user = array(
            'language' => $locale,            
            'updated_by' => session('userId')
        );
        //print_r($user); exit();
        $response = DB::table('users')
            ->where('user_id', '=', $userid)
            ->update(
                $user
            );
            return $response;
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
            if ($data['password'] == '') {
                $forcePassword = 0;
            } else {
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
            $commonservice->eventLog('update-user-request', $user_name . ' has updated the user information for - ' . $data['firstName'], 'user', $userId);
        }
        $response = DB::delete('delete from users_testsite_map where user_id = ?', [base64_decode($id)]);
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
        $userservice = new UserService();
        $result = json_decode(DB::table('users')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->join('users_testsite_map', 'users_testsite_map.user_id', '=', 'users.user_id')
            ->where('users.email', '=', $data['username'])
            ->where('user_status', '=', 'active')
            ->get(), true);            


        if (!empty($result)) {
            foreach ($result as $value) {
                Session::push('tsId', $value['ts_id']);
            }

            $result = json_decode(DB::table('users')
                ->join('roles', 'roles.role_id', '=', 'users.role_id')
                ->where('users.email', '=', $data['username'])
                ->where('user_status', '=', 'active')
                ->get(), true);
        }

        if (!empty($result)) {
            $hashedPassword = $result[0]['password'];
            // var_dump(($data['password']));
            // var_dump(Hash::make($data['password']));die;
            // var_dump(Hash::check($data['password'], $hashedPassword));
            //var_dump($hashedPassword);die;
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
                    if($result[0]['language'] != NULL){
                        app()->setLocale($result[0]['language']);
                        session()->put('locale', $result[0]['language']);
                    }                    
                    $commonservice->eventLog('login', $result[0]['first_name'] . ' logged in', 'user',$userId);
                    $userservice->loggedInHistory($data,'success');
                } else {
                    return 2;
                }
                return 1;
            } else {
                $userservice->loggedInHistory($data,'failed');
                return 0;
            }
        } else {
            $userservice->loggedInHistory($data,'failed');
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
                'language' => $data['locale'],
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
                $commonservice->eventLog('update-user-profile-request', $user_name . ' has updated the user profile information', 'user-profile', $userId);
            }
        }
        return $response;
    }

    //Update Password
    public function updatePassword($params)
    {
        $commonservice = new CommonService();
        $userservice = new UserService();
        $userId = null;
        $user_name = session('name');
        $data = $params->all();
        $data['username']=$user_name;
        $id = session('userId');
        $newPassword = Hash::make($data['newPassword']);
        if (Hash::check($data['currentPassword'], $newPassword)) {
            return 0;
        } else {
            $result = json_decode(DB::table('users')->where('user_id', '=', $id)->get(), true);
            //dd($result);
            if (count($result) > 0) {
                $hashedPassword = $result[0]['password'];
                //dd($hashedPassword,Hash::make($data['currentPassword']));
                if (Hash::check($data['currentPassword'], $hashedPassword)) {
                    $response = DB::table('users')
                        ->where('user_id', '=', $id)
                        ->update(
                            [
                                'password' => $newPassword,
                                'force_password_reset' => 0
                            ]
                        );
                    $commonservice->eventLog('change-password-request', $user_name . ' has changed the password information', 'change-password', $userId);
                    $userservice->loggedInHistory($data, $user_name . ' has changed the password information');
                    return $response;
                }
            } else {
                return 0;
            }
        }
    }

    public function resetForgotPassword($email, $newpassword)
    {
        $changepassword = DB::table('users')->where('email', $email)
        ->update(['password' => Hash::make($newpassword)]);
        return $changepassword;
    }
}
