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
<script src="{{ asset('assets/js/ckeditor/ckeditor.js')}}"></script>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Delivery Schedule</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
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
                        <div class="card-header">
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
                                    <div class = "row">
                                        <div class="col-12">
                                            <br/>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-12">
                                                    <h4><b>PO Number : </b> <span id="poNumber" class="spanFont"></span></h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-12">
                                                    <h4><b>PO Issued On : </b><span id="issuedOn" class="spanFont"></span></h4>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-12">
                                                    <h4><b>Vendors : </b><span id="vendors" class="spanFont"></span></h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-12">
                                                    <h4><b>Total Amount : </b><span id="totalAmt" class="spanFont" style="text-transform: capitalize;"></span></h4>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-12">
                                                    <h4><b>Order Status : </b><span id="orderSts" class="spanFont"></span></h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-12">
                                                    <h4><b>Payment Status : </b><span id="paymentSts" class="spanFont"></span></h4>
                                                </div>
                                            </div>
                                            <br/>
                                            <hr>
                                            <div>
                                                <center><h4><b>Purchase Order Details</b></h4><center>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <div class="bd-example">
                                                        <table class="table table-striped table-bordered table-condensed table-responsive-lg">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:30%;">Item<span class="mandatory">*</span></th>
                                                                <th style="width:25%;">Unit<span class="mandatory">*</span></th>
                                                                <th style="width:25%;">Quantity<span class="mandatory">*</span></th>
                                                                <th style="width:25%;">Unit Price<span class="mandatory">*</span></th>
                                                                <th style="width:20%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="poOrderDetails">
                                                           
                                                        </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/deliveryschedule">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                        </a>
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
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

            <!--Start Delievery schedule Modal -->
            <div class="modal fade" id="deliveryScheduleAdd" tabindex="-1" role="dialog" aria-labelledby="deliveryScheduleAddLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deliveryScheduleAddLabel"> Delivery Schedule</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showModalAlertdiv" role="alert" style="display:none"><span id="showModalAlertIndex"></span>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
                    <div id="show_modal_alert" class="mt-1" style=""></div>
                    <div id="deliverySchedulePreview" style="display:none;">
                        <div><center><h4 class="ml-2 text-center"><b>Previous Delivery Schedule Details</b></h4><center></div>
                        <div class="row">
                            <div class="table-responsive col-md-12">
                                <div class="bd-example">
                                    <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%;margin-padding:1%;">
                                    <thead>
                                        <tr>
                                            <th style="width:25%;">Item</th>
                                            <th style="width:20%;">Quantity</th>
                                            <th style="width:25%;">Delivery Date</th>
                                            <th style="width:25%;">Delivery Mode</th>
                                            <th style="width:30%;">comments</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deliveryScheduleDetails">
                                        
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <h3>Add Delivery Schedule</h3><br/>
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>Item Name<span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                <select class="form-control select2 isRequired" autocomplete="off" style="width:100%;" id="ItemId" name="ItemId">
                                </select>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>Delivery Quantity<span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                    <input type="number" id="deliverQty" class="form-control isRequired" min=0 autocomplete="off" placeholder="Enter Delivery Quantity" name="deliverQty" title="Please Delivery Quantity" >
                                </div>
                                <input type="hidden" id="qtyMax" value="">
                                <input type="hidden" id="hiddenPo_id">
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>Expected Delivery <span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                    <input type="text" id="expectedDelivery"  class="form-control datepicker isRequired" autocomplete="off" placeholder="Select Expected Delivery Date" name="expectedDelivery" title="Please Select Expected Delivery Date">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>Delivery Mode<span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                    <input type="text" id="deliveryMode" class="form-control isRequired" autocomplete="off" placeholder="Enter Delivery Mode" name="deliveryMode" title="Please Delivery mode" >
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>Comments <span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                    <textarea id="comments" class="form-control isRequired" name="comments" placeholder="Enter Comments"  title="Please Enter Comments"></textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addDeliverySchedule();">Save</button>
                </div>
                </div>
            </div>
            </div>
        </section>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".select2").select2();
        $(".select2").select2({
            tags: true
        });

        $("#itemName").select2({
            placeholder: "Select Item",
            allowClear: true
        });
        $('.datepicker').datepicker({
			// format: 'dd-M-yyyy',
            autoclose: true,
            format: 'dd-M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            // startDate:'today',
            todayHighlight: true,
            clearBtn: true,
        });
    });
    duplicateName = true;

    function getPurchaseOrder(val){
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
                    if(data.length>0){
                        $('#poNumber').text(data[0]['po_number'])
                        $('#issuedOn').text(data[0]['po_issued_on'])
                        $('#vendors').text(data[0]['vendor_name'])
                        $('#totalAmt').text(data[0]['total_amount'])
                        $('#orderSts').text(data[0]['order_status'])
                        $('#paymentSts').text(data[0]['payment_status'])
                        var details = '';
                        for(i=0;i<data.length;i++)
                        {
                            let itemName = "'"+data[i]['item_name']+"'";
                            details+='<tr><td><input type="hidden" id="podId" name="podId[]" value="'+data[i]['pod_id']+'">\
                                        <select id="item'+i+'" name="item[]" disabled class="isRequired itemName form-control datas"  title="Please select item"><option value='+data[i]['item_id']+'>'+data[i]['item_name']+'</option></select></td>';
                            details+='<td><input type="hidden" id="unitId" name="unitId[]" value="'+data[i]['uom']+'">\
                                        <input type="text" id="unit'+i+'" name="unit[]" class="form-control" placeholder="unit" title="Please enter the unit" value="'+data[i]['unit_name']+'"/></td>';
                            details+='<td><input type="number" readonly id="qty'+i+'" name="qty[]" class="form-control isRequired" placeholder="Qty" title="Please enter the qty" value="'+data[i]['quantity']+'" /></td>';
                            details+='<td><input type="number" class="form-control isRequired linetot" id="unitPrice'+i+'" name="unitPrice[]" placeholder="Unit Price" title="Please enter Unit Price" value="'+data[i]['unit_price']+'"/></td>';
                            // details+='<td></td>'
                            details+='<td><button type="button" class="btn btn-primary" onclick="getDeliverySchedule('+data[i]['pod_id']+','+data[i]['item_id']+','+itemName+','+data[i]['quantity']+')" title="Add Delivery Schedule" data-placement="left" data-toggle="modal" data-target="#deliveryScheduleAdd"><i class="ft-calendar"></i></button></td>'
                            details+='</tr>';
                            $('#item'+i).val(data[i]['item_id'])
                        }
                        $("#poOrderDetails").html(details);
                    }
                    else{
                        details+='<tr><td colspan="5" class="text-center">No Pending Purchase Order Available</td></tr>';
                        $("#poOrderDetails").html(details);
                    }
                }
            });
        }
    }

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addPurchaseOrder'
        });
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addPurchaseOrder').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();expected_date_of_delivery
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

    function checkNameValidation(tableName, fieldName, obj, fnct, msg) {
        // alert(fnct)
        checkValue = document.getElementById(obj).value;
        // alert(checkValue)
        if (checkValue != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/checkNameValidation') }}",
                method: 'post',
                data: {
                    tableName: tableName,
                    fieldName: fieldName,
                    value: checkValue,
                },
                success: function(result) {
                    // console.log(result)
                    if (result > 0) {
                        $("#showAlertIndex").text(msg);
                        $('#showAlertdiv').show();
                        duplicateName = false;
                        document.getElementById(obj).value = "";
                        $('#' + obj).focus();
                        $('#' + obj).css('background-color', 'rgb(255, 255, 153)')
                        $('#showAlertdiv').delay(3000).fadeOut();
                    } else {
                        duplicateName = true;
                    }
                }
            });
        }
    }

    let qtyMax = 0;
    function getDeliverySchedule(po_id, item_id, item_name,qty)
    {
        $('#qtyMax').val(qty)
        $("#deliverQty").attr('max',qty)
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
                    for(j=0;j<data.length;j++)
                    {
                        details+='<tr><td>'+data[j]['item_name']+'</td>';
                        details+='<td>'+data[j]['delivery_qty']+'</td>';
                        details+='<td>'+data[j]['delivery_date']+'</td>';
                        details+='<td>'+data[j]['delivery_mode']+'</td>';
                        details+='<td>'+data[j]['comments']+'</td></tr>';
                        qtyMax += data[j]['delivery_qty'];
                    }
                    if(qtyMax>0){
                        qtyBal = qty - qtyMax;
                        $('#qtyMax').val(qtyBal)
                        $("#deliverQty").attr('max',qtyBal)
                    }
                    else{
                        $('#qtyMax').val(qty)
                        $("#deliverQty").attr('max',qty)
                    }
                }
                else{
                    details+='<tr><td colspan="5" class="text-center">No Delivery Schedule Available</td></tr>';
                }
                $("#deliveryScheduleDetails").html(details);
            }

        });
        let option='<option value="'+item_id+'">'+item_name+'</option>';
        console.log(option);
        $("#ItemId").html(option);
        $("#hiddenPo_id").val(po_id);
    }

    function addDeliverySchedule()
    {
        let item = $("#ItemId").val();
        let po_id = $("#hiddenPo_id").val();
        let deliverQty = $("#deliverQty").val();
        let expectedDelivery = $("#expectedDelivery").val();
        let deliveryMode = $("#deliveryMode").val();
        let comments = $("#comments").val();
        let po = $('#purchaseOrder').val();
        console.log($('#qtyMax').val())
        console.log(deliverQty)
        if(item && deliverQty && expectedDelivery && deliveryMode && comments){
            if(parseInt(deliverQty) <= parseInt($('#qtyMax').val())){
                if(parseInt(deliverQty) == parseInt($('#qtyMax').val())){
                    status = "scheduled";
                }
                else{
                    status = "";
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/saveDeliverySchedule') }}",
                    method: 'post',
                    data: {
                        item:item,
                        po_id:po_id,
                        deliverQty:deliverQty,
                        expectedDelivery:expectedDelivery,
                        deliveryMode:deliveryMode,
                        comments:comments,
                        status:status
                    },
                    success: function(result){
                        console.log(result)
                        if(result>0)
                        {
                            swal("Delivery Schedule Added Successfully")
                            $("#deliveryScheduleAdd").modal('hide');
                            getPurchaseOrder(po);
                        }
                        
                    }

                });
            }
            else{
                swal("Entered quantity exceeds purchase order quantity")
            }
        }
        else{
            swal("Please fill all the fields")
        }
    }
</script>
@endsection