
<table style="border: 3px solid black">
    <thead style="border: 3px solid black">
    <tr>
        <td colspan="8" style="border: 3px solid black;font-weight:bold;">Test Kit Use Report</td>
      </tr>
    <tr style="border: 3px solid black">
        <th style="border: 3px solid black;font-weight:bold;">Facility</th>
        <th style="border: 3px solid black;font-weight:bold;">Site</th>
        <th style="border: 3px solid black;font-weight:bold;">Algothrim</th>
        <th style="border: 3px solid black;font-weight:bold;">Date</th>
        <th style="border: 3px solid black;font-weight:bold;">Test 1 Used</th>
        <th style="border: 3px solid black;font-weight:bold;">Test 2 Used</th>
        <th style="border: 3px solid black;font-weight:bold;">Test 3 Used</th>
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
            <td style="border: 3px solid black;text-align: left;">{{ $testkit->test_1_kit_used }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $testkit->test_2_kit_used }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $testkit->test_3_kit_used }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $testkit->total_invalid }}</td>
        </tr>
    @endforeach
    </tbody>
</table>