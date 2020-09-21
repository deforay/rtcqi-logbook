<!-- 
    Author             : Sriaam V
    Created Date       : 02 Sep 2020
    Description        : Maintenance add screen
    Last Modified Date : 
    Last Modified Name : 
-->

@extends('layouts.main')

@section('content')
<?php
use App\Service\CommonService;
$common = new CommonService();
?>
<style>
td {
    padding-left: 0.50rem !important;
    padding-right: 0.50rem !important;
}
span.twitter-typeahead .tt-menu, span.twitter-typeahead .tt-dropdown-menu {
    cursor: pointer;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
    list-style: none;
    font-size: 14px;
    text-align: left;
    background-color: #ffffff;
    border: 1px solid #cccccc;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    background-clip: padding-box;
}
</style>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <!-- <li class="breadcrumb-item active">Maintenance
                        </li> -->
                        <li class="breadcrumb-item"><a href="/maintenance/">Maintenance</a>
                        </li>
                        <li class="breadcrumb-item active">add</li>
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
                            <h3 class="content-header-title mb-0">Maintenance</h3>
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
                                <form class="form form-horizontal" role="form" name="addMaintenance" id="addMaintenance" method="post" action="/maintenance/add" autocomplete="off" onsubmit="validateNow();return false;">
                                @csrf
                                <br/>
                                <div class="row">
                                    <div class="">
                                        <!-- <div class="bd-example"> -->
                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:13%;" class="pl-1 pr-0">Location<span class="mandatory">*</span></th>
                                                    <th style="width:13%;" class="pl-1 pr-0">Item<span class="mandatory">*</span></th>
                                                    <th style="width:20%;" class="pl-1 pr-0">Service Date<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Service Done By<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Verified By<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Is This Regular<br>Service<span class="mandatory">*</span></th>
                                                    <th style="width:15%;" class="pl-1 pr-0">Next Scheduled<br>Maintenance Date<span class="mandatory">*</span></th>
                                                    <th style="width:12%;" class="pl-1 pr-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="maintenanceDetails">
                                                <tr>                                                   
                                                    <td>
                                                        <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branches0" name="branches[]" title="Please select locations" onchange="getItemByLoc(this.value,0)">
                                                            <option value="">Select Locations</option>
                                                            @foreach($branch as $type)
                                                                <option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="item0" name="item[]" title="Please select item" onchange="setQty(this.value,0)">
                                                            <option value="">Select Item</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                    <input type="text" id="serviceDate0" readonly class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter service date" name="serviceDate[]" title="Please enter service date">
                                                    </td>
                                                    <td>
                                                    <input type="text" id="serviceDoneBy0" class="form-control isRequired" autocomplete="off" placeholder="Enter service done by" name="serviceDoneBy[]" title="Please enter service done by">
                                                    </td>
                                                    <td>
                                                    <input type="text" id="verifiedBy0" class="form-control isRequired" autocomplete="off" placeholder="Enter verified by" name="verifiedBy[]" title="Please enter verify by">
                                                    </td>
                                                    <td>
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="regularService0" name="regularService[]" title="Please select if regular service">
                                                        <option value="yes" selected>Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                    </td >
                                                    <td>
                                                    <input type="text" id="nextMaintenanceDate0" readonly class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter next Maintenance date" name="nextMaintenanceDate[]" title="Please enter service date">
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-6 col-6" >
                                                                <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>
                                                            </div>
                                                            <!-- <div class="col-md-6 col-6">
                                                                <a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a>
                                                            </div> -->
                                                        </div>
                                                    </td>
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
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                    <a href="/maintenance">
                                        <button type="button" class="btn btn-warning mr-1 float-right ml-2">
                                        <i class="ft-x"></i> Cancel
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

function getItemByLoc(val,id){
    if (val != '') {
        $("#item").html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getItemByLoc') }}",
            method: 'post',
            data: {
                id : val
            },
            success: function(result) {
                var data = JSON.parse(result);
                console.log(data)
                var opt = '<option value="">Select Item</option>';
                for(var k=0;k<data.length;k++){
                   
                    expiryDate = data[k]['expiry_date'];
                    if(expiryDate){
                        let anyDate = new Date(expiryDate);
                        exp = ' ('+anyDate.toShortFormat()+')';
                    }
                    else{
                        exp = '';
                    }
                    // console.log(exp)
                    opt += '<option value="'+data[k]['item_id']+'@@'+data[k]['stock_quantity']+'@@'+expiryDate+'">'+data[k]['item_name']+exp+'</option>'
                }
                $('#item'+id).html(opt)
            }
        });
    }
    else{
        swal("Please select location")
    }
}

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
        formId: 'addMaintenance'
    });
    if (flag == true) {
        $('.itemQty').prop('disabled',false)
        if (duplicateName) {
            document.getElementById('addMaintenance').submit();
        }
    }
    else{
        $('#show_alert').html(flag).delay(3000).fadeOut();
        $('#show_alert').css("display","block");
        $(".infocus").focus();
    }
}

function changeScheduleStatus(val,id){

    receivedQtySum = 0;
    damagedQtySum = 0;
    $('.receivedQty').each(function() {
        receivedQtySum += Number($(this).val());
    });
    $('.damagedQty').each(function() {
        damagedQtySum += Number($(this).val());
    });
    if(parseInt(receivedQtySum) > parseInt(deliveryQty)){
        swal("Total of Received Quantity cannot be greater than Delivery Quantity")
    }
    if(parseInt(damagedQtySum) > parseInt(deliveryQty)){
        swal("Total of Non Confromity Quantity cannot be greater than Delivery Quantity")
    }
    if(parseInt(val)>parseInt(deliveryQty)){
        $('#'+id).val('')
        // $('#'+id).addClass('infocus');
        swal("Entered Quantity cannot be greater than Delivery Quantity")
    }

}

rowCount = 0;
function insRow() {
    rowCount++;
    rl = document.getElementById("maintenanceDetails").rows.length;
    var a = document.getElementById("maintenanceDetails").insertRow(rl);
    a.setAttribute("style", "display:none;");
    // a.setAttribute("class", "data");
    var b = a.insertCell(0);
    var c = a.insertCell(1);
    var d = a.insertCell(2);
    var e = a.insertCell(3);
    var f = a.insertCell(4);
    var g = a.insertCell(5);
    var h = a.insertCell(6);
    var i = a.insertCell(7);
    rl = document.getElementById("maintenanceDetails").rows.length - 1;
    b.innerHTML = '<select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branches'+rowCount+'" name="branches[]" title="Please select locations" onchange="getItemByLoc(this.value,'+rowCount+')">\
                        <option value="">Select Locations</option>@foreach($branch as $type)<option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>@endforeach</select>';
    c.innerHTML = '<select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="item'+rowCount+'" name="item[]" title="Please select item" onchange="setQty(this.value,'+rowCount+')">\
                        <option value="">Select Item</option>\
                    </select>';
    d.innerHTML = '<input type="text" id="serviceDate'+rowCount+'" readonly class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter service date" name="serviceDate[]" title="Please enter service date">';                        
    e.innerHTML = '<input type="text" id="serviceDoneBy'+rowCount+'" class="form-control isRequired" autocomplete="off" placeholder="Enter service done by" name="serviceDoneBy[]" title="Please enter service done by">';
    f.innerHTML = '<input type="text" id="verifiedBy'+rowCount+'" class="form-control isRequired" autocomplete="off" placeholder="Enter verified by" name="verifiedBy[]" title="Please enter verify by">';
    g.innerHTML = '<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="regularService'+rowCount+'" name="regularService[]" title="Please select if regular service"><option value="yes" selected>Yes</option><option value="no">No</option></select>';
    h.innerHTML = '<input type="text" id="nextMaintenanceDate'+rowCount+'" readonly class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter next Maintenance date" name="nextMaintenanceDate[]" title="Please enter service date">';
    i.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
    $(a).fadeIn(800);
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
    $(".select2").select2();
   
}

function removeRow(el) {
    $(el).parent().fadeOut("slow", function () {
        $(el).parent().remove();
        rowCount = rowCount-1;
        rl = document.getElementById("maintenanceDetails").rows.length;
        if (rl == 0) {
            insRow();
        }
    });
}

function setQty(val,id){
    value = val.split('@@');
    $('#itemQty'+id).val(value[1])
}

function qtyRestriction(val,id){
    itemQty = parseInt($('#itemQty'+id).val())
    if(parseInt(val) > itemQty){
        $('#itemIssuedQty'+id).val('')
        $('#itemIssuedQty'+id).focus();
        swal("Entered item issued quantity can't exceed item quantity")
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
@endsection