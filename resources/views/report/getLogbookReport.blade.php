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

$col = ['yellow', '#b5d477', '#d08662', '#76cece', '#ea7786'];

?>
<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
    <table class="table table-bordered " id="trendTable" style="width:100%;">
        <thead>

            <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class="th" style="width:10%;">Facility</th>
                <th class="th" style="width:10%;">Site</th>
                <th class="th" style="width:10%;">Algorithm</th>
                <th class="th" style="width:10%;">Start Date</th>
                <th class="th" style="width:10%;">End Date</th>
                <th class="th" style="width:10%;">Total Tests</th>
                @for($i = 1; $i <= $arr['no_of_test']; $i++) <th colspan="4" class="th" style="width:10%; text-align: center" bgcolor="{{$col[$i]}}">Test {{$i}}</th>
                    @endfor
                    <th class="th" style="width:10%;">% Pos</th>
                    <th class="th" style="width:10%;">Positive Agr</th>
                    <th class="th" style="width:10%;">OverAll Agr</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                @for($j = 1; $j <= $arr['no_of_test']; $j++) <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">R</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">NR</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">INV</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">Total</th>
                    @endfor
                    <th></th>
                    <th></th>
                    <th></th>
            </tr>
        </thead>
        <tbody>
            @if(count($report)>0)
            @foreach ($report as $trendrow)
            <?php
            $startDate = $trendrow->start_test_date;
            $endDate = $trendrow->end_test_date;
            $start_test_date = date('d-M-Y', strtotime($startDate));
            $end_test_date = date('d-M-Y', strtotime($endDate));
            $totalPositive = $trendrow->final_positive;
            $total = $trendrow->total_test;
            $positivePercentage = ($total == 0) ? 'N.A' : number_format($totalPositive * 100 / $total);
            if (($trendrow->test_1_reactive && $trendrow->test_2_reactive && $trendrow->test_1_reactive && $trendrow->test_1_nonreactive) > 0) {
                $posAgreement = number_format(100 * ($trendrow->test_2_reactive) / ($trendrow->test_1_reactive), 2);
                $OverallAgreement = number_format(100 * ($trendrow->test_2_reactive + $trendrow->test_1_nonreactive) / ($trendrow->test_1_reactive + $trendrow->test_1_nonreactive), 2);
            } // dd($posAgreement);die;
            ?>
            <tr style="text-align: right">
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->facility_name}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->site_name}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->algorithm_type}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$start_test_date}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$end_test_date}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->total_test}}</td>
                @for($l = 1; $l <= $arr['no_of_test']; $l++) <?php $reactive = 'test_' . $l . '_reactive';
                                                                $nonreactive = 'test_' . $l . '_nonreactive';
                                                                $invalid = 'test_' . $l . '_invalid';   ?> <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$reactive}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$nonreactive}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$invalid}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$reactive+$trendrow->$nonreactive+$trendrow->$invalid}}</td>
                    @endfor
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$positivePercentage}}</td>
                    @if (($trendrow->test_1_reactive && $trendrow->test_2_reactive && $trendrow->test_1_reactive && $trendrow->test_1_nonreactive) > 0)
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$posAgreement}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;"><a href="/report/overallagreement/{{ base64_encode($trendrow->mr_id)}}" name="overall_agreement" id="'.$data->mr_id.'" class="" title="Overall Agreement">{{$OverallAgreement}}</a></td>
                    @else
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;"></td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;"><a href="" name="overall_agreement" class="" title="Overall Agreement"></a></td>
                    @endif

            </tr>
            @endforeach

            @else
            <tr>
                <td class="frezz" style="text-align:center;width:94.6%;" colspan="18">No Data Available</td>
            </tr>
            @endif

        </tbody>
    </table>
</div>