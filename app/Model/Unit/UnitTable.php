<?php

namespace App\Model\Unit;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\UnitService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class UnitTable extends Model
{
    protected $table = 'units_of_measure';

    //add Unit
    public function saveUnit($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('unitName')!=null && trim($request->input('unitName')) != '') {
            $id = DB::table('units_of_measure')->insertGetId(
                ['unit_name' => $data['unitName'],
                'unit_status' => $data['unitStatus'],
                'created_on' => $commonservice->getDateTime(),
                'created_by' => session('userId'),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Unit-add', 'Add Unit '.$data['unitName'], 'Unit');
        }
        return $id;
    }

    // Fetch All Unit List
    public function fetchAllUnit()
    {
        $data = DB::table('units_of_measure')
                ->get();
        return $data;
    }

    // Fetch All Active Unit List
    public function fetchAllActiveUnit()
    {
        $data = DB::table('units_of_measure')
                ->where('unit_status','=','active')
                ->orderBy('unit_name', 'asc')
                ->get();
        return $data;
    }

     // fetch particular Unit details
     public function fetchUnitById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('units_of_measure')
                 ->where('uom_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular Unit details
    public function updateUnit($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('unitName')!=null && trim($params->input('unitName')) != '') {
            $response = DB::table('units_of_measure')
                ->where('uom_id', '=',base64_decode($id))
                ->update(
                    ['unit_name' => $data['unitName'],
                    'unit_status' => $data['unitStatus'],
                    'updated_on' => $commonservice->getDateTime(),
                    'updated_by' => session('userId'),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Unit-update', 'Update Unit '.$data['unitName'], 'Unit');
        }
        return $response;
    }
}
