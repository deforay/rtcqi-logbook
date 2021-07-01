
<table style="border: 3px solid black">
    <thead style="border: 3px solid black">
    <tr>
        <td colspan="18" style="border: 3px solid black;font-weight:bold;">LogBook Report</td>
      </tr>
    <tr style="border: 3px solid black">
        <th style="border: 3px solid black;font-weight:bold;">Facility</th>
        <th style="border: 3px solid black;font-weight:bold;">Site</th>
        <th style="border: 3px solid black;font-weight:bold;">Algothrim</th>
        <th style="border: 3px solid black;font-weight:bold;">Start Date</th>
        <th style="border: 3px solid black;font-weight:bold;">End Date</th>
        <th style="border: 3px solid black;font-weight:bold;">Total Tests</th>
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
    @foreach($report as $logbookdata)

        <tr style="border: 3px solid black">
            <td style="border: 3px solid black">{{ $logbookdata->facility_name }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->site_name }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->algorithm_type }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->start_test_date }}</td>
            <td style="border: 3px solid black">{{ $logbookdata->end_test_date }}</td>
            <td style="border: 3px solid black;;text-align: left;">{{ $logbookdata->test_1_reactive + $logbookdata->test_1_nonreactive }}</td>
            @for($l = 1; $l <= $globalValue; $l++)
            <?php $reactive = 'test_'.$l.'_reactive'; $nonreactive = 'test_'.$l.'_nonreactive'; $invalid = 'test_'.$l.'_invalid';   ?>
            <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->$reactive }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->$nonreactive }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->$invalid }}</td>
            @endfor
            <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->positive_percentage }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->positive_agreement }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $logbookdata->overall_agreement }}</td>
        </tr>
    @endforeach
    </tbody>
</table>