<?php

namespace App\Http\Controllers\InventoryOutwards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\InventoryOutwardsService;
use App\Service\BranchesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;

class InventoryOutwardsController extends Controller
{
    //View Inventory Outwards main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('inventoryoutwards.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Purchase Order (display add screen and add the PO values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new InventoryOutwardsService();
            $add = $service->saveInventoryOutwards($request);
            return Redirect::route('inventoryoutwards.index')->with('status', $add);
        }
        else
        {
            $branchService = new BranchesService();
            $branch = $branchService->getBranchesByUser();
            return view('inventoryoutwards.add',array('branch'=>$branch));
        }
    }

    public function getItemByLoc(Request $request){
        $service = new InventoryOutwardsService();
        $item = $service->getItemByLoc($request);
        return $item;
    }

    // Get all the Inventory Outwards list
    public function getAllinventoryoutwards(Request $request)
    {
        $service = new InventoryOutwardsService();
        $data = $service->getAllinventoryoutwards();
        return DataTables::of($data)
                    ->editColumn('issued_on', function($data){
                            $issuedOn = $data->issued_on;
                            if($issuedOn){
                                // $issuedOn = date("d-M-Y", strtotime($issuedOn));
                                return $issuedOn;
                            }
                    })
                    
                    ->addColumn('action', function($data){
                        $button = '';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController']['edit']) && ($role['App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController']['edit'] == "allow")){
                        //     $button .= '&nbsp;&nbsp;&nbsp;<a href="/purchaseorder/edit/'. base64_encode($data->outwards_id).'" name="edit" id="'.$data->outwards_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        $button .= '';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }
    public function returnissueitems(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new InventoryOutwardsService();
            $returnItems = $service->returnInventoryOutwards($request);
            return Redirect::route('inventoryoutwards.index')->with('status', $returnItems);
        }
        else
        {
            $branchService = new BranchesService();
            $branch = $branchService->getBranchesByUser();
            return view('inventoryoutwards.returnissueitems',array('branch'=>$branch));
        }
    }
}
