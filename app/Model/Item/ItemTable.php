<?php

namespace App\Model\Item;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\ItemService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

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
                'created_by' => session('userId'),
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

    // Fetch All Active Item List
    public function fetchAllActiveItem()
    {
        $data = DB::table('items')
                ->where('item_status','=','active')
                ->orderBy('item_name', 'asc')  
                ->get();
        return $data;
    }

     // fetch particular Item  details
     public function fetchItemById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('items')
                ->join('item_categories', 'item_categories.item_category_id', '=', 'items.item_id')
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
                    'updated_by' => session('userId'),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Item-update', 'Update Item '.$data['itemName'], 'Item');
        }
        return $response;
    }

    // fetch particular Item unit details
    public function fetchItemUnit($request)
    {
        $id = $request->val;
        $data = DB::table('items')
                ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'items.base_unit')
                ->where('item_id', '=',$id )->get();
        return $data;
    }

    public function addNewItemField($request)
    {
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $commonservice = new CommonService();
        // dd($request->all());
        $user = array();
        $data = array();
        try {
            if ($value != "") {
                $user = DB::table('items')
                    ->where('item_name', '=', $value)
                    ->orWhere('item_id', '=', $value)
                    ->get();
                $data['id'] = 0;
            }
            $countVal = count($user);
            // dd($countVal);
            if($countVal == 0){
                // $ins = DB::table($tableName)
                $id = DB::table('items')->insertGetId(
                    ['item_name' => $value,
                    'item_type' => 1,
                    'brand' => 1,
                    'base_unit' => 1,
                    'item_category_id' => 1,
                    'created_on' => $commonservice->getDateTime(),
                    'created_by' => session('userId'),
                    ]
                );
                $data['id'] = $id;
                $data['item'] = $value;

                $item = DB::table('items')
                        ->join('item_types', 'item_types.item_type_id', '=', 'items.item_type')
                        ->join('brands', 'brands.brand_id', '=', 'items.brand')
                        ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'items.base_unit')
                        ->get();

                
                $opt = '';
                foreach ($item as $items){
                    if($items->item_id == $id){
                        $opt .= '<option value="'.$items->item_id.'" selected>'.$items->item_name.'</option>';
                    }
                    else{
                        $opt .= '<option value="'.$items->item_id.'">'.$items->item_name.'</option>';
                    }
                }
                $data['option'] = $opt;
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return $data;
    }
}
