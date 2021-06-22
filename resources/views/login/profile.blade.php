<!-- 
    Author             : Prasath M
    Date               : 27 May 2021
    Description        : Login screen
    Last Modified Date : 27 May 2021
    Last Modified Name : Prasath M
-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<?php

use App\Service\CommonService;
$commonservice = new CommonService();

?>
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
    td {
        padding-left: 0.50rem !important;
        padding-right: 0.50rem !important;
    }
    table {
        border-radius: 6px !important;
        -webkit-box-shadow: 0px 0px 8px 3px rgba(161,161,168,1);
        -moz-box-shadow: 0px 0px 8px 3px rgba(161,161,168,1);
        box-shadow: 0px 0px 5px -1px rgb(197, 197, 197);
    }

    table>thead{
        background-color: #d4e4f09e !important;
        /* color: #9d9da0;
        text-transform: uppercase !important; */
    }
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>RTCQI LOGBOOK</title>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
</head>
<style>.mandatory{
    color:red;
}
</style>
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
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Vendor profile </span>
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
                                        <div class="otpContent" style="text-align: center;">
                                            <form class="form form-horizontal" role="form" name="otpValidation" id="otpValidation" method="post"  autocomplete="off" onsubmit="validateOtp();return false;">
                                                <div class="col-xl-4 col-lg-12" style="margin-left: 380px;">
                                                    <fieldset>
                                                        <h5>OTP <span class="mandatory">*</span>
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="text" min=0 maxlength="6" onkeypress="return isNumberKey(event);"  value="" id="otpLogin" class="form-control isRequired" autocomplete="off" placeholder="Enter the OTP" name="otpLogin" title="Please enter Valid OTP">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-xl-6 col-lg-12" style="margin-left: 280px;">
                                                    <fieldset>
                                                        <button type="submit" onclick="validateOtp();return false;" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> Validate OTP
                                                        </button>
                                                    
                                                    </fieldset>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="mainContent" style="display:none;">
                                                <form class="form form-horizontal" role="form" name="editvendor" id="editvendor" method="post" action="/vendors/edit/{{($id)}}" autocomplete="off" onsubmit="validateNow();return false;">
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
                                                            <h5>Vendor Code
                                                            <!-- <span class="mandatory">*</span> -->
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="text" id="vendorCode" value="{{ $vendors[0]->vendor_code }}" class="form-control" autocomplete="off" placeholder="Enter Vendor Code" name="vendorCode" title="Please enter Vendor Code">
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
                                                            </fieldset>
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
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-12">
                                                        <fieldset>
                                                            <h5>Password <span class="mandatory">*</span>
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="password" id="password" class="form-control isRequired" autocomplete="off" placeholder="Enter Password" name="password" title="Please Enter Password">
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
                                                                <input type="password" id="confirmPassword" onkeyup="checkPasswordMatch()" class="form-control isRequired" autocomplete="off" placeholder="Enter Confirm Pasword" name="confirmPassword" title="Please Enter Confirm Pasword">
                                                                <span id="confirmresult" style="width: 100%;margin-top: 0.25rem;font-size: 80%;color: #FF4961;"></span>
                                                                <input type="hidden" id="passwordCheck" name="passwordCheck" class="isRequired" title="Passwords do not match.">
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                            <th>Bank Name<span class="mandatory">*</span></th>
                                                            <th>Account No <span class="mandatory">*</span></th>
                                                            <th>Account <br/>Holder Name <span class="mandatory">*</span></th>
                                                            <th>Branch <br/>Name<span class="mandatory">*</span></th>
                                                            <th>Address <span class="mandatory">*</span>&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;</th>
                                                            <th>City<span class="mandatory">*</span></th>
                                                            <th>Country<span class="mandatory">*</span></th>
                                                            <th>SWIFT Code<span class="mandatory">*</span></th>
                                                            <th>IBAN<span class="mandatory">*</span></th>
                                                            <th>Intermediary<br>Bank<span class="mandatory">*</span></th>
                                                            <th>Status</th>
                                                            <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <?php $z=0; ?>
                                                        <tbody id="bankDetails">
                                                        @if(isset($vendors[0]->bank_id) && $vendors[0]->bank_id!='')
                                                        @foreach($vendors as $vend)
                                                            <tr>
                                                                <input type="hidden" name="bankId[]" id="bankId{{$z}}" value="{{ $vend->bank_id }}"/>
                                                            <td>
                                                                <input type="text" id="bankName{{$z}}" value="{{ $vend->bank_name }}" name="bankName[]" class="isRequired form-control"  title="Please enter bank name" placeholder="Bank Name">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="accNo{{$z}}" value="{{ $vend->bank_account_no }}" name="accNo[]" class="isRequired form-control datas"  title="Please enter account no" placeholder="Account No">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="accName{{$z}}" value="{{ $vend->account_holder_name }}" name="accName[]" class="isRequired form-control"  title="Please enter account holder name" placeholder="Account Holder Name">
                                                            </td>
                                                            <td>
                                                                <input type="text" value="{{ $vend->bank_branch }}" class="form-control qty isRequired" id="branch{{$z}}" name="branch[]" placeholder="Branch Name" title="Please enter branch name" value=""/>
                                                            </td>
                                                            <td>
                                                                <textarea id="address{{$z}}" name="address[]" class="isRequired form-control"  title="Please enter address" placeholder="address">{{ $vend->bank_address }}</textarea>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="city{{$z}}" value="{{ $vend->bank_city }}" name="city[]" class="isRequired form-control"  title="Please enter city" placeholder="city">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="country{{$z}}" value="{{ $vend->bank_country }}" name="country[]" class="isRequired form-control"  title="Please enter country" placeholder="country">
                                                            </td>
                                                            <td>
                                                                <input type="text" value="{{ $vend->swift_code }}" class="form-control isRequired" id="swiftCode{{$z}}" name="swiftCode[]" placeholder="SWIFT Code" title="Please enter SWIFT code" value=""/>
                                                            </td>
                                                            <td>
                                                                <input type="text" value="{{ $vend->iban }}" id="iban{{$z}}" name="iban[]" class="isRequired form-control"  title="Please enter IBAN" placeholder="IBAN">
                                                            </td>
                                                            <td>
                                                                <input type="text" value="{{ $vend->intermediary_bank }}" id="intermediaryBank{{$z}}" name="intermediaryBank[]" class="isRequired form-control"  title="Please enter intermediary bank" placeholder="Intermediary Bank">
                                                            </td>
                                                            <td>
                                                                <select class="form-control col-md-11 isRequired bankStatus" autocomplete="off" style="width:100%;" id="bankStatus{{$z}}" name="bankStatus[]" title="Please select status" >
                                                                    <option value="1" {{ $vend->bank_status == 1 ?  'selected':''}}>Active</option>
                                                                    <option value="0" {{ $vend->bank_status == 0 ?  'selected':''}}>Inactive</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                {{-- <div class="col-md-12"> --}}
                                                                    <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>
                                                                    &nbsp;&nbsp;
                                                                    <a class="btn btn-sm btn-warning" href="javascript:void(0);" id="{{$vend->bank_id}}" onclick="removeRow(this.parentNode);deleteBankDet(this.id,{{$z}})"><i class="ft-minus"></i></a>
                                                                {{-- </div> --}}
                                                            </td>
                                                            </tr>
                                                        <?php $z++; ?>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td>
                                                                <input type="text" id="bankName{{$z}}" name="bankName[]" class="isRequired form-control"  title="Please enter bank name" placeholder="Bank Name">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="accNo{{$z}}" name="accNo[]" class="isRequired form-control datas"  title="Please enter account no" placeholder="Account No">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="accName{{$z}}" name="accName[]" class="isRequired form-control"  title="Please enter account holder name" placeholder="Account Holder Name">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control qty isRequired" id="branch{{$z}}" name="branch[]" placeholder="Branch Name" title="Please enter branch name" value=""/>
                                                            </td>
                                                            <td>
                                                                <textarea id="address{{$z}}" name="address[]" class="isRequired form-control"  title="Please enter address" placeholder="address"></textarea>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="city{{$z}}" name="city[]" class="isRequired form-control"  title="Please enter city" placeholder="city">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="country{{$z}}" name="country[]" class="isRequired form-control"  title="Please enter country" placeholder="country">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control isRequired" id="swiftCode{{$z}}" name="swiftCode[]" placeholder="SWIFT Code" title="Please enter SWIFT code" value=""/>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="iban{{$z}}" name="iban[]" class="isRequired form-control"  title="Please enter IBAN" placeholder="IBAN">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="intermediaryBank{{$z}}" name="intermediaryBank[]" class="isRequired form-control"  title="Please enter intermediary bank" placeholder="Intermediary Bank">
                                                            </td>
                                                            <td>
                                                                <select class="form-control col-md-11 isRequired bankStatus" autocomplete="off" style="width:100%;" id="bankStatus{{$z}}" name="bankStatus[]" title="Please select status" >
                                                                    <option value="1">Active</option>
                                                                    <option value="0" selected>Inactive</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                {{-- <div class="col-md-12"> --}}
                                                                    <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>
                                                                    &nbsp;&nbsp;
                                                                    <a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a>
                                                                {{-- </div> --}}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <input type="hidden" name="deleteBankDetail" id="deleteBankDetail" value="" />
                                                <div class="form-actions right">
                                                    <input type="hidden" id="vendorStatus" value="active" name="vendorStatus">
                                                    <input type="hidden" id="vendorProfile" value="vendorProfile" name="vendorProfile">
                                                    <!-- <input type="hidden" id="password" value="{{$vendors[0]->password}}" name="password"> -->
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
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <script src="{{ asset('app-assets/vendors/js/datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/ui/jquery-ui/date-pickers.js')}}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js')}}"></script>

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
            formId: 'editvendor'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editvendor').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

    function validateOtp() {
    
    flag = deforayValidator.init({
        formId: 'otpValidation'
    });

    if (flag == true) {
        var otp = '<?php echo session("login_otp"); ?>';
        console.log(otp);
        if(otp == $("#otpLogin").val())
        {
            console.log("verified");
            $(".otpContent").css("display", "none");
            $(".mainContent").css("display", "block");
            flag='<div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-2" role="alert" ><div class="text-center" style="font-size: 18px;"><b>Verified OTP</b></div>';
            flag+='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
        }
        else{
            console.log("not verified");
            flag='<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" role="alert" ><div class="text-center" style="font-size: 18px;"><b>Please enter valid OTP</b></div>';
            flag+='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
        }
        $('#show_alert').html(flag).delay(3000).fadeOut();
        $('#show_alert').css("display", "block");
    } else {
        // Swal.fire('Any fool can use a computer');
        $('#show_alert').html(flag).delay(3000).fadeOut();
        $(".infocus").focus();
    }
}

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    rowCount = {{$z}};
    function insRow() {
        rowCount++;
        rl = document.getElementById("bankDetails").rows.length;
        var a = document.getElementById("bankDetails").insertRow(rl);
        a.setAttribute("style", "display:none;");
        a.setAttribute("class", "data");
        var b = a.insertCell(0);
        var c = a.insertCell(1);
		var d = a.insertCell(2);
        var e = a.insertCell(3);
        var m = a.insertCell(4);
        var f = a.insertCell(5);
        var g = a.insertCell(6);
        var h = a.insertCell(7);
        var i = a.insertCell(8);
        var j = a.insertCell(9);
        var k = a.insertCell(10);
        var l = a.insertCell(11);

        rl = document.getElementById("bankDetails").rows.length - 1;
        b.innerHTML = '<input type="text" id="bankName'+rowCount+'" name="bankName[]" class="isRequired form-control"  title="Please enter bank name" placeholder="Bank Name">';
        c.innerHTML = '<input type="text" id="accNo'+rowCount+'" name="accNo[]" class="isRequired form-control datas"  title="Please enter account no" placeholder="Account No">';
        d.innerHTML = '<input type="text" id="accName'+rowCount+'" name="accName[]" class="isRequired form-control"  title="Please enter account holder name" placeholder="Account Holder Name">';
        e.innerHTML = '<input type="text" class="form-control qty isRequired" id="branch'+rowCount+'" name="branch[]" placeholder="Branch Name" title="Please enter branch name" value=""/>';
        f.innerHTML = '<input type="text" id="city'+rowCount+'" name="city[]" class="isRequired form-control"  title="Please enter city" placeholder="city">'
        m.innerHTML = '<textarea id="address'+rowCount+'" name="address[]" class="isRequired form-control"  title="Please enter address" placeholder="address"></textarea>'
        g.innerHTML = '<input type="text" id="country'+rowCount+'" name="country[]" class="isRequired form-control"  title="Please enter country" placeholder="country">'
		h.innerHTML = '<input type="text" class="form-control isRequired" id="swiftCode'+rowCount+'" name="swiftCode[]" placeholder="SWIFT Code" title="Please enter SWIFT code" value=""/>';
        i.innerHTML = '<input type="text" id="iban'+rowCount+'" name="iban[]" class="isRequired form-control"  title="Please enter IBAN" placeholder="IBAN">'
        j.innerHTML = '<input type="text" id="intermediaryBank'+rowCount+'" name="intermediaryBank[]" class="isRequired form-control"  title="Please enter intermediary bank" placeholder="Intermediary Bank">';
        k.innerHTML = '<select class="form-control col-md-11 isRequired bankStatus" autocomplete="off" style="width:100%;" id="bankStatus'+rowCount+'" name="bankStatus[]" title="Please select status">\
                            <option value="1">Active</option>\
                            <option value="0" selected>Inactive</option>\
                        </select>';
        l.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void('+rowCount+');" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
        $(a).fadeIn(800);
    }

    function removeRow(el) {
        $(el).parent().fadeOut("slow", function () {
            $(el).parent().remove();
            rowCount = rowCount-1;
            rl = document.getElementById("bankDetails").rows.length;
            if (rl == 0) {
                insRow();
            }
        });
    }

    deleteBankDetail = [];
    function deleteBankDet(bankId,rowId) {
        deleteBankDetail.push(bankId);
        document.getElementById("deleteBankDetail").value=deleteBankDetail;
        console.log(document.getElementById("deleteBankDetail").value)
    }
</script>