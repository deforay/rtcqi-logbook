<!-- 
    Author             : Sriram V
    Created Date       : 26 June 2020
    Description        : Purchase Order view screen
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
            <h3 class="content-header-title mb-0 d-inline-block">Purchase Order</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/purchaseorder/">Purchase Order</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add Purchase Order</h4>
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
                                <form class="form form-horizontal" enctype="multipart/form-data" role="form" name="addPurchaseOrder" id="addPurchaseOrder" method="post" action="/purchaseorder/adddirectpo" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="col-md-12">
                                        <label class="col-md-2 label-control" for="description" >Description</label>
                                        <div class="form-group row" >
                                            <div class="col-md-12">
                                            <textarea id="description" name="description" class="form-control richtextarea ckeditor" placeholder="Enter Description" title="Please enter the description" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Attachment Files <span class="mandatory">*</span></h5>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset class="form-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="uploadFile" name="uploadFile[]" multiple>
                                                    <label class="custom-file-label" for="uploadFile" aria-describedby="uploadFile">Choose file</label>
                                                    <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>PO Number <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="poNumber" class="form-control isRequired" autocomplete="off" placeholder="Enter Po Number" name="poNumber" title="Please enter PO Number">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>PO Issued On <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="issuedOn" value="<?php echo $currentDate; ?>" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter Issued On" name="issuedOn" title="Please enter Issued On">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendors
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control select2" autocomplete="off" style="width:100%;" id="vendorId" name="vendorId" title="Please select vendors">
                                                        <option value="">Select Vendors</option>
                                                        @foreach($vendor as $type)
                                                        <option value="{{ $type->vendor_id }}">{{ $type->vendor_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Total Amount<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="totalAmount" readonly onkeypress="return isNumberKey(event);" value="" class="form-control isRequired" autocomplete="off" placeholder="Enter Total Amount" name="totalAmount" title="Please enter Total Amount">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Order Status<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="orderStatus" name="orderStatus" title="Please select status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Payment Status<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="paymentStatus" name="paymentStatus" title="Please select Payment status">
                                                        <option value="">Select</option>
                                                        <option value="immediate">Immediate</option>
                                                        <option value="staggered">Staggered</option>
                                                        <option value="specified-date">Specified Date</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Last Date of Delivery<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <input type="text" id="lastDeliveryDate" onchange="checkDate();return false;" value="" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter Last Delivery Date" name="lastDeliveryDate" title="Please enter Last Delivery Date">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Delivery Location<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="deliveryLoc" name="deliveryLoc" title="Please select delivery locations">
                                                        <option value="">Select Locations</option>
                                                        @foreach($branch as $type)
                                                            <option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="table-responsive">
                                            <div class="bd-example">
                                                <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:30%;">Item<span class="mandatory">*</span></th>
                                                            <th style="width:15%;">Unit<span class="mandatory">*</span></th>
                                                            <th style="width:20%;">Description</th>
                                                            <th style="width:15%;">Quantity<span class="mandatory">*</span></th>
                                                            <th style="width:20%;">Unit Price<span class="mandatory">*</span></th>
                                                            <!-- <th style="width:20%;">Action</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="itemDetails">
                                                    <?php $j = 0; $qty=0; ?>
                                                       
                                                        <input type="hidden" id="rfqId" name="rfqId" value=""  >
                                                        <tr>
                                                            <td>
                                                                <select id="item{{$j}}" name="item[]" class="item select2 isRequired itemName form-control datas" title="Please select item" onchange="addNewItemField(this.id,{{$j}});">
                                                                    <option value="">Select Item </option>
                                                                    @foreach ($item as $items)
                                                                    <option value="{{ $items->item_id }}" >{{ $items->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="unitName{{$j}}" readonly name="unitName[]" value="" class="isRequired form-control" title="Please enter unit" placeholder="Unit">
                                                                <input type="hidden" id="unitId{{$j}}" name="unitId[]" value="" class="isRequired form-control"  title="Please enter unit" >
                                                                <input type="hidden" id="qdId{{$j}}" name="qdId[]" value="" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text"  value="" id="quoteDesc{{$j}}" name="quoteDesc[]" class="form-control" placeholder="Item description"  />
                                                            </td>
                                                            <td>
                                                                <input type="number" min="0" id="qty{{$j}}" name="qty[]" class="form-control  isRequired"  value="" placeholder="Enter Qty" title="Please enter the qty" value="" />
                                                            </td>
                                                            <td>
                                                                <input type="number" min="0" id="unitPrice{{$j}}" name="unitPrice[]" value="" oninput="calLineTotal();" class="form-control linetot isRequired" placeholder="Enter Unit Price" title="Please enter the Unit Price" value="" />
                                                            </td>
                                                            <!-- <td>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-6">
                                                                        <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>
                                                                    </div>
                                                                    <div class="col-md-6 col-6">
                                                                        <a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a>
                                                                    </div>
                                                                </div>
                                                            </td> -->
                                                        </tr>
                                                        <?php $j++; ?>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="form-actions right">
                                        <a href="/purchaseorder">
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
        </section>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".select2").select2();
        $(".select2").select2({
            tags: true
        });
        $("#vendors").select2({
            placeholder: "Select Vendors",
            allowClear: true
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
            $('#show_alert').html(flag).delay(3000).fadeOut();
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

    // function unitByItem(id, val) {
    //     unit = '';
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: "{{ url('/getItemUnit') }}",
    //         method: 'post',
    //         data: {
    //             val: val,
    //         },
    //         success: function(result) {
    //             // console.log(result)
    //             if (result.length > 0) {
    //                 $("#unitName" + id).val(result[0]['unit_name']);
    //                 $("#unitId" + id).val(result[0]['uom_id']);
    //             }
    //         }

    //     });
    // }

    rowCount = "{{$j}}";

    function insRow() {
        rowCount++;
        rl = document.getElementById("itemDetails").rows.length;
        var a = document.getElementById("itemDetails").insertRow(rl);
        a.setAttribute("style", "display:none;");
        // a.setAttribute("class", "data");
        var b = a.insertCell(0);
        var d = a.insertCell(1);
        var e = a.insertCell(2);
        var c = a.insertCell(3);
        var f = a.insertCell(4);


        rl = document.getElementById("itemDetails").rows.length - 1;
        b.innerHTML = '<select id="item' + rowCount + '" name="item[]" class="item select2 isRequired itemName form-control datas"  title="Please select item" onchange="addNewItemField(this.id,'+rowCount+');">\
                            <option value="">Select Item </option>@foreach ($item as $items)<option value="{{ $items->item_id }}">{{ $items->item_name }}</option>@endforeach</select>';
        d.innerHTML = '<input type="text" readonly id="unitName' + rowCount + '" name="unitName[]" class="isRequired form-control"  title="Please enter unit" placeholder="unit">\
                        <input type="hidden" id="unitId' + rowCount + '" name="unitId[]" class="isRequired form-control"  title="Please enter unit">\
                        <input type="hidden" id="qdId' + rowCount + '" name="qdId[]" class="form-control">';
        c.innerHTML = '<input type="number" min="0" id="unitPrice' + rowCount + '" name="unitPrice[]" class="form-control isRequired" placeholder="Enter Unit Price" title="Please enter Unit Price" />';
        e.innerHTML = '<input type="number" min="0" id="qty' + rowCount + '" name="qty[]" class="linetot form-control isRequired" oninput="calLineTotal();" placeholder="Enter Qty" title="Please enter quantity" />';
        f.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
        $(a).fadeIn(800);
        $(".item").select2({
            placeholder: "Select Item",
            allowClear: true
        });
        $(".select2").select2({
            tags: true
        });
        
    }

    function removeRow(el) {
        $(el).parent().fadeOut("slow", function() {
            $(el).parent().remove();
            rowCount = rowCount - 1;
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

    function calLineTotal(){
        var sum = 0;
        $('.linetot').each(function() {
            sum += Number($(this).val());
        });
        if(!isNaN(sum)){
            $("#totalAmount").val(sum);
        }
        $('.linetot').blur(function(){
            var num = parseFloat($(this).val());
            var cleanNum = num.toFixed(2);
            $(this).val(cleanNum);
        });
    }

    function addNewItemField(obj,id)
    {
        
        // checkValue = document.getElementById(obj).value;
        checkValue = $("#"+obj+" option:selected").html();
        if(checkValue!='')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/addNewItemField') }}",
                method: 'post',
                data: {
                   value: checkValue,
                },
                success: function(result){
                    if (result['id'] > 0)
                    {
                        $('#item'+id).html(result['option'])
                    }
                    value = $('#item'+id).val();
                    unitByItem(id,value);
                }
            });
        }
    }

    function unitByItem(id,val){
        unit = '';
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getItemUnit') }}",
            method: 'post',
            data: {
                val:val,
            },
            success: function(result){
                console.log(result)
                if(result.length>0)
                {
                    $("#unitName"+id).val(result[0]['unit_name']);
                    // unit = '<option value="'+result[0]['uom_id']+'">'+result[0]['unit_name']+'</option>'
                    // $("#unitName"+id).html(unit);
                    $("#unitId"+id).val(result[0]['uom_id']);
				}
			}

		});
    }

    function checkDate()
    {
        let lastDeliveryDate  = new Date($("#lastDeliveryDate").val())
        let invitedOn  = new Date();
        if(lastDeliveryDate  && invitedOn)
        {
            if(invitedOn > lastDeliveryDate)
            {
                    swal("Please enter the valid date")
                    $("#lastDeliveryDate").val('')
                return false
            }
            else
            {
                return true
            }
        }
    }
</script>
@endsection