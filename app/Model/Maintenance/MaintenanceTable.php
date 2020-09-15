<?php
namespace App\Model\Maintenance;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\MaintenanceService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class MaintenanceTable extends Model
{
    //
    public function fetchAllMaintenance()
    {
        $data = DB::table('maintenance')
            // ->join('items', 'items.item_id', '=', 'asset_tags.item_id')
            // ->join('branches', 'branches.branch_id', '=', 'asset_tags.branch_id')
            ->get();
        return $data;
    }

    public function saveMaintenance($request)
    {
        $data = $request->all();
        $maintenancId = 0;
        $commonservice = new CommonService();
        $serviceDate = $commonservice->dateFormat($data['serviceDate']);
        $maintenanceDate = $commonservice->dateFormat($data['nextMaintenanceDate']);
        $maintenancId = DB::table('maintenance')->insertGetId(
                [
                    'service_date'             => $serviceDate,
                    'service_done_by'          => $data['serviceDoneBy'],
                    'verified_by'              => $data['verifiedBy'],
                    'regular_service'          => $data['regularService'],
                    'next_maintenance_date'    => $maintenanceDate,
                    'maintenance_status'       => $data['maintenanceStatus'],
                    'created_by'               => session('userId'),
                    'created_on'               => $commonservice->getDateTime(),
                ]
            );
        return $maintenancId;
    }

    public function updateMaintenance($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('serviceDate')!=null && trim($params->input('serviceDate')) != '') {
            $serviceDate = $commonservice->dateFormat($data['serviceDate']);
            $maintenanceDate = $commonservice->dateFormat($data['nextMaintenanceDate']);
            $response = DB::table('maintenance')
                ->where('maintenance_id', '=',base64_decode($id))
                ->update(
                    [
                    'service_date'             => $serviceDate,
                    'service_done_by'          => $data['serviceDoneBy'],
                    'verified_by'              => $data['verifiedBy'],
                    'regular_service'          => $data['regularService'],
                    'next_maintenance_date'    => $maintenanceDate,
                    'maintenance_status'       => $data['maintenanceStatus'],
                    'updated_by'               => session('userId'),
                    'updated_on'               => $commonservice->getDateTime(),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Maintenance-update', 'Update Maintenance '.$data['serviceDate'], 'Maintenance');
        }
        return $response;
    }

    public function fetchMaintenanceById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('maintenance')
                ->where('maintenance.maintenance_id', '=',$id )
                // ->join('branches', 'branches.branch_id', '=', 'asset_tags.branch_id')
                // ->join('items', 'items.item_id', '=', 'asset_tags.item_id')
                // ->where('items.item_status','=','active')
                // ->where('branches.branch_status','=','active')
                ->get();
        return $data;
    }
}
