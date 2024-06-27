<!--

    Date               : 03 Jun 2021
    Description        : Global Config edit screen
    Last Modified Date : 03 Jun 2021

-->

@extends('layouts.main')
@section('content')
<?php
$result['testing_algorithm'] = explode(',', $result['testing_algorithm']);
?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">{{ __('messages.global_config') }}</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/globalconfig/">{{ __('messages.global_config') }}</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> {{ __('messages.edit') }} {{ __('messages.global_config') }}</h4>
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
                                <!-- <form class="form form-horizontal" role="form" name="editGlobalConfig" id="editGlobalConfig" method="post" action="/globalconfig/edit/" autocomplete="off" enctype="multipart/form-data"  onsubmit="validateNow();return false;"> -->
                                <form class="form form-horizontal" role="form" name="editGlobalConfig" id="editGlobalConfig" method="POST" action="/globalconfig/updateglobal" autocomplete="off" enctype="multipart/form-data" onsubmit="validateNow();return false;">
                                    <input type="hidden" id="removed" name="removed" value="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.instance_name') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="instance_name" value="{{$result['instance_name']}}" class="form-control isRequired" autocomplete="off" title="Enter Instance Name" name="instance_name" placeholder="{{ __('messages.enter') }} {{ __('messages.instance_name') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.institute_name') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="institute_name" value="{{$result['institute_name']}}" class="form-control isRequired" autocomplete="off" title="Enter Institute Name" name="institute_name" placeholder="{{ __('messages.enter') }} {{ __('messages.institude_name') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.admin_name') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="admin_name" value="{{$result['admin_name']}}" class="form-control isRequired" autocomplete="off" title="Enter Admin Name" name="admin_name" placeholder="{{ __('messages.enter') }} {{ __('messages.admin_name') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.admin_email') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="admin_email" value="{{$result['admin_email']}}" class="form-control isRequired" autocomplete="off" title="Enter Admin Email" name="admin_email" placeholder="{{ __('messages.enter') }} {{ __('messages.admin_email') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.admin_phone') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="admin_phone" value="{{$result['admin_phone']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Admin Phone" name="admin_phone" title="{{ __('messages.enter') }} {{ __('messages.admin_phone') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.recency_test') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="recency_test" name="recency_test" title="{{ __('messages.select') }} { __('messages.recency_test') }}">
                                                        <option value="enabled" {{ $result['recency_test'] == 'enabled' ?  'selected':''}}>Enabled</option>
                                                        <option value="disabled" {{ $result['recency_test'] == 'disabled' ?  'selected':''}}>Disabled</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.number_of_test') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="no_of_test" name="no_of_test" title="{{ __('messages.select') }} {{ __('messages.number_of_test') }}">
                                                        <option value="1" {{ $result['no_of_test'] == '1' ?  'selected':''}}>1</option>
                                                        <option value="2" {{ $result['no_of_test'] == '2' ?  'selected':''}}>2</option>
                                                        <option value="3" {{ $result['no_of_test'] == '3' ?  'selected':''}}>3</option>
                                                        <option value="4" {{ $result['no_of_test'] == '4' ?  'selected':''}}>4</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.latitude') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="latitude" value="{{$result['latitude']}}" class="form-control isRequired" autocomplete="off" title="Enter Latitude" name="latitude" placeholder="{{ __('messages.enter') }} {{ __('messages.latitude') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.longtitude') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="longitude" value="{{$result['longitude']}}" class="form-control isRequired" autocomplete="off" title="Enter longitude" name="longitude" placeholder="{{ __('messages.enter') }} {{ __('messages.longtitude') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.title_name') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="title_name" value="{{$result['title_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Title Name" name="title_name" title="{{ __('messages.enter') }} {{ __('messages.title_name') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.map_zoom_level') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="number" min="0" id="map_zoom_level" value="{{$result['map_zoom_level']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Map Zoom Level" name="map_zoom_level" title="{{ __('messages.enter') }} {{ __('messages.map_zoom_level') }}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.testing_algorithm') }} <span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <select multiple="multiple" class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="testing_algorithm" name="testing_algorithm[]" title="{{ __('messages.select') }} {{ __('messages.testing_algorithm') }}">
                                                        <option value="serial" {{ in_array("serial",$result['testing_algorithm']) ?  'selected':''}}>Serial</option>
                                                        <option value="parallel" {{ in_array("parallel",$result['testing_algorithm']) ?  'selected':''}}>Parallel</option>
                                                        <option value="who3" {{ in_array("who3",$result['testing_algorithm']) ?  'selected':''}}>WHO 3</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5> {{ __('messages.disable_inactive_users') }}<span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" style="width:100%;" id="disable_inactive_user" name="disable_inactive_user" title="{{ __('messages.select') }} {{ __('messages.disable_inactive_users') }}" onchange="checkDisableInactiveUser();">
                                                        <option value="yes" {{ $result['disable_inactive_user'] == 'yes' ?  'selected':''}}>Yes</option>
                                                        <option value="no" {{ $result['disable_inactive_user'] == 'no' ?  'selected':''}}>No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12" id="noOfMonthDiv">
                                            <fieldset>
                                                <h5> {{ __('messages.no_of_months') }}</h5>
                                                <div class="form-group">
                                                    <input type="text" id="disable_user_no_of_months" value="{{$result['disable_user_no_of_months']}}" class="form-control" autocomplete="off" title="Enter No. of months" name="disable_user_no_of_months" placeholder="{{ __('messages.enter') }} {{ __('messages.no_of_months') }}">
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset class="form-group">
                                                <h5>{{ __('messages.logo') }}
                                                </h5>
                                                @if($result['logo'] == null)
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-outline-secondary btn-file">
                                                            <span class="fileinput-new">Select image</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="uploadFile[]">
                                                            <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                                        </span>
                                                        <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                        <img src="{{ url('/') }}{{ $result['logo'] }}" style="width:160px;height:100px" />
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-outline-secondary btn-file">
                                                            <span class="fileinput-new">Select image</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="uploadFile[]">
                                                            <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                                        </span>
                                                        <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput" onclick="storeHiddenValue()">Remove</a>
                                                    </div>
                                                </div>
                                                @endif
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.prefered_language') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="prefered_language" name="prefered_language" title="{{ __('messages.select') }} { __('messages.prefered_language') }}">
                                                        <option value="en" {{ $result['prefered_language'] == 'en' ?  'selected':''}}>English</option>
                                                        <option value="fr" {{ $result['prefered_language'] == 'fr' ?  'selected':''}}>French</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.training_mode') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" onchange="displayTrainingName()" autocomplete="off" style="width:100%;" id="training_mode" name="training_mode" title="{{ __('messages.select') }} {{ __('messages.training_mode') }}">
                                                        <option value="on" {{ $result['training_mode'] == 'on' ?  'selected':''}}>On</option>
                                                        <option value="off" {{ $result['training_mode'] == 'off' ?  'selected':''}}>Off</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 d-none training_message_div">
                                            <fieldset>
                                                <h5>{{ __('messages.training_message') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="textarea" id="training_message" value="{{$result['training_message']}}" class="form-control isRequired" autocomplete="off" title="Enter Instance Name" name="training_message" placeholder="{{ __('messages.enter') }} {{ __('messages.training_message') }}">
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <div class="form-actions right">
                                        <a href="/globalconfig">
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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jasny-bootstrap.css')}}">
<script src="{{ asset('assets/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
<script>
    duplicateName = true;
    $(document).ready(function() {
        checkDisableInactiveUser();
        displayTrainingName();
    });

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editGlobalConfig'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editGlobalConfig').submit();
            }
        } else {
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

    function storeHiddenValue() {
        var filePath = "{{ $result['logo'] }}";
        $('#removed').val(filePath);
    }

    function checkDisableInactiveUser() {
        inactiveUser = $("#disable_inactive_user").val();
        if (inactiveUser == 'yes') {
            $("#noOfMonthDiv").show();
        } else {
            $("#noOfMonthDiv").hide();
            $("#disable_user_no_of_months").val('');
        }
    }

    function displayTrainingName() {
        var selectedValue = document.getElementById('training_mode').value;
       if(selectedValue == "on") {
        $('.training_message_div').removeClass('d-none');
        return;
       }
       $('.training_message_div').addClass('d-none');

    }
</script>
@endsection
