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
        dd($data);
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
                'branch_id'       => $data['branches'],
                'created_by'      => session('userId'),
                'created_on'      => $commonservice->getDateTime(),
                'delivery_schedule_status' => 'pending for shipping',
            ]
        );
            $totalDelQty = 0;
            $totalPodQty = 0;
            $delQtySum = DB::raw('SUM(delivery_schedule.delivery_qty) as totQty');
            $purchase = DB::table('purchase_order_details')
                        // ->select($qtySum)
                        ->where('po_id','=', $data['po'])->get();
            for($k=0;$k<count($purchase);$k++){
                $delQty = DB::table('delivery_schedule')
                        ->select($delQtySum)
                        ->where('pod_id','=', $purchase[$k]->pod_id)->get();
                $totalDelQty += intval($delQty[0]->totQty);
                $totalPodQty += intval($purchase[$k]->quantity);
            }

            if($totalPodQty == $totalDelQty){
                $sts = 'delivery scheduled';
            }
            else{
                $sts = 'some items scheduled for delivery';
            }
            $stsUp = DB::table('purchase_orders')
                    ->where('po_id', '=', $data['po'])
                    ->update(
                        [
                            'order_status'    => $sts,
                        ]
                    );
        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), $autoId, 'Delivery Scheduler-add', 'Add Delivery Schedule ' . $data['po_id'], 'Purchase Order details');
        
        return $autoId;
    }

    //all delivery schedule
    public function fetchAllDeliverySchedule($params){
        $req = $params->all();
        if(session('loginType')=='users'){
            $data = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id');
                    if(isset($req['poId']) && $req['poId'])
                       $data = $data->where('purchase_order_details.po_id', '=', $req['poId']);
                    // ->where('purchase_order_details.delivery_status', '=', 'pending')
            $data = $data->get();
        }
        else{
            $userId=session('userId');
            $data = DB::table('delivery_schedule')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                    // ->where('purchase_order_details.delivery_status', '=', 'pending')
                    ->where('purchase_orders.vendor', '=', $userId)
                    ->get();
        }
        return $data;
    }

    public function fetchAllPendingDeliverySchedule(){
        if(session('loginType')=='users'){
            $data = DB::table('delivery_schedule')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id');
                    // ->where('delivery_schedule.delivery_schedule_status', '=', 'pending for shipping');
            $data = $data->get();
        }
        else{
            $userId=session('userId');
            $data = DB::table('delivery_schedule')
                    ->leftjoin('branches', 'delivery_schedule.branch_id', '=', 'branches.branch_id')
                    ->join('items', 'items.item_id', '=', 'delivery_schedule.item_id')
                    ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'delivery_schedule.pod_id')
                    ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                    // ->where('delivery_schedule.delivery_schedule_status', '=', 'pending for shipping')
                    // ->where('purchase_order_details.delivery_status', '=', 'pending')
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
                ->where('delivery_schedule.delivery_schedule_status', '=', 'pending for shipping')
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
                            'branch_id'       => $data['branches'],
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

    public function updateItemReceive($id,$request)
    {
        $data = $request->all();
        // dd($data);
        $commonservice = new CommonService();

        $autoId = DB::table('delivery_schedule')
                    ->where('delivery_id', '=', base64_decode($id))
                    ->update(
                        [
                            'received_qty'      => $data['receivedQtySum'],
                            'damaged_qty'    => $data['damagedQtySum'],
                            'short_description' => $data['description'],
                            'delivery_schedule_status' => $data['status'],
                            'updated_by'      => session('userId'),
                            'updated_on'      => $commonservice->getDateTime(),
                        ]
                    );

        for($i=0;$i<count($data['expiryDate']);$i++){
            $expiryDate = $commonservice->dateFormat($data['expiryDate'][$i]);
            $serviceDate = $commonservice->dateFormat($data['serviceDate'][$i]);
            $stk = DB::table('inventory_stock')
                    ->where('expiry_date', '=', $expiryDate)
                    ->where('branch_id', '=', $data['branches'][$i])
                    ->where('item_id', '=', $data['itemId'])->get();
                    // dd(($stk));
            if(count($stk)>0){
                $rQty = $data['receivedQty'][$i] + $stk[0]->stock_quantity;
                $stkUp = DB::table('inventory_stock')
                        ->where('expiry_date', '=', $expiryDate)
                        ->where('branch_id', '=', $data['branches'][$i])
                        ->where('item_id', '=', $data['itemId'])
                        ->update(
                            [
                                'stock_quantity'  => $rQty,
                                'updated_by'      => session('userId'),
                                'updated_on'      => $commonservice->getDateTime(),
                            ]
                        );
            }
            else{
                $inv = DB::table('inventory_stock')->insertGetId(
                            [
                                'item_id'      => $data['itemId'],
                                'expiry_date'    => $expiryDate,
                                'service_date'  => $serviceDate,
                                'stock_quantity'    => $data['receivedQty'][$i],
                                'created_by'      => session('userId'),
                                'created_on'      => $commonservice->getDateTime(),
                                'branch_id' => $data['branches'][$i],
                            ]
                        );
            }
        }
        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Delivery Scheduler-edit', 'Update Delivery Schedule ' . $data['pod_id'], 'Purchase Order details');
        
        return $autoId;
    }
}
