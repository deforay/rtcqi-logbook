<?php

namespace App\Imports;

// use App\GradePrice;
use Maatwebsite\Excel\Concerns\ToModel;

class BulkItemUpload implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
       $arrayval=array();
       $i=1;
        foreach($row as $rowval){
            if($rowval!=''){
                if($i>2){
                    dd($rowval); 
                }
            // $arrayval[]=$rowval[0];
            // return new GradePrice([
            //             'name'     => $rowval,
            //         ]);
            }
         $i++;  
        }
        // dd($arrayval); 
               
    }
}
