@if(count($report['sitewise'])>0)
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
        border-spacing:0;
    }
    .tableFixHead thead {
        position: sticky;
        top: 0;
        z-index: 150;
        background-color:#e4eff8!important;
    }

    .tableFixHead thead th:first-child{
        position: sticky;
        left:0;
        background-color:#e4eff8;
        z-index: 150;
        border-spacing:0;
        border-collapse:separate;
    }
    .tableFixHead tbody td:first-child{
        position: sticky;
        top: 0;
        left:0;
        z-index: 100;      
        background-color:#fff;
        border-spacing:0;
        border-collapse:separate;
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

            <tr class="frezz" style=" ">
                
                <th class="th" style="width:15%;">Site Name {{ $comingFrom }}</th>
                @foreach ($report['period'] as $period)
                <th class="th" style="width:7% !important;">{{$period}}</th>
                @endforeach
                
            </tr>

        </thead>
        <tbody>
            @foreach ($report['sitewise'] as $key => $val)
            
            <tr style="">
                <td class="td"> 
                    <?php if(isset($comingFrom) && trim($comingFrom)!=""){ ?>
                    {{ $key }}
                    <?php }else{ ?>
                    <input type="checkbox" id="{{ $val['site_id'] }}" name="testId[]" value="{{ $key }}" onclick="handleSiteName(this)"> 
                    {{ $key }} 
                    <?php } ?>
                    <?php if(isset($val['last_reminder_date']) && trim($val['last_reminder_date'])!=0){ ?>
                    <i class="la la-envelope"></i>({{$val['reminder_count']}})
                    <?php }?>
                   <?php if(isset($val['last_reminder_date']) && trim($val['last_reminder_date'])!=""){ ?>
                    <br>Date: <?php echo  $val['last_reminder_date']?>
                    <?php }?>
                </td>
                @foreach ($report['period'] as $period)
                <td style="text-align:center;padding:0 !important;">
                <?php
                 if(isset($val['count'][$period])){
                ?>
                <a href="javascript:void(0);" class="btn btn-success btn-sm" title="{{  $val['count'][$period] }}">
                    <i class="ft-check"></i>
                </a>
                <?php
                 }else{
                ?>
                <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="0">
                <i class="ft-x"></i>
                </a>
                <?php
                 }
                ?>
                
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>



    </table>
    
</div>
@else
<br/><h4 style="text-align:center;">No data available</h4><br/>
@endif