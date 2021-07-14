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

<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
    <table class="table table-bordered " id="testKitTable" style="width:100%;">
        <thead>

            <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class="th" style="width:10%;">Facility</th>
                <th class="th" style="width:10%;">Site</th>
                <th class="th" style="width:10%;">Algo</th>
                <th class="th" style="width:10%;">Date</th>
                <th class="th" style="width:5%;">Test 1 Used</th>
                <th class="th" style="width:5%;">Test 2 Used</th>
                <th class="th" style="width:5%;">Test 3 Used</th>
                <th class="th" style="width:5%;">Invalid Result</th>

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
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->site_name}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->algorithm_type}}</td>
                <td class="td" style=" width: 10%; text-align: left">{{$testingDate}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->test_1_kit_used}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->test_2_kit_used}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->test_3_kit_used}}</td>
                <td class="td" style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->total_invalid}}</td>
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