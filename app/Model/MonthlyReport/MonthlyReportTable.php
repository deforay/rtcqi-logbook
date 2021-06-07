<?php

namespace App\Model\MonthlyReport;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class MonthlyReportTable extends Model
{
    protected $table = 'monthly_reports';

    //add MonthlyReport
    public function saveMonthlyReport($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        $DateOfCollect = $commonservice->dateFormat($data['DateOfCollect']);
        $reportingMon = $commonservice->dateFormat($data['reportingMon']);
        if ($request->input('provinceId')!=null && trim($request->input('provinceId')) != '') {
            $id = DB::table('monthly_reports')->insertGetId(
                [
                'provincesss_id' => $data['provinceId'],
                'site_unique_id' => $data['siteUniqueId'],
                'ts_id' => $data['testsiteId'],
                'st_id' => $data['sitetypeId'],
                'site_manager' => $data['siteManager'],
                'is_flc' => $data['isFlu'],
                'is_recency' => $data['isRecency'],
                'contact_no' => $data['contactNo'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'algorithm_type' => $data['algoType'],
                'date_of_data_collection' => $DateOfCollect,
                'reporting_month' => $reportingMon,
                'book_no' => $data['bookNo'],
                'name_of_data_collector' => $data['nameOfDataCollect'],
                'signature' => $data['signature'],
                ]
            );
            $monthly_reports_pages = DB::table('monthly_reports_pages')->insertGetId(
                [
                'mr_id' => $id,
                'page_no' => $data['pageNO'],
                'start_test_date' => $data['startDate'],
                'end_test_date' => $data['endDate'],
                'test_1_kit_id' => $data['testkitId1'],
                'lot_no_1' => $data['lotNO1'],
                'expiry_date_1' => $data['expiryDate1'],
                'test_1_reactive' => $data['totalReactive1'],
                'test_1_nonreactive' => $data['totalNonReactive1'],
                'test_1_invalid' => $data['totalInvalid1'],
                'test_2_kit_id' => $data['testkitId2'],
                'lot_no_2' => $data['lotNO2'],
                'expiry_date_2' => $data['expiryDate2'],
                'test_2_reactive' => $data['totalReactive2'],
                'test_2_nonreactive' => $data['totalNonReactive2'],
                'test_2_invalid' => $data['totalInvalid2'],
                'test_3_kit_id' => $data['testkitId3'],
                'lot_no_3' => $data['lotNO3'],
                'expiry_date_3' => $data['expiryDate3'],
                'test_3_reactive' => $data['totalReactive3'],
                'test_3_nonreactive' => $data['totalNonReactive3'],
                'test_3_invalid' => $data['totalInvalid3'],
                'final_positive' => $data['totalReactive'],
                'final_negative' => $data['totalNonReactive'],
                'final_undetermined' => $data['totalInvalid'],
                ]
            );
        }

        return $id;
    }

    // Fetch All MonthlyReport List
    public function fetchAllMonthlyReport()
    {
        $data = DB::table('monthly_reports')
                ->join('provinces', 'provinces.provincesss_id', '=', 'monthly_reports.provincesss_id')
                ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->get();
        return $data;
    }

    // Fetch All Active MonthlyReport List
    public function fetchAllActiveMonthlyReport()
    {
        $data = DB::table('monthly_reports')
                // ->where('province_status','=','active')
                ->get();
        return $data;
    }

     // fetch particular MonthlyReport details
     public function fetchMonthlyReportById($id)
     {

         $id = base64_decode($id);
         $data = DB::table('monthly_reports')
                ->join('provinces', 'provinces.provincesss_id', '=', 'monthly_reports.provincesss_id')
                ->join('site_types', 'site_types.st_id', '=', 'monthly_reports.st_id')
                ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
                ->where('monthly_reports.mr_id', '=',$id )
                ->get();
         return $data;
     }

     // Update particular MonthlyReport details
    public function updateMonthlyReport($params,$id)
    {
        $data = $params->all();
        $commonservice = new CommonService();
        $DateOfCollect = $commonservice->dateFormat($data['DateOfCollect']);
        $reportingMon = $commonservice->dateFormat($data['reportingMon']);
            $upData = array(
                'provincesss_id' => $data['provinceId'],
                'site_unique_id' => $data['siteUniqueId'],
                'ts_id' => $data['testsiteId'],
                'st_id' => $data['sitetypeId'],
                'site_manager' => $data['siteManager'],
                'is_flc' => $data['isFlu'],
                'is_recency' => $data['isRecency'],
                'contact_no' => $data['contactNo'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'algorithm_type' => $data['algoType'],
                'date_of_data_collection' => $DateOfCollect,
                'reporting_month' => $reportingMon,
                'book_no' => $data['bookNo'],
                'name_of_data_collector' => $data['nameOfDataCollect'],
                'signature' => $data['signature'],
            );
            $response = DB::table('monthly_reports')
                ->where('mr_id', '=',base64_decode($id))
                ->update(
                        $upData
                    );
        return $response;
    }

    public function fetchTrendMonthlyReport($params)
 {
  $start_date = $params['startDate'];
  $end_date = $params['endDate'];
  $facilityId = $params['facilityId'];
  $algorithmType = $params['algorithmType'];
  $testSiteId = $params['testSiteId'];
  DB::enableQueryLog();
    $query = DB::table('monthly_reports')               
      ->join('test_sites', 'test_sites.ts_id', '=', 'monthly_reports.ts_id')
      ->join('facilities', 'facilities.facility_id', '=', 'monthly_reports.facility_id')
      ->where('monthly_reports.facility_id', '=',$facilityId )
      ->where('monthly_reports.sector_id', '=',$algorithmType )
      ->where('monthly_reports.ts_id', '=',$testSiteId );
     

           if (trim($start_date) != "" && trim($end_date) != "") {
               $query = $query->where('monthly_reports.reporting_month','>=',$start_date)->where('monthly_reports.reporting_month','<=',$end_date);         
           }
          if (isset($params['facilityId']) && $params['facilityId'] != '') {
              $query = $query->whereIn('monthly_reports.facility_id',$params['facilityId']); 
          }  
          if (isset($params['algorithmType']) && $params['algorithmType'] != '') {            
              $query = $query->whereIn('monthly_reports.algorithmType', $params['algorithmType']); 
          }  
         if (isset($params['testSiteId']) && $params['testSiteId'] != '') {
              $query = $query->whereIn('monthly_reports.ts_id', $params['ts_id']); 
          }
        //  if (isset($params['product_Id']) && $params['product_Id'] != '') {
        //       $query = $query->where('products.product_id', $params['product_Id']); 
        //   }

    //  $salesResult=$query->get();
    // //  dump(DB::getQueryLog());
    //  foreach ($salesResult as $sRes) {
    //   $monthResult[$sRes->monthyear] = $sRes->monthyear;
    //     $m = $sRes->monthyear;
    //       if (!isset($result[$sRes->grade_cat_id][$m])) {
    //           $result[$sRes->grade_cat_id]['gradecatId'] = $sRes->grade_cat_id;
    //           $result[$sRes->grade_cat_id]['gradeCatName'] = $sRes->grade_cat_name;
    //           $result[$sRes->grade_cat_id][$m] = $sRes->qty;
    //       }
    //       else {
    //           $result[$sRes->grade_cat_id][$m] += $sRes->qty;
    //       }
    //   }
     
    //  $res['salesMonth'] = $monthResult;
    //  $res['result'] = $result;
    //  $res['start_date'] = $start_date;
    //  $res['end_date'] = $end_date;
    //  $res['customerId'] = $customerId;
    //  $res['sectorID'] = $sectorId;
    //  $res['productId'] = $productsId;
    //  $res['loopId'] = $params['loopId'];
     return $query;
}
    
}
