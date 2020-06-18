<?php

namespace App\Model\BranchType;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\BranchTypeService;
use App\Service\CommonService;

class BranchTypeTable extends Model
{
    protected $table = 'branch_types';

    //add BranchType
    public function saveBranchType($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('branchTypeName')!=null && trim($request->input('branchTypeName')) != '') {
            $id = DB::table('branch_types')->insertGetId(
                ['branch_type' => $data['branchTypeName'],
                'branch_type_status' => $data['branchTypeStatus'],
                'created_on' => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Branch Type-add', 'Add Branch Type '.$data['branchTypeName'], 'Branch Type');
        }
        return $id;
    }

    // Fetch All Branch Type List
    public function fetchAllBranchType()
    {
        $data = DB::table('branch_types')
                ->get();
        return $data;
    }

    // Fetch All Active Branch Type List
    public function fetchAllActiveBranchType()
    {
        $data = DB::table('branch_types')
                ->where('branch_type_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular Branch Type details
     public function fetchBranchTypeById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('branch_types')
                 ->where('branch_type_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular Branch Type details
    public function updateBranchType($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('branchTypeName')!=null && trim($params->input('branchTypeName')) != '') {
            $response = DB::table('branch_types')
                ->where('branch_type_id', '=',base64_decode($id))
                ->update(
                    ['branch_type' => $data['branchTypeName'],
                    'branch_type_status' => $data['branchTypeStatus'],
                    'updated_on' => $commonservice->getDateTime(),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Branch Type-update', 'Update Branch Type '.$data['branchTypeName'], 'Branch Type');
        }
        return $response;
    }
}
