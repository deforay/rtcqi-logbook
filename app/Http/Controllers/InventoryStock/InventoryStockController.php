<?php

namespace App\Http\Controllers\InventoryStock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\InventoryStockService;
use App\Service\BranchesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;

class InventoryStockController extends Controller
{
    //View Inventory Stock main screen
    public function index(Request $request)
    {
        if(session('login')==true)
        {
            if ($request->isMethod('post')) 
            {
                $invService = new InventoryStockService();
                $result = $invService->importInventoryStock($request);
                return view('inventorystock.index',array('status'=>$result));
            }
            else{
                return view('inventorystock.index');
            }
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function inventoryStockUpload(Request $request){
        $invService = new InventoryStockService();
        $result = $invService->importInventoryStock($request);
        // print_r($result);die;
        return Redirect::to('inventorystock')->with('status', $result);
        // return view('inventorystock.index',array('status'=>$result));
    }

    
}
