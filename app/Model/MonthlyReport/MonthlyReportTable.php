<?php

namespace App\Model\MonthlyReport;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use App\Service\GlobalConfigService;
use Illuminate\Support\Facades\Session;

class MonthlyReportTable extends Model
{
    protected $table = 'monthly_reports';

    //add MonthlyReport
    public function saveMonthlyReport($request)
    {
        //to get all request values
        $data = $request->all();
        // print_r($data);die;
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
                // 'latitude' => $data['latitude'],
                // 'longitude' => $data['longitude'],
                'algorithm_type' => $data['algoType'],
                'date_of_data_collection' => $DateOfCollect,
                'reporting_month' => $reportingMon,
                'book_no' => $data['bookNo'],
                'name_of_data_collector' => $data['nameOfDataCollect'],
                // 'signature' => $data['signature'],
                ]
            );
            $GlobalConfigService = new GlobalConfigService();
            $result = $GlobalConfigService->getAllGlobalConfig();
            $arr = array();
            // now we create an associative array so that we can easily create view variables
            for ($i = 0; $i < sizeof($result); $i++) {
                $arr[$result[$i]->global_name] = $result[$i]->global_value;
            }
            // print_r($data);die;
            for($p =0; $p < count($data['pageNO']); $p++)
            {

                $insMonthlyArr = array(
                    'mr_id' => $id,
                    'page_no' => $data['pageNO'][$p],
                    'start_test_date' => $data['startDate'][$p],
                    'end_test_date' => $data['endDate'][$p],
                    'final_positive' => $data['totalPositive'][$p],
                    'final_negative' => $data['totalNegative'][$p],
                    'final_undetermined' => $data['finalUndetermined'][$p],
                );
                for($l = 1; $l <= $arr['no_of_test']; $l++)
                {
                    $m = $l;
                    $insMonthlyArr['test_'.$m.'_kit_id'] = $data['testkitId'.$l][$p];
                    $insMonthlyArr['lot_no_'.$m] = $data['lotNO'.$l][$p];
                    $insMonthlyArr['expiry_date_'.$m] = $data['expiryDate'.$l][$p];
                    $insMonthlyArr['test_'.$m.'_reactive'] = $data['totalReactive'.$l][$p];
                    $insMonthlyArr['test_'.$m.'_nonreactive'] = $data['totalNonReactive'.$l][$p];
                    $insMonthlyArr['test_'.$m.'_invalid'] = $data['totalInvalid'.$l][$p];
                }
                $totalPositive= $data['totalPositive'][$p];						
                $totalTested = $data['totalReactive1'][$p] + $data['totalNonReactive1'][$p];							
                $positivePercentage = ($totalTested ==0) ? 'N.A' : number_format($totalPositive*100/$totalTested,2);
                $posAgreement = 0;
                if($data['totalReactive1'][$p] > 0)
                $posAgreement = number_format(100*($data['totalReactive2'][$p] )/($data['totalReactive1'][$p]),2 );
                $OverallAgreement = number_format(100* ($data['totalReactive2'][$p] + $data['totalNonReactive1'][$p])/($data['totalReactive1'][$p] + $data['totalNonReactive1'][$p]),2);
                $insMonthlyArr['positive_percentage'] = $positivePercentage;
                $insMonthlyArr['positive_agreement'] = $posAgreement;
                $insMonthlyArr['overall_agreement'] = $OverallAgreement;
                // print_r($insMonthlyArr);die;
                $monthly_reports_pages = DB::table('monthly_reports_pages')->insertGetId(
                    $insMonthlyArr
                );
            }
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
