<style>
    .my-custom-scrollbar {
        position: relative;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    .tableFixHead, .tableFixHeadTwo {
        overflow-y: auto;
        max-height: 500px;
    }
    table{
        border-collapse:separate;
        border-spacing:0;
    }
    .tableFixHead thead, .tableFixHeadTwo thead {
        position: sticky;
        top: 0;
        z-index: 150;
        background-color:#e4eff8!important;
    }

    .tableFixHead thead th:first-child, .tableFixHeadTwo thead th:first-child {
        position: sticky;
        left:0;
        background-color:#e4eff8;
        z-index: 150;
        border-spacing:0;
        border-collapse:separate;
    }
    .tableFixHead thead th:nth-child(2),.tableFixHeadTwo thead th:nth-child(2){
        position: sticky;
        left:100px;
        background-color:#e4eff8;
        z-index: 150;
        border-spacing:0;
        border-collapse:separate;
    }

    .tableFixHead thead th:nth-child(3){
        position: sticky;
        left:180px;
        background-color:#e4eff8;
        z-index: 150;
        border-spacing:0;
        border-collapse:separate;
    }
    
    .tableFixHead tbody td:first-child, .tableFixHeadTwo tbody td:first-child {
        position: sticky;
        top: 0;
        left:0;
        z-index: 100;      
        background-color:#f4f5fa;
        border-spacing:0;
        border-collapse:separate;
    }
    .tableFixHead tbody td:nth-child(2), .tableFixHeadTwo tbody td:nth-child(2){
        position: sticky;
        left:100px;
        background-color:#f4f5fa;
        border-spacing:0;
        border-collapse:separate;
    }
    .tableFixHeadTwo thead th:nth-child(2), .tableFixHeadTwo tbody td:nth-child(2){
        left: 110px !important;;
    }
    .tableFixHead tbody td:nth-child(3){
        position: sticky;
        left:180px;
        background-color:#f4f5fa;
        border-spacing:0;
        border-collapse:separate;
    }

    #table-bordered {
        border-collapse: collapse;
        width: 100%;
    }

    #th,
    #td {
        padding: 8px 16px;
    }

    #th {
        background: #eee;
    }
</style>
<?php

use App\Service\GlobalConfigService;

$GlobalConfigService = new GlobalConfigService();
$glob = $GlobalConfigService->getAllGlobalConfig();
$arr = array();
// now we create an associative array so that we can easily create view variables
for ($i = 0; $i < sizeof($glob); $i++) {
    $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
}
// for($i = 1; $i <= $arr['no_of_test']; $i++){
//     echo ${"testkit" . $i} = 0;
// }
?>

<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
    <table class="table table-bordered " id="testKitTable" style="width:100%;">
        <thead>

            <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class="th" style="max-width:100px;">Site</th>
                <th class="th" style="max-width:100px;">Algorithm</th>
                <th class="th" style="max-width:120px;">Testing Period</th>
                @for($i = 1; $i <= $arr['no_of_test']; $i++)
                <th class="th" style="width:5%;">Test {{$i}} Used</th>
                @endfor
                <th class="th" style="width:5%;">Invalid Result</th>

            </tr>
        </thead>
        <tbody>
            
            @if(count($report['res'])>0)
            @foreach ($report['res'] as $trendrow)
            <?php
            if ($report['reportFrequency'] == 'quaterly') {
                $quarterlyData = $trendrow->quarterly;
                $year = $trendrow->quaYear;
                $testingDate = $quarterlyData . '-' . $year;
            } else if ($report['reportFrequency'] == 'monthly') {
                $testingDate = $trendrow->month;
            } else {
                $testingDate = $trendrow->year;
            }
            // dd($trendrow->end_test_date);die;
            // $testingMonth= date('F - Y', strtotime($date)); //June, 2017
            ?>
            <tr style="text-align: right">
                <td class="td" style="max-width:100px; text-align: left; color: black;font-weight: 500;">{{$trendrow->site_name}}</td>
                <td class="td" style="max-width:100px; text-align: left; color: black;font-weight: 500;">{{ ucwords($trendrow->algorithm_type) }}</td>
                <td class="td" style="max-width:120px; text-align: left">{{$testingDate}}</td>
                @for($l = 1; $l <= $arr['no_of_test']; $l++) 
                <?php $test_kit_used = 'test_' . $l . '_kit_used'; ?>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$test_kit_used}}</td>
                @endfor
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->total_invalid}}</td>
            </tr>
            @endforeach

            @else
            <tr>
                <td class="frezz" style="text-align:center;width:94.6%;" colspan="16">No Data Available</td>
            </tr>
            @endif

        </tbody>        
    </table>
    
</div>
<h3 class="content-header-title mb-0 mt-5">Test Kit Summary Report</h3>
<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHeadTwo">

<table class="table table-bordered mt-3">
        <thead>
            <tr>
            <th class="th" style="max-width:110px;">Test Kit Name</th>
            <th class="th" style="max-width:170px;">Total No. of times used </th>
            @for($l = 1; $l <= $arr['no_of_test']; $l++) 
                <?php $test_title = 'No. of times used for Test ' . $l; ?>
                <th class="th">{{$test_title}}</th>
                @endfor
        </tr>
        </thead>
        <tbody>
        @if(count($report['summary'])>0)
            @foreach ($report['summary'] as $testKitSummary)
            @if($testKitSummary['test_kit_total'] > 0)
            <tr class="frezz">
                <td class="td" style="max-width:110px">{{$testKitSummary['test_kit_name']}}</td>
                <td class="td" style="max-width:170px">{{$testKitSummary['test_kit_total']}}</td>
                @for($l = 1; $l <= $arr['no_of_test']; $l++) 
                <?php $test_kit_value='test_kit_'.$l.'_total'; ?>
                <td class="td">{{$testKitSummary[$test_kit_value]}}</td>
                @endfor
            </tr>
            @endif
            @endforeach
            @else
            <tr>
                <td colspan="2">No Data Available</td>
            </tr>
            @endif
        </tbody>
    </table>
        </div>