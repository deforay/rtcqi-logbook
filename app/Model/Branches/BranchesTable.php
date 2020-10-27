<?php

namespace App\Model\Branches;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\BranchesService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class BranchesTable extends Model
{
    protected $table = 'branches';

    //add Branches
    public function saveBranches($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('branchName')!=null && trim($request->input('branchName')) != '') {
            $id = DB::table('branches')->insertGetId(
                [
                'branch_name'       => $data['branchName'],
                'branch_code'       =>$data['branchCode'],
                'branch_type_id'    => $data['branchType'],
                'phone'             => $data['mobileNo'],
                'email'             => $data['email'],
                'address_line_1'    => $data['addressLine1'],
                'address_line_2'    => $data['addressLine2'],
                'country'           => $data['country'],
                'state'             => $data['state'],
                'city'              => $data['city'],
                'pincode'           => $data['pincode'],
                'branch_status'     => $data['branchStatus'],
                'created_by'        => session('userId'),
                'created_on'        => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Branch-add', 'Add Branch '.$data['branchName'], 'Branch');
        }
        return $id;
    }

    // Fetch All Branches List
    public function fetchAllBranches()
    {
        $data = DB::table('branches')
                ->join('branch_types', 'branch_types.branch_type_id', '=', 'branches.branch_type_id')
                ->join('countries', 'countries.country_id', '=', 'branches.country')
                ->get();
        return $data;
    }

    // Fetch All Active Branch es List
    public function fetchAllActiveBranches()
    {
        $data = DB::table('branches')
                ->where('branch_status','=','active')
                ->get();
        return $data;
    }

    
    // Fetch All Active Branch es List
    public function fetchBranchesByUser()
    {
        $user = DB::table('user_branch_map')->where('user_id','=',session('userId'))->get();
        if(session('loginType') == 'vendor'){
            $data = DB::table('branches')
            ->where('branch_status','=','active')
            ->get();
        }
        else{
            if(count($user)>0){
                if(strtolower(session('roleName'))=='admin'){
                    $data = DB::table('branches')
                            ->where('branch_status','=','active')
                            ->get();
                }
                else{
                    $data = DB::table('user_branch_map')
                        ->join('branches', 'branches.branch_id', '=', 'user_branch_map.branch_id')
                        ->where('user_branch_map.user_id','=',session('userId'))
                        ->get();
                }

            }
            else{
                $data = DB::table('branches')
                    ->where('branch_status','=','active')
                    ->get();
            }
        }
        return $data;
    }

     // fetch particular Branch es details
     public function fetchBranchesById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('branches')
                ->join('branch_types', 'branch_types.branch_type_id', '=', 'branches.branch_type_id')
                ->join('countries', 'countries.country_id', '=', 'branches.country')
                 ->where('branches.branch_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular Branch es details
    public function updateBranches($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('branchName')!=null && trim($params->input('branchName')) != '') {
            $response = DB::table('branches')
                ->where('branch_id', '=',base64_decode($id))
                ->update(
                    [
                        'branch_name'     => $data['branchName'],
                        'branch_code'     =>$data['branchCode'],
                        'branch_type_id'  => $data['branchType'],
                        'phone'           => $data['mobileNo'],
                        'email'           => $data['email'],
                        'address_line_1'  => $data['addressLine1'],
                        'address_line_2'  => $data['addressLine2'],
                        'country'         => $data['country'],
                        'state'           => $data['state'],
                        'city'            => $data['city'],
                        'pincode'         => $data['pincode'],
                        'branch_status'   => $data['branchStatus'],
                        'updated_on'      => $commonservice->getDateTime(),
                        'updated_by'      => session('userId'),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Branch-update', 'Update Branch'.$data['branchName'], 'Branch');
        }
        return $response;
    }
}
