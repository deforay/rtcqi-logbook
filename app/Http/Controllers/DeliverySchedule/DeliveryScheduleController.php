<?php

namespace App\Http\Controllers\DeliverySchedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\QuotesService;
use App\Service\DeliveryScheduleService;
use App\Service\PurchaseOrderService;
use App\Service\VendorsService;
use App\Service\ItemService;

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
        if ($request->isMethod('post')) 
        {
        //     $service = new DeliveryScheduleService();
        //     $add = $service->saveDeliverySchedule($request);
        //     return Redirect::route('deliveryschedule.index')->with('status', $add);
        }
        else
        {
            $purchaseOrderService = new PurchaseOrderService();
            $purchase = $purchaseOrderService->getAllActivePurchaseOrder();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            return view('deliveryschedule.add',array('purchase'=>$purchase,'item' => $item));
        }
    }
    public function saveDeliverySchedule(Request $request)
    {
    
        $service = new DeliveryScheduleService();
        $add = $service->saveDeliverySchedule($request);
        return $add;
        // return Redirect::route('deliveryschedule.index')->with('status', $add);
    }
}
