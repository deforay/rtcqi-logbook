<?php

namespace App\Model\InventoryStock;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\InventoryStockService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;
use App\Imports\InventoryStockUpload;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Importer;

class InventoryStockTable extends Model
{

    public function importInventoryStock($request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'grade_excel'  => 'required|mimes:xls,xlsx'
            ]);
        // dd($data);
        $autoId = 0;
        $commonservice = new CommonService();
        
        if ($validator->passes()) {
            $dateTime = date('Ymd_His');
            $file = $request->file('grade_excel');
            $fileName = $dateTime.'-'.$file->getClientOriginalName();
            $savePath = public_path('/uploads/inventorystock/');
            $file->move($savePath, $fileName);
            // print_r($savePath.$fileName);die;
            $array =  Excel::toArray(new InventoryStockUpload(), $savePath.$fileName);
            // $array = Excel::import(new InventoryStockUpload, $savePath.$fileName);
            // dd($array);die;
            $i=1;
            foreach($array[0] as $row){
                // dd($row);
                $item_category = $row[0];
                $item_type = $row[1]; 
                $unit_name = $row[2]; 
                $item_name = $row[3]; 
                $item_code = $row[4]; 
                $country_name = $row[5];
                $location_type = $row[6];
                $location_name = $row[7];
                $stock_qty = $row[8];
                $brand_name = $row[9];
                $expiry_date = $row[10];
                $manufacturer_date = $row[11];
                $vendor_name = $row[12];
                $vendor_email = $row[13];
                $po_number = $row[14];
                $po_date = $commonservice->dateFormat($row[15]);
                $payment_status = $row[16];
                $order_status = $row[17];
                $base_currency = $row[18];
                $exchange_rate = $row[19];
                if($i>2){
                    $itemCat = DB::table('item_categories')
                                ->where('item_category', '=', $item_category)
                                ->get();
                    // dd($itemCat);
                    if(count($itemCat) == 0){
                        $itemCatId = DB::table('item_categories')->insertGetId(
                                        [
                                        'item_category' => $item_category,
                                        'item_category_status' => 'active',
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                    }
                    else{
                        $itemCatId = $itemCat[0]->item_category_id;
                    }
                    $itemType = DB::table('item_types')
                                ->where('item_type', '=', $item_type)
                                ->get();
                    // dd($itemType);
                    if(count($itemType) == 0){
                        $itemTypeId = DB::table('item_types')->insertGetId(
                                        [
                                        'item_type' => $item_type,
                                        'item_type_status' => 'active',
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                    }
                    else{
                        $itemTypeId = $itemType[0]->item_type_id;
                    }

                    if($unit_name != ""){
                        $unit = DB::table('units_of_measure')
                                    ->where('unit_name', '=', $unit_name)
                                    ->get();
                        // dd($unit);
                        if(count($unit) == 0){
                            $unitId = DB::table('units_of_measure')->insertGetId(
                                            [
                                            'unit_name' => $unit_name,
                                            'unit_status' => 'active',
                                            'created_on' => $commonservice->getDateTime(),
                                            'created_by' => session('userId'),
                                            ]
                                        );
                        }
                        else{
                            $unitId = $unit[0]->uom_id;
                        }
                    }
                    else{
                        $unitId = '1';
                    }

                    $item = DB::table('items')
                                ->where('item_name', '=', $item_name)
                                ->get();
                    // dd($item);
                    if(count($item) == 0){
                        $itemId = DB::table('items')->insertGetId(
                                        [
                                        'item_name' => $item_name,
                                        'item_code' => $item_code,
                                        'item_type' => $itemTypeId,
                                        'item_category_id' => $itemCatId,
                                        'stockable' => 'yes',
                                        'brand'     => '1',
                                        'base_unit' => $unitId,
                                        'item_status' => 'active',
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                    }
                    else{
                        $itemId = $item[0]->item_id;
                    }

                    if($location_type != ""){
                        $locationType = DB::table('branch_types')
                                        ->where('branch_type', '=', $location_type)
                                        ->get();
                        // dd($location);
                        if(count($locationType) == 0){
                            $locationTypeId = DB::table('branch_types')->insertGetId(
                                            [
                                            'branch_type' => $location_type,
                                            'branch_type_status' => 'active',
                                            'created_on' => $commonservice->getDateTime(),
                                            'created_by' => session('userId'),
                                            ]
                                        );
                        }
                        else{
                            $locationTypeId = $locationType[0]->branch_type_id;
                        }
                    }
                    else{
                        $locationTypeId = '1'; 
                    }

                    if($country_name != ""){
                        $country = DB::table('countries')
                                        ->where('country_name', '=', $country_name)
                                        ->get();
                        // dd($location);
                        if(count($country) == 0){
                            $countryId = DB::table('countries')->insertGetId(
                                            [
                                            'country_name' => $country_name,
                                            'country_status' => 'active',
                                            'created_on' => $commonservice->getDateTime(),
                                            'created_by' => session('userId'),
                                            ]
                                        );
                        }
                        else{
                            $countryId = $country[0]->country_id;
                        }
                    }
                    else{
                        $countryId = '1'; 
                    }

                    if($brand_name != ""){
                        $brand = DB::table('brands')
                                        ->where('brand_name', '=', $brand_name)
                                        ->get();
                        // dd($location);
                        if(count($brand) == 0){
                            $brandId = DB::table('brands')->insertGetId(
                                            [
                                            'brand_name' => $brand_name,
                                            'brand_status' => 'active',
                                            'created_on' => $commonservice->getDateTime(),
                                            'created_by' => session('userId'),
                                            ]
                                        );
                        }
                        else{
                            $brandId = $brand[0]->brand_id;
                        }
                    }
                    else{
                        $brandId = '1'; 
                    }

                    $location = DB::table('branches')
                                ->where('branch_name', '=', $location_name)
                                ->get();
                    // dd($location);
                    if(count($location) == 0){
                        $locationId = DB::table('branches')->insertGetId(
                                        [
                                        'branch_name' => $location_name,
                                        'branch_status' => 'active',
                                        'country'  => $countryId,
                                        'branch_type_id' => $locationTypeId,
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                    }
                    else{
                        $locationId = $location[0]->branch_id;
                    }

                    $vendor = DB::table('vendors')
                                ->where('email', '=', $vendor_email)
                                ->get();
                    // dd($vendor);
                    if(count($vendor) == 0){
                        $vendorId = DB::table('vendors')->insertGetId(
                                        [
                                        'vendor_name' => $vendor_name,
                                        'vendor_status' => 'active',
                                        'email'  => $vendor_email,
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                    }
                    else{
                        $vendorId = $vendor[0]->vendor_id;
                    }
                    
                    if($po_number != ""){
                        $po = DB::table('purchase_orders')
                                        ->where('po_number', '=', $po_number)
                                        ->where('po_issued_on', '=', $po_date)
                                        ->get();
                        // dd($location);
                        if(count($po) == 0){
                            $poId = DB::table('purchase_orders')->insertGetId(
                                            [
                                            'po_number' => $po_number,
                                            'po_issued_on' => $po_date,
                                            'created_on' => $commonservice->getDateTime(),
                                            'created_by' => session('userId'),
                                            ]
                                        );
                        }
                        else{
                            $poId = $po[0]->po_id;
                        }
                        $invStkId = DB::table('inventory_stock')->insertGetId(
                                        [
                                        'item_id' => $itemId,
                                        'stock_quantity' => $stock_qty,
                                        'branch_id' => $locationId,
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                    }
                    else{
                        $invStkId = DB::table('inventory_stock')->insertGetId(
                                        [
                                        'item_id' => $itemId,
                                        'stock_quantity' => $stock_qty,
                                        'branch_id' => $locationId,
                                        'created_on' => $commonservice->getDateTime(),
                                        'created_by' => session('userId'),
                                        ]
                                    );
                    }


                }
                $i++;
            }
        }
        // print($invStkId);die;
        return $invStkId;
    }

}
