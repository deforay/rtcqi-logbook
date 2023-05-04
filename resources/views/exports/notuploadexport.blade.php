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
            <th style="border: 3px solid black;font-weight:bold;">Test Site</th>
            <th style="border: 3px solid black;font-weight:bold;">Entry Point</th>
            <th style="border: 3px solid black;font-weight:bold;">Facility</th>
            <th style="border: 3px solid black;font-weight:bold;">Province</th>
            <th style="border: 3px solid black;font-weight:bold;">Site Manager</th>
            <th style="border: 3px solid black;font-weight:bold;">Site Unique Id</th>
            <th style="border: 3px solid black;font-weight:bold;">Lab Manager Name</th>
            <th style="border: 3px solid black;font-weight:bold;">Is FLC*</th>
            <th style="border: 3px solid black;font-weight:bold;">Does site do Recency Tests?*</th>
            <th style="border: 3px solid black;font-weight:bold;">Lab Manager Contact Number</th>
            <th style="border: 3px solid black;font-weight:bold;">Algorithm Type</th>
            <th style="border: 3px solid black;font-weight:bold;">Date of data collection</th>
            <th style="border: 3px solid black;font-weight:bold;">Reporting Month</th>
            <th style="border: 3px solid black;font-weight:bold;">Book No</th>
            <th style="border: 3px solid black;font-weight:bold;">Name of Data Collector</th>
            <th style="border: 3px solid black;font-weight:bold;">Page No</th>
            <th style="border: 3px solid black;font-weight:bold;">Start Date</th>
            <th style="border: 3px solid black;font-weight:bold;">End Date</th>
            @if ($arr['no_of_test'] >= 1)
            <th style="border: 3px solid black;font-weight:bold;">Test Kit Name1</th>
            <th style="border: 3px solid black;font-weight:bold;">Lot No. 1</th>
            <th style="border: 3px solid black;font-weight:bold;">Expiry Date 1</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit1 Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit1 Non Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit1 Invalid</th>
            @endif
            @if ($arr['no_of_test'] >= 2)
            <th style="border: 3px solid black;font-weight:bold;">Test Kit Name2</th>
            <th style="border: 3px solid black;font-weight:bold;">Lot No. 2</th>
            <th style="border: 3px solid black;font-weight:bold;">Expiry Date 2</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit2 Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit2 Non Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit2 Invalid</th>
            @endif
            @if ($arr['no_of_test'] >= 3)
            <th style="border: 3px solid black;font-weight:bold;">Test Kit Name3</th>
            <th style="border: 3px solid black;font-weight:bold;">Lot No. 3</th>
            <th style="border: 3px solid black;font-weight:bold;">Expiry Date 3</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit3 Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit3 Non Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit3 Invalid</th>
            @endif
            @if ($arr['no_of_test'] >= 4)
            <th style="border: 3px solid black;font-weight:bold;">Test Kit Name4</th>
            <th style="border: 3px solid black;font-weight:bold;">Lot No. 4</th>
            <th style="border: 3px solid black;font-weight:bold;">Expiry Date 4</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit4 Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit4 Non Reactive</th>
            <th style="border: 3px solid black;font-weight:bold;">Test Kit4 Invalid</th>
            @endif
            <th style="border: 3px solid black;font-weight:bold;">Final Positive</th>
            <th style="border: 3px solid black;font-weight:bold;">Final Negative</th>
            <th style="border: 3px solid black;font-weight:bold;">Final Indeterminate</th>
            <th style="border: 3px solid black;font-weight:bold;">Comments</th>
</tr>
</thead>
<tbody style="border: 3px solid black">
    @php
            print_r($report);
            @endphp
        @foreach($report as $notuploaddrow)
        <tr>
        <td>{{ $notuploaddrow->test_site_name }}</td>
            <td>{{ $notuploaddrow->site_type }}</td>
            <td>{{ $notuploaddrow->facility }}</td>
            <td>{{ $notuploaddrow->province_name }}</td>
            <td>{{ $notuploaddrow->site_manager }}</td>
            <td>{{ $notuploaddrow->site_unique_id }}</td>
            <td>{{ $notuploaddrow->tester_name }}</td>
            <td>{{ $notuploaddrow->is_flc }}</td>
            <td>{{ $notuploaddrow->is_recency }}</td>
            <td>{{ $notuploaddrow->contact_no }}</td>
            <td>{{ $notuploaddrow->algorithm_type }}</td>
            <td>{{ $notuploaddrow->date_of_data_collection }}</td>
            <td>{{ $notuploaddrow->reporting_month }}</td>
            <td>{{ $notuploaddrow->book_no }}</td>
            <td>{{ $notuploaddrow->name_of_data_collector }}</td>
            <td>{{ $notuploaddrow->page_no }}</td>
            <td>{{ $notuploaddrow->start_test_date }}</td>
            <td>{{ $notuploaddrow->end_test_date }}</td>
            @if ($arr['no_of_test'] >= 1)
            <td>{{ $notuploaddrow->test_kit_name1 }}</td>
            <td>{{ $notuploaddrow->lot_no_1 }}</td>
            <td>{{ $notuploaddrow->expiry_date_1 }}</td>
            <td>{{ $notuploaddrow->test_1_reactive }}</td>
            <td>{{ $notuploaddrow->test_1_non_reactive }}</td>
            <td>{{ $notuploaddrow->test_1_invalid }}</td>
            @endif
            @if ($arr['no_of_test'] >= 2)
            <td>{{ $notuploaddrow->test_kit_name2 }}</td>
            <td>{{ $notuploaddrow->lot_no_2 }}</td>
            <td>{{ $notuploaddrow->expiry_date_2 }}</td>
            <td>{{ $notuploaddrow->test_2_reactive }}</td>
            <td>{{ $notuploaddrow->test_2_non_reactive }}</td>
            <td>{{ $notuploaddrow->test_2_invalid }}</td>
            @endif
            @if ($arr['no_of_test'] >= 3)
            <td>{{ $notuploaddrow->test_kit_name3 }}</td>
            <td>{{ $notuploaddrow->lot_no_3 }}</td>
            <td>{{ $notuploaddrow->expiry_date_3 }}</td>
            <td>{{ $notuploaddrow->test_3_reactive }}</td>
            <td>{{ $notuploaddrow->test_3_non_reactive }}</td>
            <td>{{ $notuploaddrow->test_3_invalid }}</td>
            @endif
            @if ($arr['no_of_test'] >= 4)
            <td>{{ $notuploaddrow->test_kit_name4 }}</td>
            <td>{{ $notuploaddrow->lot_no_4 }}</td>
            <td>{{ $notuploaddrow->expiry_date_4 }}</td>
            <td>{{ $notuploaddrow->test_4_reactive }}</td>
            <td>{{ $notuploaddrow->test_4_non_reactive }}</td>
            <td>{{ $notuploaddrow->test_4_invalid }}</td>
            @endif
            <td>{{ $notuploaddrow->final_positive }}</td>
            <td>{{ $notuploaddrow->final_negative }}</td>
            <td>{{ $notuploaddrow->final_undetermined }}</td>
            <td>{{ $notuploaddrow->comment }}</td>
</tr>
        @endforeach
</table>
        
        
    