<?php

namespace App\Http\Controllers\DeliverySchedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\QuotesService;
use App\Service\DeliveryScheduleService;
use App\Service\PurchaseOrderService;
use App\Service\VendorsService;
use App\Service\ItemService;
use Yajra\DataTables\Facades\DataTables;
use View;
use Redirect;

class DeliveryScheduleController extends Controller
{
    //View Delivery schedule main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('deliveryschedule.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Delivery schedule (display add screen and add the rfq values)
    public function add(Request $request)
    {
        $purchaseOrderService = new PurchaseOrderService();
        $purchase = $purchaseOrderService->getAllActivePurchaseOrder();
        $itemservice = new ItemService();
        $item = $itemservice->getAllActiveItem();
        return view('deliveryschedule.add',array('purchase'=>$purchase,'item' => $item));
    }
    public function saveDeliverySchedule(Request $request)
    {
    
        $service = new DeliveryScheduleService();
        $add = $service->saveDeliverySchedule($request);
        return $add;
        // return Redirect::route('deliveryschedule.index')->with('status', $add);
    }

    // Get all the delivery schedule list
    public function getAllDeliverySchedule(Request $request)
    {
        $service = new DeliveryScheduleService();
        $data = $service->getAllDeliverySchedule();
        return DataTables::of($data)
            ->editColumn('expected_date_of_delivery', function($data){
                    $issuedOn = $data->expected_date_of_delivery;
                    if($issuedOn){
                        $issuedOn = date("d-M-Y", strtotime($issuedOn));
                        return $issuedOn;
                    }
            })
            ->addColumn('action', function($data){
                $button = '<div style="width: 180px;">';
                $role = session('role');

                if (isset($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['edit']) && ($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['edit'] == "allow")){
                    $button .= '&nbsp;&nbsp;&nbsp;<a onclick="showAjaxModal(\'/deliveryDetailsEdit/'.base64_encode($data->delivery_id).'\' );" name="edit" id="'.$data->delivery_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                }else{
                    $button .= '';
                }
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function deliveryDetailsEdit($id)
    {
        $deliveryService = new DeliveryScheduleService();
        $delivery = $deliveryService->getDeliveryScheduleById($id);
        // dd($delivery);
        $view = View::make('deliveryschedule.deliveryDetailsEditModal', ['deliveryId'=>$id,'result'=>$delivery]);
        $contents = (string) $view;
        return $contents;
         
    }

    public function updateDeliverySchedule($id,Request $request){
        $service = new DeliveryScheduleService();
        $add = $service->updateDeliverySchedule($id,$request);
        return Redirect::route('deliveryschedule.index')->with('status', $add);
    }
}
