<?php
/*

Date               : 31 May 2021
Description        : District Service Page
Last Modified Date : 31 May 2021

*/

namespace App\Service;

use App\Model\District\DistrictTable;
use DB;

class DistrictService
{

    public function saveDistrict($request)
    {
        $data =  $request->all();
        DB::beginTransaction();
        try {
            $model = new DistrictTable();
            $add = $model->saveDistrict($request);
            if ($add > 0) {
                DB::commit();
                return 'District Added Successfully';
            }
        } catch (Exception $exc) {
            DB::rollBack();
            $exc->getMessage();
        }
    }

    //Get All District List
    public function getAllDistrict()
    {
        $model = new DistrictTable();
        return $model->fetchAllDistrict();
    }

    public function getDistrictByProvinceId($id)
    {
        $model = new DistrictTable();
        return $model->fetchDistrictNameByProvinceId($id);
    }

    //Get Particular District Details
    public function getDistrictById($id)
    {

        $model = new DistrictTable();
        return $model->fetchDistrictById($id);
    }
    //Update Particular District Details
    public function updateDistrict($params, $id)
    {
        DB::beginTransaction();
        try {
            $model = new DistrictTable();
            $add = $model->updateDistrict($params, $id);
            if ($add > 0) {
                DB::commit();
                return 'District Updated Successfully';
            }
        } catch (Exception $exc) {
            DB::rollBack();
            $exc->getMessage();
        }
    }


    //Get Particular District Name
    public function getDistictName($id)
    {
        $model = new DistrictTable();
        return $model->fetchDistrictName($id);
    }
    public function getDistictById($id)
    {
        $model = new DistrictTable();
        return $model->fetchDistrictId($id);
    }

    public function getDistictByData($id)
    {
        $model = new DistrictTable();
        return $model->fetchDistrictData($id);
    }
}
