<?php

namespace App\Model\Brand;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\BrandService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class BrandTable extends Model
{
    protected $table = 'brands';

    //add Brand
    public function saveBrand($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('brandName')!=null && trim($request->input('brandName')) != '') {
            $id = DB::table('brands')->insertGetId(
                ['brand_name' => $data['brandName'],
                'manufacturer_name' => $data['manufacturerName'],
                'brand_status' => $data['brandStatus'],
                'created_on' => $commonservice->getDateTime(),
                'created_by' => session('userId'),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'Brand-add', 'Add Brand '.$data['brandName'], 'Brand');
        }
        return $id;
    }

    // Fetch All Brand List
    public function fetchAllBrand()
    {
        $data = DB::table('brands')
                ->get();
        return $data;
    }

    // Fetch All Active Brand List
    public function fetchAllActiveBrand()
    {
        $data = DB::table('brands')
                ->where('Brand_status','=','active')
                ->orderBy('brand_id', 'asc')
                ->get();
        return $data;
    }

     // fetch particular Brand details
     public function fetchBrandById($id)
     {
         $id = base64_decode($id);
         $data = DB::table('brands')
                 ->where('brand_id', '=',$id )->get();
         return $data;
     }
 
     // Update particular Brand details
    public function updateBrand($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('brandName')!=null && trim($params->input('brandName')) != '') {
            $response = DB::table('brands')
                ->where('brand_id', '=',base64_decode($id))
                ->update(
                    ['brand_name' => $data['brandName'],
                    'manufacturer_name' => $data['manufacturerName'],
                    'brand_status' => $data['brandStatus'],
                    'updated_on' => $commonservice->getDateTime(),
                    'updated_by' => session('userId'),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Brand-update', 'Update Brand '.$data['brandName'], 'Brand');
        }
        return $response;
    }
}
