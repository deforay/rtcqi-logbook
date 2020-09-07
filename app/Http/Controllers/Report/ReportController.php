<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\InventoryOutwardsService;
use App\Service\BranchesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;

class ReportController extends Controller
{
    //View Inventory Report screen
    public function inventoryReport()
    {
        if(session('login')==true)
        {
            $branchService = new BranchesService();
            $branch = $branchService->getBranchesByUser();
            return view('report.inventoryreport',array('branch'=>$branch));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function getInventoryReport(Request $request){
        $service = new InventoryOutwardsService();
        $data = $service->getInventoryReport($request);
        return $data;
    }
}
