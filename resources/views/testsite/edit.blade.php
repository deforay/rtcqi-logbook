<!--

    Date               : 28 May 2021
    Description        : Test Site edit screen
    Last Modified Date : 28 May 2021

-->
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">{{ __('messages.test_site') }}</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/testsite/">{{ __('messages.test_site') }}</a>
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
                        <h4 class="form-section"><i class="la la-plus-square"></i> {{ __('messages.edit') }} {{ __('messages.test_site') }}</h4>
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
                                <form class="form form-horizontal" role="form" name="editTestSite" id="editTestSite" method="post" action="/testsite/edit/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    @php
                                    $fnct = "ts_id##".($result[0]->ts_id);
                                    @endphp
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.site_id') }}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="siteId" value="{{$result[0]->site_id}}" class="form-control" autocomplete="off" placeholder="Enter Site ID" name="siteId" title="Please enter Site ID" onblur="checkNameValidation('test_sites','site_ID', this.id,'{{$fnct}}','Entered Site Id is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.external_site_id') }}
                                               </h5>
                                                <div class="form-group">
                                                    <input type="text" id="externalSiteId" value="{{$result[0]->external_site_id}}" class="form-control" autocomplete="off" placeholder="Enter External Site ID" name="externalSiteID" title="Please enter External Site ID">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.site_name') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="site_name" value="{{$result[0]->site_name}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Site Name" name="siteName" title="Please Enter Site Name" onblur="checkNameValidation('test_sites','site_name', this.id,'{{$fnct}}','Entered Site Name is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.entry_point') }} / {{ __('messages.site_id') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select multiple="multiple" class="js-example-basic-multiple form-control isRequired" autocomplete="off" style="width:100%;" id="sitetypeId" name="sitetypeId[]" title="Please select entry point / site ID">
                                                        @foreach($sitetype as $row1)
                                                        <option value="{{$row1->st_id}}" {{ in_array($row1->st_id, $resultsitetype) ?  'selected':''}}>{{$row1->site_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.implementing_partners') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="implementingPartnerId" name="implementingPartnerId" title="Please select implementing partner">
                                                        @foreach($implementingpartners as $row1)
                                                        <option value="{{$row1->implementing_partner_id}}" {{ $result[0]->site_implementing_partner_id == $row1->implementing_partner_id ?  'selected':''}}>{{$row1->implementing_partner_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.latitude') }}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="latitude" value="{{$result[0]->site_latitude}}" class="form-control " autocomplete="off" placeholder="Enter Latitude" name="latitude" title="Please Enter Latitude">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.longtitude') }}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="longitude" value="{{$result[0]->site_longitude}}" class="form-control " autocomplete="off" placeholder="Enter Longitude" name="longitude" title="Please Enter Longitude">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.primary_email') }}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="primaryEmail" value="{{$result[0]->site_primary_email}}" class="form-control isEmail" autocomplete="off" placeholder="Enter Primary Email" name="primaryEmail" title="Please Enter Primary Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.secondary_email') }}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="secondaryEmail" value="{{$result[0]->site_secondary_email}}" class="form-control isEmail" autocomplete="off" placeholder="Enter Secondary Email" name="secondaryEmail" title="Please Enter Secodary Email">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.primary_mobile_number') }} </h5>
                                                <div class="form-group">
                                                    <input type="tel" maxlength="10" onkeypress="return isNumberKey(event);" id="primaryMobileNo" value="{{$result[0]->site_primary_mobile_no}}" class="form-control" autocomplete="off" placeholder="Enter Primary Mobile Number" name="primaryMobileNo" title="Please Enter Primary Mobile Number">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <>{{ __('messages.secondary_mobile_number') }} </h5>
                                                <div class="form-group">
                                                    <input type="tel" maxlength="10" onkeypress="return isNumberKey(event);" id="secondaryMobileNo" value="{{$result[0]->site_secondary_mobile_no}}" class="form-control" autocomplete="off" placeholder="Enter Secondary Mobile Number" name="secondaryMobileNo" title="Please Enter Secondary Mobile Number">
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.address') }} 1</h5>
                                                <div class="form-group">
                                                    <input type="text" id="address1" value="{{$result[0]->site_address1}}" class="form-control  " autocomplete="off" placeholder="Enter Address1" name="address1" title="Please Enter Address1">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.address') }} 2</h5>
                                                <div class="form-group">
                                                    <input type="text" id="address2" value="{{$result[0]->site_address2}}" class="form-control  " autocomplete="off" placeholder="Enter Address2" name="address2" title="Please Enter Address2">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.postal_code') }}</h5>
                                                <div class="form-group">
                                                    <input type="tel" maxlength="6" value="{{$result[0]->site_postal_code}}" onkeypress="return isNumberKey(event);" id="postalCode" class="form-control" autocomplete="off" placeholder="Enter Postal Code" name="postalCode" title="Please Enter Postal Code">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.province_name') }}<span class="mandatory">*</span>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="provincesssId" name="provincesssId" title="Please Select Province Name">
                                                        <option value="">Select Province Name</option>
                                                        @foreach($province as $row)
                                                        <option value="{{$row->province_id}}" {{ $result[0]->site_province == $row->province_id ?  'selected':''}}>{{$row->province_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.district_name') }}<span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="districtId" name="districtId" title="Please Select District Name">
                                                        <option value="">Select District Name</option>
                                                        @foreach($district as $row)
                                                        <option value="{{$row->district_id}}" {{ $result[0]->site_district == $row->district_id ?  'selected':''}}>{{$row->district_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.sub_district_name') }}
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control" autocomplete="off" style="width:100%;" id="subDistrictId" name="subDistrictId" title="Please Select Sub District Name">
                                                        <option value="">Select Sub District Name</option>
                                                        @foreach($subdistrict as $row)
                                                        <option value="{{$row->sub_district_id}}" {{ $result[0]->site_sub_district == $row->sub_district_id ?  'selected':''}}>{{$row->sub_district_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.country') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="country" value="{{$result[0]->site_country}}" class="form-control  isRequired" autocomplete="off" placeholder="Enter Country" name="country" title="Please Enter Country">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.city') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="city" value="{{$result[0]->site_city}}" class="form-control  isRequired" autocomplete="off" placeholder="Enter City" name="city" title="Please Enter City">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                            <h5>{{ __('messages.test_site_status') }}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testSiteStatus" name="testSiteStatus" title="Please Select Test Site Status">
                                                        <option value="active" {{ $result[0]->test_site_status == 'active' ?  'selected':''}}>Active</option>
                                                        <option value="inactive" {{ $result[0]->test_site_status == 'inactive' ?  'selected':''}}>Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <div class="form-actions right">
                                        <a href="/testsite">
                                            <button type="button" class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> {{ __('messages.cancel') }}
                                           </button>
                                        </a>
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> {{ __('messages.update') }}
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
            formId: 'editTestSite'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editTestSite').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }
</script>

<script type='text/javascript'>
    $(document).ready(function() {

        $('.js-example-basic-multiple').select2();
        $selectElement = $('#sitetypeId').select2({
            placeholder: "Select Entry Point / Site Type",
            allowClear: true
        });

        // Province Change
        $('#provincesssId').change(function() {

            // Province id
            var id = $(this).val();

            // Empty the dropdown
            $('#districtId').find('option').not(':first').remove();
            $('#subDistrictId').find('option').not(':first').remove();

            // AJAX request
            $.ajax({
                url: "{{url('/getDistrict') }}/" + id,
                type: 'get',
                dataType: 'json',
                success: function(response) {

                    $.each(response, function(key, value) {
                        // console.log(value.district_id);
                        $("#districtId").append('<option value="' + value.district_id + '">' + value.district_name + '</option>');
                    });

                }
            });
        });


        $('#districtId').change(function() {

            // District id
            var id = $(this).val();

            // Empty the dropdown
            $('#subDistrictId').find('option').not(':first').remove();

            // AJAX request
            $.ajax({
                url: "{{url('/getSubDistrict') }}/" + id,
                type: 'get',
                dataType: 'json',
                success: function(response) {

                    $.each(response, function(key, value) {
                        // console.log(value.sub_district_id);
                        $("#subDistrictId").append('<option value="' + value.sub_district_id + '">' + value.sub_district_name + '</option>');
                    });

                }
            });
        });

    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
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
                    fnct:fnct,
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
