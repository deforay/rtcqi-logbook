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

    table{
        border-collapse:separate;
        border-spacing:0!important;
    }
    .tableFixHead thead {
        position: sticky;
        top: 0;
        z-index: 150;
        background-color:#e4eff8!important;
    }
    .tableFixHead thead th:first-child {
        position: sticky;
        left:0;
        background-color:#e4eff8;
        z-index: 150;
    }
    .tableFixHead thead th:nth-child(2){
        position: sticky;
        left:90px;
        background-color:#e4eff8;
        z-index: 150;
    }
    .tableFixHead thead th:nth-child(3){
        position: sticky;
        left: 150px;
        background-color:#e4eff8;
        z-index: 150;
    }
    
    .tableFixHead tbody td:first-child {
        position: sticky;
        top: 0;
        left:0;
        z-index: 100;      
        background-color:#fff;
    }
    .tableFixHead tbody td:nth-child(2){
        position: sticky;
        left:90px;
        background-color:#fff;
    }
    .tableFixHead tbody td:nth-child(3){
        position: sticky;
        left:150px;
        background-color:#fff;
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
    <table class="table table-bordered " id="trendTable" style="width:100%;">
        <thead>
            <tr class="frezz" style=" top: 37px; width:94.6%;">
                <th class="th" style="max-width:120px;">Site Name</th>
                <th class="th" style="max-width:120px;">Site ID</th>
                <th class="th" style="max-width:120px;">Email</th>
                <th class="th" style="max-width:120px;">Phone</th>
                <th class="th" style="max-width:120px;">Province</th>
                <th class="th" style="width:10%;">District</th>
                <th class="th" style="width:10%;">Sub-District</th>
                <th class="th" style="width:10%;">Last Reported On</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                
            </tr>
        </thead>
        <tbody>
            @if(count($report)>0)
            
            @foreach ($report as $notreportedsitesrow)
            
            <tr style="text-align: right">
                <td class="td" style="max-width:120px; text-align:left">{{$notreportedsitesrow->site_name}}</td>
                <td class="td" style="max-width:120px; text-align:left">{{$notreportedsitesrow->ts_id}}</td>
                <td class="td" style="max-width:120px; text-align:left">{{$notreportedsitesrow->site_primary_email}}</td>
                <td class="td" style="max-width:120px; text-align:left">{{$notreportedsitesrow->site_primary_mobile_no}}</td>
                <td class="td" style="max-width:120px; text-align:left">{{$notreportedsitesrow->province_name}}</td>
                <td class="td" style="text-align:left">{{$notreportedsitesrow->district_name}}</td>
                <td class="td" style="text-align:left">{{$notreportedsitesrow->sub_district_name}}</td>
                <td class="td" style="text-align:left">{{$notreportedsitesrow->added_on}}</td>
            </tr>
            @endforeach

            @else
            <tr>
                <td class="frezz" style="text-align:center;width:94.6%;" colspan="6">No Data Available</td>
            </tr>
            @endif

        </tbody>
    </table>
</div>