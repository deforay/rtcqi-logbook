@extends('layouts.main')

@section('content')
<?php
use App\Service\CommonService;
$common = new CommonService();
$deliveryDate = $common->humanDateFormat($result[0]->expected_date_of_delivery);
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
                        <li class="breadcrumb-item"><a href="/itemreceive/">Receive Deliveries</a>
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
                            <h3 class="content-header-title mb-0">Receive Deliveries</h3>
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
                                <form class="form form-horizontal" role="form" enctype="multipart/form-data"  name="updateItemReceive" id="updateItemReceive" method="post" action="/itemreceive/updateItemReceive/{{$deliveryId}}" autocomplete="off" onsubmit="validateNow();return false;">
                                @csrf
                                <!-- <div>
                                    <center><h4><b>PURCHASE ORDER</b></h4><center>
                                </div> -->
                                <br/>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>PO Number : </b> <span id="rfqNumber" class="spanFont">{{$result[0]->po_number }} </span></h4>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>PO Issued On : </b><span id="quoteNumber" class="spanFont">{{$result[0]->po_issued_on}}</span></h4>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>Vendors : </b><span id="invitedDate" class="spanFont">{{$result[0]->vendor_name}}</span></h4>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>Item Name : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$result[0]->item_name}} </span></h4>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>Total Amount : </b><span id="quoteSts" class="spanFont" style="text-transform: capitalize;">{{$result[0]->total_amount}} </span></h4>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>Payment Status : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->payment_status}} </span></h4>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>Expected Delivery : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$deliveryDate}} </span></h4>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>Delivery Mode : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->delivery_mode}} </span></h4>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <h4><b>Delivery Quantity : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->delivery_qty}} </span></h4>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <h4><b>Order Status : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$result[0]->order_status}} </span></h4>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="">
                                        <!-- <div class="bd-example"> -->
                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%;" class="pl-1 pr-0">Sl.No</th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Manufacturing<br> Date</th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Expiry Date</th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Batch No</th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Received<br> Quantity<span class="mandatory">*</span></th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Non Conformity<br> Quantity<span class="mandatory">*</span></th>
                                                    <th style="width:15%;" class="pl-1 pr-0">Reason for<br> non conformity</th>
                                                    <th style="width:10%;" class="pl-1 pr-0">Locations<span class="mandatory">*</span></th>
                                                    <th style="width:15%;" class="pl-1 pr-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemDetails">
                                                <tr>
                                                    <td>
                                                        <input type="text" id="slNumber0" onkeypress="return isNumberKey(event);" class="form-control " autocomplete="off" placeholder="Sl No" name="slNumber[]" title="Please enter sl Number">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="manufacturingDate0" class="form-control datepicker " autocomplete="off" placeholder="Enter Manufacturing Date" name="manufacturingDate[]" title="Please enter Manufacturing Date">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="expiryDate0" class="form-control datepicker " autocomplete="off" placeholder="Enter expiry date" name="expiryDate[]" title="Please enter expiry date">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="batchNo0" class="form-control " autocomplete="off" placeholder="Enter batch number" name="batchNo[]" title="Please enter batch number">
                                                    </td>
                                                    <td>
                                                        <input type="number" value="0" id="receivedQty0" name="receivedQty[]" min="0" onchange="changeScheduleStatus(this.value,this.id)" class="form-control isRequired receivedQty" placeholder="Enter Received Qty" title="Please enter the received qty" value="" />
                                                    </td >
                                                    <td>
                                                        <input type="number" value="0" id="expiryQty0" name="expiryQty[]" min="0" onchange="changeScheduleStatus(this.value,this.id)" class="form-control damagedQty" placeholder="Enter Non Confromity Qty" title="Please enter the Non Confromity qty" value="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="description0" class="form-control typeahead-bloodhound" name="description[]" placeholder="Enter the description about non conformity quantity"  title="Enter the description about non conformity quantity">
                                                    </td>
                                                    <td>
                                                    <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branches0" name="branches[]" title="Please select locations">
                                                        <option value="">Select Locations</option>
                                                        @foreach($branch as $type)
                                                            <option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>
                                                        @endforeach
                                                    </select>
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
                                            <div class="col-md-2">
                                            <h5>Attachment <span class="mandatory">*</span></h5>
                                        </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="uploadFile" name="uploadFile[]" multiple>
                                                <label class="custom-file-label" multiple="multiple" for="uploadFile" aria-describedby="uploadFile">Choose file</label>
                                                <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                            </div>
                                        </fieldset>
                                    </div>
                                        <!-- </div> -->
                                    </div>
                                </div>
                                <br/>
                                <!-- <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Received Quantity<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="receivedQty" oninput="changeScheduleStatus(this.value,this.id)" value="" class="form-control isRequired" autocomplete="off" placeholder="Enter Received Quantity" name="receivedQty" title="Please enter Received Quantity" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Non Confromity Quantity<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="damagedQty" oninput="changeScheduleStatus();" value="" class="form-control isRequired" autocomplete="off" placeholder="Enter Non Confromity Quantity" name="damagedQty" title="Please enter Non Confromity Quantity" >
                                            </div>
                                        </fieldset>
                                    </div>
                                </div> -->
                                <input type="hidden" id="receivedQtySum"  value="" class="form-control" autocomplete="off" placeholder="Enter Received Quantity" name="receivedQtySum" title="Please enter Received Quantity" >
                                <input type="hidden" id="damagedQtySum" value="" class="form-control" autocomplete="off" placeholder="Enter Non Confromity Quantity" name="damagedQtySum" title="Please enter Non Confromity Quantity" >
                                <input type="hidden" id="itemId" name="itemId" class="form-control" value="{{$result[0]->item_id}}">
                                <div class="row">

                                    <input type="hidden" id="status" value="" class="form-control" autocomplete="off" placeholder="Enter Delivery Schedule Status" name="status" title="Please enter Delivery Schedule Status" >
                                    <!-- <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Short Description <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="description" class="form-control typeahead-bloodhound" name="description" placeholder="Enter the description about non conformity quantity"  title="Enter the description about non conformity quantity">
                                            </div>
                                        </fieldset>
                                    </div> -->
                                </div>
                                <br/>
                                <input type="hidden" value="{{$deliveryId}}" id="deliveryId" name="deliveryId" >
                                <input type="hidden" value="{{$result[0]->pod_id}}" id="pod_id" name="pod_id" >
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
var deliveryQty = '{{$result[0]->delivery_qty}}';
$(document).ready(function() {
    $(".select2").select2();
    $("#branches").select2({
        placeholder: "Select Locations",
		allowClear: true
    });
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
    let autocompComments = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/getAutoCompleteComments",
            replace: function(url, uriEncodedQuery) {
                comments = $('#description0').val();
                return url + '/' + uriEncodedQuery + '/' + comments
            },
            filter: function(data) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(data, function(autocompComments) {
                    return {
                        value: autocompComments.value
                    };
                });
            }
        }
    });

    // Initialize the Bloodhound suggestion engine
    autocompComments.initialize();

    console.log(autocompComments)
    $('#description0').typeahead(null, {
        name: 'value',
        displayKey: 'value',
        source: autocompComments.ttAdapter(),
        limit:'Infinity'
    });
    // $('.twitter-typeahead').css('display','block')
    // $('.tt-menu').addClass('pl-1 pr-1')
});

duplicateName = true;
function validateNow() {
    receivedQtySum = 0;
    damagedQtySum = 0;
    $('.receivedQty').each(function() {
        receivedQtySum += Number($(this).val());
        $('#receivedQtySum').val(receivedQtySum)
    });
    $('.damagedQty').each(function() {
        damagedQtySum += Number($(this).val());
        $('#damagedQtySum').val(damagedQtySum)
    });
    if(damagedQtySum>0){
        $('#description').addClass('isRequired');
        $('#status').val('Non Conformity')
    }
    else if(receivedQtySum == deliveryQty && damagedQtySum == 0){
        $('#status').val('Received')
        $('#description').removeClass('isRequired');
    }
    else{
        $('#status').val('Non Conformity')
    }
    let total = 0;
    total = parseInt(receivedQtySum) + parseInt(damagedQtySum);
    flag = deforayValidator.init({
        formId: 'updateItemReceive'
    });
    if(parseInt(total) > parseInt(deliveryQty)){
        swal("Please enter valid Received and Non Confromity quantity, can't exceed delivery quantity")
        flag = false
    }
    else{
        if (flag == true) {
            $('#status').prop('disabled',false)
            if (duplicateName) {
                document.getElementById('updateItemReceive').submit();
            }
        }
        else{
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $(".infocus").focus();
        }
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
    var g = a.insertCell(7);
    var e = a.insertCell(8);
    rl = document.getElementById("itemDetails").rows.length - 1;
    i.innerHTML = '<input type="text" id="slNumber' + rowCount + '" onkeypress="return isNumberKey(event);" class="form-control  isRequired" autocomplete="off" placeholder="Sl No" name="slNumber[]" title="Please enter Sl Number">';
    j.innerHTML = '<input type="text" id="manufacturingDate' + rowCount + '" class="form-control datepicker " autocomplete="off" placeholder="Enter manufacturing date" name="manufacturingDate[]" title="Please enter manufacturing date">';
    b.innerHTML = '<input type="text" id="expiryDate' + rowCount + '" class="form-control datepicker " autocomplete="off" placeholder="Enter expiry date" name="expiryDate[]" title="Please enter expiry date">';
    d.innerHTML = '<input type="text" id="batchNo' + rowCount + '" class="form-control " autocomplete="off" placeholder="Enter batch number" name="batchNo[]" title="Please enter batch number">';
    c.innerHTML = '<input type="number" value="0" id="receivedQty' + rowCount + '" name="receivedQty[]" onchange="changeScheduleStatus(this.value,this.id)" min="0" class="form-control receivedQty isRequired " placeholder="Enter Received Qty" title="Please enter the received qty" value="" />';
    f.innerHTML = '<input type="number" value="0" id="expiryQty' + rowCount + '" name="expiryQty[]" onchange="changeScheduleStatus(this.value,this.id)" min="0" class="form-control damagedQty isRequired " placeholder="Enter Non Confromity Qty" title="Please enter the Non Confromity qty" value="" />'
    h.innerHTML = '<input type="text" id="description' + rowCount + '" class="form-control typeahead-bloodhound" name="description[]" placeholder="Enter the description about non conformity quantity"  title="Enter the description about non conformity quantity">';
    g.innerHTML = '<select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branches' + rowCount + '" name="branches[]" title="Please select locations">\
                        <option value="">Select Locations</option>@foreach($branch as $type)<option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>@endforeach</select>';
    e.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
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
    let autocompComments = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/getAutoCompleteComments",
            replace: function(url, uriEncodedQuery) {
                comments = $('#description'+rowCount).val();
                return url + '/' + uriEncodedQuery + '/' + comments
            },
            filter: function(data) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(data, function(autocompComments) {
                    return {
                        value: autocompComments.value
                    };
                });
            }
        }
    });

    // Initialize the Bloodhound suggestion engine
    autocompComments.initialize();

    console.log(autocompComments)
    $('#description'+rowCount).typeahead(null, {
        name: 'value',
        displayKey: 'value',
        source: autocompComments.ttAdapter(),
        limit:'Infinity'
    });
    $('.twitter-typeahead').css('display','block')
    $('.tt-menu').addClass('pl-1 pr-1')
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
function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endsection