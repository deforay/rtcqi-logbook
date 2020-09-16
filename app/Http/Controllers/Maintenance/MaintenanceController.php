<?php
namespace App\Http\Controllers\Maintenance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\MaintenanceService;
use App\Service\BranchesService;
use App\Service\InventoryOutwardsService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;

class MaintenanceController extends Controller
{
    //View Maintenance main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('maintenance.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Maintenance Screen
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $assetService = new MaintenanceService();
            $add = $assetService->saveMaintenance($request);
            return Redirect::route('maintenance.index')->with('status', $add);
        }
        else
        {
            $assetService = new BranchesService();
            $branch = $assetService->getBranchesByUser();
            // dd($branch);
            return view('maintenance.add',array('branch'=>$branch));
        }
    }

    // Get all the Maintenance list
    public function getAllMaintenance(Request $request)
    {
        $all = new MaintenanceService();
        $data = $all->getAllMaintenance();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Maintenance\\MaintenanceController']['edit']) && ($role['App\\Http\\Controllers\\Maintenance\\MaintenanceController']['edit'] == "allow")){
                           $button .= '<a href="/maintenance/edit/'. base64_encode($data->maintenance_id).'" name="edit" id="'.$data->maintenance_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        }else{
                            $button .= '';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->editColumn('service_date', function($data){
                        $serviceDate = $data->service_date;
                        if($serviceDate){
                            $serviceDate = date("d-M-Y", strtotime($serviceDate));
                            return $serviceDate;
                        }
                    })
                    ->editColumn('next_maintenance_date', function($data){
                        $maintenanceDate = $data->next_maintenance_date;
                        if($maintenanceDate){
                            $maintenanceDate = date("d-M-Y", strtotime($maintenanceDate));
                            return $maintenanceDate;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }
    // public function createAssetId(Request $request){
    //     $service = new AssetTagService();
    //     $assetTag = $service->getAssetId($request);
    //     return $assetTag;
    // }
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $assetService = new MaintenanceService();
            $edit = $assetService->updateMaintenance($request,$id);
            return Redirect::route('maintenance.index')->with('status', $edit);
        }
        else
        {
            $assetService = new MaintenanceService();
            $assetResult = $assetService->getMaintenanceById($id);
            $assetService = new BranchesService();
            $branch = $assetService->getBranchesByUser();
            return view('maintenance.edit',array('result'=>$assetResult,'branch'=>$branch));
        }
    }
}
