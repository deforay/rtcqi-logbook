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
            <td colspan="12" style="border: 3px solid black;font-weight:bold;">LogBook Report</td>
            @elseif($arr['no_of_test'] == 2)
            <td colspan="15" style="border: 3px solid black;font-weight:bold;">LogBook Report</td>
            @elseif($arr['no_of_test'] == 3)
            <td colspan="18" style="border: 3px solid black;font-weight:bold;">LogBook Report</td>
            @else
            <td colspan="21" style="border: 3px solid black;font-weight:bold;">LogBook Report</td>
            @endif
        </tr>
        <tr style="border: 3px solid black">
            <th style="border: 3px solid black;font-weight:bold;">Facility</th>
            <th style="border: 3px solid black;font-weight:bold;">Site</th>
            <th style="border: 3px solid black;font-weight:bold;">Algothrim</th>
            <th style="border: 3px solid black;font-weight:bold;">Start Date</th>
            <th style="border: 3px solid black;font-weight:bold;">End Date</th>
            <th style="border: 3px solid black;font-weight:bold;">Total Tests</th>
            @for($i = 1; $i <= $globalValue; $i++) <th colspan="3" style="border: 3px solid black;font-weight:bold;text-align: center;">Test {{$i}}</th>
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
            <th></th>
            @for($j = 1; $j <= $globalValue; $j++) <th style="border: 3px solid black;font-weight:bold;width:4px;">R</th>
                <th style="border: 3px solid black;font-weight:bold;width:4px;">NR</th>
                <th style="border: 3px solid black;font-weight:bold;width:4px;">INV</th>
                @endfor
                <th style="border: 3px solid black;"></th>
                <th style="border: 3px solid black;"></th>
                <th style="border: 3px solid black;"></th>
        </tr>
    </thead>
    <tbody style="border: 3px solid black">
        @foreach($report as $logbookdata)
        <?php
        $totalPositive = $logbookdata->final_positive;
        $total = $logbookdata->total_test;
        $positivePercentage = ($total == 0) ? 'N.A' : number_format($totalPositive * 100 / $total);
        $posAgreement = number_format(100 * ($logbookdata->test_2_reactive) / ($logbookdata->test_1_reactive), 2);
        $OverallAgreement = number_format(100 * ($logbookdata->test_2_reactive + $logbookdata->test_1_nonreactive) / ($logbookdata->test_1_reactive + $logbookdata->test_1_nonreactive), 2);
        ?>
        <tr style="border: 3px solid black">
            <td style="border: 3px solid black">{{ $logbookdata->facility_name }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->site_name }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->algorithm_type }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->start_test_date }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->end_test_date }}</td>
            <td style="border: 3px solid black;;text-align: left;">{{ $logbookdata->test_1_reactive + $logbookdata->test_1_nonreactive }}</td>
            @for($l = 1; $l <= $globalValue; $l++) <?php $reactive = 'test_' . $l . '_reactive';
                                                    $nonreactive = 'test_' . $l . '_nonreactive';
                                                    $invalid = 'test_' . $l . '_invalid';   ?> <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->$reactive }}</td>
                <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->$nonreactive }}</td>
                <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->$invalid }}</td>
                @endfor
                <td style="border: 3px solid black;text-align: left;">{{ $positivePercentage }}</td>
                <td style="border: 3px solid black;text-align: left;">{{ $posAgreement }}</td>
                <td style="border: 3px solid black;text-align: left;">{{ $OverallAgreement }}</td>
        </tr>
        @endforeach
    </tbody>
</table>