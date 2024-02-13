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
        <td colspan="3" style="border: 3px solid black;font-weight:bold;">Test Kit Summary Report</td>
        @elseif($arr['no_of_test'] == 2)
        <td colspan="4" style="border: 3px solid black;font-weight:bold;">Test Kit Summary Report</td>
        @elseif($arr['no_of_test'] == 3)
        <td colspan="5" style="border: 3px solid black;font-weight:bold;">Test Kit Summary Report</td>
        @else
        <td colspan="6" style="border: 3px solid black;font-weight:bold;">Test Kit Summary Report</td>
        @endif
      </tr>
    <tr style="border: 3px solid black">
        <th style="border: 3px solid black;font-weight:bold;">Test Kit Name</th>
        <th style="border: 3px solid black;font-weight:bold;">Total No. of times used</th>
        @for($i = 1; $i <= $arr['no_of_test']; $i++)
            <?php $test_title = 'No. of times used for Test ' . $i; ?>
            <th style="border: 3px solid black;font-weight:bold;">{{$test_title}}</th>
        @endfor
        
    </tr>
    </thead>
    <tbody style="border: 3px solid black">
    @foreach($report as $testKitSummary)
    
        @if($testKitSummary['test_kit_total'] > 0)
        <tr style="border: 3px solid black">
            <td style="border: 3px solid black">{{$testKitSummary['test_kit_name']}}</td>
            <td style="border: 3px solid black">{{$testKitSummary['test_kit_total']}}</td>
            @for($l = 1; $l <= $arr['no_of_test']; $l++) 
            <td style="border: 3px solid black;text-align: left;">{{$testKitSummary['test_kit_' . $l . '_total']}}</td>
            @endfor
    
    </tr>
    @endif
    @endforeach
    </tbody>
</table>