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
        $rslt = "";
        if ($validator->passes()) {
            DB::beginTransaction();
            try{
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
                $itemIdIns= 0;
                $itemIdUp= 0;
                $itemTypeIns = 0;
                $itemTypeUp = 0;
                $itemCatIns = 0;
                $itemCatUp = 0;
                $locationIns = 0;
                $locationUp = 0;
                $poIns = 0;
                $poUp = 0;
                $invIns = 0;
                $invUp = 0;
                $unitIns = 0;
                $unitUp = 0;
                $brandIns = 0;
                $brandUp = 0;
                $locationTypeIns = 0;
                $locationTypeUp = 0;
                $vendorIns = 0;
                $vendorUp = 0;
                $countryIns = 0;
                $countryUp = 0;
                foreach($array[0] as $row){
                    if($i>1){
                        // dd($row);
                        $item_category = $row[0];
                        $item_type = $row[1]; 
                        $unit_name = $row[2]; 
                        $item_name = $row[3]; 
                        $item_code = $row[4];
                        $item_qty = $row[5];
                        $country_name = $row[6];
                        $location_type = $row[7];
                        $location_name = $row[8];
                        $stock_qty = $row[9];
                        $brand_name = $row[10];
                        if($row[11] != ""){
                            $expiry_date = $row[11];
                        }
                        else{
                            $expiry_date = null;
                        }
                        $manufacturer_date = $row[12];
                        $vendor_name = $row[13];
                        $vendor_email = $row[14];
                        $po_number = $row[15];
                        // print_r($row[16]);
                        if($row[16] != ""){
                            $po_date = date('Y-m-d',strtotime($row[16]));
                        }
                        else{
                            $po_date = null;
                        }
                        $payment_status = $row[17];
                        if($row[18] != ""){
                            $order_status = $row[18];
                        }
                        else{
                            $order_status = "active";
                        }
                        $base_currency = $row[19];
                        $exchange_rate = $row[20];
                        $unit_price = $row[21];
                        $total_price = 0;
                        // if($i>2){
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

                                $itemCatIns++;
                            }
                            else{
                                $itemCatId = $itemCat[0]->item_category_id;
                                $itemCatUp++;
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
                                $itemTypeIns++;
                            }
                            else{
                                $itemTypeId = $itemType[0]->item_type_id;
                                $itemTypeUp++;
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
                                    $unitIns++;
                                }
                                else{
                                    $unitId = $unit[0]->uom_id;
                                    $unitUp++;
                                }
                            }
                            else{
                                $unitId = '1';
                                $unitUp++;
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
                                $itemIdIns++;
                            }
                            else{
                                $itemId = $item[0]->item_id;
                                $itemIdUp++;
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
                                    $locationTypeIns++;
                                }
                                else{
                                    $locationTypeId = $locationType[0]->branch_type_id;
                                    $locationTypeUp++;
                                }
                            }
                            else{
                                $locationTypeId = '1';
                                $locationTypeUp++;
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
                                    $countryIns++;
                                }
                                else{
                                    $countryId = $country[0]->country_id;
                                    $countryUp++;
                                }
                            }
                            else{
                                $countryId = '1';
                                $countryUp++;
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
                                    $brandIns++;
                                }
                                else{
                                    $brandId = $brand[0]->brand_id;
                                    $brandUp++;
                                }
                            }
                            else{
                                $brandId = '1';
                                $brandUp++;
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
                                $locationIns++;
                            }
                            else{
                                $locationId = $location[0]->branch_id;
                                $locationUp++;
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
                                $vendorIns++;
                            }
                            else{
                                $vendorId = $vendor[0]->vendor_id;
                                $vendorUp++;
                            }
                            
                            if($po_number != ""){
                                if($base_currency == "yes"){
                                    if($exchange_rate != ""){
                                        $converted_price = $exchange_rate * $unit_price;
                                    }
                                    else{
                                        $converted_price = 1 * $unit_price;
                                    }
                                }
                                else{
                                    $converted_price = 1 * $unit_price;
                                }
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
                                                    'vendor'    => $vendorId,
                                                    'order_status' => $order_status,
                                                    'payment_status' => $payment_status,
                                                    'total_amount'  => $converted_price,
                                                    'delivery_location' => $locationId,
                                                    'created_on' => $commonservice->getDateTime(),
                                                    'created_by' => session('userId'),
                                                    ]
                                                );
                                    
                                    $poIns++;
                                    $podId = DB::table('purchase_order_details')->insertGetId(
                                                [
                                                    'po_id'             => $poId,
                                                    'item_id'           => $itemId,
                                                    'uom'               => $unitId,
                                                    'quantity'          => $item_qty,
                                                    'unit_price'        => $unit_price,
                                                    'converted_price'   => $converted_price,
                                                ]
                                            );
                                    
                                }
                                else{
                                    $poId = $po[0]->po_id;
                                    // dd($po);
                                    $total_price = intval($po[0]->total_amount) + (int)$converted_price;
                                    $poParams = array(
                                        'po_number' => $po_number,
                                        'po_issued_on' => $po_date,
                                        'vendor'    => $vendorId,
                                        'order_status' => $order_status,
                                        'payment_status' => $payment_status,
                                        'total_amount'  => $total_price,
                                        'delivery_location' => $locationId,
                                        'updated_on' => $commonservice->getDateTime(),
                                        'updated_by' => session('userId'),
                                    );
                                    
                                    $purchaseOrder = DB::table('purchase_orders')
                                                        ->where('po_id', '=', $poId)
                                                        ->update(
                                                            $poParams
                                                        );

                                    $poUp++;
                                    $poData = DB::table('purchase_order_details')
                                                ->where('purchase_order_details.po_id', '=', $poId)
                                                ->where('purchase_order_details.item_id', '=', $itemId)
                                                ->get();

                                    if(count($poData) > 0){
                                        if($base_currency == "yes"){
                                            if($exchange_rate != ""){
                                                $converted_price = $exchange_rate * $unit_price;
                                            }
                                            else{
                                                $converted_price = 1 * $unit_price;
                                            }
                                        }
                                        else{
                                            $converted_price = 1 * $unit_price;
                                        }
                                        // dd($poData);
                                        // $total_price = intval($po[0]->total_amount) + (int)$converted_price;
                                        $podId = $poData[0]->pod_id;
                                        

                                        $purchaseOrderDetailsData = array(
                                            'po_id'             => $poId,
                                            'item_id'           => $itemId,
                                            'uom'               => $unitId,
                                            'quantity'          => $item_qty,
                                            'unit_price'        => $unit_price,
                                            'converted_price'   => $converted_price,
                                        );
                                        $purchaseOrderdetailsUp = DB::table('purchase_order_details')
                                                                    ->where('pod_id', '=', $podId)
                                                                    ->update($purchaseOrderDetailsData);
                                    }
                                    else{
                                        if($base_currency == "yes"){
                                            if($exchange_rate != ""){
                                                $converted_price = $exchange_rate * $unit_price;
                                            }
                                            else{
                                                $converted_price = 1 * $unit_price;
                                            }
                                        }
                                        else{
                                            $converted_price = 1 * $unit_price;
                                        }
                                        $podId = DB::table('purchase_order_details')->insertGetId(
                                            [
                                                'po_id'             => $poId,
                                                'item_id'           => $itemId,
                                                'uom'               => $unitId,
                                                'quantity'          => $item_qty,
                                                'unit_price'        => $unit_price,
                                                'converted_price'   => $converted_price,
                                            ]
                                        );
                                    }
                                }
                                $invStk = DB::table('inventory_stock')->where('item_id', '=', $itemId)->where('branch_id', '=', $locationId);
                                if($expiry_date!="" && $expiry_date!=null){
                                    $invStk = $invStk->where('expiry_date', '=', $commonservice->dateFormat($expiry_date));
                                }
                                if($podId!="" && $podId!=null){
                                    $invStk = $invStk->where('pod_id', '=', $podId);
                                }
                                $invStk = $invStk->get();
                                if(count($invStk) == 0){
                                    $invStkId = DB::table('inventory_stock')->insertGetId(
                                                    [
                                                    'item_id' => $itemId,
                                                    'stock_quantity' => $stock_qty,
                                                    'branch_id' => $locationId,
                                                    'created_on' => $commonservice->getDateTime(),
                                                    'created_by' => session('userId'),
                                                    'expiry_date' => $expiry_date,
                                                    'pod_id' => $podId,
                                                    'manufacturing_date' => $manufacturer_date,
                                                    ]
                                                );
                                    $invIns++;
                                }
                                else{
                                    $stkQty = intval($stock_qty) + intval($invStk[0]->stock_quantity);
                                    $stockId = DB::table('inventory_stock')
                                                ->where('branch_id', '=', $locationId)
                                                ->where('item_id', '=', $itemId);
                                    if($expiry_date!="" && $expiry_date != null){
                                        $stockId = $stockId->where('expiry_date', '=', $commonservice->dateFormat($expiry_date));
                                    }
                                    $stockId = $stockId->update(
                                                [
                                                    'manufacturing_date'      => $manufacturer_date,
                                                    'stock_quantity'          => $stkQty,
                                                    'updated_by'              => session('userId'),
                                                    'updated_on'              => $commonservice->getDateTime(),
                                                    'pod_id'                  => $podId,
                                                    'expiry_date'             => $commonservice->dateFormat($expiry_date),
                                                ]
                                            );

                                    $invUp++;
                                }
                            }
                            else{
                                $invStk = DB::table('inventory_stock')->where('item_id', '=', $itemId)->where('branch_id', '=', $locationId);
                                if($expiry_date!="" && $expiry_date!=null){
                                    $invStk = $invStk->where('expiry_date', '=', $commonservice->dateFormat($expiry_date));
                                }
                                $invStk = $invStk->get();
                                if(count($invStk) == 0){
                                    $invStkId = DB::table('inventory_stock')->insertGetId(
                                                    [
                                                    'item_id' => $itemId,
                                                    'stock_quantity' => $stock_qty,
                                                    'branch_id' => $locationId,
                                                    'created_on' => $commonservice->getDateTime(),
                                                    'created_by' => session('userId'),
                                                    'expiry_date' => $expiry_date,
                                                    'manufacturing_date' => $manufacturer_date,
                                                    ]
                                                );
                                    $invIns++;
                                }
                                else{
                                    $stkQty = intval($stock_qty) + intval($invStk[0]->stock_quantity);
                                    $stockId = DB::table('inventory_stock')
                                                ->where('branch_id', '=', $locationId)
                                                ->where('item_id', '=', $itemId);
                                    if($expiry_date!="" && $expiry_date != null){
                                        $stockId = $stockId->where('expiry_date', '=', $commonservice->dateFormat($expiry_date));
                                    }
                                    $stockId = $stockId->update(
                                                [
                                                    'manufacturing_date'      => $manufacturer_date,
                                                    'stock_quantity'          => $stkQty,
                                                    'updated_by'              => session('userId'),
                                                    'updated_on'              => $commonservice->getDateTime(),
                                                    'expiry_date'             => $commonservice->dateFormat($expiry_date),
                                                ]
                                            );
                                    $invUp++;
                                }
                            
                            }

                        // }
                    }
                    $i++;
                }
                $rslt .= $itemCatIns." Item Category are Inserted and ".$itemCatUp." are Updated <br>";
                $rslt .= $itemTypeIns." Item Type are Inserted and ".$itemTypeUp." are Updated <br>";
                $rslt .= $itemIdIns." Item are Inserted and ".$itemIdUp." are Updated <br>";
                $rslt .= $brandIns." Brand are Inserted and ".$brandUp." are Updated <br>";
                $rslt .= $locationIns." Location are Inserted and ".$locationUp." are Updated <br>";
                $rslt .= $locationTypeIns." Location Type are Inserted and ".$locationTypeUp." are Updated <br>";
                $rslt .= $vendorIns." Vendors are Inserted and ".$vendorUp." are Updated <br>";
                $rslt .= $poIns." Purchase Order are Inserted and ".$poUp." are Updated <br>";
                $rslt .= $invIns." Inventory Stock are Inserted and ".$invUp." are Updated <br>";
                // dd($rslt);
                DB::commit();
            } 
            catch (Exception $exc) {
                DB::rollBack();
                $exc->getMessage();
                $rslt .= "Nothing Updated <br>";
            }
        }
        // print($invStkId);die;
        return $rslt;
    }

}
