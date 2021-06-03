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
        $data = $params->all();
            if($data['instance_name'])
            {
                $upData = array(
                    'global_value' => $data['instance_name'],
                );
                $response = DB::table('global_config')
                    ->where('global_name', '=','instance_name')
                    ->update($upData);
            }
            if($data['institute_name'])
            {
                $upData = array(
                    'global_value' => $data['institute_name'],
                );
                $response = DB::table('global_config')
                    ->where('global_name', '=','institute_name')
                    ->update($upData);
            }
            if($data['admin_name'])
            {
                $upData = array(
                    'global_value' => $data['admin_name'],
                );
                $response = DB::table('global_config')
                    ->where('global_name', '=','admin_name')
                    ->update($upData);
            }
            if($data['admin_email'])
            {
                $upData = array(
                    'global_value' => $data['admin_email'],
                );
                $response = DB::table('global_config')
                    ->where('global_name', '=','admin_email')
                    ->update($upData);
            }
            if($data['admin_phone'])
            {
                $upData = array(
                    'global_value' => $data['admin_phone'],
                );
                $response = DB::table('global_config')
                ->where('global_name', '=','admin_phone')
                    ->update($upData);
            }
            if($data['recency_test'])
            {
                $upData = array(
                    'global_value' => $data['recency_test'],
                );
                $response = DB::table('global_config')
                ->where('global_name', '=','recency_test')
                    ->update($upData);
            }
            if($data['no_of_test'])
            {
                $upData = array(
                    'global_value' => $data['no_of_test'],
                );
                $response = DB::table('global_config')
                ->where('global_name', '=','no_of_test')
                    ->update($upData);
            }
        return 1;
    }

    
}
