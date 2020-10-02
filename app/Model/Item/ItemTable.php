<?php

namespace App\Model\Item;

use Illuminate\Database\Eloquent\Model;
use App\Imports\BulkItemUpload;
use DB;
use App\Service\ItemService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Importer;

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
                'minimum_quantity' => $data['minQuantity'],
                'requires_service' => $data['requiresService'],
                'can_expire' => $data['canExpire'],
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
                ->join('item_types', 'item_types.item_type_id', '=', 'items.item_type')
                ->leftjoin('item_categories', 'item_categories.item_category_id', '=', 'items.item_category_id')
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
                    'minimum_quantity' => $data['minQuantity'],
                    'item_category_id' => $data['itemCatId'],
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

    public function bulkItemUpload($request)
    {
        $data = $request->all();
        // dd($data);
        $commonservice = new CommonService();
        $bulkUpload = 0;
        $validator = Validator::make($request->all(), [
        'uploadFile'  => 'required|mimes:xls,xlsx'
        ]);
        if ($validator->passes()) {
            $dateTime = date('Ymd_His');
            $file = $request->file('uploadFile');
            $fileName = $dateTime.'-'.$file->getClientOriginalName();
            $savePath = public_path('/uploads/bulkitemupload/');
            if (!file_exists($savePath) && !is_dir($savePath)) {
                mkdir($savePath,0755,true);
            }
            $file->move($savePath, $fileName);
            $savePathVal =  Excel::toArray(new BulkItemUpload(), $savePath.$fileName);
            $j=1;
            foreach($savePathVal[0] as $excelval){
                if(isset($excelval) && $excelval!='' && $excelval!=null){
                    if($j>1){
                        $itemCat = DB::table('item_categories')
                                    ->where('item_category', '=', $excelval[2])
                                    ->get();
                        $itemCat = $itemCat->toArray();
                        
                        if(count($itemCat)==0){
                            $itemCatId = DB::table('item_categories')->insertGetId(
                                        ['item_category' => $excelval[2],
                                        'item_category_status' => 'active',
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                

                            $commonservice->eventLog(session('userId'), $itemCatId, 'Item Category-add', 'Add Item Category By Excel'.$excelval[2], 'Item Category');
                        }
                        else{
                            $itemCatId = $itemCat[0]->item_category_id;
                        }

                        $itemType = DB::table('item_types')
                                    ->where('item_type', '=', $excelval[3])
                                    ->get();
                        $itemType = $itemType->toArray();
                        if(count($itemType)==0){
                            $itemTypeId = DB::table('item_types')->insertGetId(
                                    ['item_type' => $excelval[3],
                                    'item_category' => $itemCatId,
                                    'item_type_status' => 'active',
                                    'created_on' => $commonservice->getDateTime(),
                                    'created_by' => session('userId'),
                                    ]
                                );
                
                            $commonservice = new CommonService();
                            $commonservice->eventLog(session('userId'), $itemTypeId, 'Item Type-add', 'Add Item Type By Excel'.$excelval[3], 'Item Type');
                        }
                        else{
                            $itemTypeId = $itemType[0]->item_type_id;
                        }

                        $brand = DB::table('brands')
                                    ->where('brand_name', '=', $excelval[4])
                                    ->get();
                        $brand = $brand->toArray();
                        // dd($brand);
                        if(count($brand)==0){
                            $brandId = DB::table('brands')->insertGetId(
                                        ['brand_name' => $excelval[4],
                                        'brand_status' => 'active',
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                
                            $commonservice = new CommonService();
                            $commonservice->eventLog(session('userId'), $brandId, 'Brand-add', 'Add Brand By Excel'.$excelval[4], 'Brand');
                        }
                        else{
                            $brandId = $brand[0]->brand_id;
                        }

                        $unit = DB::table('units_of_measure')
                                    ->where('unit_name', '=', $excelval[5])
                                    ->get();
                        $unit = $unit->toArray();
                        if(count($unit)==0){
                            $unitId = DB::table('units_of_measure')->insertGetId(
                                        ['unit_name' => $excelval[5],
                                        'unit_status' => 'active',
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                
                            $commonservice = new CommonService();
                            $commonservice->eventLog(session('userId'), $unitId, 'Unit-add', 'Add Unit By Excel'.$excelval[5], 'Unit');
                        }
                        else{
                            $unitId = $unit[0]->uom_id;
                        }

                        $item = DB::table('items')
                                ->where('item_code', '=', $excelval[1])
                                ->get();

                        $item = $item->toArray();
                        if(count($item)==0){
                            $commonservice = new CommonService();
                            $bulkUpload = DB::table('items')->insertGetId(
                                            ['item_name' => $excelval[0],
                                            'item_code' => $excelval[1],
                                            'item_type' => $itemTypeId,
                                            'brand' => $brandId,
                                            'base_unit' => $unitId,
                                            'stockable' => $excelval[7],
                                            'minimum_quantity' => $excelval[6],
                                            'requires_service' => $excelval[8],
                                            'can_expire' => $excelval[9],
                                            'created_on' => $commonservice->getDateTime(),
                                            'created_by' => session('userId'),
                                            ]
                                        );
                
                            $commonservice->eventLog(session('userId'), $bulkUpload, 'Item-add', 'Add Item by excel'.$excelval[0], 'Item');
                        }
                        // else{

                        // }
                    }
                }
                $j++;
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'),$bulkUpload, 'Grade price-update', 'Update Grade price import grade price details', 'grade price');
        }
        else{

        }
        return $bulkUpload;
    }
}
