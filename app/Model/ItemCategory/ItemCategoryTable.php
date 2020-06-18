<?php

namespace App\Model\ItemCategory;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\ItemCategoryService;
use App\Service\CommonService;

class ItemCategoryTable extends Model
{
    protected $table = 'item_categories';

    //add ItemCategory
    public function saveItemCategory($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('itemCategoryName')!=null && trim($request->input('itemCategoryName')) != '') {
            $id = DB::table('item_categories')->insertGetId(
                ['item_category' => $data['itemCategoryName'],
                'item_category_status' => $data['itemCategoryStatus'],
                'created_on' => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Item Category-add', 'Add Item Category '.$data['itemCategoryName'], 'Item Category');
        }
        return $id;
    }

    // Fetch All Item Category List
    public function fetchAllItemCategory()
    {
        $data = DB::table('item_categories')
                ->get();
        return $data;
    }

    // Fetch All Active Item Category List
    public function fetchAllActiveItemCategory()
    {
        $data = DB::table('item_categories')
                ->where('item_category_status','=','active')
                ->orderBy('item_category', 'asc')
                ->get();
        return $data;
    }

     // fetch particular Item Category details
     public function fetchItemCategoryById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('item_categories')
                 ->where('item_category_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular Item Category details
    public function updateItemCategory($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('itemCategoryName')!=null && trim($params->input('itemCategoryName')) != '') {
            $response = DB::table('item_categories')
                ->where('item_category_id', '=',base64_decode($id))
                ->update(
                    ['item_category' => $data['itemCategoryName'],
                    'item_category_status' => $data['itemCategoryStatus'],
                    'updated_on' => $commonservice->getDateTime(),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Item Category-update', 'Update Item Category '.$data['itemCategoryName'], 'Item Category');
        }
        return $response;
    }
}
