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

class ReportDataExport implements FromCollection, WithHeadings, WithTitle
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
        $userId = session('userId');
        // dd($item);
        $a = 0;
        $wholeArr = array();
        $arr = array();
        for ($k = 0; $k < count($item); $k++) {
            $inv = DB::table('inventory_stock')
                ->join('branches', 'branches.branch_id', '=', 'inventory_stock.branch_id')
                ->join('items', 'items.item_id', '=', 'inventory_stock.item_id')
                ->join('purchase_order_details', 'purchase_order_details.pod_id', '=', 'inventory_stock.pod_id')
                ->join('purchase_orders', 'purchase_orders.po_id', '=', 'purchase_order_details.po_id')
                ->join('vendors', 'vendors.vendor_id', '=', 'purchase_orders.vendor')
                ->join('user_branch_map', 'user_branch_map.branch_id', '=', 'branches.branch_id')
                ->join('brands', 'brands.brand_id', '=', 'items.brand');
                // ->select($qty, 'items.item_code', 'items.item_name')
                // ->groupBy('inventory_stock.branch_id')
                // ->groupBy('inventory_stock.item_id', 'items.item_code', 'items.item_name')
            if(session('loginType') != 'vendor' && strtolower(session('roleName'))!='admin'){
                $inv = $inv->where('user_branch_map.user_id', '=', $userId);
            }
            $inv = $inv->where('inventory_stock.item_id', '=', $item[$k]->item_id);
            if ($this->branches) {
                $inv = $inv->where('branches.branch_id', '=', $this->branches);
            }
           
            $inv = $inv->get();
            // dd($inv);
            // print_r($inv);
            $inv = $inv->toArray();
            // print_r(json_encode($inv));die;
            if (isset($inv) && count($inv) > 0) {
                for ($l = 0; $l < count($inv); $l++) {
                    $arr[$a]['item_name'] = $inv[$l]->item_name;
                    if ($inv[$l]->item_code != null && $inv[$l]->item_code != '' && $inv[$l]->item_code != 'null') {
                        $arr[$a]['item_code'] = $inv[$l]->item_code;
                    } else {
                        $arr[$a]['item_code'] = '';
                    }
                    $arr[$a]['stock_quantity'] = $inv[$l]->stock_quantity;
                    // $str = implode(',', array_unique(explode(',', $inv[$l]->branch_name)));
                    $arr[$a]['branch_name'] = $inv[$l]->branch_name;
                    $arr[$a]['expiry_date'] = $commonservice->humanDateFormat($inv[$l]->expiry_date);
                    $arr[$a]['manufacturing_date'] = $commonservice->humanDateFormat($inv[$l]->manufacturing_date);
                    $arr[$a]['received_date'] = $commonservice->humanDateFormat($inv[$l]->received_date);
                    $arr[$a]['brand_name'] = $inv[$l]->brand_name;
                    $arr[$a]['manufacturer_name'] = $inv[$l]->manufacturer_name;
                    $arr[$a]['vendor_name'] = $inv[$l]->vendor_name;
                    $arr[$a]['po_number'] = $inv[$l]->po_number;
                    $arr[$a]['po_issued_on'] = $commonservice->humanDateFormat($inv[$l]->po_issued_on);
                    $a++;
                    // array_push($wholeArr,$arr);
                }
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
        $colForm[4] = 'Expiry Date';
        $colForm[5] = 'Manufacturing Date';
        $colForm[6] = 'Brand Name';
        $colForm[7] = 'Manufacturer';
        $colForm[8] = 'Vendor';
        $colForm[9] = 'PO Number';
        $colForm[10] = 'PO Issued On';

        // print_r($colForm);die;
        return [
            $colForm
        ];
    }

    public function title(): string
    {
        return 'Inventory Report Detailed Data';
    }
}
