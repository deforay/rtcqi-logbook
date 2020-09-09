<!-- 
    Author             : Sudarmathi M
    Created Date       : 17 July 2020
    Description        : Delivery Schedule view screen
    Last Modified Date :   
    Last Modified Name :
-->

@extends('layouts.main')

@section('content')

{{-- <style>
td {
    padding-left: 0.50rem !important;
    padding-right: 0.50rem !important;
}
</style> --}}
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Procurement
                        </li>
                        <li class="breadcrumb-item"><a href="/deliveryschedule/">Delivery Schedule</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    
        <div class="content-header-right col-md-4 col-12 ">
            <div class="dropdown float-md-right">
            <?php
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['add']) && ($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['add'] == "allow")){ ?>
                    <a href="/deliveryschedule/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="ft-plus icon-left"></i> Add Delivery Schedule</b></a>
            <?php } ?>
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
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"></h4>
                            <h3 class="content-header-title mb-0">Delivery Schedule</h3>
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
                            <div class="card-body card-dashboard">
                                <p class="card-text"></p>
                                <?php if(session('loginType')=='users'){ ?>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Purchase Order
                                            </h5>
                                            <div class="form-group">
                                            <select class="form-control" autocomplete="off" style="width:100%;" id="purchaseOrder" name="purchaseOrder"  onchange="getAllDeliverySchedule(this.value)">
                                            <option value=''>Select Purchase Order</option>
                                                @foreach ($poList as $po)
                                                <option value="{{$po->po_id}}" >{{$po->po_number}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                    {{-- <div class="col-xl-4 col-lg-12" style="margin-top: 1.90rem !important">
                                        <a href="#" onclick="getPurchaseOrder()" class="btn btn-outline-info box-shadow-1 px-2" id="btnGroupDrop1"><b><i class="ft-plus icon-left"></i> Update Delivery Schedule</b></a>
                                    </div> --}}
                                </div>
                                <?php }?>
                                <br/>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="deliveryScheduleList" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:15%;">Purchase Order</th>
                                                <th style="width:10%;">Item Name</th>
                                                <th style="width:10%;">Quantity</th>
                                                <th style="width:15%;">Estimated Delivery Date</th>
                                                <th style="width:10%;">Delivery Mode</th>
                                                <th style="width:10%;">Location</th>
                                                <th style="width:20%;">Comments</th>
                                                <th style="width:10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!--Start Delievery schedule Modal -->
<div class="modal fade" id="deliveryScheduleAdd" tabindex="-1" role="dialog" aria-labelledby="deliveryScheduleAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width:1000px;">
        <div class="modal-content" style="margin-top: 2%;margin-left:2%;border: solid;margin-right:2%;">
            <div class="card" style="margin-top: 2%;margin-left:2%;border: solid;margin-right:2%;">
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
                    <div class="card collapse-icon left accordion-icon-rotate" style="-webkit-box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important; -moz-box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important; box-shadow: 0px 1px 6px -2px rgb(121, 121, 121) !important;">
                        <div data-toggle="collapse" href="#bulkUpdate" aria-expanded="false"
                        aria-controls="bulkUpdate" id="bulkUpdateHeading" class="card-header" style="background-color: #cfdee347;padding:12px 3px 6px 17px;">
                            <a data-toggle="collapse" href="#bulkUpdate" aria-expanded="false"
                            aria-controls="bulkUpdate" class="card-title lead collapsed"><h5 class="text-bold-600 d-inline-block" style="color: #688991 !important;">Purchase Order</h5></a>
                        </div>
                        <div id="bulkUpdate" role="tabpanel" aria-labelledby="bulkUpdateHeading" class="collapse" style="border:1px solid #cfdee347;">
                            <div class="card-content">                  
                                <div class="card-body">
                                    <!-- <p class="blue-grey"><span class="red">#</span><em></em></p> -->
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
                                    <div id="deliverySchedulePreview" style="display:none;">
                                        <!-- <div><center><h4 class="ml-2 text-center"><b>Previous Delivery Schedule History</b></h4><center></div> -->
                                        <div class="row">
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
                                                        
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <!-- <form class="form form-horizontal" role="form" name="addDeliverySchedule" id="addDeliverySchedule" method="post" action="/deliveryschedule/addDeliveryScheduleByDate" autocomplete="off" onsubmit="validateNow();return false;">
                        @csrf -->
                        <div id="addDeliverySchedule">
                            <h4 class="text-center">Add Delivery Schedule</h4><br/>
                            
                            <!-- <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <h4><b>Item : </b><span id="itemTxt" class="spanFont"></span></h4>
                                </div>
                                <div class="col-xl-6 col-lg-12">
                                    <h4><b>Quantity: </b><span id="qtyTxt" class="spanFont"></span></h4>
                                </div>
                            </div>
                            <br/> -->
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <fieldset>
                                        <h5>Expected Delivery <span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <input type="text" id="expectedDelivery"  class="form-control datepicker isRequired delivClass" autocomplete="off" placeholder="Select Expected Delivery Date" name="expectedDelivery" title="Please Select Expected Delivery Date">
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
                                            <!-- <tr>
                                                <td><input type="number" id="deliverQty0" class="form-control isRequired hideClass" min=0 autocomplete="off" placeholder="Enter Delivery Quantity" name="deliverQty[]" title="Please Delivery Quantity" ></td>
                                                <td><input type="text" id="deliveryMode0" class="form-control isRequired hideClass" autocomplete="off" placeholder="Enter Delivery Mode" name="deliveryMode[]" title="Please Delivery mode" ></td>
                                                <td><input type="text" id="comments0" class="form-control isRequired hideClass" name="comments[]" placeholder="Enter Comments"  title="Please Enter Comments"></td>
                                                <td>
                                                    <select class="form-control isRequired hideClass select2" autocomplete="off" style="width:100%;" id="branches0" name="branches[]" title="Please select locations">
                                                        <option value="">Select Locations</option>
                                                        @foreach($branch as $type)
                                                            <option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a></td>
                                            </tr> -->
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="modal-footer" style="border-top: 0px">
                                <button type="button" class="btn btn-success" onclick="addDeliverySchedule();">Save and Next</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
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
        $.blockUI();
        getAllDeliverySchedule();
        $.unblockUI();
    });
    function getAllDeliverySchedule(val = '')
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#deliveryScheduleList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: true,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllDeliverySchedule") }}',
                type: 'POST',
                data : {
                    poId : val,
                }
            },
            columns: [
                    { data: 'po_number', name: 'po_number'},
                    { data: 'item_name', name: 'item_name',className:'firstcaps'},
                    { data: 'delivery_qty', name: 'delivery_qty'},
                    { data: 'expected_date_of_delivery', name: 'expected_date_of_delivery'},
                    { data: 'delivery_mode', name: 'delivery_mode'},
                    { data: 'branch_name', name: 'branch_name' },
                    { data: 'comments', name: 'comments' },
                    {data: 'action', name: 'action', orderable: false},
                ],
                columnDefs: [
                {
                        "targets": 0,
                        "className": "text-right",
                },
                {
                        "targets": 2,
                        "className": "text-right",
                },
                ],  
            order: [[0, 'desc']]
        });
    }

    let totalQty = 0;
    let length = 0;

    function getPurchaseOrder(){
        val = encodeURIComponent(window.btoa($('#purchaseOrder').val()));
        if (val != '') {
            $("#poOrderDetails").html('');
            
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $.ajax({
            //     url: "{{ url('/getDeliveryScheduleByPurchaseOrder') }}",
            //     method: 'post',
            //     data: {
            //         id : val
            //     },
            //     success: function(result) {
                    window.location.href ="/getDeliveryScheduleByPurchaseOrder/"+val;
            //     }
            // });
        }
        else{
            swal("Please Select Purchase Order")
        }
    }
    function getPurchaseOrder(){
        val = $('#purchaseOrder').val()
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
                        $('#poNumber').text(data[0]['po_number'])
                        $('#issuedOn').text(data[0]['po_issued_on'])
                        $('#vendors').text(data[0]['vendor_name'])
                        $('#totalAmt').text(data[0]['total_amount'])
                        $('#orderSts').text(data[0]['order_status'])
                        $('#paymentSts').text(data[0]['payment_status'])
                        // $('#itemTxt').text(data[0]['item_name'])
                        // $('#qtyTxt').text(data[0]['quantity'])
                        var details = '';
                        length = data.length;
                        for(i=0;i<data.length;i++)
                        {
                            let itemName = data[i]['item_name'];
                            details+='<tr id="addDeliveryScheduleRow'+i+'"><td><input type="hidden" id="podId'+i+'" name="podId[]" value="'+data[i]['pod_id']+'">\
                                        <span>'+data[i]['item_name']+'</span>\
                                        <input type="hidden" id="item'+i+'" name="item[]" value="'+data[i]['item_id']+'">'
                            // details+='<td><input type="hidden" id="unitId" name="unitId[]" value="'+data[i]['uom']+'">\
                                        // <input type="text" id="unit'+i+'" name="unit[]" class="form-control" placeholder="unit" title="Please enter the unit" value="'+data[i]['unit_name']+'"/></td>';
                            details+='<td><input type="hidden" readonly id="qty'+i+'" name="qty[]" class="form-control isRequired delivClass" placeholder="Qty" title="Please enter the qty" value="'+data[i]['quantity']+'" />'+data[i]['quantity']+'</td>';
                            details+='<td><input type="number" id="deliverQty'+i+'" class="form-control isRequired delivClass hideClass" min=0 autocomplete="off" placeholder="Enter Delivery Quantity" name="deliverQty[]" title="Please Enter Delivery Quantity" oninput="validateQty('+i+',this.value)" ></td>';
                            details+='<td><input type="text" id="deliveryMode'+i+'" class="form-control isRequired delivClass hideClass" autocomplete="off" placeholder="Enter Delivery Mode" name="deliveryMode[]" title="Please Enter Delivery mode" ></td>'
                            details+='<td><input type="text" id="comments'+i+'" class="form-control isRequired delivClass hideClass" name="comments[]" placeholder="Enter Comments"  title="Please Enter Comments"></td>'
                            details+='<td><select class="form-control isRequired delivClass select2" autocomplete="off" style="width:100%;" id="dbranches'+i+'" name="dbranches[]" title="Please select locations">\
                                        <option value="">Select Locations</option>@foreach($branch as $type)<option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>@endforeach</select></td>'
                            // details+='<td><input type="number" class="form-control isRequired linetot" id="unitPrice'+i+'" name="unitPrice[]" placeholder="Unit Price" title="Please enter Unit Price" value="'+data[i]['unit_price']+'"/></td>';
                            // details+='<td></td>'
                            // details+='<td><button type="button" class="btn btn-primary" onclick="getDeliverySchedule('+data[i]['pod_id']+','+data[i]['item_id']+','+itemName+','+data[i]['quantity']+')" title="Add Delivery Schedule" data-placement="left" data-toggle="modal" data-target="#deliveryScheduleAdd"><i class="ft-calendar"></i></button></td>'
                            details+='<input type="hidden" id="qtyMax'+i+'" value=""><input type="hidden" id="hiddenPo_id'+i+'" name="hiddenPo_id[]" value="'+data[i]['pod_id']+'">'
                            details+='</tr>';
                            totalQty += data[i]['quantity'];
                            $('#item'+i).val(data[i]['item_id'])
                            getDeliverySchedule(data[i]['pod_id'],data[i]['item_id'],itemName,data[i]['quantity'],i)
                        }
                        $("#delivDetails").html(details);
                        $(".select2").select2();
                        $('#deliveryScheduleAdd').modal('show');
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
                        details+='<td>'+data[j]['delivery_qty']+'</td>';
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

    function validateQty(id,val){
        // alert(val)
        max = parseInt($('#qtyMax'+id).val())
        val = parseInt(val)
        if(val>max){
            $('#deliverQty'+id).val('');
            msg = "Entered delivery quantity is greater than total quantity"
            $("#showModalAlertIndex").text(msg);
            $('#showModalAlertdiv').show();
            duplicateName = false;
            $('#deliverQty' + id).focus();
            $('#deliverQty' + id).css('background-color', 'rgb(255, 255, 153)')
            $('#showModalAlertdiv').delay(3000).fadeOut();
        }
    }

    function addDeliverySchedule(){
        let podId = $("input[name='podId[]']").map(function(){return $(this).val();}).get();
        let expectedDelivery = $("#expectedDelivery").val();
        let po = $('#purchaseOrder').val();
        let deliverQty = $("input[name='deliverQty[]']").map(function(){return $(this).val();}).get();
        let deliveryMode = $("input[name='deliveryMode[]']").map(function(){return $(this).val();}).get();
        let comments = $("input[name='comments[]']").map(function(){return $(this).val();}).get();
        let dbranches = $("select[name='dbranches[]']").map(function(){return $(this).val();}).get();
        let item = $("input[name='item[]']").map(function(){return $(this).val();}).get();
        console.log(dbranches)
        // if($('.isRequired').val())
        var reqlength = $('.delivClass').length;
        console.log(reqlength);
        var value = $('.delivClass').filter(function () {
            return this.value != '';
        });

        if (value.length>=0 && (value.length !== reqlength)) {
            swal('Please fill out all required fields.');
        }else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/saveDeliveryScheduleByDate') }}",
                method: 'post',
                data: {
                    item:item,
                    podId:podId,
                    deliverQty:deliverQty,
                    expectedDelivery:expectedDelivery,
                    deliveryMode:deliveryMode,
                    comments:comments,
                    // status:status,
                    branches:dbranches,
                    po:po,
                },
                success: function(result){
                    console.log(result)
                    if(result>0)
                    {
                        swal("Delivery Schedule Added Successfully")
                        $('#deliveryScheduleDetails').html('')
                        getPurchaseOrder()
                        getAllDeliverySchedule(po)
                        // $('.close').trigger('click')
                        // $("#deliveryScheduleAdd").modal('hide');
                        // getPurchaseOrder(po);
                    }
                    
                }

            });
        }
    }

    rowCount = 0;
    function insRow() {
        rowCount++;
        rl = document.getElementById("delivDetails").rows.length;
        var a = document.getElementById("delivDetails").insertRow(rl);
        a.setAttribute("style", "display:none;");
        // a.setAttribute("class", "data");
        var b = a.insertCell(0);
        var d = a.insertCell(1);
        var c = a.insertCell(2);
        var f = a.insertCell(3);
        var h = a.insertCell(4);
        // var g = a.insertCell(5);
        // var e = a.insertCell(6);
        rl = document.getElementById("delivDetails").rows.length - 1;
        b.innerHTML = '<input type="number" id="deliverQty' + rowCount + '" class="form-control isRequired" min=0 autocomplete="off" placeholder="Enter Delivery Quantity" name="deliverQty[]" title="Please Delivery Quantity" >';
        d.innerHTML = '<input type="text" id="deliveryMode' + rowCount + '" class="form-control isRequired" autocomplete="off" placeholder="Enter Delivery Mode" name="deliveryMode[]" title="Please Delivery mode" >';
        c.innerHTML = '<input type="text" id="comments' + rowCount + '" class="form-control isRequired" name="comments[]" placeholder="Enter Comments"  title="Please Enter Comments">';
        f.innerHTML = '<select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branches' + rowCount + '" name="branches[]" title="Please select locations">\
                            <option value="">Select Locations</option>@foreach($branch as $type)<option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>@endforeach</select>';
        h.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
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
            rl = document.getElementById("delivDetails").rows.length;
            if (rl == 0) {
                insRow();
            }
        });
    }
  </script>
@endsection