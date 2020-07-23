<?php

namespace App\Model\DeliverySchedule;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\DeliveryScheduleService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class DeliveryScheduleTable extends Model
{
    //Add Delivery Schedule
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
                'delivery_qty'    => $data['deliverQty'],
                'delivery_mode'    => $data['deliveryMode'],
                'comments'  => $data['comments'],
                'created_by'      => session('userId'),
                'created_on'      => $commonservice->getDateTime(),
            ]
        );
        if($data['status']){
            $sts = DB::table('purchase_order_details')
                    ->where('pod_id', '=', $data['po_id'])
                    ->update(
                        [
                            'delivery_status'    => $data['status'],
                        ]
                    );
        }
        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), $autoId, 'Delivery Scheduler-add', 'Add Delivery Schedule ' . $data['po_id'], 'Purchase Order details');
        
        return $autoId;
    }

    //all delivery schedule
    public function fetchAllDeliverySchedule(){
        if(session('loginType')=='users'){
            $data = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    // ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    // ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                    ->get();
        }
        else{
            $userId=session('userId');
            $data = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                    ->where('purchase_orders.vendor', '=', $userId)
                    ->get();
        }
        return $data;
    }

    // delivery schedule by id
    public function fetchDeliveryScheduleById($id){
        $id = base64_decode($id);
        $data = DB::table('delivery_schedule')
                ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                ->join('vendors', 'purchase_orders.vendor', '=', 'vendors.vendor_id')
        ->where('delivery_schedule.delivery_id', '=', $id)->get();
        return $data;
    }

    //Update Delivery Schedule
    public function updateDeliverySchedule($id,$request)
    {
        //to get all request values
        $data = $request->all();
        // dd($data);
        $commonservice = new CommonService();
        $expectedDelivery = $commonservice->dateFormat($data['expectedDelivery']);

        $autoId = DB::table('delivery_schedule')
                    ->where('delivery_id', '=', base64_decode($id))
                    ->update(
                        [
                            'pod_id'      => $data['pod_id'],
                            'expected_date_of_delivery'    => $expectedDelivery,
                            'item_id'          => $data['ItemId'],
                            'delivery_qty'    => $data['deliverQty'],
                            'delivery_mode'    => $data['deliveryMode'],
                            'updated_by'      => session('userId'),
                            'updated_on'      => $commonservice->getDateTime(),
                        ]
                    );

        $commentId = DB::table('delivery_schedule_edit_comments')->insertGetId(
            [
                'delivery_id'      => base64_decode($id),
                'edit_comments'  => $data['comments'],
                'created_by'      => session('userId'),
                'created_on'      => $commonservice->getDateTime(),
            ]
        );

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Delivery Scheduler-edit', 'Update Delivery Schedule ' . $data['pod_id'], 'Purchase Order details');
        
        return $commentId;
    }
    
    public function fetchDeliverySchedule($request){
        $data = $request->all();
        // dd($data);
        $delDate = DB::raw("DATE_FORMAT(delivery_schedule.expected_date_of_delivery,'%d-%b-%Y') as delivery_date");
        $query = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->where('delivery_schedule.pod_id', '=', $data['po_id'])
                    ->where('delivery_schedule.item_id', '=', $data['item'])
                    ->select('*',$delDate)
                    ->get();
        return $query;
    }
}
