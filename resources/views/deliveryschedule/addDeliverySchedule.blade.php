<!-- 
    Author             : Sudarmathi M
    Created Date       : 20 July 2020
    Description        : Delivery schedule add screen
    Last Modified Date :   
    Last Modified Name :
-->

@extends('layouts.main')

@section('content')
@php
$currentDate=date('d-M-Y');
@endphp
<style>
td {
    padding-left: 0.50rem !important;
    padding-right: 0.50rem !important;
}
</style>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Delivery Schedule</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Procurement
                        </li>
                        <li class="breadcrumb-item"><a href="/deliveryschedule/">Delivery Schedule</a>
                        </li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- horizontal grid start -->
        <section class="horizontal-grid" id="horizontal-grid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-1">
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add Delivery Schedule</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div id="show_alert" class="mt-1" style=""></div>
                                <form class="form form-horizontal" role="form" name="addPurchaseOrder" id="addPurchaseOrder" method="post" action="/deliveryschedule/add" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <p class="blue-grey"><span class="red">#</span><em>To Add Delivery Schedule Please Select the Purchase Order</em></p>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Purchase Order<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control select2" autocomplete="off" style="width:100%;" id="purchaseOrder" name="purchaseOrder" title="Please select purchase order" onchange="getPurchaseOrder(this.value)">
                                                        <option value="">Select Purchase Order</option>
                                                        @foreach($purchase as $type)
                                                        <option value="{{ $type->po_id }}">{{ $type->po_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="card collapse-icon left accordion-icon-rotate" style="-webkit-box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important; -moz-box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important; box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important;">
                                        <div data-toggle="collapse" href="#bulkUpdate" aria-expanded="false" aria-controls="bulkUpdate" id="bulkUpdateHeading" class="card-header" style="background-color: #cfdee347;padding:12px 3px 6px 17px;">
                                                <a data-toggle="collapse" href="#bulkUpdate" aria-expanded="false" aria-controls="bulkUpdate" class="card-title lead collapsed"><h5 class="text-bold-600 d-inline-block" style="color: #688991 !important;">Purchase Order</h5></a>
                                        </div>
                                        <div id="bulkUpdate" role="tabpanel" aria-labelledby="bulkUpdateHeading" class="collapse" style="border:1px solid #cfdee347;">
                                            <div class="card-content">                  
                                                <div class="card-body">
                                                    <!-- <p class="blue-grey"><span class="red">#</span><em></em></p> -->
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-12">
                                                        <h4><b>PO Number : </b> <span id="poNumber" class="spanFont"></span></h4>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-12">
                                                            <h4><b>PO Issued On : </b><span id="issuedOn" class="spanFont"></span></h4>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-12">
                                                            <h4><b>Total Amount : </b><span id="totalAmt" class="spanFont" style="text-transform: capitalize;"></span></h4>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-12">
                                                            <h4><b>Vendor : </b><span id="vendors" class="spanFont"></span></h4>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-12">
                                                            <h4><b>Order Status : </b><span id="orderSts" class="spanFont"></span></h4>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-12">
                                                            <h4><b>Payment Status : </b><span id="paymentSts" class="spanFont"></span></h4>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "row">
                                        <div class="col-12">
                                            <div class="card collapse-icon left accordion-icon-rotate" style="-webkit-box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important; -moz-box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important; box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important;">
                                                <div data-toggle="collapse" href="#preview" aria-expanded="false"
                                                aria-controls="preview" id="previewHeading" class="card-header" style="background-color: #cfdee347;padding:12px 3px 6px 17px;">
                                                    <a data-toggle="collapse" href="#preview" aria-expanded="false"
                                                    aria-controls="preview" class="card-title lead collapsed"><h5 class="text-bold-600 d-inline-block" style="color: #688991 !important;">Previous Delivery Schedule History</h5></a>
                                                </div>
                                                <div id="preview" role="tabpanel" aria-labelledby="previewHeading" class="collapse" style="border:1px solid #cfdee347;">
                                                    <br/>
                                                    <div id="deliverySchedulePreview" >
                                                        <!-- <div><center><h4 class="ml-2 text-center"><b>Previous Delivery Schedule History</b></h4><center></div> -->
                                                        <div class="">
                                                            <div class="table-responsive col-md-12 mt-1">
                                                                <div class="bd-example">
                                                                    <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:20%;">Item</th>
                                                                            <th style="width:10%;">Quantity</th>
                                                                            <th style="width:20%;">Delivery Date</th>
                                                                            <th style="width:15%;">Delivery Mode</th>
                                                                            <th style="width:35%;">comments</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="deliveryScheduleDetails">
                                                                            <tr><td colspan="5" class="text-center">No Delivery Schedule Available</td></tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div id="addDeliverySchedule">
                                                
                                                <div id="addDeliveryScheduleContent"></div>
                                                {{-- <div class="row">
                                                    <div class="col-xl-6 col-lg-12">
                                                        <fieldset>
                                                            <h5>Expected Delivery <span class="mandatory">*</span>
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="text" id="expectedDelivery"  class="form-control datepicker delivClass" autocomplete="off" placeholder="Select Expected Delivery Date" name="expectedDelivery" title="Please Select Expected Delivery Date">
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <div class="bd-example">
                                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:10%;">Item<span class="mandatory">*</span></th>
                                                                    <th style="width:10%;">Total<br/>Quantity<span class="mandatory">*</span></th>
                                                                    <th style="width:15%;">Delivery<br/>Quantity<span class="mandatory">*</span></th>
                                                                    <th style="width:15%;">Delivery<br/>Mode<span class="mandatory">*</span></th>
                                                                    <th style="width:35%;">Comments<span class="mandatory">*</span></th>
                                                                    <th style="width:25%;">Location<span class="mandatory">*</span></th>
                                                                    <!-- <th style="width:10%;">Action</th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody id="delivDetails">
                                                            
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/> --}}
                                            </div>
                                    </div>
                                    <div class="col-12">
                                        <a href="/deliveryschedule" >
                                        <button type="button" class="btn btn-warning mr-1 float-right ml-2">
                                        <i class="ft-x"></i> Cancel
                                        </button>
                                        </a>
                                        <button type="" onclick="validateNow();return false;" id="submitBtn" class="btn btn-primary float-right" style="display:none">
                                        <i class="la la-check-square-o"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- horizontal grid end -->
        </section>
        <div id="toast-bottom-right" class="toast-container toast-bottom-right"><div class="toast toast-danger" aria-live="polite" style="display: none;"><div class="toast-message">I do not think that word means what you think it means.</div></div></div>
    </div>
</div>

<script>
    $(document).ready(function() {
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
    });
    let totalQty = 0;
    let rowCount = 0;
    let length = 0;
    function getPurchaseOrder(val){
        // val = $('#purchaseOrder').val()
        if (val != '') {
            $("#poOrderDetails").html('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/getPurchaseorderByIdForDelivery') }}",
                method: 'post',
                data: {
                    id : val
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    console.log(data)
                    if(data.length>0){
                        $('#deliveryScheduleDetails').html('')
                        $('#poNumber').text(data[0]['po_number'])
                        $('#issuedOn').text(data[0]['po_issued_on'])
                        $('#vendors').text(data[0]['vendor_name'])
                        $('#totalAmt').text(data[0]['total_amount'])
                        $('#orderSts').text(data[0]['order_status'])
                        $('#paymentSts').text(data[0]['payment_status'])
                        // $('#itemTxt').text(data[0]['item_name'])
                        // $('#qtyTxt').text(data[0]['quantity'])
                        var details = '<div><h4 class="text-center"><b>Add Delivery Schedule</b></h4><br/>';
                        length = data.length;
                        rowCount = length;
                        for(i=0;i<data.length;i++)
                        {
                            j = 0;
                            arg = data[i]['item_id']+"@"+data[i]['item_name']+"@"+data[i]['quantity'];
                            console.log(arg)
                            details +='<div id="addDeliveryScheduleRow'+i+'"><div class="row" style="padding-left: 0.5rem !important;">\
                                            <div class="col-xl-4 col-lg-12">\
                                            <h4><b>Item : </b><input type="hidden" id="itemNames'+i+'" name="itemNames[]" value="'+data[i]['item_name']+'" ><span id="itemName'+i+'" class="spanFont" name="itemName'+i+'">'+data[i]['item_name']+'</span></h4>\
                                            </div>\
                                            <div class="col-xl-4 col-lg-12">\
                                                <h4><b>Quantity : </b><input type="hidden" id="quantityM'+i+'" name="quantityM[]" value="'+data[i]['quantity']+'" ><span id="quantityDis'+i+'" name="quantityDis'+i+'" class="spanFont">'+data[i]['quantity']+'</span></h4>\
                                            </div>\
                                        </div>\
                                        <br/>'
                            details +='<div class="row">\
                                            <div class="table-responsive">\
                                                <div class="bd-example pl-1 pr-1">\
                                                    <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%" >\
                                                    <thead style="background-color:#ebecd2">\
                                                        <tr>\
                                                            <th style="width:15%;">Delivery<br/>Date</th>\
                                                            <th style="width:15%;">Delivery<br/>Quantity</th>\
                                                            <th style="width:15%;">Delivery<br/>Mode</th>\
                                                            <th style="width:20%;">Location</th>\
                                                            <th style="width:30%;">Comments</th>\
                                                            <th style="width:10%;">Action</th>\
                                                        </tr>\
                                                    </thead>\
                                                    <tbody id="delivDetails'+i+'">\
                                                        <tr>\
                                                            <td><input type="hidden" id="item'+i+'" name="item[]" value="'+data[i]['item_id']+'">\
                                                            <input type="hidden" id="podId'+i+'" name="podId[]" value="'+data[i]['pod_id']+'">\
                                                            <input type="text" id="expectedDelivery'+i+'" onchange="addValidatingClass('+i+',this.value)" class="form-control datepicker delivClass'+i+'" autocomplete="off" placeholder="Select Expected Delivery Date" name="expectedDelivery[]" title="Please Select Expected Delivery Date"></td>\
                                                            <td><input type="number" id="deliverQty'+i+'" class="form-control delivClass'+i+' hideClass quantityTot'+i+'" min=0 autocomplete="off" placeholder="Enter Delivery Quantity" name="deliverQty[]" title="Please Enter Delivery Quantity" oninput="validateQty('+i+',this.value)" ></td>\
                                                            <td><input type="text" id="deliveryMode'+i+'" class="form-control delivClass'+i+' hideClass" autocomplete="off" placeholder="Enter Delivery Mode" name="deliveryMode[]" title="Please Enter Delivery mode" ></td>\
                                                            <td><select class="form-control delivClass'+i+' select2" autocomplete="off" style="width:100%;" id="dbranches'+i+'" name="dbranches[]" title="Please select locations">\
                                                            <option value="">Select Locations</option>@foreach($branch as $type)<option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>@endforeach</select></td>\
                                                            <td><input type="text" id="comments'+i+'" class="form-control delivClass'+i+' hideClass" name="comments[]" placeholder="Enter Comments"  title="Please Enter Comments"></td>\
                                                            <td><a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow('+i+',\''+arg+'\','+data[i]['pod_id']+');"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;\
                                                            <a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode,'+i+','+data[i]['item_id']+','+data[i]['pod_id']+');"><i class="ft-minus"></i></a></td>\
                                                            <input type="hidden" id="qtyMax'+i+'" class="qtyMax'+i+'" value=""><input type="hidden" id="hiddenPo_id'+i+'" name="hiddenPo_id[]" value="'+data[i]['pod_id']+'">\
                                                        </tr>\
                                                    </tbody>\
                                                    </table>\
                                                </div>\
                                            </div>\
                                        </div></div>\
                                        <br/>'
                            let itemName = data[i]['item_name'];
                            totalQty += data[i]['quantity'];
                            $('#item'+i).val(data[i]['item_id'])
                            getDeliverySchedule(data[i]['pod_id'],data[i]['item_id'],itemName,data[i]['quantity'],i)
                            iG = i;
                        }
                        details += '</div>'
                        $("#addDeliveryScheduleContent").html(details);
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
                        // $('#deliveryScheduleAdd').modal('show');
                    }
                    else{
                        $('#poNumber').text('')
                        $('#issuedOn').text('')
                        $('#vendors').text('')
                        $('#totalAmt').text('')
                        $('#orderSts').text('')
                        $('#paymentSts').text('')
                        $('#itemTxt').text('')
                        $('#qtyTxt').text('')
                        details+='<tr><td colspan="5" class="text-center">No Pending Purchase Order Available</td></tr>';
                        $("#poOrderDetails").html(details);
                        $('#addDeliverySchedule').hide();
                        swal("Delivery scheduled for all items")
                        $('#deliveryScheduleAdd').modal('hide');
                    }
                }
            });
            $('#submitBtn').show()
        }
        else{
            swal("Please Select Purchase Order")
        }
    }

    function getDeliverySchedule(po_id, item_id, item_name,qty,id)
    {
        $('#addDeliverySchedule').show();
        let qtyMax = 0;
        // alert(qty)
        $('#qtyMax'+id).val('')
        $('#ItemId').val('')
        $('#deliverQty').val('')
        $('#expectedDelivery').val('')
        $('#deliveryMode').val('')
        $('#comments').val('')
        $('#branches').val('')
        $('#qtyMax').val(qty)
        $("#deliverQty").attr('max',qty)
        flag = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getDeliverySchedule') }}",
            method: 'post',
            data: {
                item:item_id,
                po_id:po_id,
            },
            success: function(data){
                // var data = JSON.parse(result);
                console.log(data)
                var details = "";
                $('#deliverySchedulePreview').show();
                if(data.length>0){
                    flag = 0
                    for(j=0;j<data.length;j++)
                    {
                        details+='<tr><td>'+data[j]['item_name']+'</td>';
                        details+='<td style="text-align:right;">'+data[j]['delivery_qty']+'</td>';
                        details+='<td>'+data[j]['delivery_date']+'</td>';
                        details+='<td>'+data[j]['delivery_mode']+'</td>';
                        details+='<td>'+data[j]['comments']+'</td></tr>';
                        qtyMax += data[j]['delivery_qty'];
                    }
                    if(qtyMax>0){
                        qtyBal = qty - qtyMax;
                        $('#qtyMax'+id).val(qtyBal)
                        $("#deliverQty"+id).attr('max',qtyBal)
                        if(qtyBal == 0){
                            $('#addDeliveryScheduleRow'+id).remove();
                            // $('#')
                        }
                    }
                    else{
                        $('#qtyMax'+id).val(qty)
                        $("#deliverQty"+id).attr('max',qty)
                        if(qty == 0){
                            $('#addDeliveryScheduleRow'+id).remove();
                        }
                    }
                }
                else{
                    flag = 1;
                    details+='<tr><td colspan="5" class="text-center">No Delivery Schedule Available for '+item_name+'</td></tr>';
                    $('#addDeliverySchedule').show();
                    $('#qtyMax'+id).val(qty)
                    $("#deliverQty"+id).attr('max',qty)
                }
                // if(flag){
                //     $("#deliveryScheduleDetails").html(details);
                // }
                // else{
                    $("#deliveryScheduleDetails").append(details);
                // }
            }

        });
        // let option='<option value="'+item_id+'">'+item_name+'</option>';
        // $("#ItemId").html(option);
        // $("#branches").select2({
        //     placeholder: "Select Branches",
        //     allowClear: true
        // });
        $("#hiddenPo_id"+id).val(po_id);
    }

    // let rowCount = length;
    // rowCount = length;
    function insRow(id,item,podId) {
        itemDt = item.split('@');
        itemID = itemDt[0];
        itemName = itemDt[1];
        qtyV = itemDt[2];
        qtymax = $('#qtyMax'+id).val();
        // rowCount++;
        rl = document.getElementById("delivDetails"+id).rows.length;
        var a = document.getElementById("delivDetails"+id).insertRow(rl);
        a.setAttribute("style", "display:none;");
        // a.setAttribute("class", "data");
        var g = a.insertCell(0);
        var b = a.insertCell(1);
        var d = a.insertCell(2);
        var f = a.insertCell(3);
        var c = a.insertCell(4);
        var h = a.insertCell(5);
        // var e = a.insertCell(6);
        rl = document.getElementById("delivDetails"+id).rows.length - 1;
        g.innerHTML='<input type="hidden" id="item'+rowCount+'" name="item[]" value="'+itemID+'">\
                    <input type="hidden" id="itemNames'+rowCount+'" name="itemNames[]" value="'+itemName+'">\
                    <input type="hidden" id="quantityM'+rowCount+'" name="quantityM[]" value="'+qtyV+'">\
                    <input type="hidden" id="podId'+rowCount+'" name="podId[]" value="'+podId+'">\
                    <input type="text" id="expectedDelivery'+rowCount+'" onchange="addValidatingClass('+rowCount+',this.value)" class="form-control datepicker delivClass'+rowCount+'" autocomplete="off" placeholder="Select Expected Delivery Date" name="expectedDelivery[]" title="Please Select Expected Delivery Date">';
        b.innerHTML = '<input type="number" id="deliverQty' + rowCount + '" class="form-control delivClass'+rowCount+' quantityTot'+id+'" min=0 autocomplete="off" placeholder="Enter Delivery Quantity" name="deliverQty[]" title="Please Delivery Quantity" oninput="validateQty('+rowCount+',this.value)" >';
        d.innerHTML = '<input type="text" id="deliveryMode' + rowCount + '" class="form-control delivClass'+rowCount+'" autocomplete="off" placeholder="Enter Delivery Mode" name="deliveryMode[]" title="Please Delivery mode" >';
        f.innerHTML = '<select class="form-control delivClass'+rowCount+' select2" autocomplete="off" style="width:100%;" id="dbranches' + rowCount + '" name="dbranches[]" title="Please select locations">\
                            <option value="">Select Locations</option>@foreach($branch as $type)<option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>@endforeach</select>';
        c.innerHTML = '<input type="text" id="comments' + rowCount + '" class="form-control delivClass'+rowCount+'" name="comments[]" placeholder="Enter Comments"  title="Please Enter Comments">';
        h.innerHTML = '<input type="hidden" id="qtyMax'+rowCount+'" class="qtyMax'+id+'" value="'+qtymax+'">\
                      <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow(' + id + ','+item+','+podId+');"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode,' + id + ');"><i class="ft-minus"></i></a>';
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
        rowCount++;
    }

    function removeRow(el,id,item,podId) {
        $(el).parent().fadeOut("slow", function () {
            $(el).parent().remove();
            rowCount = rowCount-1;
            rl = document.getElementById("delivDetails"+id).rows.length;
            if (rl == 0) {
                insRow(id,item,podId);
            }
        });
    }

    duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addPurchaseOrder'
        });
        // console.log(length)
        for(k=0;k<length;k++){
            sum = 0;
            $('.quantityTot'+k).each(function() {
                sum += Number($(this).val());
            });
            // console.log(sum)
            if(!isNaN(sum)){
                max = parseInt($('.qtyMax'+k).val());
                console.log(max+'max')
                if(sum>max){
                    duplicateName = false;
                    break; 
                }
                else{
                    duplicateName = true;
                }
            }
        }
        // alert(duplicateName)
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addPurchaseOrder').submit();
            }
            else{
                msg = "Entered Quantity should not exceed Delivery Quantity.Please Check!"
                // $('#show_alert').html(msg).delay(3000).fadeOut();
                // $('#show_alert').css("display", "block");
                swal(msg)
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

    function validateQty(id,val){
        // alert(val)
        max = parseInt($('#qtyMax'+id).val())
        val = parseInt(val)
        if(val>max){
            $('#deliverQty'+id).val('');
            msg = "Entered delivery quantity is greater than total quantity"
            $("#showAlertIndex").text(msg);
            $('#showAlertdiv').show();
            duplicateName = false;
            $('#deliverQty' + id).focus();
            $('#deliverQty' + id).css('background-color', 'rgb(255, 255, 153)')
            $('#showAlertdiv').delay(3000).fadeOut();
        }
    }

    function addValidatingClass(id,val){
        if(val){
            $('.delivClass'+id).addClass('isRequired');
        }
        else{
            $('.delivClass'+id).removeClass('isRequired');
        }
    }

</script>

@endsection