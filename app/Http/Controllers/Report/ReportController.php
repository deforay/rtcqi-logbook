<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\InventoryOutwardsService;
use App\Service\BranchesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use App\Exports\ReportSheetExport;
use Maatwebsite\Excel\Facades\Excel;
use Response;

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

    public function export(Request $request) 
    {
        // if ($request->isMethod('post')){
            $req = $request->all();
            $branches = $request->input('branches');
            // if($branches){
            //     $branches = explode(' to ',$branches);
            // }
            $datetime = date('d-m-Y-H:i:s');
            if(file_exists('temporary')){
                mkdir('temporary', 0777);
            }
            $name = 'temporary/Inventory-Report-Data-'.$datetime;
            $report['branches'] = $branches;
            
            $data['report_all_values'] = 'Inventory_Report_Consolidated_Data';
            $data['report_values'] = 'Inventory_Report_Detailed_Data';
            $export = new ReportSheetExport($data,$report);
            Excel::store($export, $name.'.xlsx');
            return $name.'.xlsx';
        // }
    }

    public function exportDownload(){
        $name = explode("/",$_GET["file"])[1];
        $file = storage_path()."/app/".$_GET["file"];
        $headers = array(
            'Content-Type: application/xlsx',
          );
        return Response::download($file, $name, $headers);
    }
}
