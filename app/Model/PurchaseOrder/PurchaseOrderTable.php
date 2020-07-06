<?php

namespace App\Model\PurchaseOrder;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\PurchaseOrderService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class PurchaseOrderTable extends Model
{
    //add Purchase Order
    public function savePurchaseOrder($id, $request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();


        $params = array(
            'approve_status' => 'yes',
            'updated_on' => $commonservice->getDateTime()
        );
        $response = DB::table('quotes')
            ->where('quote_id', '=', base64_decode($id))
            ->update(
                $params
            );

        if ($request->input('poNumber') != null && trim($request->input('poNumber')) != '') {
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $poId = DB::table('purchase_orders')->insertGetId(
                [
                    'po_number'      => $data['poNumber'],
                    'po_issued_on'    => $issuedOn,
                    'vendor'          => $data['vendorId'],
                    'total_amount'    => $data['totalAmount'],
                    'order_status'    => $data['orderStatus'],
                    'payment_status'  => $data['paymentStatus'],
                    'description' => $data['description'],
                    'created_by'      => session('userId'),
                    'created_on'      => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $poId, 'Purchaseorder-add', 'Add Purchase Order ' . $data['poNumber'], 'Purchase Order');
        }

        if ($request->input('item') != null) {
            for ($k = 0; $k < count($data['item']); $k++) {
                $purchaseOrderDetailsId = DB::table('purchase_order_details')->insertGetId(
                    [
                        'po_id'         =>  $poId,
                        'item_id'       => $data['item'][$k],
                        'uom'           => $data['unitName'][$k],
                        'unit_price'    => $data['unitPrice'][$k],
                        'quantity'      => $data['qty'][$k],
                        'delivery_status'      => 'pending',
                        'created_on'    => $commonservice->getDateTime(),
                    ]
                );
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $purchaseOrderDetailsId, 'Purchaseorderdetails-add', 'add Purchase Order Details ' . $purchaseOrderDetailsId, 'Purchase Order Details');
        }
        return $poId;
    }

    // Fetch All Purchase Order List
    public function fetchAllPurchaseOrder()
    {
        $data = DB::table('purchase_orders')
            ->get();
        return $data;
    }

    // Fetch All PurchaseOrder List
    public function fetchAllActivePurchaseOrder()
    {
        $data = DB::table('purchase_orders')
            ->where('order_status', '=', 'active')
            ->orderBy('po_number', 'asc')
            ->get();
        return $data;
    }

    // fetch particular Vendor details
    public function fetchVendorDetailById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quotes')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->where('quotes.vendor_id', '=', $id)->get();
        return $data;
    }
    public function fetchSumOfQuoteById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quote_details')
            ->select(DB::raw('SUM(quote_details.unit_price) as tot'))
            ->where('quote_details.quote_id', '=', $id)->get();
        return $data;
    }
    public function fetchAllQuoteDetailsId($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quote_details')
            ->where('quote_details.quote_id', '=', $id)->get();
        return $data;
    }

    public function fetchPurchaseOrderDetailsId($id)
    {
        $id = base64_decode($id);
        $data = DB::table('purchase_order_details')
            ->where('purchase_order_details.po_id', '=', $id)->get();
        return $data;
    }
    public function fetchPurchaseorderById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('purchase_orders')
            ->where('purchase_orders.po_id', '=', $id)->get();
        return $data;
    }
    public function updatePurchaseOrderDetails($params, $id)
    {

        $response = 0;
        $data = $params->all();
        // $delMap = '';
        // $delivUp = '';
        // $delUp = '';
        $purchaseOrder = '';
        $purchaseOrderDetailsData = '';
        // delete Consumption 
        //  if(isset($data['deleteConsumptionDetail']) && $data['deleteConsumptionDetail']!=null && trim($data['deleteConsumptionDetail'])!=''){
        //     $delConsumptionId = explode(",",$data['deleteConsumptionDetail']);
        //     for($e = 0;$e<count($delConsumptionId);$e++){

        //        $delUp = DB::table('customer_consumption_quantity')->where('customer_consumption_id', '=', $delConsumptionId[$e])->delete();
        //     }
        // }
        //$purchase Order details 
        $commonservice = new CommonService();
        for ($j = 0; $j < count($data['item']); $j++) {
            $purchaseOrderDetailsData = array(
                'po_id'             => base64_decode($id),
                'item_id'           => $data['item'][$j],
                'uom'               => $data['unitName'][$j],
                'unit_price'        => $data['unitPrice'][$j],
                'quantity'          => $data['qty'][$j],
                'delivery_status'   => 'pending',
                'created_on'        => $commonservice->getDateTime(),
            );
            if(isset($data['podId'][$j]) && $data['podId'][$j]!=''){
                $purchaseOrderdetailsUp = DB::table('purchase_order_details')
                ->where('pod_id', '=', $data['podId'][$j])
                    ->update($purchaseOrderDetailsData);
            }else{
                $purchaseOrderdetailsUp = DB::table('purchase_order_details')
                    ->insert($purchaseOrderDetailsData);
            }
        }

        //$purchase Order
        if ($params->input('poNumber') != null && trim($params->input('poNumber')) != '') {
            $commonservice = new CommonService();
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $params = array(
                'po_number' => $data['poNumber'],
                'po_issued_on'    => $issuedOn,
                'vendor'          => $data['vendorId'],
                'total_amount'    => $data['totalAmount'],
                'order_status'    => $data['orderStatus'],
                'payment_status'  => $data['paymentStatus'],
                'description' => $data['description'],
                'updated_by'      => session('userId'),
                'updated_on'      => $commonservice->getDateTime(),
            );

            $purchaseOrder = DB::table('purchase_orders')
                ->where('po_id', '=', base64_decode($id))
                ->update(
                    $params
                );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Purchase Order-update', 'Update Purchase Order ' . $data['poNumber'], 'Customer');
        }
        if ($purchaseOrderdetailsUp || $purchaseOrder) {
            $response = 1;
        }
        return $response;
    }
}
