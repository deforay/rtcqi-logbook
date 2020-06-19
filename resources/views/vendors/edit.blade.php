<!-- 
    Author             : Sudarmathi M
    Date               : 3 Feb 2020
    Description        : customers add screen
    Last Modified Date : 7 Feb 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')

@section('content')
<style>
    #addresstable {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #addresstable td,
    #addresstable th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #addresstable tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #addresstable tr:hover {
        background-color: #ddd;
    }

    #addresstable th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #b0bec5;
        color: white;
    }

    #addresstable input {
        width: 250px;
    }
</style>
<?php
    use App\Service\CommonService;
    $common = new CommonService();
    $registeredOn = $common->humanDateFormat($vendors[0]->registered_on);
?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Vendor</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/vendor/">Vendor</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Edit Vendor</h4>
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
                                <form class="form form-horizontal" role="form" name="editvendor" id="editvendor" method="post" action="/vendors/edit/{{base64_encode($vendors[0]->vendor_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    @php
                                    $fnct = "vendor_id##".($vendors[0]->vendor_id);
                                    @endphp
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Name <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" value="{{ $vendors[0]->vendor_name }}" id="vendorName" class="form-control isRequired" autocomplete="off" placeholder="Enter a Vendor name" name="vendorName" title="Please enter Vendor name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Code<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorCode" value="{{ $vendors[0]->vendor_code }}" class="form-control isRequired" autocomplete="off" placeholder="Enter a Vendor Code" name="vendorCode" title="Please enter Vendor Code">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Type<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="vendorType" name="vendorType" title="Please select Vendor Type">
                                                        <option value="">Select Vendor Type</option>
                                                        @foreach($vendors_type as $type)
                                                        <option value="{{ $type->vendor_type_id }}" {{ $vendors[0]->vendor_type == $type->vendor_type_id ?  'selected':''}}>{{ $type->vendor_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Register On<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorRegisterOn" readonly value="{{ $registeredOn }}" class="form-control isRequired" autocomplete="off" placeholder="Enter a registered On" name="vendorRegisterOn" title="Please enter register On">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Address Line 1
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="addressline1" class="form-control" value="{{ $vendors[0]->address_line_1 }}" autocomplete="off" placeholder="Enter address Line 1" name="addressline1" title="Please enter address Line 1">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Address Line 2
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="addressline2" class="form-control" value="{{ $vendors[0]->address_line_2 }}" autocomplete="off" placeholder="Enter address Line 2" name="addressline2" title="Please enter address Line 2">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>City
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorCity" class="form-control" value="{{ $vendors[0]->city }}" autocomplete="off" placeholder="Enter City" name="vendorCity" title="Please enter City">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>State
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorState" class="form-control" value="{{ $vendors[0]->state }}" autocomplete="off" placeholder="Enter state" name="vendorState" title="Please enter State">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Pincode
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorPincode" class="form-control" value="{{ $vendors[0]->pincode }}" autocomplete="off" placeholder="Enter Pincode" name="vendorPincode" title="Please enter Pincode">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Country<span class="mandatory">*</span>
                                                </h5>
                                                <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="vendorCountry" name="vendorCountry" title="Please select Country">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $countrylist)
                                                    <option value="{{ $countrylist->country_id }}" {{ $vendors[0]->country == $countrylist->country_id ?  'selected':''}}>{{ $countrylist->country_name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Email
                                                </h5>
                                                <div class="form-group">
                                                    <input type="email" id="vendorEmail" class="form-control isEmail" value="{{ $vendors[0]->email }}" autocomplete="off" placeholder="Enter Vendor Email" name="vendorEmail" title="Please enter a Valid Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Alternate Email
                                                </h5>
                                                <div class="form-group">
                                                    <input type="email" id="vendorAltEmail" class="form-control isEmail" value="{{ $vendors[0]->alt_email }}" autocomplete="off" placeholder="Enter Vendor Alternate Email" name="vendorAltEmail" title="Please enter a Valid Alternate Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Phone
                                                </h5>
                                                <div class="form-group">
                                                    <input maxlength="10" type="tel" id="vendorPhone" class="form-control isMobNo" value="{{ $vendors[0]->phone }}" onkeypress="return isNumberKey(event);" autocomplete="off" placeholder="Enter Phone Number" name="vendorPhone" title="Please enter Number">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Alternate Phone Number
                                                </h5>
                                                <div class="form-group">
                                                    <input maxlength="10" type="tel" id="vendorAltPhone" class="form-control isMobNo" value="{{ $vendors[0]->pincode }}" onkeypress="return isNumberKey(event);" autocomplete="off" placeholder="Enter Vendor Alternate Phone Number" name="vendorAltPhone" title="Please enter Alternate Phone Number">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Status<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="vendorStatus" name="vendorStatus" title="Please select Vendor status">
                                                        <option value="active" {{ $vendors[0]->vendor_status == 'active' ?  'selected':''}}>Active</option>
                                                        <option value="inactive" {{ $vendors[0]->vendor_status == 'inactive' ?  'selected':''}}>Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/vendors">
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
        $(".select2").select2();
        $(".select2").select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#vendorRegisterOn').datepicker({
            autoclose: true,
            format: 'dd-M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            // startDate:'today',
            clearBtn: true,
        }).on('changeDate', function(e) {
            duplicateValidation();
        });
    });



    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }


    duplicateName = true;

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editvendors'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editvendors').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }

    }

    function checkNameValidation(tableName, fieldName, obj, fnct, msg) {
        checkValue = document.getElementById(obj).value;
        if ($.trim(checkValue) != '') {
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
                    fnct: fnct,
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

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endsection