<!-- 
    Author             : Sriram V
    Date               : 19 Jun 2020
    Description        : Vendors add screen
    Last Modified Date : 
    Last Modified Name : 
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Vendors</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/vendors/">Vendors</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add Vendors</h4>
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
                                <form class="form form-horizontal" role="form" name="addvendors" id="addvendors" method="post" action="/vendors/add" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorName" class="form-control isRequired" onblur="duplicateValidation('vendors','vendor_name', this.id, 'Entered Vendor is already exist.')" autocomplete="off" placeholder="Enter a Vendor Name" name="vendorName" title="Please enter Vendor Name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Vendor Code<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorCode" class="form-control isRequired" autocomplete="off" placeholder="Enter a Vendor Code" name="vendorCode" title="Please enter Vendor Code">
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
                                                        <option value="{{ $type->vendor_type_id }}">{{ $type->vendor_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Register On
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorRegisterOn" readonly class="form-control" autocomplete="off" placeholder="Enter a registered On" name="vendorRegisterOn" title="Please enter register On">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Password <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="password" id="password" class="form-control isRequired" autocomplete="off" placeholder="Enter a Password" name="password" title="Please Enter Password">
                                                    <div class="invalid-feedback">
                                                        must contain atleast 6 characters, 1 number , 1 alphabet and 1 special character
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Confirm Password <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="password" id="confirmPassword" onkeyup="checkPasswordMatch()" class="form-control isRequired" autocomplete="off" placeholder="Enter a Confirm Pasword" name="confirmPassword" title="Please Enter Confirm Pasword">
                                                    <span id="confirmresult" style="width: 100%;margin-top: 0.25rem;font-size: 80%;color: #FF4961;"></span>
                                                    <input type="hidden" id="passwordCheck" name="passwordCheck" class="isRequired" title="Passwords do not match.">
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
                                                    <input type="text" id="addressline1" class="form-control" autocomplete="off" placeholder="Enter address Line 1" name="addressline1" title="Please enter address Line 1">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Address Line 2
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="addressline2" class="form-control" autocomplete="off" placeholder="Enter address Line 2" name="addressline2" title="Please enter address Line 2">
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
                                                    <input type="text" id="vendorCity" class="form-control" autocomplete="off" placeholder="Enter City" name="vendorCity" title="Please enter City">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>State
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="vendorState" class="form-control" autocomplete="off" placeholder="Enter state" name="vendorState" title="Please enter State">
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
                                                    <input type="text" id="vendorPincode" maxlength='6' onkeypress="return isNumberKey(event);" class="form-control isPincode" autocomplete="off" placeholder="Enter Pincode" name="vendorPincode" title="Please enter Pincode">
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
                                                    <option value="{{ $countrylist->country_id }}">{{ $countrylist->country_name }}</option>
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
                                                    <input type="email" id="vendorEmail" class="form-control isEmail" autocomplete="off" placeholder="Enter Vendor Email" name="vendorEmail" title="Please enter a Valid Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Alternate Email
                                                </h5>
                                                <div class="form-group">
                                                    <input type="email" id="vendorAltEmail" class="form-control isEmail" autocomplete="off" placeholder="Enter Vendor Alternate Email" name="vendorAltEmail" title="Please enter a Valid Alternate Email">
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
                                                    <input maxlength="10" type="tel" id="vendorPhone" class="form-control isRequired isMobNo" onblur="mobileDuplicateValidation('vendors','users','phone', this.id, 'Entered Phone Number is already exist.')" onkeypress="return isNumberKey(event);" autocomplete="off" placeholder="Enter Phone Number" name="vendorPhone" title="Please enter Number">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Alternate Phone Number
                                                </h5>
                                                <div class="form-group">
                                                    <input maxlength="10" type="tel" id="vendorAltPhone" class="form-control isMobNo" onkeypress="return isNumberKey(event);" autocomplete="off" placeholder="Enter Vendor Alternate Phone Number" name="vendorAltPhone" title="Please enter Alternate Phone Number">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Status<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="vendorStatus" name="vendorStatus" title="Please select status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
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
@endsection