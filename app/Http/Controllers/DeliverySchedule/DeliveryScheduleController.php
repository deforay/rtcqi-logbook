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
use App\Service\BranchesService;
use View;
use Redirect;

class DeliveryScheduleController extends Controller
{
    //View Delivery schedule main screen
    public function index()
    {
        if(session('login')==true)
        {
            $service = new PurchaseOrderService();
            $data = $service->getAllPurchaseorder();
            return view('deliveryschedule.index',array('poList' => $data));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Delivery schedule (display add screen and add the rfq values)
    public function add(Request $request)
    {
        $purchaseOrderService = new PurchaseOrderService();
        $purchase = $purchaseOrderService->getAllNotScheduledPurchaseOrder();
        $itemservice = new ItemService();
        $item = $itemservice->getAllActiveItem();
        $branchService = new BranchesService();
        $branch = $branchService->getAllActiveBranches();
        return view('deliveryschedule.add',array('purchase'=>$purchase,'item' => $item,'branch'=>$branch));
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
        $data = $service->getAllDeliverySchedule($request);
        return DataTables::of($data)
            ->editColumn('expected_date_of_delivery', function($data){
                $issuedOn = $data->expected_date_of_delivery;
                if($issuedOn){
                    $issuedOn = date("d-M-Y", strtotime($issuedOn));
                    return $issuedOn;
                }
            })
            ->addColumn('action', function($data){
                $button = '';
                $role = session('role');
                if(strtolower($data->delivery_schedule_status) == 'pending for shipping'){
                    if (isset($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['edit']) && ($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['edit'] == "allow")){
                        $button .= '&nbsp;&nbsp;&nbsp;<a onclick="showAjaxModal(\'/deliveryDetailsEdit/'.base64_encode($data->delivery_id).'\' );" name="edit" id="'.$data->delivery_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                }
                else if(strtolower($data->delivery_schedule_status) == 'received'){
                    $button .= '<span class="badge badge-success"><b>'.ucfirst($data->delivery_schedule_status).'</b></span>';
                }
                else{
                    $button .= '<span class="badge badge-warning"><b>'.ucfirst($data->delivery_schedule_status).'</b></span>';
                }
                // $button .= '</div>';
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
        $branchService = new BranchesService();
        $branch = $branchService->getAllActiveBranches();
        $view = View::make('deliveryschedule.deliveryDetailsEditModal', ['deliveryId'=>$id,'result'=>$delivery,'branch'=>$branch]);
        $contents = (string) $view;
        return $contents;
         
    }

    public function updateDeliverySchedule($id,Request $request){
        $service = new DeliveryScheduleService();
        $add = $service->updateDeliverySchedule($id,$request);
        return Redirect::route('deliveryschedule.index')->with('status', $add);
    }

    public function getDeliverySchedule(Request $request){
        $service = new DeliveryScheduleService();
        $result = $service->getDeliverySchedule($request);
        return $result;
    }

    
    //View pending Delivery schedule main screen
    public function itemreceive()
    {
        if(session('login')==true)
        {
            return view('deliveryschedule.itemreceive');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Get all the pending delivery schedule list
    public function getAllPendingDeliverySchedule(Request $request)
    {
        $service = new DeliveryScheduleService();
        $data = $service->getAllPendingDeliverySchedule();
        return DataTables::of($data)
            ->editColumn('expected_date_of_delivery', function($data){
                $issuedOn = $data->expected_date_of_delivery;
                if($issuedOn){
                    $issuedOn = date("d-M-Y", strtotime($issuedOn));
                    return $issuedOn;
                }
            })
            ->editColumn('delivery_schedule_status', function($data){
                if($data->delivery_schedule_status){
                    $del = '<span class="badge badge-warning">'.ucfirst($data->delivery_schedule_status).'</span>';
                    return $del;
                }
            })
            ->addColumn('action', function($data){
                $button = '';
                $role = session('role');
                if($data->delivery_schedule_status == 'pending for shipping'){
                    if (isset($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['edit']) && ($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['edit'] == "allow")){
                        $button .= '&nbsp;&nbsp;&nbsp;<a onclick="showAjaxModal(\'/itemReceiveEdit/'.base64_encode($data->delivery_id).'\' );" name="edit" id="'.$data->delivery_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                    }else{
                        $button .= '';
                    }
                }
                elseif(strtolower($data->delivery_schedule_status) == 'received'){
                    $button .= '<span class="badge badge-success"><b>'.ucfirst($data->delivery_schedule_status).'</b></span>';
                }
                else{
                    $button .= '<span class="badge badge-warning"><b>'.ucfirst($data->delivery_schedule_status).'</b></span>';
                }
                // $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function itemReceiveEdit($id)
    {
        $deliveryService = new DeliveryScheduleService();
        $delivery = $deliveryService->getDeliveryScheduleById($id);
        // dd($delivery);
        $branchService = new BranchesService();
        $branch = $branchService->getAllActiveBranches();
        $view = View::make('deliveryschedule.itemReceiveEditModal', ['deliveryId'=>$id,'result'=>$delivery,'branch'=>$branch]);
        $contents = (string) $view;
        return $contents;
         
    }

    public function updateItemReceive($id,Request $request){
        $deliveryService = new DeliveryScheduleService();
        $delivery = $deliveryService->updateItemReceive($id,$request);
        return Redirect::route('deliveryschedule.itemreceive')->with('status', $delivery);
    }

}
