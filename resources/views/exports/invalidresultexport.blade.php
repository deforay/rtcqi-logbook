<table style="border: 3px solid black">
    <thead style="border: 3px solid black">
    <tr style="border: 3px solid black">
        <td colspan="4" style="border: 3px solid black;font-weight:bold;">Invalid Results Report</td>
      </tr></thead></table>
      @for($i = 1; $i <= $globalValue; $i++)
    
        <table style="border: 3px solid black">
    <thead style="border: 3px solid black">
    <tr>
        <th colspan="4" style="border: 3px solid black;font-weight:bold;text-align: center;">Test {{$i}}</th>
      </tr>
    <tr style="border: 3px solid black">
        <th style="border: 3px solid black;font-weight:bold;">Algothrim</th>
        <th style="border: 3px solid black;font-weight:bold;">Kit Name</th>
        <th style="border: 3px solid black;font-weight:bold;">Test Used</th>
        <th style="border: 3px solid black;font-weight:bold;">Invalid Results</th>
    </tr>
    </thead>
    <tbody style="border: 3px solid black">
        @foreach ($report as $invalidresult)
        <?php $reactive = 'test_'.$i.'_reactive'; 
        $nonreactive = 'test_'.$i.'_nonreactive'; 
        $invalid = 'test_'.$i.'_invalid'; 
        $testKitName = 'testKit_'.$i.'_name'; 
        ?>

        <tr style="border: 3px solid black">
            <td style="border: 3px solid black">{{ $invalidresult->algorithm_type }}</td>
            <td style="border: 3px solid black">{{ $invalidresult->$testKitName }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $invalidresult->$reactive + $invalidresult->$nonreactive }}</td>
            <td style="border: 3px solid black;text-align: left;">{{ $invalidresult->$invalid }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
@endfor