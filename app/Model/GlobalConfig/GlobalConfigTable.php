<?php

namespace App\Model\GlobalConfig;
use DB;
use Illuminate\Database\Eloquent\Model;

class GlobalConfigTable extends Model
{
    //
    protected $table = 'global_config';

    // Fetch All config List
    public function fetchAllConfig()
    {
        $data = DB::table('global_config')->where('allow_admin_edit','=','yes')
                ->get();
        return $data;
    }

    public function fetchGlobalConfigLogo(){
        $data = DB::table('global_config')->where('allow_admin_edit','=','yes')->where('global_name','=','logo_path')
                ->get();
        return $data;
    }

    public function fetchAllConfigEdit()
    {
        $data = DB::table('global_config')->where('allow_admin_edit','=','yes')
                ->get();
        $configValues = $data->toArray();
        //$arr = array();
        //for ($i = 0; $i < count($configValues); $i++) {
          //  $arr[$configValues[$i]->display_name] = $configValues[$i]->global_value;
        //}
        return $configValues;
    }

    // Update global config details
    public function updateGlobalConfig($params)
    {
        $data = $params->all();
        $res = 0;
        // dd($data);
        foreach ($data as $fieldName => $fieldValue) {
            if($fieldName != '_token'){
                $columnName = str_replace("_"," ",$fieldName);
                    $configdata = array(
                                'global_value' => $fieldValue,
                                );
                    $response = DB::table('global_config')->where('display_name' , $columnName)
                                ->update($configdata);
                if($response){
                    $res = 1;
                }
            }
        }
        return $res;
    }
}
