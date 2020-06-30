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
// dd($result);
use App\Service\CommonService;

$common = new CommonService();
$invitedOn = $common->humanDateFormat($result[0]->invited_on);
?>
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
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div id="show_alert" class="mt-1" style=""></div>
                                <form class="form form-horizontal" role="form" name="editQuotes" id="editQuotes" method="post" action="/quotes/edit/{{base64_encode($result[0]->quote_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    @php
                                    $fnct = "quote_id##".($result[0]->quote_id);
                                    @endphp
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>RFQ Number
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" disabled id="rfqNumber" value="{{$result[0]->rfq_number}}" class="form-control" autocomplete="off" name="rfqNumber">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Name
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" disabled id="vendorName" value="{{$result[0]->vendor_name}}" class="form-control" autocomplete="off" name="vendorName">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Quote Number<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="quoteNumber" value="{{$result[0]->quote_number}}" class="form-control" autocomplete="off" name="quoteNumber">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Invited On
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="invitedOn" value="{{ $invitedOn }}" disabled class="form-control" autocomplete="off" placeholder="Enter a Invited On" name="invitedOn" title="Please enter Invited On">
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
                                                <table class="table table-striped table-bordered table-condensed table-responsive-lg">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:50%;">Item Name<span class="mandatory">*</span></th>
                                                            <th style="width:25%;">Qty<span class="mandatory">*</span></th>
                                                            <th style="width:25%;">Unit Price<span class="mandatory">*</span></th>
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
                                                                <input type="text" value="{{$quotesDetail->quantity}}" id="quoteQty{{$z}}" name="quoteQty[]" class="form-control isRequired" placeholder="Order Qty" title="Please enter the order qty" />
                                                            </td>
                                                            <td>
                                                                <input type="text" value="{{$quotesDetail->unit_price}}" id="unitPrice{{$z}}" name="unitPrice[]" class="form-control isRequired" placeholder="Unit Price" title="Please enter the Unit Price" />
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
</script>
@endsection