<!-- 
Author             : Sriram V
Date               : 25 June 2020
Description        : Quotes Edit Page
Last Modified Date : 
Last Modified Name : 
-->
@extends('layouts.main')

@section('content')
<?php

use App\Service\CommonService;
// dd($result[0]->quotes_upload_file);
$common = new CommonService();
$invitedOn = $common->humanDateFormat($result[0]->invited_on);
$deliveryDate = $common->humanDateFormat($result[0]->estimated_date_of_delivery);
$respondedOn = $common->humanDateFormat($result[0]->responded_on);
if(isset($result[0]->estimated_date_of_delivery)){
    $estimatedDate = $common->humanDateFormat($result[0]->estimated_date_of_delivery);
}
else{
    $estimatedDate = '';
}
$optionSelect='';
$optionSelect1='';
$eta_if_no_stock='';
$style = '';
$vendor_notes = '';
$mode_of_delivery = '';
if(isset($result[0]->stock_available)){
    $style = 'display:none;';
    if($result[0]->stock_available=='no'){
        $optionSelect1='selected';
    }
    else{
        $optionSelect='selected';
    }
}

if(isset($result[0]->eta_if_no_stock)){
  $eta_if_no_stock=$result[0]->eta_if_no_stock;
}
if(isset($result[0]->vendor_notes)){
    $vendor_notes=$result[0]->vendor_notes;
}
if(isset($result[0]->mode_of_delivery)){
    $mode_of_delivery=$result[0]->mode_of_delivery;
}
?>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js')}}"></script>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Quotes </h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/quotes/">Quotes </a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Edit Quotes </h4>
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
                        <div class="card-content collapse show" style="margin-top: -20px;">
                            <div class="card-body">
                                <div id="show_alert" class="mt-1" style=""></div>
                                <form class="form form-horizontal" role="form" name="editQuotes" id="editQuotes" enctype="multipart/form-data" method="post" action="/quotes/edit/{{base64_encode($result[0]->quote_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    @php
                                    $fnct = "quote_id##".($result[0]->quote_id);
                                    @endphp
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <h4><b>RFQ Number : </b> <span id="rfqNumber" class="spanFont">{{$result[0]->rfq_number }} </span></h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <h4><b>Vendor Name : </b><span id="quoteNumber" class="spanFont">{{$result[0]->vendor_name}}</span></h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <h4><b>Invited On : </b><span id="invitedDate" class="spanFont">{{$invitedOn}}</span></h4>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <h4><b>Quotes Status : </b> <span id="quotesStatus" class="spanFont">{{ucfirst($result[0]->quotes_status) }} </span></h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <h4><b>Delivery Mode : </b><span id="deliveryMode" class="spanFont">{{$result[0]->mode_of_delivery}}</span></h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <h4><b>Responded On : </b><span id="respondedDate" class="spanFont">{{$respondedOn}}</span></h4>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                         <div class="col-xl-6 col-lg-12">
                                            <h4><b>Estimated Delivery Date : </b><span id="estimatedDate" class="spanFont">{{$deliveryDate}}</span></h4>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        <label class="col-md-2 label-control" for="description" ><h5>Description</h5></label>
                                        <div class="form-group row" >
                                            <div class="col-md-12">
                                            <textarea id="description" name="description" class="form-control richtextarea ckeditor" placeholder="Enter Description" title="Please enter the description" >{{$result[0]->quote_description}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(isset($result[0]->quotes_upload_file) && $result[0]->quotes_upload_file!='' && $result[0]->quotes_upload_file!=null){ ?>
                                        <div class="row p-1">
                                            <div class="col-xl-6 col-md-12">
                                                <div class="card" style="border: 1px solid #b7defa">
                                                  <div class="card-content">
                                                    <div class="card-body cleartfix">
                                                      <div class="media align-items-stretch">
                                                        <div class="align-self-center">
                                                          <i class="la la-file-text info font-large-2 mr-2"></i>
                                                        </div>
                                                        <div class="media-body">
                                                          <h4>Attachments</h4>
                                                          <?php
                                                     $fileVaL= explode(",", $result[0]->quotes_upload_file);
                                                     $filecount=count($fileVaL);
                                                    if($filecount>1){
                                                        $forcount=$filecount-1;
                                                    }else{
                                                        $forcount=$filecount;
                                                    }
                                                    for($i=0;$i<$forcount;$i++)
                                                    {
                                                        $attach = explode('/',$fileVaL[$i])[8];
                                                        $attachext = explode('.',$attach);
                                                        $attachext = end($attachext);
                                                        $attachfile = explode('@@',$attach)[0];
                                                        if($attachfile){
                                                            if($attachext){
                                                                $attachmentFile = $attachfile.'.'.$attachext;
                                                            }
                                                            else{
                                                                $attachmentFile = $attachfile;
                                                            }
                                                        }
                                                        else{
                                                            $attachfile = 'Attachment';
                                                        }
                                                        $imagefile= str_replace('/var/www/asm-pi/public', '', $fileVaL[$i]);
                                                        echo  '<div><a href="'.$imagefile.'" target="_blank">'.$attachmentFile.'  <i class="ft-download"></i></a></div>';
                                                    }
                                                    ?>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>
                                        <?php  } else{ ?>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Attachment <span class="mandatory">*</span></h5>
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
                                    <?php } ?>
                                    <br/>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Quote Number<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="quoteNumber" value="{{$result[0]->quote_number}}" class="form-control isRequired" autocomplete="off" name="quoteNumber" title="Please enter quotes number">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Currently in Stock?<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="stockable" name="stockable" title="Please select Stockable" onchange="isStockable(this.value)">
                                                    <option value="yes" {{ $optionSelect }}>Yes</option>
                                                    <option value="no" {{ $optionSelect1 }}>No</option>
                                                </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12" id="ifNotInStockDiv" style="{{$style}}">
                                            <fieldset>
                                                <h5>If not in Stock</h5>
                                                <div class="form-group">
                                                    <input type="text" id="notInStock" value="{{ $eta_if_no_stock }}" class="form-control" autocomplete="off" placeholder="estimated number of days to deliver after date of order" name="notInStock" title="estimated number of days to deliver after date of order">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Notes<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorNotes" value="{{$vendor_notes}}" class="form-control isRequired" autocomplete="off" name="vendorNotes" title="Please vendor notes">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Mode of Delivery<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                <input type="text" id="deliveryMode" value="{{$mode_of_delivery}}" class="form-control isRequired" autocomplete="off" name="deliveryMode" title="Please delivery mode">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Estimated Date of Delivery<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="estimatedDate" value="{{$estimatedDate}}" onchange="checkDate();return false;" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter Estimated Date of Delivery" name="estimatedDate" title="Please enter Estimated Date of Delivery">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <br /><br />
                                    <div class="row">
                                        <h4>Orders Details</h4>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="table-responsive">
                                            <div class="bd-example">
                                                <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                                    <thead>
                                                        <tr style="background-color:#ebecd2">
                                                            <th style="width:30%;">Item Name<span class="mandatory">*</span></th>
                                                            <th style="width:15%;">Unit<span class="mandatory">*</span></th>
                                                            <th style="width:20%;">Description</th>
                                                            <th style="width:15%;">Quantity<span class="mandatory">*</span></th>
                                                            <th style="width:20%;">Unit Price<span class="mandatory">*</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="orderDetails">
                                                        <?php $z = 0; ?>
                                                        @foreach($result['quotesdetails'] as $quotesDetail)
                                                        <tr>
                                                            <input type="hidden" name="qdId[]" id="qdId{{$z}}" value="{{ $quotesDetail->qd_id }}" />
                                                            <td>
                                                                <select id="itemName{{$z}}" disabled name="itemName[]" class="select2 isRequired form-control" title="Please select Item Name">
                                                                    <option value="">Select Item Name</option>
                                                                    @foreach ($items as $itemDetails)
                                                                    <option value="{{ $itemDetails->item_id }}" {{ $quotesDetail->item_id == $itemDetails->item_id ?  'selected':''}}>{{ $itemDetails->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="unitName{{$z}}" readonly name="unitName[]" value="{{ $quotesDetail->unit_name }}" class="isRequired form-control"  title="Please enter unit" placeholder="Unit">
                                                                <input type="hidden" id="unitId{{$z}}" name="unitId[]" value="{{ $quotesDetail->uom }}" class="isRequired form-control"  title="Please enter unit">
                                                            </td>
                                                            <td>
                                                                <input type="text"  value="{{$quotesDetail->description}}" id="quoteDesc{{$z}}" name="quoteDesc[]" class="form-control" placeholder="Item description"  />
                                                            </td>
                                                            <td>
                                                                <input type="number" min="0" value="{{$quotesDetail->quantity}}" id="quoteQty{{$z}}" name="quoteQty[]" class="form-control isRequired" placeholder="Order Qty" title="Please enter the order qty" />
                                                            </td>
                                                            <td>
                                                                <input type="number" min="0" value="{{$quotesDetail->unit_price}}" id="unitPrice{{$z}}" name="unitPrice[]" class="form-control isRequired" placeholder="Unit Price" title="Please enter the Unit Price" />
                                                            </td>
                                                        </tr>
                                                        <?php $z++; ?>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="form-actions right">
                                        <a href="/quotes">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                        </a>
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Update
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
    $('.datepicker').datepicker({
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

function isStockable(val) {
    if(val=="no"){
        $('#ifNotInStockDiv').show();
    }
    else{
        $('#ifNotInStockDiv').hide();
    }
}
    duplicateName = true;

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editQuotes'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editQuotes').submit();
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
                    fnct: fnct
                },
                success: function(result) {
                    console.log(result)
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

    function checkDate()
    {
        let estimatedDate  = new Date($("#estimatedDate").val())
        let invitedOn  = new Date($("#invitedOn").val())

        if(estimatedDate  && invitedOn)
        {
            if(invitedOn > estimatedDate)
            {
                    swal("Estimated date should be Greater than invited on date")
                    $("#estimatedDate").val('')
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