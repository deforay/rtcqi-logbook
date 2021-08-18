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
        <td colspan="6" style="border: 3px solid black;font-weight:bold;">Test Kit Use Report</td>
        @elseif($arr['no_of_test'] == 2)
        <td colspan="7" style="border: 3px solid black;font-weight:bold;">Test Kit Use Report</td>
        @elseif($arr['no_of_test'] == 3)
        <td colspan="8" style="border: 3px solid black;font-weight:bold;">Test Kit Use Report</td>
        @else
        <td colspan="9" style="border: 3px solid black;font-weight:bold;">Test Kit Use Report</td>
        @endif
      </tr>
    <tr style="border: 3px solid black">
        <th style="border: 3px solid black;font-weight:bold;">Facility</th>
        <th style="border: 3px solid black;font-weight:bold;">Site</th>
        <th style="border: 3px solid black;font-weight:bold;">Algothrim</th>
        <th style="border: 3px solid black;font-weight:bold;">Testing Month</th>
        @for($i = 1; $i <= $arr['no_of_test']; $i++)
                <th style="border: 3px solid black;font-weight:bold;">Test {{$i}} Used</th>
                @endfor
        <th style="border: 3px solid black;font-weight:bold;">Invalid Result</th>
    </tr>
    </thead>
    <tbody style="border: 3px solid black">
    @foreach($report['res'] as $testkit)
    <?php
        if($report['reportFrequency']=='quaterly'){
            $quarterlyData = $testkit->quarterly;
            $year = $testkit->quaYear;
            $testingDate = $quarterlyData. '-' . $year;
        }
        else if($report['reportFrequency']=='monthly'){
            $testingDate = $testkit->month;
        }else{
            $testingDate = $testkit->year;
        }
?>
        <tr style="border: 3px solid black">
            <td style="border: 3px solid black">{{ $testkit->facility_name }}</td>
            <td style="border: 3px solid black">{{ $testkit->site_name }}</td>
            <td style="border: 3px solid black">{{ $testkit->algorithm_type }}</td>
            <td style="border: 3px solid black">{{ $testingDate }}</td>
            @for($l = 1; $l <= $arr['no_of_test']; $l++) 
                <?php $test_kit_used = 'test_' . $l . '_kit_used';   ?>
                <td style="border: 3px solid black;text-align: left;">{{$testkit->$test_kit_used}}</td>
                @endfor
            <td style="border: 3px solid black;text-align: left;">{{ $testkit->total_invalid }}</td>
        </tr>
    @endforeach
    </tbody>
</table>