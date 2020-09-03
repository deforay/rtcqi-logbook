<!-- 
    Author             : Sudarmathi M
    Created Date       : 02 Sep 2020
    Description        : Inventory Outwards add screen
    Last Modified Date : 02 Sep 2020
    Last Modified Name : Sudarmathi M
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
                        <li class="breadcrumb-item active">Procurement
                        </li>
                        <li class="breadcrumb-item"><a href="/inventoryoutwards/">Issue Items</a>
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
                            <h3 class="content-header-title mb-0">Issue Items</h3>
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
                                <form class="form form-horizontal" role="form"  name="addIssueItem" id="addIssueItem" method="post" action="/inventoryoutwards/add" autocomplete="off" onsubmit="validateNow();return false;">
                                @csrf
                                <br/>
                                <div class="row">
                                    <div class="">
                                        <!-- <div class="bd-example"> -->
                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:13%;" class="pl-1 pr-0">Locations</th>
                                                    <th style="width:20%;" class="pl-1 pr-0">Item<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Item<br> Quantity<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Item Issued<br> Quantity<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Issued On<span class="mandatory">*</span></th>
                                                    <th style="width:15%;" class="pl-1 pr-0">Issued To<span class="mandatory">*</span></th>
                                                    <th style="width:20%;" class="pl-1 pr-0">Description</th>
                                                    <th style="width:12%;" class="pl-1 pr-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemDetails">
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
                                                        <input type="number" value="0" id="itemQty0" name="itemQty[]" min="0" readonly class="form-control isRequired itemQty" placeholder="Enter Item Qty" title="Please enter the item qty" value="" />
                                                    </td >
                                                    <td>
                                                        <input type="number" value="0" id="itemIssuedQty0" name="itemIssuedQty[]" min="0" onchange="qtyRestriction(this.value,0)" class="form-control isRequired" placeholder="Enter Item Issued Qty" title="Please enter the item issued qty" value="" />
                                                    </td >
                                                    <td>
                                                        <input type="text" id="issuedOn0" class="form-control isRequired datepicker " autocomplete="off" placeholder="Enter issued on" name="issuedOn[]" title="Please enter issued on">
                                                    </td>
                                                    <td>
                                                        <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="issuedTo0" name="issuedTo[]" title="Please select locations">
                                                            <option value="">Select Locations</option>
                                                            @foreach($branch as $type)
                                                                <option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea id="description0" class="form-control" name="description[]"></textarea>
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
                                        <a href="/itemreceive" >
                                            <button type="button" class="btn btn-warning mr-1 float-right ml-2">
                                            <i class="ft-x"></i> Cancel
                                            </button>
                                        </a>
                                    <button type="submit" onclick="validateNow();return false;" class="btn btn-primary float-right">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
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
                    let anyDate = new Date(expiryDate);
                    // console.log(anyDate.toShortFormat());
                    exp = anyDate.toShortFormat();
                    // console.log(exp)
                    opt += '<option value="'+data[k]['item_id']+'@@'+data[k]['stock_quantity']+'">'+data[k]['item_name']+' ('+exp+')</option>'
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
        formId: 'addIssueItem'
    });
    if (flag == true) {
        $('#status').prop('disabled',false)
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
    rl = document.getElementById("itemDetails").rows.length;
    var a = document.getElementById("itemDetails").insertRow(rl);
    a.setAttribute("style", "display:none;");
    // a.setAttribute("class", "data");
    var i = a.insertCell(0);
    var j = a.insertCell(1);
    var b = a.insertCell(2);
    var d = a.insertCell(3);
    var c = a.insertCell(4);
    var f = a.insertCell(5);
    var h = a.insertCell(6);
    // var g = a.insertCell(7);
    var e = a.insertCell(7);
    rl = document.getElementById("itemDetails").rows.length - 1;
    i.innerHTML = '<select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branches'+rowCount+'" name="branches[]" title="Please select locations" onchange="getItemByLoc(this.value,'+rowCount+')">\
                        <option value="">Select Locations</option>@foreach($branch as $type)<option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>@endforeach</select>';
    j.innerHTML = '<select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="item'+rowCount+'" name="item[]" title="Please select item" onchange="setQty(this.value,'+rowCount+')">\
                        <option value="">Select Item</option>\
                    </select>';
    b.innerHTML = '<input type="number" id="itemQty'+rowCount+'" name="itemQty[]" min="0" readonly class="form-control isRequired itemQty" placeholder="Enter Item Qty" title="Please enter the item qty" value="0" />';
    d.innerHTML = '<input type="number" id="itemIssuedQty'+rowCount+'" name="itemIssuedQty[]" min="0" onchange="qtyRestriction(this.value,'+rowCount+')" class="form-control isRequired" placeholder="Enter Item Issued Qty" title="Please enter the item issued qty" value="0" />';
    c.innerHTML = '<input type="text" id="issuedOn'+rowCount+'" class="form-control isRequired datepicker " autocomplete="off" placeholder="Enter issued on" name="issuedOn[]" title="Please enter issued on">';
    f.innerHTML = '<select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="issuedTo'+rowCount+'" name="issuedTo[]" title="Please select locations">\
                        <option value="">Select Locations</option>\
                        @foreach($branch as $type)\
                            <option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>\
                        @endforeach\
                    </select>'
    h.innerHTML = '<textarea id="description'+rowCount+'" class="form-control" name="description[]"></textarea>';
    e.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
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
        rl = document.getElementById("itemDetails").rows.length;
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
    itemQty = $('#itemQty'+id).val()
    if(val > itemQty){
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