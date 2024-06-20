<!--

    Date               : 27 May 2021
    Description        : User add screen
    Last Modified Date : 27 May 2021

-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">{{ __('messages.user') }}</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/user/">{{ __('messages.user') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('messages.add') }}</li>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> {{ __('messages.add') }} {{ __('messages.user') }}</h4>
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
                                <form class="form form-horizontal" role="form" name="addUser" id="addUser" method="post" action="/user/add" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf

                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.first_name') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="firstName" class="form-control isRequired" autocomplete="off" placeholder="Enter First Name" name="firstName" title="Please Enter First Name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.last_name') }}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="lastName" class="form-control " autocomplete="off" placeholder="Enter Last Name" name="lastName" title="Please Enter Last Name">
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.password') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="password" id="password" class="form-control isRequired" autocomplete="off" placeholder="Enter Password" name="password" title="Please Enter Password">
                                                    <div class="invalid-feedback">
                                                        must contain atleast 6 characters, 1 number , 1 alphabet and 1 special character
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.confirm_password') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="password" id="confirmPassword" onkeyup="checkPasswordMatch()" class="form-control isRequired" autocomplete="off" placeholder="Enter Confirm Pasword" name="confirmPassword" title="Please Enter Confirm Pasword">
                                                    <span id="confirmresult" style="width: 100%;margin-top: 0.25rem;font-size: 80%;color: #FF4961;"></span>
                                                    <input type="hidden" id="passwordCheck" name="passwordCheck" class="isRequired" title="Passwords do not match.">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.mobile_number') }}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="tel" maxlength="10" onkeypress="return isNumberKey(event);" id="mobileNo" class="form-control" autocomplete="off" placeholder="Enter Mobile Number" name="mobileNo" title="Please Enter Mobile Number" onblur="checkNameValidation('users','phone', this.id,'','Entered mobile number is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.email') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="email" class="form-control isEmail isRequired" autocomplete="off" placeholder="Enter Email" name="email" title="Please Enter Email" onblur="checkNameValidation('users','email', this.id,'','Entered mail id is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.user_status') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="userStatus" name="userStatus" title="Please Select User Status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.role') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="select2 form-control isRequired" autocomplete="off" style="width:100%;" id="roleId" name="roleId" title="Please Select Role">
                                                        @foreach($roleId as $row)
                                                        <option value="{{$row->role_id}}">{{$row->role_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.user_mapping') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="userMapping" name="userMapping" title="Please Select User Mapping">
                                                        <option value="1" selected>Sitewise</option>
                                                        <option value="2">LocationWise</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.prefered_language') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;"  name="prefered_language" title="{{ __('messages.select') }} {{ __('messages.prefered_language') }}">
                                                        <option value="en" selected>English</option>
                                                        <option value="fr">French</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div id="sitewise">
                                        <div class="form-actions left">
                                            <input type="button" id="showBtn" class="btn btn-success" value="{{ __('messages.show_filter') }}" />
                                        </div>
                                        <div class="row filterDiv" style="display:none;">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.province_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId[]" title="Please select Province Name">
                                                            @foreach($province as $row)
                                                            <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.district_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="districtId" name="districtId[]" title="Please select District  Name">

                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.sub_district_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="subDistrictId" name="subDistrictId[]" title="Please select Sub District  Name">

                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <button type="button" onclick="getAllTestSiteList();return false;" class="btn btn-info"> {{ __('messages.search') }}</button>&nbsp;&nbsp;
                                            </div>
                                        </div>
                                        <div class="form-actions left filterDiv" style="display:none;">

                                        </div>


                                        <div class="row">
                                            <div class="col-xl-5 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.test_site_user_map_details') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select name="siteMap[]" id="search" class="form-control" size="8" multiple="multiple">
                                                            @foreach($test as $row)
                                                            <option value="{{$row->ts_id}}">{{$row->site_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-xl-1 col-lg-12"><br>
                                                <button type="button" id="search_rightAll" class="btn btn-secondary"><i class="ft-fast-forward"></i></button><br><br>
                                                <button type="button" id="search_rightSelected" class="btn btn-secondary"><i class="ft-chevron-right"></i></button><br><br>
                                                <button type="button" id="search_leftSelected" class="btn btn-secondary"><i class="ft-chevron-left"></i></button><br><br>
                                                <button type="button" id="search_leftAll" class="btn btn-secondary"><i class="ft-rewind"></i></button><br><br>
                                            </div>

                                            <div class="col-xl-5 col-lg-12"><br>
                                                <select name="search_to[]" id="search_to" class="form-control" size="8" multiple="multiple"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="locationwise">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.province_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="provinceMappingId" name="provinceMappingId[]" title="Please select Province Name">
                                                            @foreach($province as $row)
                                                            <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12" id="districtBlock">
                                                <fieldset>
                                                    <h5>{{ __('messages.district_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="districtMappingId" name="districtMappingId[]" title="Please select District  Name">

                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions right">
                                        <a href="/user">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> {{ __('messages.cancel') }}
                                            </button>
                                        </a>
                                        <input type="hidden" name="testSiteName" id="testSiteName" />
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> {{ __('messages.save') }}
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
<script src="{{ asset('assets/js/multiselect.min.js') }}"></script>
<script src="{{ asset('assets/js/jasny-bootstrap.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#search').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length > 3;
            }
        });
        $(".select2").select2();
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

        $('#provinceId').select2({
            placeholder: "Select Province Name",
            allowClear: true,
        });

        $('#districtId').select2({
            placeholder: "Select District Name",
            allowClear: true,
        });
        $('#subDistrictId').select2({
            placeholder: "Select Subdistrict Name",
            allowClear: true,
        });

        $("#provinceId").change(function() {
            var datas = $(this).val();
            listDistrictForProvince(true);
        });
        $("#districtId").change(function() {
            var datas = $(this).val();
            listSubDistrictForDistrict();
        });

        $("#showBtn").click(function() {
            $(".filterDiv").toggle();
        });

        $('#showBtn').click(function() {
            $(this).val() == "Show Filter" ? showFilter() : hideFilter();
        });
        $("#locationwise").hide();
        $('#userMapping').change(function() {
            if ($('#userMapping').val() == 1) {
                $("#sitewise").show();
                $("#locationwise").hide();
            } else {
                $("#sitewise").hide();
                $("#locationwise").show();
            }
        });

        $('#provinceMappingId').select2({
            placeholder: "Select Province Name",
            allowClear: true,
        });

        $('#districtMappingId').select2({
            placeholder: "Select District Name",
            allowClear: true,
        });
        $("#provinceMappingId").change(function() {
            var datas = $(this).val();
            listDistrictForProvince(false);
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

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    duplicateName = true;

    function validateNow() {
        var selVal = [];
        var mobNum = $('#mobileNo').val();
        $('#search_to option').each(function(i, selected) {
            selVal[i] = $(selected).val();
        });
        $("#testSiteName").val(selVal);
        // if(mobNum.length!=10){
        // 	$("html, body").animate({ scrollTop: 0 }, "slow");
        // 	$("#showAlertIndex").text('Please give 10  digit mobile number');
        // 	$('#showAlertdiv').show();
        // 	ismob = false;
        // 	$('#mobileNo').css('background-color', 'rgb(255, 255, 153)')
        // 	$('#showAlertdiv').delay(3000).fadeOut();
        // }
        // else{
        // 	ismob = true;
        // }
        // if(ismob==true){
        flag = deforayValidator.init({
            formId: 'addUser'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addUser').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
        // }
    }

    function checkNameValidation(tableName, fieldName, obj, fnct, msg) {
        checkValue = document.getElementById(obj).value;
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

    function showFilter() {
        $('#showBtn').val("Hide Filter");
        $("#showBtn").removeClass("btn-success");
        $("#showBtn").addClass("btn-secondary");
    }

    function hideFilter() {
        $('#showBtn').val("Show Filter");
        $("#showBtn").removeClass("btn-secondary");
        $("#showBtn").addClass("btn-success");
    }

    function listDistrictForProvince(isFilter) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getDistrictByProvinceId') }}",
            method: 'post',
            data: {
                provinceId: isFilter ? $("#provinceId").val() : $("#provinceMappingId").val(),
            },
            success: function(result) {
                var districtsOption = '';
                result.forEach((res) => {
                    districtsOption += '<option value="' + res.district_id + '">' + res.district_name + '</option>';
                });
                if (isFilter) {
                    $('#districtId').html(districtsOption);
                } else {
                    $('#districtMappingId').html(districtsOption);
                }
            }
        });
    }

    function listSubDistrictForDistrict() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getSubDistrictByDistrictId') }}",
            method: 'post',
            data: {
                districtId: $("#districtId").val(),
            },
            success: function(result) {

                // console.log($('#districtId').html(''));
                var subDistrictsOption = '';
                result.forEach((res) => {
                    subDistrictsOption += '<option value="' + res.sub_district_id + '">' + res.sub_district_name + '</option>';
                });
                $('#subDistrictId').html(subDistrictsOption);
            }
        });
    }

    function getAllTestSiteList() {
        $.blockUI();
        var searchToVal = [];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#search_to option').each(function(i, selected) {
            searchToVal[i] = $(selected).val();
        });
        $.ajax({
            url: "{{ url('/getAllTestSiteList') }}",
            method: 'post',
            data: {
                provinceId: $("#provinceId").val(),
                districtId: $("#districtId").val(),
                subDistrictId: $("#subDistrictId").val(),
                searchTo: searchToVal,
            },
            success: function(result) {
                //console.log('data results', result);
                //return;
                var districtsOption = '';
                result.forEach((res) => {
                    districtsOption += '<option value="' + res.ts_id + '">' + res.site_name + '</option>';
                });
                $('#search').html(districtsOption);
                $.unblockUI();
            }
        });
    }
</script>
<link href="public/dist/css/select2.min.css" rel="stylesheet" />
<script src="public/dist/js/select2.min.js"></script>
@endsection