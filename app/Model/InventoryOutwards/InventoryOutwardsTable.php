<?php

namespace App\Model\InventoryOutwards;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\InventoryOutwardsService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class InventoryOutwardsTable extends Model
{
    //
    public function fetchItemByLoc($params){
        $req = $params->all();
        // dd($req['id']);
        $data = DB::table('inventory_stock')
                ->join('items', 'items.item_id', '=', 'inventory_stock.item_id')
                ->where('inventory_stock.branch_id', '=', $req['id'])
                ->select('items.item_name','inventory_stock.item_id','inventory_stock.stock_quantity','inventory_stock.expiry_date')
                ->distinct('inventory_stock.item_id')
                ->get();
        // dd($data);
        return json_encode($data);
    }

    public function saveInventoryOutwards($request){
        $data = $request->all();
        // dd($data);
        $autoId = 0;
        $commonservice = new CommonService();
        // dd($commonservice->getDateTime());
        for ($j = 0; $j < count($data['item']); $j++) {
            $issuedOn = $commonservice->dateFormat($data['issuedOn'][$j]);
            $value = explode('@@',$data['item'][$j]);
            $item = $value[0];
            $itemQty = $value[1];
            $expiryDate = $value[2];
            $stkQty = intval($itemQty) - intval($data['itemIssuedQty'][$j]);
            // dd($stkQty);
            $autoId = DB::table('inventory_outwards')->insertGetId(
                    [
                        'item_id' => $item,
                        'issued_on' => $issuedOn,
                        'item_issued_quantity' => $data['itemIssuedQty'][$j],
                        'issued_to' => $data['issuedTo'][$j],
                        'outwards_description'  => $data['description'][$j],
                        'created_by' => session('userId'),
                        'created_on' => $commonservice->getDateTime(),
                    ]
                );
            
            $invStock =  DB::table('inventory_stock')
                        ->where('item_id', '=', $item)
                        ->where('branch_id', '=', $data['branches'][$j]);
            if($expiryDate){
                $invStock = $invStock->where('expiry_date', '=', $expiryDate);
            }
            $invStock = $invStock->update(
                            [
                                'stock_quantity'    => $stkQty,
                            ]
                        );
        }
        return $autoId;
    }

    // Fetch All Inventory Outwards List
    public function fetchAllInventoryOutwards()
    {
        $userId=session('userId');
        if(session('loginType')=='users'){
            $data = DB::table('inventory_outwards')
                    ->join('items', 'items.item_id', '=', 'inventory_outwards.item_id')
                    ->join('branches', 'branches.branch_id', '=', 'inventory_outwards.issued_to')
                    ->join('user_branch_map', 'branches.branch_id', '=', 'user_branch_map.branch_id')
                    ->where('user_branch_map.user_id', '=', $userId)
                    ->get();
        }
        else{
            $data = DB::table('inventory_outwards')
                    ->join('items', 'items.item_id', '=', 'inventory_outwards.item_id')
                    ->join('branches', 'branches.branch_id', '=', 'inventory_outwards.issued_to')
                    ->join('user_branch_map', 'branches.branch_id', '=', 'user_branch_map.branch_id')
                    ->where('user_branch_map.user_id', '=', $userId)
                    ->get();
        }
        return $data;
    }

    public function fetchInventoryReport($request){
        $data = $request->all();
        $arr = array();
        // dd($data);
        $userId=session('userId');
        $item = DB::table('items')->get();
        $qty = DB::raw('SUM(inventory_stock.stock_quantity) as stock_quantity');
        $branch = DB::raw('group_concat(branches.branch_name) as branch_name');
        // dd($item);
        $a = 0;
        for($k=0;$k<count($item);$k++){
            $inv = DB::table('inventory_stock')
                    ->join('branches', 'branches.branch_id', '=', 'inventory_stock.branch_id')
                    ->join('items', 'items.item_id', '=', 'inventory_stock.item_id')
                    // ->where('user_branch_map.user_id', '=', $userId)
                    ->select($qty,$branch,'items.item_code','items.item_name')
                    ->groupBy('inventory_stock.item_id','items.item_code','items.item_name')
                    ->where('inventory_stock.item_id', '=', $item[$k]->item_id);
            if($request['branchId']){
                $inv = $inv->where('branches.branch_id', '=', $data['branchId']);
            }
            $inv = $inv->get();
            // dd($inv);
            // print_r($inv);
            $inv = $inv->toArray();
            // print_r(count($inv));
            if(isset($inv) && count($inv)>0){
                $arr[$a]['stock_quantity'] = $inv[0]->stock_quantity;
                $arr[$a]['item_name'] = $inv[0]->item_name;
                if($inv[0]->item_code!=null && $inv[0]->item_code!='' && $inv[0]->item_code!='null'){
                    $arr[$a]['item_code'] = $inv[0]->item_code;
                }
                else{
                    $arr[$a]['item_code'] = '';
                }
                $str = implode(',',array_unique(explode(',', $inv[0]->branch_name)));
                $arr[$a]['branch_name'] = $str;
                $a++;
            }
        }
        // dd($arr);
        return json_encode($arr);
    }
}
