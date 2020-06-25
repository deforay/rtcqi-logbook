<?php

namespace App\Model\ItemType;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\ItemTypeService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class ItemTypeTable extends Model
{
    protected $table = 'item_types';

    //add ItemType
    public function saveItemType($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('itemTypeName')!=null && trim($request->input('itemTypeName')) != '') {
            $id = DB::table('item_types')->insertGetId(
                ['item_type' => $data['itemTypeName'],
                'item_category' => $data['itemCategoryId'],
                'item_type_status' => $data['itemTypeStatus'],
                'created_on' => $commonservice->getDateTime(),
                'created_by' => session('userId'),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Item Type-add', 'Add Item Type '.$data['itemTypeName'], 'Item Type');
        }
        return $id;
    }

    // Fetch All Item Type List
    public function fetchAllItemType()
    {
        $data = DB::table('item_types')
                ->join('item_categories', 'item_categories.item_category_id', '=', 'item_types.item_category')
                ->get();
        return $data;
    }

    // Fetch All Active Item Type List
    public function fetchAllActiveItemType()
    {
        $data = DB::table('item_types')
                ->where('item_type_status','=','active')
                ->orderBy('item_type', 'asc')
                ->get();
        return $data;
    }

     // fetch particular Item Type details
     public function fetchItemTypeById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('item_types')
                 ->where('item_type_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular Item Type details
    public function updateItemType($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('itemTypeName')!=null && trim($params->input('itemTypeName')) != '') {
            $response = DB::table('item_types')
                ->where('item_type_id', '=',base64_decode($id))
                ->update(
                    ['item_type' => $data['itemTypeName'],
                    'item_category' => $data['itemCategoryId'],
                    'item_type_status' => $data['itemTypeStatus'],
                    'updated_on' => $commonservice->getDateTime(),
                    'updated_by' => session('userId'),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Item Type-update', 'Update Item Type '.$data['itemTypeName'], 'Item Type');
        }
        return $response;
    }
}
