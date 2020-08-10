
<?php
use App\Service\CommonService;
$common = new CommonService();
$deliveryDate = $common->humanDateFormat($result[0]->expected_date_of_delivery);
?>
<style>
td{
    padding-left: 1rem !important;
    padding-right: 1rem !important;
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
<section class="horizontal-grid" id="horizontal-grid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 3%;margin-left:3%;border: solid;margin-right:3%;">
                <div class="card-header">
                    <center><h2 class="form-section" style="font-weight: 600;">DELIVERY SCHEDULE DETAILS</h2></center><hr>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div id="show_alert"  class="mt-1" style=""></div>
                        <form class="form form-horizontal" role="form" name="updateItemReceive" id="updateItemReceive" method="post" action="/itemreceive/updateItemReceive/{{$deliveryId}}" autocomplete="off" onsubmit="validateNow();return false;">
                        @csrf
                        <!-- <div>
                            <center><h4><b>PURCHASE ORDER DETAILS</b></h4><center>
                        </div> -->
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>PO Number : </b> <span id="rfqNumber" class="spanFont">{{$result[0]->po_number }} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>PO Issued On : </b><span id="quoteNumber" class="spanFont">{{$result[0]->po_issued_on}}</span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Vendors : </b><span id="invitedDate" class="spanFont">{{$result[0]->vendor_name}}</span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Total Amount : </b><span id="quoteSts" class="spanFont" style="text-transform: capitalize;">{{$result[0]->total_amount}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Order Status : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$result[0]->order_status}} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Payment Status : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->payment_status}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Item Name : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$result[0]->item_name}} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Delivery Quantity : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->delivery_qty}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Expected Delivery : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$deliveryDate}} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Delivery Mode : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->delivery_mode}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="table-responsive">
                                <div class="bd-example">
                                    <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:15%;">Expiry Date<span class="mandatory">*</span></th>
                                            <th style="width:15%;">Service Date<span class="mandatory">*</span></th>
                                            <th style="width:12%;">Received Qty<span class="mandatory">*</span></th>
                                            <th style="width:12%;">Non Confromity Qty<span class="mandatory">*</span></th>
                                            <th style="width:26%;">Locations<span class="mandatory">*</span></th>
                                            <th style="width:20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemDetails">
                                        <tr>
                                            <td class="pr-1 pl-1">
                                                <input type="text" id="expiryDate0" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter expiry date" name="expiryDate[]" title="Please enter expiry date">
                                            </td>
                                            <td class="pr-1 pl-1">
                                                <input type="text" id="serviceDate0" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter service date" name="serviceDate[]" title="Please enter service date">
                                            </td>
                                            <td class="pr-1 pl-1">
                                                <input type="number" value="0" id="receivedQty0" name="receivedQty[]" min="0" onchange="changeScheduleStatus(this.value,this.id)" class="form-control isRequired receivedQty" placeholder="Enter Received Qty" title="Please enter the received qty" value="" />
                                            </td >
                                            <td class="pr-1 pl-1">
                                                <input type="number" value="0" id="expiryQty0" name="expiryQty[]" min="0" onchange="changeScheduleStatus(this.value,this.id)" class="form-control isRequired damagedQty" placeholder="Enter Non Confromity Qty" title="Please enter the Non Confromity qty" value="" />
                                            </td>
                                            <td class="pr-1 pl-1">
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
                                </div>
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
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Short Description <span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <input type="text" id="description" class="form-control typeahead-bloodhound" name="description" placeholder="Enter the description about non conformity quantity"  title="Please Enter Description">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <br/>
                        <input type="hidden" value="{{$deliveryId}}" id="deliveryId" name="deliveryId" >
                        <input type="hidden" value="{{$result[0]->pod_id}}" id="pod_id" name="pod_id" >
                        </form>
                        <div class="form-actions right" style="margin-bottom: 5%;">
                            <button type="button" class="btn btn-warning mr-1 float-right ml-2" data-dismiss = "modal">
                            <i class="ft-x"></i> Close
                            </button>
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
                comments = $('#description').val();
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
    $('#description').typeahead(null, {
        name: 'value',
        displayKey: 'value',
        source: autocompComments.ttAdapter(),
        limit:'Infinity'
    });
    $('.twitter-typeahead').css('display','block')
    $('.tt-menu').addClass('pl-1 pr-1')
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
    // receivedQty = $('#receivedQty').val();
    // damagedQty = $('#damagedQty').val();
    // if(damagedQty>0){
    //     $('#description').addClass('isRequired');
    // }
    // if(receivedQty){
    //     if(receivedQty>deliveryQty){
    //         $('#receivedQty').val('')
    //         swal("Entered Received Quantity cannot be greater than Delivery Quantity")
    //         return
    //     }
    //     if(damagedQty>deliveryQty){
    //         $('#damagedQty').val('')
    //         swal("Entered Non Confromity Quantity cannot be greater than Delivery Quantity")
    //         return
    //     }
    //     if(deliveryQty == receivedQty && (damagedQty=='' || damagedQty==0)){
    //         $('#status').val('Received')
    //         // $('#damagedQty').val(0);
    //     }
    //     else{
    //         $('#status').val('Non Conformity')
    //     }
    // }
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
    var b = a.insertCell(0);
    var d = a.insertCell(1);
    var c = a.insertCell(2);
    var f = a.insertCell(3);
    var g = a.insertCell(4);
    var e = a.insertCell(5);
    rl = document.getElementById("itemDetails").rows.length - 1;
    b.innerHTML = '<input type="text" id="expiryDate' + rowCount + '" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter expiry date" name="expiryDate[]" title="Please enter expiry date">';
    d.innerHTML = '<input type="text" id="serviceDate' + rowCount + '" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter service date" name="serviceDate[]" title="Please enter service date">';
    c.innerHTML = '<input type="number" value="0" id="receivedQty' + rowCount + '" name="receivedQty[]" onchange="changeScheduleStatus(this.value,this.id)" min="0" class="form-control receivedQty isRequired " placeholder="Enter Received Qty" title="Please enter the received qty" value="" />';
    f.innerHTML = '<input type="number" value="0" id="expiryQty' + rowCount + '" name="expiryQty[]" onchange="changeScheduleStatus(this.value,this.id)" min="0" class="form-control damagedQty isRequired " placeholder="Enter Non Confromity Qty" title="Please enter the Non Confromity qty" value="" />'
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
</script>