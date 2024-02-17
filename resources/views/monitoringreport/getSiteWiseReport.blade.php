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
    @if(count($report['sitewise'])>0)
    <table class="table table-bordered " id="trendTable" style="width:100%;">
        <thead>

            <tr class="frezz" style=" ">
                
                <th class="th" style="width:15%;">Site Name</th>
                @foreach ($report['period'] as $period)
                <th class="th" style="width:7% !important;">{{$period}}</th>
                @endforeach
            </tr>

        </thead>
        <tbody>
            @foreach ($report['sitewise'] as $key => $val)
            <tr style="">
                <td class="td"> <input type="checkbox" id="{{ $val['site_id'] }}" name="testId[]" value="{{ $key }}" onclick="handleSiteName(this)"> {{ $key }} </td>
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
    @endif
</div>