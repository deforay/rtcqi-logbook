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
        $data = DB::table('global_config')
            ->get();
        return $data;
    }

    // Update particular GlobalConfig details
    public function updateGlobalConfig($params)
    {
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
        if ($data['removed'] != null) {
            unlink(public_path($data['removed']));
            $upData = array(
                'global_value' => $filePathName,
            );
            DB::table('global_config')
                ->where('global_name', '=', 'logo')
                ->update($upData);
        } else {
            if (isset($data['uploadFile'])) {
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
                if ($filePathName) {
                    $upData = array(
                        'global_value' => $filePathName,
                    );
                    DB::table('global_config')
                        ->where('global_name', '=', 'logo')
                        ->update($upData);
                }
            }
        }

        $userTracking = DB::table('track')->insertGetId(
            [
                'event_type' => 'update-global-config-request',
                'action' => $user_name . ' has updated the global config information',
                'resource' => 'global-config',
                'date_time' => $commonservice->getDateTime(),
                'ip_address' => request()->ip(),
            ]
        );
        // dd($filePathName);die;
        return 1;
    }

    public function fetchGlobalConfigValue($configName)
    {
        //select global_value from global_config where global_name='no_of_test'
        $data = DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $configName)
            ->value('global_value');
        return $data;
    }

    public function fetchGlobalConfigData($configName)
    {
        $data = DB::table('global_config')
            ->select('display_name')
            ->where('global_name', '=', $configName)
            ->value('global_name');
        return $data;
    }

    public function fetchGlobalConfigLatitide($latitute)
    {
        $data = DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $latitute)
            ->value('global_value');
        return $data;
    }

    public function fetchGlobalConfigLongitude($longitude)
    {
        $data = DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $longitude)
            ->value('global_value');
        return $data;
    }

    public function fetchGlobalConfigMapZoomLevel($mapZoomLevel)
    {
        $data = DB::table('global_config')
            ->select('global_value')
            ->where('global_name', '=', $mapZoomLevel)
            ->value('global_value');
        return $data;
    }
}
