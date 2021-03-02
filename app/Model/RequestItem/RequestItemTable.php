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
}
