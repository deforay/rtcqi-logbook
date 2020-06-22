<?php

namespace App\Model\UnitConversion;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\UnitConversionService;
use App\Service\CommonService;

class UnitConversionTable extends Model
{
    protected $table = 'uom_conversion';

    //add Unit
    public function saveUnitConversion($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('baseUnit') != null && trim($request->input('baseUnit')) != '') {
            $id = DB::table('uom_conversion')->insertGetId(
                [
                    'base_unit'              => $data['baseUnit'],
                    'multiplier'             => $data['multiplier'],
                    'to_unit'                => $data['toUnit'],
                    'unit_conversion_status' => $data['unitConversionStatus'],
                    'created_on'             => $commonservice->getDateTime(),

                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Unit Conversion-add', 'Add Unit Conversion' . $data['baseUnit'], 'Unit Conversion');
        }
        return $id;
    }

    // Fetch All Unit Conversion List
    public function fetchAllUnitConversion()
    {
        $data = DB::table('uom_conversion')
            ->get();
        return $data;
    }

    // Fetch All Active Unit Conversion List
    public function fetchAllActiveUnitConversion()
    {
        $data = DB::table('uom_conversion')
            ->where('unit_conversion_status', '=', 'active')
            ->orderBy('conversion_id', 'asc')
            ->get();
        return $data;
    }

    // fetch particular Unit details
    public function fetchUnitConversionById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('uom_conversion')
            ->where('conversion_id', '=', $id)->get();
        return $data;
    }

    // Update particular Unit Conversion details
    public function updateUnitConversion($params, $id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('baseUnit') != null && trim($params->input('baseUnit')) != '') {
            $response = DB::table('uom_conversion')
                ->where('conversion_id', '=', base64_decode($id))
                ->update(
                    [
                        'base_unit'                 => $data['baseUnit'],
                        'multiplier'                => $data['multiplier'],
                        'to_unit'                   => $data['toUnit'],
                        'unit_conversion_status'    => $data['unitConversionStatus'],
                        'updated_on'                => $commonservice->getDateTime(),
                    ]
                );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Unit  Conversion-update', 'Update Unit Conversion ' . $data['baseUnit'], 'Unit Conversion');
        }
        return $response;
    }
}
