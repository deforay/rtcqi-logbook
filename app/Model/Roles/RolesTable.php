<?php

namespace App\Model\Roles;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\RolesService;
use Illuminate\Support\Facades\File;
use App\Service\CommonService;

class RolesTable extends Model
{
    //
    protected $table = 'roles';
    public function saveRoles($request)
    {
        //to get all request values
        $data = $request->all();
        if ($request->input('roleName') != null && trim($request->input('roleName')) != '') {
            $id = DB::table('roles')->insertGetId(
                [
                    'role_name' => $data['roleName'],
                    'role_code' => $data['roleCode'],
                    'role_description' => $data['Description'],
                    'role_status' => $data['rolesStatus'],
                ]
            );
        }
        return $id;
    }

    // Fetch All Roles List
    public function fetchAllRole()
    {
        $data = DB::table('roles')
            ->get();
        return $data;
    }

    // Fetch All Active Roles List
    public function fetchAllActiveRole()
    {
        $data = DB::table('roles')
            ->where('role_status', '=', 'active')
            ->get();
        return $data;
    }

    // fetch particular roles details
    public function fetchRolesById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('roles')
            ->where('role_id', '=', $id)->get();
        return $data;
    }

    // Update particular roles details
    public function updateRoles($params, $id)
    {
        $data = $params->all();
        if ($params->input('eroleName') != null && trim($params->input('eroleName')) != '') {
            $response = DB::table('roles')
                ->where('role_id', '=', base64_decode($id))
                ->update(
                    [
                        'role_name' => $data['eroleName'],
                        'role_code' => $data['roleCode'],
                        'role_description' => $data['eDescription'],
                        'role_status' => $data['erolesStatus'],
                    ]
                );
        }
        return 1;
    }
    //fetch all resource
    public function fetchAllResource()
    {
        $resourceResult = DB::table('resources')->orderBy('display_name', 'asc')->get();
        $count = count($resourceResult);
        for ($i = 0; $i < $count; $i++) {
            $resourceResult[$i]->privilege = DB::table('privileges')
                ->where('resource_id', '=', $resourceResult[$i]->resource_id)
                ->orderBy('display_name', 'asc')->get();
        }
        return $resourceResult;
    }

    //Role Save in Acl File
    public function mapRolePrivilege($params,$id)
    {
        // dd($id);die;
        try {
            $configFile =  "acl.config.json";
            // dd(config_path() . DIRECTORY_SEPARATOR . $configFile);die;
            if (file_exists(config_path() . DIRECTORY_SEPARATOR . $configFile))
                $config = json_decode(File::get(config_path() . DIRECTORY_SEPARATOR . $configFile), true);
            else
                $config = array();
            $config[$id] = array();

            if (isset($params['resource']) && $params['resource'] != '' && $params['resource'] != null) {
                foreach ($params['resource'] as $resourceName => $privilege) {
                    $config[$id][$resourceName] = $privilege;
                }
            }
            if (!is_writable(config_path() . DIRECTORY_SEPARATOR . $configFile))
                chmod(config_path() . DIRECTORY_SEPARATOR . $configFile, 0755);
            File::put(config_path() . DIRECTORY_SEPARATOR . $configFile, json_encode($config));
        } catch (Exception $exc) {

            error_log($exc->getMessage());
            error_log($exc->getTraceAsString());
        }
    }
}
