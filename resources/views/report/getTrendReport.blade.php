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
    table{
        border-collapse:separate;
        border-spacing:0;
    }
    .tableFixHead thead {
        position: sticky;
        top: 0;
        z-index: 150;
        background-color:#e4eff8!important;
    }
    .tableFixHead thead th:first-child {
        position: sticky;
        left:0;
        background-color:#e4eff8;
        z-index: 150;
    }
    .tableFixHead thead th:nth-child(2){
        position: sticky;
        left:100px;
        background-color:#e4eff8;
        z-index: 150;
    }
    .tableFixHead thead th:nth-child(3){
        position: sticky;
        left:180px;
        background-color:#e4eff8;
        z-index: 150;
    }
    .tableFixHead tbody td:first-child {
        position: sticky;
        top: 0;
        left:0;
        z-index: 100;      
        background-color:#fff;
    }
    .tableFixHead tbody td:nth-child(2){
        position: sticky;
        left:100px;
        background-color:#fff;
    }
    .tableFixHead tbody td:nth-child(3){
        position: sticky;
        left:180px;
        background-color:#fff;
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
<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead tableLeftRight">
    <table class="table table-bordered " id="trendTable" style="width:100%;">
        <thead>

            <tr class="frezz" style="top: 37px; width:94.6%;">
                
                <th class="th" style="width:100px;">Site</th>
                <th class="th" style="max-width:100px;">Algorithm</th>
                <th class="th" style="max-width:120px;">Testing Period</th>
                <th class="th" style="width:5%;">Total Tests</th>
                @for($i = 1; $i <= $arr['no_of_test']; $i++) 
                    <th colspan="4" class="th" style="width:10%; text-align: center" bgcolor="{{$col[$i]}}">Test {{$i}}</th>
                    @endfor
                    <th colspan="3" class="th" style="width:10%; text-align: center">Final Result</th>
                    <th class="th" style="width:10%;">% Pos</th>
                    <th class="th" style="width:10%;">Positive Agr <br/> (Test 1 & 2)</th>
                    <th class="th" style="width:10%;">OverAll Agr <br/> (Test 1 & 2)</th>
                    @if($arr['no_of_test']==3)
                    <th class="th" style="width:10%;">Positive Agr <br/> (Test 2 & 3)</th>
                    <th class="th" style="width:10%;">OverAll Agr <br/> (Test 2 & 3)</th>
                    @endif
            </tr>
            <tr>
                <th></th>
                
                <th></th>
                <th></th>
                <th></th>
                @for($j = 1; $j <= $arr['no_of_test']; $j++) <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">R</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">NR</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">INV</th>
                    <th class="th" style="width:5%;" bgcolor="{{$col[$j]}}">Total</th>
                    @endfor
                    <th class="th" style="width:5%;">Positive</th>
                    <th class="th" style="width:5%;">Negative</th>
                    <th class="th" style="width:5%;">Indeterminate</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    @if($arr['no_of_test']==3)
                    <th></th>
                    <th></th>
                    @endif
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

            $totalPositive = $trendrow->final;
            $total = $trendrow->test_1_reactive + $trendrow->test_1_nonreactive;
            $positivePercentage = ($total == 0) ? 'N.A' : number_format($totalPositive * 100 / $total);
            if (($trendrow->test_1_reactive && $trendrow->test_2_reactive && $trendrow->test_1_reactive && $trendrow->test_1_nonreactive) > 0) {
                $posAgreement = number_format(100 * ($trendrow->test_2_reactive) / ($trendrow->test_1_reactive), 2);
                $OverallAgreement = number_format(100 * ($trendrow->test_2_reactive + $trendrow->test_1_nonreactive) / ($trendrow->test_1_reactive + $trendrow->test_1_nonreactive), 2);
            }
            $posAgreementTest2_3="";
            $OverallAgreement2_3="";
            if (($trendrow->test_2_reactive && $trendrow->test_3_reactive && $trendrow->test_2_reactive && $trendrow->test_2_nonreactive) > 0) {
                $posAgreementTest2_3 = number_format(100 * ($trendrow->test_3_reactive) / ($trendrow->test_2_reactive), 2);
                $OverallAgreement2_3 = number_format(100 * ($trendrow->test_3_reactive + $trendrow->test_2_nonreactive) / ($trendrow->test_2_reactive + $trendrow->test_2_nonreactive), 2);
            }
            // dd($trendrow->end_test_date);die;
            // $testingMonth= date('F - Y', strtotime($date)); //June, 2017
            ?>
            <tr style="text-align: right">
                <td class="td" style=" max-width:100px; text-align: left; color: black;font-weight: 500;"><a onclick="logData('{{$trendrow->ts_id}}')" href="javascript:void(0);" name="data" class="" title="Site Name">{{$trendrow->site_name}}</a></td>
                <td class="td" style=" max-width:100px; text-align: left; color: black;font-weight: 500;">{{ ucwords($trendrow->algorithm_type) }}</td>
                <td class="td" style=" max-width: 120px; text-align: left">{{$testingDate}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$total}}</td>
                @for($l = 1; $l <= $arr['no_of_test']; $l++) <?php $reactive = 'test_' . $l . '_reactive'; 
                                                                $nonreactive = 'test_' . $l . '_nonreactive';
                                                                $invalid = 'test_' . $l . '_invalid';   ?> <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$reactive}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$nonreactive}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$invalid}}</td>
                    <td class="td" bgcolor="{{$col[$l]}}" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$reactive+$trendrow->$nonreactive+$trendrow->$invalid}}</td>
                    @endfor
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->final}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->final_negative}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->final_undetermined}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$positivePercentage}}</td>
                    @if(($trendrow->test_1_reactive && $trendrow->test_2_reactive && $trendrow->test_1_reactive && $trendrow->test_1_nonreactive) > 0)
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$posAgreement}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$OverallAgreement}}</td>
                    @else
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;"></td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;"></td>
                    @endif
                    @if($arr['no_of_test']==3)
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$posAgreementTest2_3}}</td>
                    <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$OverallAgreement2_3}}</td>
                    @endif
            </tr>
            @endforeach

            @else
            <tr>
                <td class="frezz" style="text-align:center;width:94.6%;" colspan="19">No Data Available</td>
            </tr>
            @endif

        </tbody>



    </table>
</div>
