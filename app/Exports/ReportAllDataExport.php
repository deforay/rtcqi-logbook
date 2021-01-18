<?php

namespace App\Exports;

use App\Model\InventoryOutwards\InventoryOutwardsTable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Service\CommonService;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;
use Illuminate\Support\Facades\Schema;

class ReportAllDataExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(string $sheets,array $reportData)
    {
        $this->branches = $reportData['branches'];
    }

    public function collection()
    {
        // print_r($this->branches);die;
        $commonservice = new CommonService();
        $userId = session('userId');
        $item = DB::table('items')->get();
        $qty = DB::raw('SUM(inventory_stock.stock_quantity) as stock_quantity');
        $branch = DB::raw('group_concat(branches.branch_name) as branch_name');
        // dd($item);
        $a = 0;
        $arr = array();
        for ($k = 0; $k < count($item); $k++) {
            $inv = DB::table('inventory_stock')
                ->join('branches', 'branches.branch_id', '=', 'inventory_stock.branch_id')
                ->join('items', 'items.item_id', '=', 'inventory_stock.item_id')
                ->leftjoin('user_branch_map', 'user_branch_map.branch_id', '=', 'branches.branch_id')
                // ->where('user_branch_map.user_id', '=', $userId)
                ->select($qty, $branch, 'items.item_code', 'items.item_name')
                ->groupBy('inventory_stock.item_id', 'items.item_code', 'items.item_name')
                ->where('inventory_stock.item_id', '=', $item[$k]->item_id);
            if ($this->branches) {
                $inv = $inv->where('branches.branch_id', '=', $this->branches);
            }
            if(session('loginType') != 'vendor' && strtolower(session('roleName'))!='admin'){
                $inv = $inv->where('user_branch_map.user_id', '=', $userId);
            }
            $inv = $inv->get();
            // dd($inv);
            // print_r($inv);
            $inv = $inv->toArray();
            // print_r($inv);die;
            if (isset($inv) && count($inv) > 0) {
                $arr[$a]['item_name'] = $inv[0]->item_name;
                if ($inv[0]->item_code != null && $inv[0]->item_code != '' && $inv[0]->item_code != 'null') {
                    $arr[$a]['item_code'] = $inv[0]->item_code;
                } else {
                    $arr[$a]['item_code'] = '';
                }
                $arr[$a]['stock_quantity'] = $inv[0]->stock_quantity;
                $str = implode(',', array_unique(explode(',', $inv[0]->branch_name)));
                $arr[$a]['branch_name'] = $str;
                // $arr[$a]['expiry_date'] = $commonservice->humanDateFormat($inv[0]->expiry_date);
                // $arr[$a]['manufacturing_date'] = $commonservice->humanDateFormat($inv[0]->manufacturing_date);
                // $arr[$a]['received_date'] = $commonservice->humanDateFormat($inv[0]->received_date);
                $a++;
            }
        }
        // print_r(json_encode($arr));die;
        return collect([
            
            $arr
        ]);
        // }
        // else{
        //     $msg = "There is no data in this specimen collection date range";
        // }
    }

    public function headings(): array
    {
        $colForm = array();
        $colForm[0] = 'Item Name';
        $colForm[1] = 'Item Code';
        $colForm[2] = 'Current Inventory';
        $colForm[3] = 'Location';
        // $colForm[4] = 'Expiry Date';
        // $colForm[5] = 'Manufacturing Date';
        // $colForm[6] = 'Received Date';
        return [
            $colForm
        ];
    }

    public function title(): string
    {
        return 'Inventory Report Consolidated Data';
    }
}
