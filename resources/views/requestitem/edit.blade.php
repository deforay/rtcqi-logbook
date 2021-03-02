<!-- 
    Author             : Sudarmathi M
    Created Date       : 02 Mar 2021
    Description        : request item edit screen
    Last Modified Date : 02 Mar 2021
    Last Modified Name : Sudarmathi M
-->

@extends('layouts.main')

@section('content')
<?php
use App\Service\CommonService;
$common = new CommonService();
$neededOn = $common->humanDateFormat($result[0]->need_on);
?>
<style>
td {
    padding-left: 0.50rem !important;
    padding-right: 0.50rem !important;
}

</style>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/requestitem">Request Items</a>
                        </li>
                        <li class="breadcrumb-item active">Edit
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    
        <div class="content-header-right col-md-4 col-12 ">
            <div class="dropdown float-md-right">
            
            </div>
        </div>
    </div>
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
        <div class="text-center" style=""><b>
            {{ session('status') }}</b></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <script>
        $('#show_alert_index').delay(3000).fadeOut();
    </script>
    @endif
    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"></h4>
                            <h3 class="content-header-title mb-0">Add Issue Items</h3>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body mt-0 pt-0">
                                <div id="show_alert" class="mt-1" style=""></div>
                            <form class="form form-horizontal" role="form"  name="addIssueItem" id="addIssueItem" method="post" action="/requestitem/edit/{{base64_encode($result[0]->requested_item_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                                @csrf
                                <br/>
                                <div class="row">
                                    <div class="" style="width:100%">
                                        <!-- <div class="bd-example"> -->
                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:25%;" class="pl-1 pr-0">Item<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Item<br> Quantity<span class="mandatory">*</span></th>
                                                    <th style="width:17%;" class="pl-1 pr-0">Needed On<span class="mandatory">*</span></th>
                                                    <th style="width:15%;" class="pl-1 pr-0">Location<span class="mandatory">*</span></th>
                                                    <th style="width:20%;" class="pl-1 pr-0">Reason</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemDetails">
                                                <tr>
                                                    <td>
                                                        <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="item0" name="item" title="Please select item" >
                                                            <option value="">Select Item </option>
                                                            @foreach ($item as $items)
                                                            <option value="{{ $items->item_id }}" {{ $result[0]->item_id == $items->item_id ?  'selected':''}}>{{ $items->item_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                    <input type="number" value="{{$result[0]->request_item_qty}}" id="itemQty0" name="itemQty" min="0" class="form-control isRequired itemQty" placeholder="Enter Item Qty" title="Please enter the item qty" />
                                                    </td >
                                                    <td>
                                                        <input type="text" id="neededOn0" class="form-control isRequired datepicker " value="{{$neededOn}}" autocomplete="off" placeholder="Enter needed on" name="neededOn" title="Please enter needed on">
                                                    </td>
                                                    <td>
                                                        <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="location0" name="location" title="Please select locations">
                                                            <option value="">Select Locations</option>
                                                            @foreach($branch as $type)
                                                                <option value="{{ $type->branch_id }}" {{ $result[0]->branch_id == $type->branch_id ?  'selected':''}}>{{ $type->branch_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                    <textarea id="reason0" class="form-control" name="reason">{{$result[0]->reason}}</textarea>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="row">
                                                            <div class="col-md-6 col-6" >
                                                                <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>
                                                            </div>
                                                            <!-- <div class="col-md-6 col-6">
                                                                <a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a>
                                                            </div> -->
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            </tbody>
                                            </table>
                                        <!-- </div> -->
                                    </div>
                                </div>
                                <br/>
                                </form>
                                <div class="form-actions right" style="margin-bottom: 5%;">
                                    <button type="submit" onclick="validateNow();return false;" class="btn btn-primary float-right">
                                        <i class="la la-check-square-o"></i> Update
                                    </button>
                                    <a href="/requestitem" >
                                        <button type="button" class="btn btn-warning mr-1 float-right ml-2">
                                        <i class="ft-x"></i> Close
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
var deliveryQty = '';
$(document).ready(function() {
    $(".select2").select2();
    $('.datepicker').datepicker({
        // format: 'dd-M-yyyy',
        autoclose: true,
        format: 'dd-M-yyyy',
        changeMonth: true,
        changeYear: true,
        maxDate: 0,
        startDate:'today',
        todayHighlight: true,
        clearBtn: true,
    });

});


Date.prototype.toShortFormat = function() {

let monthNames =["Jan","Feb","Mar","Apr",
                  "May","Jun","Jul","Aug",
                  "Sep", "Oct","Nov","Dec"];

let day = this.getDate();

let monthIndex = this.getMonth();
let monthName = monthNames[monthIndex];

let year = this.getFullYear();

return `${day}-${monthName}-${year}`;  
}

duplicateName = true;
function validateNow() {
    
    flag = deforayValidator.init({
        formId: 'addIssueItem'
    });
    if (flag == true) {
        $('.itemQty').prop('disabled',false)
        if (duplicateName) {
            document.getElementById('addIssueItem').submit();
        }
    }
    else{
        $('#show_alert').html(flag).delay(3000).fadeOut();
        $('#show_alert').css("display","block");
        $(".infocus").focus();
    }
}

</script>
@endsection