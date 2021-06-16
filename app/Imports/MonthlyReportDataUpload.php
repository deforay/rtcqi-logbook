<?php

namespace App\Imports;

use App\Model\MonthlyReport\MonthlyReportTable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonthlyReportDataUpload implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // echo "ss";die;
        $arrayval=array();
        // dd($row);
    //    $i=1;
    //     foreach($row as $rowval){
    //         print_r($row);die;
    //         if($rowval!=''){
    //             if($i>2){
    //                 dd($rowval); 
    //             }
    //         // $arrayval[]=$rowval[0];
    //         // return new GradePrice([
    //         //             'name'     => $rowval,
    //         //         ]);
    //         }
    //      $i++;  
    //     }
        return new MonthlyReportTable([
            'item_category' => $row[0],
            'item_type'    => $row[1], 
            'unit'    => $row[2], 
            'item'    => $row[3], 
            'item_code'    => $row[4], 
            'location'    => $row[5], 
            'stock_qty'    => $row[6], 
            'vendor_name'    => $row[7], 
            'vendor_email'    => $row[8],
        ]);
               
    }

    // public function collection(Collection $rows)
    // {   
    //     return InventoryStockUpload::all();
    // }
}
