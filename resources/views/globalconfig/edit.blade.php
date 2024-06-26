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
            <h3 class="content-header-title mb-0 d-inline-block">Global Config</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/globalconfig/">Global Config</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Edit Global Config</h4>
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
                                                <h5>Instance Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="instance_name" value="{{$result['instance_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Instance Name" name="instance_name" title="Please Enter Instance Name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Institute Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="institute_name" value="{{$result['institute_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Institute Name" name="institute_name" title="Please Enter Institute Name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Admin Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="admin_name" value="{{$result['admin_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Admin Name" name="admin_name" title="Please Enter Admin Name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Admin Email<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="admin_email" value="{{$result['admin_email']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Admin Email" name="admin_email" title="Please Enter Admin Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Admin Phone<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="admin_phone" value="{{$result['admin_phone']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Admin Phone" name="admin_phone" title="Please Enter Admin Phone">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Recency Test<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="recency_test" name="recency_test" title="Please Select Recency Test">
                                                        <option value="enabled" {{ $result['recency_test'] == 'enabled' ?  'selected':''}}>Enabled</option>
                                                        <option value="disabled" {{ $result['recency_test'] == 'disabled' ?  'selected':''}}>Disabled</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Number of Test<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="no_of_test" name="no_of_test" title="Please Select Number of Test">
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
                                                <h5>Latitude<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="latitude" value="{{$result['latitude']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Latitude" name="latitude" title="Please Enter Latitude">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Longitude<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="longitude" value="{{$result['longitude']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter longitude" name="longitude" title="Please Enter Longitude">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Title Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="title_name" value="{{$result['title_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Title Name" name="title_name" title="Please Enter Title Name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Map Zoom Level<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="number" min="0" id="map_zoom_level" value="{{$result['map_zoom_level']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Map Zoom Level" name="map_zoom_level" title="Please Enter Map Zoom Level">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Testing Algorithm <span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <select multiple="multiple" class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="testing_algorithm" name="testing_algorithm[]" title="Please Select Testing Algorithm">
                                                        <option value="serial" {{ in_array("serial",$result['testing_algorithm']) ?  'selected':''}}>Serial</option>
                                                        <option value="parallel" {{ in_array("parallel",$result['testing_algorithm']) ?  'selected':''}}>Parallel</option>
                                                        <option value="who3" {{ in_array("who3",$result['testing_algorithm']) ?  'selected':''}}>WHO 3</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5> Disable Inactive Users<span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" style="width:100%;" id="disable_inactive_user" name="disable_inactive_user" title="Please Select Disable Inactive User" onchange="checkDisableInactiveUser();">
                                                        <option value="yes" {{ $result['disable_inactive_user'] == 'yes' ?  'selected':''}}>Yes</option>
                                                        <option value="no" {{ $result['disable_inactive_user'] == 'no' ?  'selected':''}}>No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12" id="noOfMonthDiv">
                                            <fieldset>
                                                <h5> No. of months</h5>
                                                <div class="form-group">
                                                    <input type="text" id="disable_user_no_of_months" value="{{$result['disable_user_no_of_months']}}" class="form-control" autocomplete="off" placeholder="Enter No. of months" name="disable_user_no_of_months" title="Please enter number of month">
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset class="form-group">
                                                <h5>Logo
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
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/globalconfig">
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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jasny-bootstrap.css')}}">
<script src="{{ asset('assets/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
<script>
    duplicateName = true;
    $(document).ready(function() {
        checkDisableInactiveUser();
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
</script>
@endsection
