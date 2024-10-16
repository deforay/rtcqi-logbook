<?php

namespace App\Model\User;

use App\Model\Roles\RolesTable;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\UserService;
use App\Service\DistrictService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;
use Illuminate\Support\Facades\File;
use LDAP\Result;
use App\Service\GlobalConfigService;

class UserTable extends Model
{
    protected $table = 'users';

    //add User
    public function saveUser($request)
    {
        //to get all request values
        $userId = null;
        $data = $request->all();
        // print_r($data); die;
        $user_name = session('name');

        // update session by user giving language
        App::setLocale($data['prefered_language']);
        session(['locale' => $data['prefered_language']]);
        //dd($data);die;
        $commonservice = new CommonService();
        DB::beginTransaction();
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
                    'last_login_datetime' => $commonservice->getDateTime(),  
                    'force_password_reset' => 1,
                    'role_id' => $data['roleId'],
                    'prefered_language' => $data['prefered_language'],
                    'user_mapping' => $data['userMapping']
                ]
            );

            // update global config
            $upData = array(
                'global_value' => $data['prefered_language'],
            );
            DB::table('global_config')
                ->where('global_name', '=', 'prefered_language')
                ->update($upData);
            if ($data['userMapping'] == 1) {
                if ($id > 0 && trim($data['testSiteName']) != '' && ($id > 0 && trim($data['testSiteName']) != '')) {
                    $selectedSiteName = explode(",", $data['testSiteName']);
                    $uniqueSiteId = array_unique($selectedSiteName);
                    $counter = count($selectedSiteName);
                    for ($x = 0; $x < $counter; $x++) {
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
            } else {
                if (isset($data['provinceMappingId']) && count($data['provinceMappingId']) > 0) {
                    foreach($data['provinceMappingId'] as $key => $val) {
                        $newLocationMappingId = DB::table('users_location_map')->insertGetId(
                            [
                                'user_id' => $id,
                                'province_id' => $val,
                                'district_id' => null
                            ]
                        );

                        $selectedSites = DB::table('test_sites')
                            ->select('ts_id')
                            ->where('site_province', '=', $val)
                            ->get();
                        if (count($selectedSites) > 0) {
                            for ($i = 0; $i < count($selectedSites); $i++) {
                                $userFacility = DB::table('users_testsite_map')->insertGetId(
                                    [
                                        'user_id' => $id,
                                        'ts_id' => $selectedSites[$i]->ts_id,
                                    ]
                                );
                            }
                        }
                    }
                }
                if (isset($data['districtMappingId']) && count($data['districtMappingId']) > 0) {
                   
                    foreach($data['districtMappingId'] as $key => $val) {
                        $districtservice = new DistrictService();
                        $districtDetail = $districtservice->getDistrictById(base64_encode($val));
                        $province_id = $districtDetail[0]->province_id;
                        DB::table('users_location_map')->insertGetId(
                            [
                                'user_id' => $id,
                                'province_id' => $province_id,
                                'district_id' => $val
                            ]
                        );

                        $selectedSites = DB::table('test_sites')
                            ->select('ts_id')
                            ->where('site_province', '=', $province_id)
                            ->where('site_district', '=', $val)
                            ->get();
                        if (count($selectedSites) > 0) {
                            for ($i = 0; $i < count($selectedSites); $i++) {
                                $userFacility = DB::table('users_testsite_map')->insertGetId(
                                    [
                                        'user_id' => $id,
                                        'ts_id' => $selectedSites[$i]->ts_id,
                                    ]
                                );
                            }
                        }
                    }
                }
            }
            DB::commit();
            $commonservice->eventLog('add-user-request', $user_name . ' added user ' . $data['firstName'] . ' User', 'user', $userId);
        }

        return $id;
    }

    public function saveNewUser($data)
    {
        $id = 0;
        $commonservice = new CommonService();
        if ($data['firstName'] != null && trim($data['firstName']) != '') {
            $id = DB::table('users')->insertGetId(
                [
                    'first_name' => $data['firstName'],
                    'last_name' => $data['lastName'],
                    'password' => Hash::make($data['password']), // Hashing passwords
                    'email' => $data['email'],
                    'user_status' => 'active',
                    'created_by' => null,
                    'created_on' => $commonservice->getDateTime(),
                    'force_password_reset' => 1,
                    'role_id' => 1
                ]
            );
            $result = DB::table('test_sites')->take(1)->get();
            if ($result->count() > 0) {
                $ts_id = $result[0]->ts_id;
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
        return DB::table('users')
            ->get();
    }

    // Fetch All Active User List
    public function fetchAllActiveUser()
    {
        return DB::table('users')
            ->where('user_status', '=', 'active')
            ->get();
    }

    // fetch particular User details
    public function fetchUserById($id)
    {

        $id = base64_decode($id);
        return DB::table('users')->select('users.*', 'roles.*')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->leftjoin('users_testsite_map', 'users_testsite_map.user_id', '=', 'users.user_id')
            ->where('users.user_id', '=', $id)
            ->get();
    }

    public function fetchUserByEmail($email)
    {
        return DB::table('users')
            // ->join('roles', 'roles.role_id', '=', 'users.role_id')
            // ->leftjoin('users_testsite_map', 'users_testsite_map.user_id', '=', 'users.user_id')
            ->where('users.email', '=', $email)
            ->get();
    }

    public function updateUserLanguage($locale)
    {
        $userid = session('userId');
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
        $loggedInUser = session('userId');
        $user = array(
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['mobileNo'],
            'user_status' => $data['userStatus'],
            'role_id' => $data['roleId'],
            'updated_by' => session('userId'),
            'prefered_language' => $data['prefered_language'],
            'user_mapping' => $data['userMapping']
        );
        if ($loggedInUser == 1) { // admin
            $user['last_login_datetime'] = $commonservice->getDateTime(); // Current date and time
        }
        // refresh user updated language
        App::setLocale($data['prefered_language']);
        session(['locale' => $data['prefered_language']]);
        $response = DB::table('users')
            ->where('user_id', '=', base64_decode($id))
            ->update(
                $user
            );

        // update global config
        $upData = array(
            'global_value' => $data['prefered_language'],
        );
        DB::table('global_config')
            ->where('global_name', '=', 'prefered_language')
            ->update($upData);

        if (trim($data['password']) !== '' && trim($data['password']) !== '0') {
            $user['password'] = Hash::make($data['password']); // Hashing passwords
            $response = DB::table('users')
                ->where('user_id', '=', base64_decode($id))
                ->update(
                    $user
                );
        }
        if ($response == 1) {
            $forcePassword = $data['password'] == '' ? 0 : 1;
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
        $testSiteResponse = DB::delete('delete from users_testsite_map where user_id = ?', [base64_decode($id)]);
        $locationResponse = DB::delete('delete from users_location_map where user_id = ?', [base64_decode($id)]);
        if (base64_decode($id) != '' && trim($data['testSiteName']) != '') {
            $selectedSiteName = explode(",", $data['testSiteName']);
            $uniqueSiteId = array_unique($selectedSiteName);
            $counter = count($selectedSiteName);
            for ($x = 0; $x < $counter; $x++) {
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

        if ($data['userMapping'] == 1) {
            if (base64_decode($id) != '' && trim($data['testSiteName']) != '') {
                $selectedSiteName = explode(",", $data['testSiteName']);
                $uniqueSiteId = array_unique($selectedSiteName);
                $counter = count($selectedSiteName);
                for ($x = 0; $x < $counter; $x++) {
                    if (isset($uniqueSiteId[$x])) {
                        $userFacility = DB::table('users_testsite_map')->insertGetId(
                            [
                                'user_id' => base64_decode($id),
                                'ts_id' => $selectedSiteName[$x],
                            ]
                        );
                    }
                }
            }
        } else {
            if (isset($data['provinceMappingId']) && count($data['provinceMappingId']) > 0) {
                foreach($data['provinceMappingId'] as $key => $val) {
                   $newLocationMappingId = DB::table('users_location_map')->insertGetId(
                        [
                            'user_id' => base64_decode($id),
                            'province_id' => $val,
                            'district_id' => null
                        ]
                    );

                    $selectedSites = DB::table('test_sites')
                        ->select('ts_id')
                        ->where('site_province', '=', $val)
                        ->get();
                    if (count($selectedSites) > 0) {
                        for ($i = 0; $i < count($selectedSites); $i++) {
                            $userFacility = DB::table('users_testsite_map')->insertGetId(
                                [
                                    'user_id' => base64_decode($id),
                                    'ts_id' => $selectedSites[$i]->ts_id,
                                ]
                            );
                        }
                    }
                }
            }
            if (isset($data['districtMappingId']) && count($data['districtMappingId']) > 0) {
                foreach($data['districtMappingId'] as $key => $val) {
                    $districtservice = new DistrictService();
                    $districtDetail = $districtservice->getDistrictById(base64_encode($val));
                    $province_id = $districtDetail[0]->province_id;
                    // print_r($province_id); die;
                    DB::table('users_location_map')->insertGetId(
                        [
                            'user_id' => base64_decode($id),
                            'province_id' => $province_id,
                            'district_id' => $val
                        ]
                    );

                    $selectedSites = DB::table('test_sites')
                        ->select('ts_id')
                        ->where('site_province', '=', $province_id)
                        ->where('site_district', '=', $val)
                        ->get();
                    //print_r();exit();
                    if (count($selectedSites) > 0) {
                        for ($i = 0; $i < count($selectedSites); $i++) {
                            $userFacility = DB::table('users_testsite_map')->insertGetId(
                                [
                                    'user_id' => base64_decode($id),
                                    'ts_id' => $selectedSites[$i]->ts_id,
                                ]
                            );
                        }
                    }
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
        $globalConfigService = new GlobalConfigService();
        $disableInactiveUser = $globalConfigService->getGlobalConfigValue('disable_inactive_user');


        $result = json_decode(DB::table('users')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->leftJoin('users_testsite_map', 'users_testsite_map.user_id', '=', 'users.user_id')
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
                if ($disableInactiveUser == 'yes') {
                    $currentDate = Date("d-M-Y");
                    $lastLoginDatetime = $result[0]['last_login_datetime'];
                    //Calculate number of month
                    $diff = abs(strtotime($currentDate) - strtotime($lastLoginDatetime));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $noOfMonths = $globalConfigService->getGlobalConfigValue('disable_user_no_of_months');
                    if (trim($noOfMonths) == "") {
                        $noOfMonths = 6;
                    }
                    if ($months >= $noOfMonths) {
                        $response = DB::table('users')
                            ->where('user_id', '=', $result[0]['user_id'])
                            ->update(array('user_status' => 'inactive'));
                        return 2;
                    }
                }
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
                    if ($result[0]['language'] != NULL) {
                        app()->setLocale($result[0]['language']);
                        session()->put('locale', $result[0]['language']);
                    }
                    $commonservice->eventLog('login', $result[0]['first_name'] . ' logged in', 'user', $userId);
                    $userservice->loggedInHistory($data, 'success');
                    $response = DB::table('users')
                        ->where('user_id', '=', $result[0]['user_id'])
                        ->update(array('last_login_datetime' => $commonservice->getDateTime()));
                } else {
                    return 2;
                }
                return 1;
            } else {
                $userservice->loggedInHistory($data, 'failed');
                return 0;
            }
        } else {
            $userservice->loggedInHistory($data, 'failed');
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
                'prefered_language' => $data['locale'],
                'updated_by' => session('userId')
            );

            $response = DB::table('users')
                ->where('user_id', '=', base64_decode($id))
                ->update(
                    $user
                );
            
            // update global config
            $upData = array(
                'global_value' => $data['locale'],
            );
            DB::table('global_config')
                ->where('global_name', '=', 'prefered_language')
                ->update($upData);

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
        $data['username'] = $user_name;
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
        return DB::table('users')->where('email', $email)
            ->update(['password' => Hash::make($newpassword)]);
    }

    public function bulkUploadUser($params)
    {
        $commonservice = new CommonService();
        if (isset($params['user_excel']) && $params['user_excel']->isValid()) {
            DB::beginTransaction();
            try {
                $dateTime = date('Ymd_His');
                $file = $params['user_excel'];
                $fileName = $dateTime . '-' . $file->getClientOriginalName();
                $savePath = public_path('/uploads/');
                $file->move($savePath, $fileName);
    
                $filePath = $savePath . $fileName;
                $file_type = IOFactory::identify($filePath);
                $reader = IOFactory::createReader($file_type);
                $reader->setReadDataOnly(true);
                $reader->setReadEmptyCells(false);
                $spreadsheet = $reader->load($filePath);
                unlink($filePath);
    
                $sheetDatas = $spreadsheet->getActiveSheet()->toArray();
                // unset($sheetDatas[0]);
                foreach($sheetDatas as $key=>$val)
                {
                    $role = new RolesTable();
                    $roleId = $role->checkRole($val[6]);
                    $id = DB::table('users')->insertGetId(
                        [
                            'first_name' => $val[0],
                            'last_name' => $val[1],
                            'password' => Hash::make('logbook#12345@'), // Hashing passwords
                            'email' => $val[3],
                            'phone' => $val[2],
                            'created_by' => session('userId'),
                            'created_on' => $commonservice->getDateTime(),
                            'force_password_reset' => 1,
                            'role_id' => $roleId
                        ]
                    );
                }   
                return $id;
            } catch (Exception $exc) {
                DB::rollBack();
                $result = "Error: " . $exc->getMessage();
                return $result;
            }
            DB::commit();
            return "File uploaded and processed successfully";
        } else {
            return "No file uploaded or invalid file.";
        }
    }
}
