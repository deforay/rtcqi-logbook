<!--

    Date               : 27 May 2021
    Description        : User edit screen
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
                        <li class="breadcrumb-item active">{{ __('messages.edit') }}</li>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> {{ __('messages.user_profile') }}</h4>
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
                                <form class="form form-horizontal" role="form" name="editUser" id="editUser" method="post" action="/user/profile/{{base64_encode($result[0]->user_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    @php
                                    $fnct = "user_id##".($result[0]->user_id);
                                    @endphp
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.first_name') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="firstName" class="form-control isRequired" value="{{$result[0]->first_name}}" autocomplete="off" placeholder="Enter {{ __('messages.first_name') }}" name="firstName" title="Please enter {{ __('messages.first_name') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.last_name') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="lastName" class="form-control isRequired" value="{{$result[0]->last_name}}" autocomplete="off" placeholder="Enter {{ __('messages.last_name') }}" name="lastName" title="Please enter {{ __('messages.last_name') }}">
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.mobile_number') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="tel" maxlength="10" value="{{$result[0]->phone}}" onkeypress="return isNumberKey(event);" id="mobileNo" class="form-control isMobNo isRequired" autocomplete="off" placeholder="Enter {{ __('messages.mobile_number') }}" name="mobileNo" title="Please Enter {{ __('messages.mobile_number') }}" onblur="checkMobileValidation('users','vendors','phone', this.id,'{{$fnct}}','Entered {{ __('messages.mobile_number') }} is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.email') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="email" value="{{$result[0]->email}}" class="form-control isEmail isRequired" autocomplete="off" placeholder="Enter {{ __('messages.email') }}" name="email" title="Please Enter Email" onblur="checkMobileValidation('vendors','users','email', this.id,'{{$fnct}}','Entered mail id is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.select') }} {{ __('messages.language') }}</h5>
                                                <div class="form-group">
                                                    <select class="form-control" autocomplete="off" style="width:100%;" id="locale" name="locale" title="{{ __('messages.select') }} {{ __('messages.language') }}">
                                                        <option value="">{{ __('messages.select') }} {{ __('messages.language') }}</option>
                                                        @foreach($available_locales as $locale_name => $available_locale)

                                                        <option value="{{$available_locale}}" {{ $available_locale === $result[0]->prefered_language  ?  'selected':''}}>{{ $locale_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/dashboard">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> {{ __('messages.cancel') }}
                                            </button>
                                        </a>
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

<script>
    $(document).ready(function() {
        $(".select2").select2();
        $("#branches").select2({
            placeholder: "Select Branches",
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
        mobNum = $('#mobileNo').val();
        if (mobNum.length != 10) {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            $("#showAlertIndex").text('Please give 10  digit mobile number');
            $('#showAlertdiv').show();
            ismob = false;
            $('#mobileNo').css('background-color', 'rgb(255, 255, 153)')
            $('#showAlertdiv').delay(3000).fadeOut();
        } else {
            ismob = true;
        }
        if (ismob == true) {
            flag = deforayValidator.init({
                formId: 'editUser'
            });

            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('editUser').submit();
                }
            } else {
                // Swal.fire('Any fool can use a computer');
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display", "block");
                $(".infocus").focus();
            }
        }
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
                    fnct: fnct
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

    function checkMobileValidation(tableName1, tableName2, fieldName, obj, fnct, msg) {
        checkValue = document.getElementById(obj).value;
        if ($.trim(checkValue) != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/checkMobileValidation') }}",
                method: 'post',
                data: {
                    tableName1: tableName1,
                    tableName2: tableName2,
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
</script>
@endsection
