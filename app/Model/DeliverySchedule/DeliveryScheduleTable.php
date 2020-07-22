<?php

namespace App\Model\DeliverySchedule;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\DeliveryScheduleService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class DeliveryScheduleTable extends Model
{
    //add Delivery Schedule Order
    public function saveDeliverySchedule($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();

        $expectedDelivery = $commonservice->dateFormat($data['expectedDelivery']);
        $autoId = DB::table('delivery_schedule')->insertGetId(
            [
                'pod_id'      => $data['po_id'],
                'expected_date_of_delivery'    => $expectedDelivery,
                'item_id'          => $data['item'],
                'qty'    => $data['deliverQty'],
                'delivery_mode'    => $data['deliveryMode'],
                'comments'  => $data['comments'],
                'created_by'      => session('userId'),
                'created_on'      => $commonservice->getDateTime(),
            ]
        );

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), $autoId, 'Delivery Scheduler-add', 'Add Delivery Schedule ' . $data['po_id'], 'Purchase Order details');

        return $autoId;
    }

    
}
