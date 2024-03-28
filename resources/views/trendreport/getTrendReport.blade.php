<style>
.my-custom-scrollbar {
position: relative;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}

.tableFixHead          { overflow-y: auto; max-height: 500px;  }
.tableFixHead thead th { position: sticky; top: 0;  background-color: lavender; z-index: 99; }
#table-bordered  { border-collapse: collapse; width: 100%; }
#th, #td { padding: 8px 16px; }
#th     { background:#eee; }

</style>

<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
<table class="table table-bordered "  id="trendTable" style="width:100%;">
     <thead>
        
          <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class = "th" style="width:10%;">Facility</th>
                <th class = "th" style="width:10%;">Site</th>
                <th class = "th" style="width:10%;">Algorithm</th>
                <th class = "th" style="width:10%;">Testing Period</th>
                <th class = "th" style="width:5%;">Total Tests</th>
                <th colspan="3" class = "th" style="width:10%; text-align: center">Test 1</th>
                <th colspan="3" class = "th" style="width:10%; text-align: center">Test 2</th>
                <th class = "th" style="width:10%;">% Pos</th>
                <th class = "th" style="width:10%;">Positive Agr</th>
                <th class = "th" style="width:10%;">OverAll Agr</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class = "th" style="width:5%;" >R</th>
                <th class = "th" style="width:5%;" >NR</th>
                <th class = "th" style="width:5%;" >INV</th>
                <th class = "th" style="width:5%;" >R</th>
                <th class = "th" style="width:5%;" >NR</th>
                <th class = "th" style="width:5%;" >INV</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($report as $trendrow)
        <?php
            $date = $trendrow->end_test_date;
            $testingMonth= date('F - Y', strtotime($date)); //June, 2017
        ?>
        <tr style="text-align: right">
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->facility_name}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->site_type_name}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->algorithm_type}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$testingMonth}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->final_positive}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->test_1_reactive}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->test_1_nonreactive}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->test_1_invalid}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->test_2_reactive}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->test_2_invalid}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->final_positive}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->positive_percentage}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->positive_agreement}}</td>
        <td class = "td"style=" width: 10%; text-align: left">{{$trendrow->overall_agreement}}</td>
        </tr>
        @endforeach
        
        </tbody> 
</table>
</div>