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
    <table class="table table-bordered " id="customTable" style="width:100%;">
        <thead>

            <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class="th" style="width:10%;">Facility</th>
                <th class="th" style="width:10%;">Site</th>
                <th class="th" style="width:10%;">Algo</th>
                <th class="th" style="width:10%;">Testing Month</th>
                <th class="th" style="width:5%;">Total Testing</th>
                @for($i = 1; $i <= $arr['no_of_test']; $i++) <th colspan="3" class="th" style="width:10%; text-align: center" bgcolor="{{$col[$i]}}">Test {{$i}}</th>
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
                @for($j = 1; $j <= $arr['no_of_test']; $j++) <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">R</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">NR</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">INV</th>
                    @endfor
                    <th></th>
                    <th></th>
                    <th></th>
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
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->facility_name}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;"><a onclick="logData('{{$trendrow->ts_id}}')" href="javascript:void(0);" name="data" class="" title="Site Name">{{$trendrow->site_name}}</a></td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->algorithm_type}}</td>
                <td class="td" style=" width: 10%; text-align: left">{{$testingDate}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->test_1_reactive + $trendrow->test_1_nonreactive}}</td>
                @for($l = 1; $l <= $arr['no_of_test']; $l++) <?php $reactive = 'test_' . $l . '_reactive';
                                                                $nonreactive = 'test_' . $l . '_nonreactive';
                                                                $invalid = 'test_' . $l . '_invalid';   ?> <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$reactive}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$nonreactive}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$invalid}}</td>
                    @endfor
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->positive_percentage}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->positive_agreement}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->overall_agreement}}</td>
            </tr>
            @endforeach

            @else
            <tr>
                <td class="frezz" style="text-align:center;width:94.6%;" colspan="17">No Data Available</td>
            </tr>
            @endif

        </tbody>



    </table>
</div>