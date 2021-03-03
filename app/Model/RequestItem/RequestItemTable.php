<?php

namespace App\Model\RequestItem;

use Illuminate\Database\Eloquent\Model;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;
use DB;

class RequestItemTable extends Model
{
    public function saveRequestItem($request)
    {
        $data = $request->all();
        // dd($data);
        $autoId = 0;
        $commonservice = new CommonService();
        // dd($commonservice->getDateTime());
        for ($j = 0; $j < count($data['item']); $j++) {
            $neededOn = $commonservice->dateFormat($data['neededOn'][$j]);
            
            $autoId = DB::table('requested_items')->insertGetId(
                [
                    'item_id' => $data['item'][$j],
                    'request_item_qty' => $data['itemQty'][$j],
                    'need_on' => $neededOn,
                    'branch_id' => $data['location'][$j],
                    'reason'  => $data['reason'][$j],
                    'requested_by' => session('userId'),
                    'requested_on' => $commonservice->getDateTime(),
                    'request_item_status' => 'pending',
                ]
            );

        }
        return $autoId;
    }

    public function fetchRequestItemByLogin()
    {
        $role = session('role');
        // dd($role);
        $data = DB::table('requested_items')
                ->leftjoin('items', 'requested_items.item_id', '=', 'items.item_id')
                ->leftjoin('branches', 'requested_items.branch_id', '=', 'branches.branch_id');
        // if($role == "lab/location user"){
        //     $data = $data ->where('requested_by', '=', session('userId'));
        // }
        if (isset($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem']) && ($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem'] == "allow")){
            $data = $data->leftjoin('user_branch_map', 'branches.branch_id', '=', 'user_branch_map.branch_id')->where('user_branch_map.user_id', '=', session('userId'));
        }
        else{
            $data = $data ->where('requested_by', '=', session('userId'));
        }
        $data = $data->get();
        return $data;
    }

    public function changeApproveStatus($request)
    {
        $commonservice = new CommonService();
        $id = $request['id'];
        try {
            if ($id != "") {
                $updateData = array(
                                'request_item_status' => $request['sts'],
                                'approved_by' => session('userId'),
                                'approved_on' => $commonservice->getDateTime(),
                                'updated_on' => $commonservice->getDateTime(),
                                'updated_by' => session('userId'),
                            );
                DB::table('requested_items')
                    ->where('requested_item_id', '=', $id)
                    ->update($updateData);
               
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $id;
    }

    public function fetchRequestItemById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('requested_items')
                ->leftjoin('items', 'requested_items.item_id', '=', 'items.item_id')
                ->leftjoin('branches', 'requested_items.branch_id', '=', 'branches.branch_id')
                ->where('requested_items.requested_item_id', '=', $id)
                ->get();
        return $data;
    }

    // Update particular Item  details
    public function updateRequestItem($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('item')!=null && trim($params->input('item')) != '') {
            $neededOn = $commonservice->dateFormat($data['neededOn']);
            $response = DB::table('requested_items')
                ->where('requested_item_id', '=',base64_decode($id))
                ->update(
                    ['item_id' => $data['item'],
                    'request_item_qty' => $data['itemQty'],
                    'need_on' => $neededOn,
                    'branch_id' => $data['location'],
                    'reason'  => $data['reason'],
                    'updated_on' => $commonservice->getDateTime(),
                    'updated_by' => session('userId'),
                    ]);
        }
        return $response;
    }

}
