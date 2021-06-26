<style>
.my-custom-scrollbar {
position: relative;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}

.tableFixHead          { overflow-y: auto; max-height: 500px;  }
.tableFixHead thead th { position: sticky; top: 0;   z-index: 99; }
#table-bordered  { border-collapse: collapse; width: 100%; }
#th, #td { padding: 8px 16px; }
#th     { background:#eee; }

</style>
<?php 
use App\Service\GlobalConfigService;
$GlobalConfigService = new GlobalConfigService();
$glob = $GlobalConfigService->getAllGlobalConfig();
$arr = array();
// now we create an associative array so that we can easily create view variables
for ($i = 0; $i < sizeof($glob); $i++) {
    $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
}

$col = ['yellow', '#b5d477' , '#d08662', '#76cece', '#ea7786'];

?>
 @for($i = 1; $i <= $arr['no_of_test']; $i++)
<div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
<table class="table table-bordered "  id="trendTable" style="width:100%;">
     <thead>
        <tr>
        <th class = "th" style="width:10%; text-align: center; background-color:#76cece">Test {{$i}}</th>
        </tr></thead></table></div>
        <div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
        <table class="table table-bordered "  id="trendTable" style="width:100%;">
     <thead>
          <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class = "th" style="width:10%;">Facility</th>
                <th class = "th" style="width:10%;">Algo</th>
                <th class = "th" style="width:10%;">Kit Name</th>
                <th class = "th" style="width:10%;">Test Used</th>
                <th class = "th" style="width:10%;">Invalid Results</th>
            </tr>
        </thead>
        <tbody>
        @if(count($report)>0)
        @foreach ($report as $trendrow)
        <?php $reactive = 'test_'.$i.'_reactive'; 
        $nonreactive = 'test_'.$i.'_nonreactive'; 
        $invalid = 'test_'.$i.'_invalid'; 
        $testKitName = 'testKit_'.$i.'_name'; 
        ?>
        <tr style="text-align: right">
        <td class = "td"style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->facility_name}}</td>
        <td class = "td"style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->algorithm_type}}</td>
        <td class = "td"style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$testKitName}}</td>
        <td class = "td"style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$reactive + $trendrow->$nonreactive}}</td>
        <td class = "td"style=" width: 10%; text-align: left; color: black;font-weight: 500;">{{$trendrow->$invalid}}</td>
        </tr>
        @endforeach

        @else
            <tr>
               <td class="frezz" style="text-align:center;width:94.6%;" colspan="18">No Data Available</td>
          </tr>
        @endif 
        
        </tbody> 
        </table>
</div>
@endfor
        