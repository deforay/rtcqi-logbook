<?php

namespace App\Model\GlobalConfig;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class GlobalConfigTable extends Model
{
    protected $table = 'global_config';

    // Fetch All GlobalConfig List
    public function fetchAllGlobalConfig()
    {
        return DB::table('global_config')
            ->get();
    }

    // Update particular GlobalConfig details
    public function updateGlobalConfig($params)
    {
        $userId = null;
        $filePathName = '';
        $user_name = session('name');
        $commonservice = new CommonService();
        $data = $params->all();
        if ($data['instance_name']) {
            $upData = array(
                'global_value' => $data['instance_name'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'instance_name')
                ->update($upData);
        }
        if ($data['institute_name']) {
            $upData = array(
                'global_value' => $data['institute_name'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'institute_name')
                ->update($upData);
        }
        if ($data['admin_name']) {
            $upData = array(
                'global_value' => $data['admin_name'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'admin_name')
                ->update($upData);
        }
        if ($data['admin_email']) {
            $upData = array(
                'global_value' => $data['admin_email'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'admin_email')
                ->update($upData);
        }
        if ($data['admin_phone']) {
            $upData = array(
                'global_value' => $data['admin_phone'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'admin_phone')
                ->update($upData);
        }
        if ($data['recency_test']) {
            $upData = array(
                'global_value' => $data['recency_test'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'recency_test')
                ->update($upData);
        }
        if ($data['no_of_test']) {
            $upData = array(
                'global_value' => $data['no_of_test'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'no_of_test')
                ->update($upData);
        }

        if ($data['latitude']) {
            $upData = array(
                'global_value' => $data['latitude'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'latitude')
                ->update($upData);
        }
        if ($data['longitude']) {
            $upData = array(
                'global_value' => $data['longitude'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'longitude')
                ->update($upData);
        }
        if ($data['title_name']) {
            $upData = array(
                'global_value' => $data['title_name'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'title_name')
                ->update($upData);
        }
        if ($data['map_zoom_level']) {
            $upData = array(
                'global_value' => $data['map_zoom_level'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'map_zoom_level')
                ->update($upData);
        }

        if ($data['testing_algorithm']) {
            $data['testing_algorithm']=implode(",",$data['testing_algorithm']);
            $upData = array(
                'global_value' => $data['testing_algorithm'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'testing_algorithm')
                ->update($upData);
        }

        if ($data['training_mode']) {
            $upData = array(
                'global_value' => $data['training_mode'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'training_mode')
                ->update($upData);
                session()->put('training_mode', $data['training_mode']);
            }

        if (isset($data['training_message'])) {
            $upData = array(
                'global_value' => $data['training_message'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'training_message')
                ->update($upData);
            
            session()->put('training_message', $data['training_message']);
        }

        if (isset($data['default_testing_algorithm'])) {
            $upData = array(
                'global_value' => $data['default_testing_algorithm'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'default_testing_algorithm')
                ->update($upData);
        }

        if ($data['prefered_language']) {
            $upData = array(
                'global_value' => $data['prefered_language'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'prefered_language')
                ->update($upData);
            
                // update to users table
                 DB::table('users')
                ->where('user_id', '=', session('userId'))
                ->update(['prefered_language' => $data['prefered_language']]);

                app()->setLocale($data['prefered_language']);
                session()->put('locale', $data['prefered_language']);
        }
        
        if ($data['disable_inactive_user']) {
            $upData = array(
                'global_value' => $data['disable_inactive_user'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'disable_inactive_user')
                ->update($upData);
        }

        if ($data['disable_user_no_of_months']) {
            $upData = array(
                'global_value' => $data['disable_user_no_of_months'],
            );
            $response = DB::table('global_config')
                ->where('global_name', '=', 'disable_user_no_of_months')
                ->update($upData);
        } elseif ($data['disable_inactive_user']=='yes' && trim($data['disable_user_no_of_months'])=="") {
            $upData = array(
                'global_value' => '6',
            );
            $response = DB::table('global_config')
            ->where('global_name', '=', 'disable_user_no_of_months')
            ->update($upData);
        } else{
            $upData = array(
                'global_value' => NULL,
            );
            $response = DB::table('global_config')
            ->where('global_name', '=', 'disable_user_no_of_months')
            ->update($upData);
        }
        
        if ($data['removed'] != null) {
            unlink(public_path($data['removed']));
            $upData = array(
                'global_value' => $filePathName,
            );
            DB::table('global_config')
                ->where('global_name', '=', 'logo')
                ->update($upData);
        } elseif (isset($data['uploadFile'])) {
            $filePathName = '';
            $fileName = '';
            $extension = '';
            if (isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != '') {
                if (!file_exists(public_path('uploads')) && !is_dir(public_path('uploads'))) {
                    mkdir(public_path('uploads'), 0755, true);
                    // chmod (getcwd() .public_path('uploads'), 0755 );
                }

                if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "logo") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "logo")) {
                    mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "logo", 0755);
                }

                $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "logo";
                $pathnameDb = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . "logo";

                if (!file_exists($pathname) && !is_dir($pathname)) {
                    mkdir($pathname);
                }
                $extension = strtolower(pathinfo($pathname . DIRECTORY_SEPARATOR . $_FILES['uploadFile']['name'][0], PATHINFO_EXTENSION));
                $ext = '.' . $extension;
                $orgFileName = explode($ext, $_FILES['uploadFile']['name'][0]);
                $orgFileName = str_replace(' ', '-', $orgFileName);
                $fileName = $orgFileName[0] . '@@' . time() . "." . $extension;

                $filePath = $pathnameDb . DIRECTORY_SEPARATOR . $fileName;
                move_uploaded_file($_FILES["uploadFile"]["tmp_name"][0], $pathname . DIRECTORY_SEPARATOR . $fileName);
                $filePathName .= $filePath;
            }
            if ($filePathName !== '' && $filePathName !== '0') {
                $upData = array(
                    'global_value' => $filePathName,
                );
                DB::table('global_config')
                    ->where('global_name', '=', 'logo')
                    ->update($upData);
            }
        }
        $commonservice->eventLog('update-global-config-request', $user_name . ' has updated the global config information', 'global-config',$userId);
        return 1;
    }

    public function fetchGlobalConfigValue($configName)
    {
        return DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $configName)
            ->value('global_value');
    }

    public function fetchGlobalConfigData($configName)
    {
        return DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $configName)
            ->value('global_name');
    }

    public function fetchGlobalConfigLatitide($latitute)
    {
        return DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $latitute)
            ->value('global_value');
    }

    public function fetchGlobalConfigLongitude($longitude)
    {
        return DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $longitude)
            ->value('global_value');
    }

    public function fetchGlobalConfigMapZoomLevel($mapZoomLevel)
    {
        return DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $mapZoomLevel)
            ->value('global_value');
    }

    public function getTestingAlgorithms()
    {
        return DB::table('global_config')
        ->select('global_value')
        ->where('global_name', 'testing_algorithm')
        ->value('global_value');
    }
}
