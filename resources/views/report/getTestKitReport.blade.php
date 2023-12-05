<style>
    .my-custom-scrollbar {
        position: relative;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    .tableFixHead {
        overflow-y: auto;
        max-height: 500px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 99;
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
?>

<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
    <table class="table table-bordered " id="testKitTable" style="width:100%;">
        <thead>

            <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class="th" style="width:10%;">Site</th>
                <th class="th" style="width:10%;">Algorithm</th>
                <th class="th" style="width:10%;">Testing Period</th>
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
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->site_name}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->algorithm_type}}</td>
                <td class="td" style=" width: 10%; text-align: left">{{$testingDate}}</td>
                @for($l = 1; $l <= $arr['no_of_test']; $l++) 
                <?php $test_kit_used = 'test_' . $l . '_kit_used';   ?>
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