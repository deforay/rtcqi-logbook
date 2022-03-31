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
<table style="border: 3px solid black">
    <thead style="border: 3px solid black">
    <tr>
        @if($arr['no_of_test'] == 1)
        <td colspan="11" style="border: 3px solid black;font-weight:bold;">Trend Report</td>
        @elseif($arr['no_of_test'] == 2)
        <td colspan="14" style="border: 3px solid black;font-weight:bold;">Trend Report</td>
        @elseif($arr['no_of_test'] == 3)
        <td colspan="17" style="border: 3px solid black;font-weight:bold;">Trend Report</td>
        @else
        <td colspan="20" style="border: 3px solid black;font-weight:bold;">Trend Report</td>
        @endif
      </tr>
    <tr style="border: 3px solid black">
        <th style="border: 3px solid black;font-weight:bold;">Facility</th>
        <th style="border: 3px solid black;font-weight:bold;">Site</th>
        <th style="border: 3px solid black;font-weight:bold;">Algothrim</th>
        <th style="border: 3px solid black;font-weight:bold;">Testing Month</th>
        <th style="border: 3px solid black;font-weight:bold;">Total Testing</th>
        @for($i = 1; $i <= $globalValue; $i++)
        <th colspan="3" style="border: 3px solid black;font-weight:bold;text-align: center;">Test {{$i}}</th>
        @endfor
        <th style="border: 3px solid black;font-weight:bold;">% Pos</th>
        <th style="border: 3px solid black;font-weight:bold;">Positive Agr</th>
        <th style="border: 3px solid black;font-weight:bold;">OverAll Agr</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        @for($j = 1; $j <= $globalValue; $j++)
        <th style="border: 3px solid black;font-weight:bold;width:4px;">R</th>
        <th style="border: 3px solid black;font-weight:bold;width:4px;">NR</th>
        <th style="border: 3px solid black;font-weight:bold;width:4px;">INV</th>
        @endfor
        <th style="border: 3px solid black;"></th>
        <th style="border: 3px solid black;"></th>
        <th style="border: 3px solid black;"></th>
    </tr>
    </thead>
    <tbody style="border: 3px solid black">
    @foreach($report['res'] as $trendrow)
    <?php
        if($report['reportFrequency']=='quaterly'){
            $quarterlyData = $trendrow->quarterly;
            $year = $trendrow->quaYear;
            $testingDate = $quarterlyData. '-' . $year;
        }
        else if($report['reportFrequency']=='monthly'){
            $testingDate = $trendrow->month;
        }else{
            $testingDate = $trendrow->year;
        }
        $totalPositive = $trendrow->final;
            $total = $trendrow->test_1_reactive + $trendrow->test_1_nonreactive;
            $positivePercentage = ($total == 0) ? 'N.A' : number_format($totalPositive * 100 / $total);
            if ($trendrow->test_2_reactive > 0) {
                $posAgreement = number_format(100 * ($trendrow->test_2_reactive) / ($trendrow->test_1_reactive), 2);
                $OverallAgreement = number_format(100 * ($trendrow->test_2_reactive + $trendrow->test_1_nonreactive) / ($trendrow->test_1_reactive + $trendrow->test_1_nonreactive), 2);
            }
?>
        <tr style="border: 3px solid black">
            <td style="border: 3px solid black">{{ $trendrow->facility_name }}</td>
            <td style="border: 3px solid black">{{ $trendrow->site_name }}</td>
            <td style="border: 3px solid black">{{ $trendrow->algorithm_type }}</td>
            <td style="border: 3px solid black">{{ $testingDate }}</td>
            <td style="border: 3px solid black;;text-align: left;">{{ $total }}</td>
            @for($l = 1; $l <= $globalValue; $l++)
            <?php $reactive = 'test_'.$l.'_reactive'; $nonreactive = 'test_'.$l.'_nonreactive'; $invalid = 'test_'.$l.'_invalid';   ?>
            <td style="border: 3px solid black;text-align: left;">{{ $trendrow->$reactive }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $trendrow->$nonreactive }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $trendrow->$invalid }}</td>
            @endfor
            <td style="border: 3px solid black;text-align: left;">{{ $positivePercentage }}</td>
            @if ($trendrow->test_2_reactive > 0)
            <td style="border: 3px solid black;text-align: left;">{{ $posAgreement }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $OverallAgreement }}</td>
            @else
            <td style="border: 3px solid black;text-align: left;"></td>
            <td style="border: 3px solid black;text-align: left;"></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>