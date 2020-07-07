<!-- 
    Author             : Sudarmathi M
    Date               : 22 June 2020
    Description        : Login screen
    Last Modified Date : 22 June 2020
    Last Modified Name : Sudarmathi M
-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<?php

use App\Service\CommonService;
$commonservice = new CommonService();
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Procurement & Inventory Manager</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png')}}">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/logo/asm_logo.png')}}"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/login-register.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column   blank-page" data-open="click" data-menu="horizontal-menu" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content container center-layout mt-2">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-12 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <!-- <div class="p-1"><img src="{{ asset('app-assets/images/logo/asm_logo.png')}}" alt="branding logo" style="width: 100px;"></div> -->
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Profile </span>
                                    </h6>
                                </div>
                                <div id="show_alert"  class="mt-1" style="font"></div>
                                @if (session('status'))
                                    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index" ><div class="text-center" style="font-size: 18px;"><b>
                                        {{ session('status') }}</b></div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <script>$('#show_alert_index').delay(3000).fadeOut();</script>
                                @endif
                                <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
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
                                                    <input type="text" value="{{ $vendors[0]->vendor_name }}" id="vendorName" class="form-control isRequired" autocomplete="off" placeholder="Enter Vendor name" name="vendorName" title="Please enter Vendor name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Code<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorCode" value="{{ $vendors[0]->vendor_code }}" class="form-control isRequired" autocomplete="off" placeholder="Enter Vendor Code" name="vendorCode" title="Please enter Vendor Code">
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
                                                    <select class="form-control isRequired select2" disabled autocomplete="off" style="width:100%;" id="vendorType" name="vendorType" title="Please select Vendor Type">
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
                                                    <input type="text" id="vendorRegisterOn" readonly value="{{$commonservice->getDateTime()}}" class="form-control isRequired" autocomplete="off" placeholder="Enter registered On" name="vendorRegisterOn" title="Please enter register On">
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
                                                    <input type="text" id="vendorPincode" maxlength='6' onkeypress="return isNumberKey(event);" class="form-control isPincode" value="{{ $vendors[0]->pincode }}" autocomplete="off" placeholder="Enter Pincode" name="vendorPincode" title="Please enter Pincode">
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
                                                    <input type="email" id="vendorEmail" class="form-control isEmail" value="{{ $vendors[0]->email }}" autocomplete="off" placeholder="Enter Vendor Email" name="vendorEmail" title="Please Enter Valid Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Alternate Email
                                                </h5>
                                                <div class="form-group">
                                                    <input type="email" id="vendorAltEmail" class="form-control isEmail" value="{{ $vendors[0]->alt_email }}" autocomplete="off" placeholder="Enter Vendor Alternate Email" name="vendorAltEmail" title="Please Enter Valid Alternate Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Phone<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input maxlength="10" type="tel" id="vendorPhone" class="form-control isMobNo isRequired" onblur="checkMobileValidation('vendors','users', 'phone', this.id,'{{$fnct}}', 'Entered Phone Number is already exist. . Please enter another Phone Number.');" value="{{ $vendors[0]->phone }}" onkeypress="return isNumberKey(event);" autocomplete="off" placeholder="Enter Phone Number" name="vendorPhone" title="Please enter Number">
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
                      
                                    <div class="form-actions right">
                                        <a href="/vendors">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                        </a>
                                        <input type="hidden" id="vendorStatus" value="active" name="vendorStatus">
                                        <input type="hidden" id="vendorType" value="vendorProfile" name="vendorType">
                                        <input type="hidden" id="password" value="{{$vendors[0]->password}}" name="password">
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
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->



</body>
<!-- END: Body-->

</html>
<script src="{{ asset('assets/js/deforayValidation.js') }}"></script>
<script>
    duplicateName = true;
    $(document).ready(function() {
        $(".select2").select2();
        $(".select2").select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#confirmPassword').keyup(function() {
            var nPws = $('#password').val();
            var cPws = $('#confirmPassword').val();
            if (nPws != cPws) {
                $('#confirmresult').html('Passwords do not match.')
                $('#passwordCheck').val('');
            } else {

                $('#passwordCheck').val('passwordCheck');
                $('#confirmresult').html('')
            }
        })
        $('#password').change(function() {

            $('#result').html(checkStrength($('#password').val()))
        })
        $('#vendorRegisterOn').datepicker({
            autoclose: true,
            format: 'dd-M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            // startDate:'today',
            todayHighlight: true,
            clearBtn: true,
        }).on('changeDate', function(e) {
            duplicateValidation();
        });
    });

    function checkStrength(password) {
        var strength = 0
        if (password.length < 7) {
            $('#result').removeClass()
            $('#result').addClass('short')
            $('#passwordCheck').val('')
            $("#password").val("");
            $(".invalid-feedback").show();
            return 'Too short'
        }
        if (password.length > 7) strength += 1
        // If password contains both lower and uppercase characters, increase strength value.
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
        // If it has numbers and characters, increase strength value.
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
        // If it has one special character, increase strength value.
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        // If it has two special characters, increase strength value.
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        // Calculated strength value, we can return messages
        // If value is less than 2
        if (strength < 2) {
            $('#result').removeClass()
            $('#result').addClass('weak')
            $('#passwordCheck').val('')
            $("#password").val("");
            $(".invalid-feedback").show();
            return 'Weak'
        } else if (strength == 2) {
            $('#result').removeClass()
            $('#result').addClass('good')
            $('#passwordCheck').val('good')
            $(".invalid-feedback").hide();
            return 'Good'
        } else {
            $('#result').removeClass()
            $('#result').addClass('strong')
            $('#passwordCheck').val('strong')
            $(".invalid-feedback").hide();
            return 'Strong'
        }
    }

    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();
        if (password.trim() && confirmPassword.trim()) {
            if (password.trim() != confirmPassword.trim()) {
                $("#confirmPassword").onfocus = function() {
                    // $("#confirmPassword").style.background = "#FFFFFF";
                }
            } else {
                $("#password").focusout();
                $("#confirmPassword").focusout();
            }
        }
    }

    function duplicateValidation(tableName, fieldName, obj, msg) {
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
                url: "{{ url('/duplicateValidation') }}",
                method: 'post',
                data: {
                    tableName: tableName,
                    fieldName: fieldName,
                    value: checkValue,
                },
                success: function(result) {
                    //   console.log(result)
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

    function mobileDuplicateValidation(tableName1, tableName2, fieldName, obj, msg) {
        checkValue = document.getElementById(obj).value;
        if (checkValue != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/mobileDuplicateValidation') }}",
                method: 'post',
                data: {
                    tableName1: tableName1,
                    tableName2: tableName2,
                    fieldName: fieldName,
                    value: checkValue,
                },
                success: function(result) {
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

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addvendors'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addvendors').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>