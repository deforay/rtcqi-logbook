<?php

namespace App\Model\Item;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\ItemService;
use App\Service\CommonService;

class ItemTable extends Model
{
    protected $table = 'items';

    //add Item
    public function saveItem($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('itemName')!=null && trim($request->input('itemName')) != '') {
            $id = DB::table('items')->insertGetId(
                ['item_name' => $data['itemName'],
                'item_code' => $data['itemCode'],
                'item_type' => $data['itemTypeId'],
                'brand' => $data['brandId'],
                'base_unit' => $data['unitId'],
                'stockable' => $data['stockable'],
                'created_on' => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Item-add', 'Add Item '.$data['itemName'], 'Item');
        }
        return $id;
    }

    // Fetch All Item  List
    public function fetchAllItem()
    {
        $data = DB::table('items')
                ->join('item_types', 'item_types.item_type_id', '=', 'items.item_type')
                ->join('brands', 'brands.brand_id', '=', 'items.brand')
                ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'items.base_unit')
                ->get();
        return $data;
    }

     // fetch particular Item  details
     public function fetchItemById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('items')
                 ->where('item_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular Item  details
    public function updateItem($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('itemName')!=null && trim($params->input('itemName')) != '') {
            $response = DB::table('items')
                ->where('item_id', '=',base64_decode($id))
                ->update(
                    ['item_name' => $data['itemName'],
                    'item_code' => $data['itemCode'],
                    'item_type' => $data['itemTypeId'],
                    'brand' => $data['brandId'],
                    'base_unit' => $data['unitId'],
                    'stockable' => $data['stockable'],
                    'updated_on' => $commonservice->getDateTime(),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Item-update', 'Update Item '.$data['itemName'], 'Item');
        }
        return $response;
    }
}
