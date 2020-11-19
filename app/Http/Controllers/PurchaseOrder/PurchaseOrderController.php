<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\PurchaseOrderService;
use App\Service\VendorsService;
use App\Service\ItemService;
use App\Service\BranchesService;
use App\Service\GlobalConfigService;
use Yajra\DataTables\Facades\DataTables;
use App\Service\RfqService;
use Redirect;
use View;


class PurchaseOrderController extends Controller
{
    //View Purchase Order main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('purchaseorder.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Purchase Order (display add screen and add the PO values)
    public function add($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new PurchaseOrderService();
            $add = $service->savePurchaseorder($id,$request);
            return Redirect::route('purchaseorder.index')->with('status', $add);
        }
        else
        {
            $service = new VendorsService();
            $vendor = $service->getAllActiveVendors();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $purchaseOrderService = new PurchaseOrderService();
            $vendorDetailId = $purchaseOrderService->getAllVendorDetailById($id);
            $quotes = $purchaseOrderService->getSumOfQuoteById($id);
            $quoteDetails = $purchaseOrderService->getAllQuoteDetailsId($id);
            $branchService = new BranchesService();
            $branch = $branchService->getAllActiveBranches();
            $globalConfigService = new GlobalConfigService();
            $config = $globalConfigService->getGlobalConfigBaseCurrency();
            $rfqservice = new RfqService();
            $pc = $rfqservice->getPurchaseCategory($request);
            return view('purchaseorder.add',array('quoteId'=>$id,'vendor'=>$vendor,'item'=>$item,'vendorDetailId'=>$vendorDetailId,'quotes'=>$quotes,'quoteDetails'=>$quoteDetails,'branch'=>$branch,'config'=>$config,'pc'=>$pc));
        }
    }


    public function adddirectpo(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new PurchaseOrderService();
            $add = $service->savePurchaseorderDirectPo($request);
            return Redirect::route('purchaseorder.index')->with('status', $add);
        }
        else
        {
            $service = new VendorsService();
            $vendor = $service->getAllActiveVendors();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $purchaseOrderService = new PurchaseOrderService();
            $globalConfigService = new GlobalConfigService();
            $config = $globalConfigService->getGlobalConfigBaseCurrency();
            $pc = $purchaseOrderService->getPoPurchaseCategory($request);
            // dd($config);
            // $vendorDetailId = $purchaseOrderService->getAllVendorDetailById($id);
            // $quotes = $purchaseOrderService->getSumOfQuoteById($id);
            // $quoteDetails = $purchaseOrderService->getAllQuoteDetailsId($id);
            $branchService = new BranchesService();
            $branch = $branchService->getAllActiveBranches();
            return view('purchaseorder.adddirectpo',array('vendor'=>$vendor,'item'=>$item,'branch'=>$branch,'config'=>$config,'pc'=>$pc));
        }
    }

    // Get all the Purchase Order list
    public function getAllPurchaseOrder(Request $request)
    {
        $service = new PurchaseOrderService();
        $data = $service->getAllPurchaseorder();
        return DataTables::of($data)
                    ->editColumn('po_issued_on', function($data){
                            $issuedOn = $data->po_issued_on;
                            if($issuedOn){
                                // $issuedOn = date("d-M-Y", strtotime($issuedOn));
                                return $issuedOn;
                            }
                    })
                    ->editColumn('last_date_of_delivery', function($data){
                            $lastDate = $data->last_date_of_delivery;
                            if($lastDate){
                                $lastDate = date("d-M-Y", strtotime($lastDate));
                                return $lastDate;
                            }
                    })
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        
                        // if($data->order_status == 'active'){
                            // $buttonStatus="changeStatus('purchase_orders','po_id',$data->po_id,'order_status', 'active', 'purchaseOrderList')";
                            // $button .= '<button type="button" name="changeStatus" id="changeStatus'.$data->po_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Active</button>';
                            if (isset($role['App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController']['edit']) && ($role['App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController']['edit'] == "allow")){
                                $button .= '&nbsp;&nbsp;&nbsp;<a href="/purchaseorder/edit/'. base64_encode($data->po_id).'" name="edit" id="'.$data->po_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                             }else{
                                 $button .= '';
                             }
                        // }else{
                            // $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->po_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        // }

                        // $button .= '<div class = "row">';
                        // $button .= '<div class = "col-md-6 mt-1">
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="purchaseDetails" id="purchaseDetails" class="btn btn-outline-success btn-sm" onclick="showAjaxModal(\'/purchaseDetailsView/'.base64_encode($data->po_id).'\' );" title="purchase Details"><b><i class="ft-eye"></i></b></button>';
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit Purchase Order
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new PurchaseOrderService();
            $edit = $service->updatePurchaseOrder($request,$id);
            return Redirect::route('purchaseorder.index')->with('status', $edit);
        }
        else
        {
            $service = new PurchaseOrderService();
            $result = $service->getPurchaseorderById($id);
            $purchaseOrderDetails = $service->getPurchaseOrderDetailsId($id);
            $vendorService = new VendorsService();
            $vendor = $vendorService->getAllActiveVendors();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $branchService = new BranchesService();
            $branch = $branchService->getAllActiveBranches();
            $globalConfigService = new GlobalConfigService();
            $config = $globalConfigService->getGlobalConfigBaseCurrency();
            $pc = $service->getPoPurchaseCategory($request);
            return view('purchaseorder.edit',array('result'=>$result,'vendor'=>$vendor,'item'=>$item,'purchaseOrderDetails'=>$purchaseOrderDetails,'branch'=>$branch,'config'=>$config,'pc'=>$pc));
        }
    }
    public function purchaseDetailsView(Request $request,$id)
    {
      
            $service = new PurchaseOrderService();
            $result = $service->getPurchaseorderById($id);
            $purchaseOrderDetails = $service->getPurchaseOrderDetailsId($id);
            $vendorService = new VendorsService();
            $vendor = $vendorService->getAllActiveVendors();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $view = View::make('purchaseorder.purchaseOrderDetailsViewModal', ['purchaseId'=>$id,'result'=>$result,'vendor'=>$vendor,'item'=>$item,'purchaseOrderDetails'=>$purchaseOrderDetails]);
            $contents = (string) $view;
            return $contents;
         
    }

    public function getPurchaseorderByIdForDelivery(Request $request){
        $id = base64_encode($request->id);
        $service = new PurchaseOrderService();
        $result = $service->getPurchaseorderByIdForDelivery($id);
        return json_encode($result);
    }
}
