<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class ODKDataCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odkdata:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Odk Data save';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://odk-central.labsinformatics.com/v1/sessions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"email\": \"support@deforay.com\",
        \"password\": \"mko)(*&^\"
        }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $email = 'support@deforay.com';
        $password = 'mko)(*&^';
        $token = base64_encode($email . ':' . $password);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://odk-central.labsinformatics.com/v1/projects/5/forms/Monthly_Report.svc/Submissions?%24filter=__system%2FsubmissionDate%20gt%202021-06-01");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic $token",
        ));
        $response1 = curl_exec($ch);
        $submission = json_decode($response1,TRUE);
        curl_close($ch);
        for($t=0;$t<count($submission['value']);$t++)
        {
           $uid = $submission['value'][$t]['__id'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://odk-central.labsinformatics.com/v1/projects/5/forms/Monthly_Report/submissions/".$uid.".xml");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Basic $token",
                "Content-Type: application/xml"    
            ));
            $response2 = curl_exec($ch);
            curl_close($ch);
            $xml = simplexml_load_string($response2);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            // print_r($json);
            $test_site_name = $array['Section_1']['sitename'];
            $site_type = $array['Section_1']['sitetype']; 
            $province = $array['Section_1']['provincename']; 
            $site_manager = $array['Section_1']['sitemanager'];
            $site_unique_id = $array['Section_1']['siteid'];
            $if_flc = $array['Section_1']['is_flc'];
            $is_recency = $array['Section_1']['perform_recency_test'];
            $contact_no = $array['Section_1']['phoneno'];
            $algo_type = $array['Section_2']['algo'];
            $date_of_collection = date('Y-m-d', strtotime($array['Section_2']['data_collection_date']));
            $report_months = date('Y-m-d', strtotime($array['Section_2']['reporting_month']));
            $book_no = $array['Section_2']['bookno'];
            $name_of_collector = $array['signature_block']['data_collector_name'];
            // $provinceId
            // site Type
            $siteTypeData = DB::table('site_types')
                            ->where('site_type_name', '=', trim($site_type))
                            ->get();
            if(count($siteTypeData) > 0){
                $siteTypeId = $siteTypeData[0]->st_id;
            }
            else
            {
                $siteTypeId = DB::table('site_types')->insertGetId(
                    [
                    'site_type_name' => trim($site_type),
                    'site_type_status' => 'active',
                    ]
                );
            }
            // Test Site
            $testsiteData = DB::table('test_sites')
                            ->where('site_name', '=', trim($test_site_name))
                            ->get();
            if(count($testsiteData) > 0){
                $testSiteId = $testsiteData[0]->ts_id;
            }
            else
            {
                $testSiteId = DB::table('test_sites')->insertGetId(
                    [
                    'site_name' => trim($test_site_name),
                    'test_site_status' => 'active',
                    ]
                );
            }
            // Province
            $provinceData = DB::table('provinces')
                            ->where('province_name', '=', trim($province))
                            ->get();
            if(count($provinceData) > 0){
                $provinceId = $provinceData[0]->provincesss_id;
            }
            else
            {
                $provinceId = DB::table('provinces')->insertGetId(
                    [
                    'province_name' => trim($province),
                    'province_status' => 'active',
                    ]
                );
            }

            
            $monthyReportVal = DB::table('monthly_reports')
                            ->where('ts_id', '=', $testSiteId)
                            ->where('reporting_month', '=', $report_months)
                            ->where('book_no', '=', $book_no)
                            ->get();
            if(count($monthyReportVal) > 0){
                $mr_id = $monthyReportVal[0]->mr_id;
            }
            else
            {
                $mr_id = DB::table('monthly_reports')->insertGetId(
                    [
                        'provincesss_id' => $provinceId,
                        'site_unique_id' => $site_unique_id,
                        'ts_id' => $testSiteId,
                        'st_id' => $siteTypeId,
                        'site_manager' => $site_manager,
                        'is_flc' => $if_flc,
                        'is_recency' => $is_recency,
                        'contact_no' => $contact_no,
                        'algorithm_type' => $algo_type,
                        'date_of_data_collection' => $date_of_collection,
                        'reporting_month' => $report_months,
                        'book_no' => $book_no,
                        'name_of_data_collector' => $name_of_collector,
                        'source' => 'odk',
                        'added_on' => date('Y-m-d'),
                        'added_by' => session('userId')
                    ]
                );
            }
            if(count($array['HIV_TESTING_1']) > 1)
            {
                foreach($array['HIV_TESTING_1'] as $row)
                {
                    $page_no = $row['SECONDARY']['pageno'];
                    $start_date = date('Y-m-d', strtotime($row['SECONDARY']['startdate']));
                    $end_date = date('Y-m-d', strtotime($row['SECONDARY']['enddate']));
                    $final_positive = $row['SECONDARY']['TR_RECENT'];
                    $final_negative = $row['SECONDARY']['TNR_NEGATIVE'];
                    $final_indeterminate = $row['SECONDARY']['TINV_INCL'];
                    // Test Kit 1
                    $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_1']))
                                    ->get();
                        if(count($testkitData) > 0){
                            $testkitId1 = $testkitData[0]->tk_id;
                        }
                        else
                        {
                            $testkitId1 = DB::table('test_kits')->insertGetId(
                                [
                                'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_1']),
                                'test_kit_status' => 'active',
                                ]
                            );
                        }
                        $test_kit1 = $testkitId1;
                        $lot_no1 = $row['SECONDARY']['LOT_NO_1'];
                        $expiry_date1 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_1']));
                        $testkit1_reactive = $row['SECONDARY']['REACTIVE_1'];
                        $testkit1_nonreactive = $row['SECONDARY']['NON_REACTIVE_1'];
                        $testkit1_invalid = $row['SECONDARY']['INVALID_1'];
                        // Test Kit 2
                        $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_2']))
                                    ->get();
                        if(count($testkitData) > 0){
                            $testkitId2 = $testkitData[0]->tk_id;
                        }
                        else
                        {
                            $testkitId2 = DB::table('test_kits')->insertGetId(
                                [
                                'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_2']),
                                'test_kit_status' => 'active',
                                ]
                            );
                        }
                        $test_kit2 = $testkitId2;
                        $lot_no2 = $row['SECONDARY']['LOT_NO_2'];
                        $expiry_date2 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_2']));
                        $testkit2_reactive = $row['SECONDARY']['REACTIVE_2'];
                        $testkit2_nonreactive = $row['SECONDARY']['NON_REACTIVE_2'];
                        $testkit2_invalid = $row['SECONDARY']['INVALID_2'];
                        // Test Kit 3
                        $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_3']))
                                    ->get();
                        if(count($testkitData) > 0){
                            $testkitId3 = $testkitData[0]->tk_id;
                        }
                        else
                        {
                            $testkitId3 = DB::table('test_kits')->insertGetId(
                                [
                                'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_3']),
                                'test_kit_status' => 'active',
                                ]
                            );
                        }
                        $test_kit3 = $testkitId3;
                        $lot_no3 = $row['SECONDARY']['LOT_NO_3'];
                        $expiry_date3 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_3']));
                        $testkit3_reactive = $row['SECONDARY']['REACTIVE_3'];
                        $testkit3_nonreactive = $row['SECONDARY']['NON_REACTIVE_3'];
                        $testkit3_invalid = $row['SECONDARY']['INVALID_3'];
                        // Test Kit 4
                        $testkitData = DB::table('test_kits')
                                    ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_4']))
                                    ->get();
                        if(count($testkitData) > 0){
                            $testkitId4 = $testkitData[0]->tk_id;
                        }
                        else
                        {
                            $testkitId4 = DB::table('test_kits')->insertGetId(
                                [
                                'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_4']),
                                'test_kit_status' => 'active',
                                ]
                            );
                        }
                        $test_kit4 = $testkitId4;
                        $lot_no4 = $row['SECONDARY']['LOT_NO_4'];
                        $expiry_date4 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_4']));
                        $testkit4_reactive = $row['SECONDARY']['REACTIVE_4'];
                        $testkit4_nonreactive = $row['SECONDARY']['NON_REACTIVE_4'];
                        $testkit4_invalid = $row['SECONDARY']['INVALID_4'];
                    $duplicateCheck = DB::table('monthly_reports')
                                    ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
                                    ->where('ts_id', '=', $testSiteId)
                                    ->where('reporting_month', '=', $report_months)
                                    ->where('book_no', '=', $book_no)
                                    ->where('monthly_reports_pages.page_no', '=', $page_no)
                                    ->get();
                    if(count($duplicateCheck) == 0){
                        $insMonthlyArr = array(
                            'mr_id' => $mr_id,
                            'page_no' => $page_no,
                            'start_test_date' => $start_date,
                            'end_test_date' => $end_date,
                            'final_positive' => $final_positive,
                            'final_negative' => $final_negative,
                            'final_undetermined' => $final_indeterminate,
                            'test_1_kit_id' => $test_kit1,
                            'lot_no_1' => $lot_no1,
                            'expiry_date_1' => $expiry_date1,
                            'test_1_reactive' => $testkit1_reactive,
                            'test_1_nonreactive' => $testkit1_nonreactive,
                            'test_1_invalid' => $testkit1_invalid,
                            'test_2_kit_id' => $test_kit2,
                            'lot_no_2' => $lot_no2,
                            'expiry_date_2' => $expiry_date2,
                            'test_2_reactive' => $testkit2_reactive,
                            'test_2_nonreactive' => $testkit2_nonreactive,
                            'test_2_invalid' => $testkit2_invalid,
                            'test_3_kit_id' => $test_kit3,
                            'lot_no_3' => $lot_no3,
                            'expiry_date_3' => $expiry_date3,
                            'test_3_reactive' => $testkit3_reactive,
                            'test_3_nonreactive' => $testkit3_nonreactive,
                            'test_3_invalid' => $testkit3_invalid,
                            'test_4_kit_id' => $test_kit4,
                            'lot_no_4' => $lot_no4,
                            'expiry_date_4' => $expiry_date4,
                            'test_4_reactive' => $testkit4_reactive,
                            'test_4_nonreactive' => $testkit4_nonreactive,
                            'test_4_invalid' => $testkit4_invalid,
                        );
                        
                        $totalPositive = $final_positive;
                        $totalTested = (int)$testkit1_reactive + (int)$testkit1_nonreactive;
                        $positivePercentage = ((int)$totalTested == 0) ? 'N.A' : number_format((int)$totalPositive * 100 / (int)$totalTested, 2);
                        $posAgreement = 0;
                        $OverallAgreement = 0;
                        if ((int)$testkit1_reactive > 0)
                            $posAgreement = number_format(100 * ((int)$testkit2_reactive) / ((int)$testkit1_reactive), 2);
                        if(((int)$testkit1_reactive + (int)$testkit1_nonreactive) > 0)
                        $OverallAgreement = number_format(100 * ((int)$testkit2_reactive + (int)$testkit1_nonreactive) / ((int)$testkit1_reactive + (int)$testkit1_nonreactive), 2);
                        $insMonthlyArr['positive_percentage'] = $positivePercentage;
                        $insMonthlyArr['positive_agreement'] = $posAgreement;
                        $insMonthlyArr['overall_agreement'] = $OverallAgreement;
                        $monthly_reports_pages = DB::table('monthly_reports_pages')->insertGetId(
                            $insMonthlyArr
                        );
                        if($monthly_reports_pages > 0)
                        {
                            \Log::info("ODK Data Cron - Inserted Monthly Report Page for Page No - ".$page_no." and Book No - ".$book_no);
                        }
                        
                    }
                }
            }
            else
            {
                $row = $array['HIV_TESTING_1'];
                $page_no = $row['SECONDARY']['pageno'];
                $start_date = date('Y-m-d', strtotime($row['SECONDARY']['startdate']));
                $end_date = date('Y-m-d', strtotime($row['SECONDARY']['enddate']));
                $final_positive = $row['SECONDARY']['TR_RECENT'];
                $final_negative = $row['SECONDARY']['TNR_NEGATIVE'];
                $final_indeterminate = $row['SECONDARY']['TINV_INCL'];
                // Test Kit 1
                $testkitData = DB::table('test_kits')
                                ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_1']))
                                ->get();
                    if(count($testkitData) > 0){
                        $testkitId1 = $testkitData[0]->tk_id;
                    }
                    else
                    {
                        $testkitId1 = DB::table('test_kits')->insertGetId(
                            [
                            'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_1']),
                            'test_kit_status' => 'active',
                            ]
                        );
                    }
                    $test_kit1 = $testkitId1;
                    $lot_no1 = $row['SECONDARY']['LOT_NO_1'];
                    $expiry_date1 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_1']));
                    $testkit1_reactive = $row['SECONDARY']['REACTIVE_1'];
                    $testkit1_nonreactive = $row['SECONDARY']['NON_REACTIVE_1'];
                    $testkit1_invalid = $row['SECONDARY']['INVALID_1'];
                    // Test Kit 2
                    $testkitData = DB::table('test_kits')
                                ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_2']))
                                ->get();
                    if(count($testkitData) > 0){
                        $testkitId2 = $testkitData[0]->tk_id;
                    }
                    else
                    {
                        $testkitId2 = DB::table('test_kits')->insertGetId(
                            [
                            'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_2']),
                            'test_kit_status' => 'active',
                            ]
                        );
                    }
                    $test_kit2 = $testkitId2;
                    $lot_no2 = $row['SECONDARY']['LOT_NO_2'];
                    $expiry_date2 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_2']));
                    $testkit2_reactive = $row['SECONDARY']['REACTIVE_2'];
                    $testkit2_nonreactive = $row['SECONDARY']['NON_REACTIVE_2'];
                    $testkit2_invalid = $row['SECONDARY']['INVALID_2'];
                    // Test Kit 3
                    $testkitData = DB::table('test_kits')
                                ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_3']))
                                ->get();
                    if(count($testkitData) > 0){
                        $testkitId3 = $testkitData[0]->tk_id;
                    }
                    else
                    {
                        $testkitId3 = DB::table('test_kits')->insertGetId(
                            [
                            'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_3']),
                            'test_kit_status' => 'active',
                            ]
                        );
                    }
                    $test_kit3 = $testkitId3;
                    $lot_no3 = $row['SECONDARY']['LOT_NO_3'];
                    $expiry_date3 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_3']));
                    $testkit3_reactive = $row['SECONDARY']['REACTIVE_3'];
                    $testkit3_nonreactive = $row['SECONDARY']['NON_REACTIVE_3'];
                    $testkit3_invalid = $row['SECONDARY']['INVALID_3'];
                    // Test Kit 4
                    $testkitData = DB::table('test_kits')
                                ->where('test_kit_name', '=', trim($row['SECONDARY']['TESTING_KIT_TEST_4']))
                                ->get();
                    if(count($testkitData) > 0){
                        $testkitId4 = $testkitData[0]->tk_id;
                    }
                    else
                    {
                        $testkitId4 = DB::table('test_kits')->insertGetId(
                            [
                            'test_kit_name' => trim($row['SECONDARY']['TESTING_KIT_TEST_4']),
                            'test_kit_status' => 'active',
                            ]
                        );
                    }
                    $test_kit4 = $testkitId4;
                    $lot_no4 = $row['SECONDARY']['LOT_NO_4'];
                    $expiry_date4 = date('Y-m-d', strtotime($row['SECONDARY']['EXPIRY_DATE_4']));
                    $testkit4_reactive = $row['SECONDARY']['REACTIVE_4'];
                    $testkit4_nonreactive = $row['SECONDARY']['NON_REACTIVE_4'];
                    $testkit4_invalid = $row['SECONDARY']['INVALID_4'];
                $duplicateCheck = DB::table('monthly_reports')
                                ->join('monthly_reports_pages', 'monthly_reports_pages.mr_id', '=', 'monthly_reports.mr_id')
                                ->where('ts_id', '=', $testSiteId)
                                ->where('reporting_month', '=', $report_months)
                                ->where('book_no', '=', $book_no)
                                ->where('monthly_reports_pages.page_no', '=', $page_no)
                                ->get();
                if(count($duplicateCheck) == 0){
                    $insMonthlyArr = array(
                        'mr_id' => $mr_id,
                        'page_no' => $page_no,
                        'start_test_date' => $start_date,
                        'end_test_date' => $end_date,
                        'final_positive' => $final_positive,
                        'final_negative' => $final_negative,
                        'final_undetermined' => $final_indeterminate,
                        'test_1_kit_id' => $test_kit1,
                        'lot_no_1' => $lot_no1,
                        'expiry_date_1' => $expiry_date1,
                        'test_1_reactive' => $testkit1_reactive,
                        'test_1_nonreactive' => $testkit1_nonreactive,
                        'test_1_invalid' => $testkit1_invalid,
                        'test_2_kit_id' => $test_kit2,
                        'lot_no_2' => $lot_no2,
                        'expiry_date_2' => $expiry_date2,
                        'test_2_reactive' => $testkit2_reactive,
                        'test_2_nonreactive' => $testkit2_nonreactive,
                        'test_2_invalid' => $testkit2_invalid,
                        'test_3_kit_id' => $test_kit3,
                        'lot_no_3' => $lot_no3,
                        'expiry_date_3' => $expiry_date3,
                        'test_3_reactive' => $testkit3_reactive,
                        'test_3_nonreactive' => $testkit3_nonreactive,
                        'test_3_invalid' => $testkit3_invalid,
                        'test_4_kit_id' => $test_kit4,
                        'lot_no_4' => $lot_no4,
                        'expiry_date_4' => $expiry_date4,
                        'test_4_reactive' => $testkit4_reactive,
                        'test_4_nonreactive' => $testkit4_nonreactive,
                        'test_4_invalid' => $testkit4_invalid,
                    );
                    
                    $totalPositive = $final_positive;
                    $totalTested = (int)$testkit1_reactive + (int)$testkit1_nonreactive;
                    $positivePercentage = ((int)$totalTested == 0) ? 'N.A' : number_format((int)$totalPositive * 100 / (int)$totalTested, 2);
                    $posAgreement = 0;
                    $OverallAgreement = 0;
                    if ((int)$testkit1_reactive > 0)
                        $posAgreement = number_format(100 * ((int)$testkit2_reactive) / ((int)$testkit1_reactive), 2);
                    if(((int)$testkit1_reactive + (int)$testkit1_nonreactive) > 0)
                    $OverallAgreement = number_format(100 * ((int)$testkit2_reactive + (int)$testkit1_nonreactive) / ((int)$testkit1_reactive + (int)$testkit1_nonreactive), 2);
                    $insMonthlyArr['positive_percentage'] = $positivePercentage;
                    $insMonthlyArr['positive_agreement'] = $posAgreement;
                    $insMonthlyArr['overall_agreement'] = $OverallAgreement;
                    $monthly_reports_pages = DB::table('monthly_reports_pages')->insertGetId(
                        $insMonthlyArr
                    );
                    if($monthly_reports_pages > 0)
                    {
                        \Log::info("ODK Data Cron - Inserted Monthly Report Page for Page No - ".$page_no." and Book No - ".$book_no);
                    }
                    
                }
            }
        }
        // DB::beginTransaction();
        //         \Log::info("Test cron");
        // DB::commit();
        
    }
}
