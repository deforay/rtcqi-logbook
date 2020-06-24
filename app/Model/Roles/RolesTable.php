<?php

namespace App\Model\Roles;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\RolesService;
use Illuminate\Support\Facades\File;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class RolesTable extends Model
{
    //fetch all resource
    public function fetchAllResource(){
        $resourceResult = DB::table('resources')->orderBy('display_name','asc')->get();
        $count = count($resourceResult);
        for ($i = 0; $i < $count; $i++) {
            $resourceResult[$i]->privilege = DB::table('privileges')
                                            ->where('resource_id', '=',$resourceResult[$i]->resource_id)
                                            ->orderBy('display_name','asc')->get();
        }
        return $resourceResult;
    }

    protected $table = 'roles';

    //add roles
    public function saveRoles($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('roleName')!=null && trim($request->input('roleName')) != '') {
            $id = DB::table('roles')->insertGetId(
                ['role_name' => $data['roleName'],
                'role_code' => $data['roleCode'],
                'role_description' => $data['Description'],
                'role_status' => $data['rolesStatus'],
                'created_on' => $commonservice->getDateTime(),
                'created_by' => session('userId'),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Role-add', 'Add Role '.$data['roleName'], 'Role');
        }
        return $id;
    }

    //Role Save in Acl File
    public function mapRolePrivilege($params) {
        try {
            $roleCode=$params['roleCode'];
            $configFile =  "acl.config.json";
            if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile))
            {
                if(!is_writable(getcwd() . DIRECTORY_SEPARATOR . $configFile))
                    chmod (getcwd() . DIRECTORY_SEPARATOR . $configFile , 0755 );
                $config = json_decode(File::get( getcwd() . DIRECTORY_SEPARATOR . $configFile),true);
            }
            else
                $config = array();
                $config[$roleCode] = array();
                // dump($params['resource']); die;
            foreach ($params['resource'] as $resourceName => $privilege) {
                $config[$roleCode][$resourceName] = $privilege;
            }
            File::put( getcwd() . DIRECTORY_SEPARATOR . $configFile, json_encode($config));
            
        } catch (Exception $exc) {
    
            error_log($exc->getMessage());
            error_log($exc->getTraceAsString());
        }
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
                ->where('role_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular roles details
     public function fetchRolesById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('roles')
                 ->where('role_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular roles details
    public function updateRoles($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('eroleName')!=null && trim($params->input('eroleName')) != '') {
            $response = DB::table('roles')
                ->where('role_id', '=',base64_decode($id))
                ->update(
                ['role_name' => $data['eroleName'],
                'role_code' => $data['roleCode'],
                'role_description' => $data['eDescription'],
                'role_status' => $data['erolesStatus'],
                'updated_on' => $commonservice->getDateTime(),
                'updated_by' => session('userId'),
                ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Role-update', 'Update Role '.$data['eroleName'], 'Role');
        }
        return 1;
    }
}
