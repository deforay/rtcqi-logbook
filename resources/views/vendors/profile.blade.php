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
            <h3 class="content-header-title mb-0 d-inline-block">Profile</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/dashboard/">Home</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Edit Profile</h4>
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
                                <form class="form form-horizontal" role="form" name="editvendor" id="editvendor" method="post" action="/vendors/profile/{{base64_encode($vendors[0]->vendor_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
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
                                                    <input type="email" id="vendorEmail" class="form-control isEmail" value="{{ $vendors[0]->email }}" autocomplete="off" placeholder="Enter Vendor Email" name="vendorEmail" title="Please Enter Valid Email" onblur="checkMobileValidation('vendors','users', 'email', this.id,'{{$fnct}}', 'Entered emailId is already exist. . Please enter another email Id.');">
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
                                        <a href="/dashboard">
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
        $('#confirmPassword').keyup(function() {			
            var nPws=$('#password').val();
            var cPws=$('#confirmPassword').val();
            if(nPws!=cPws){
                $('#confirmresult').html('Passwords do not match.')
                $('#passwordCheck').val('');
            }else{

                $('#passwordCheck').val('passwordCheck');
            $('#confirmresult').html('')}
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

    function checkPasswordMatch()
    {
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();
        if(password.trim() && confirmPassword.trim())
        {
            if(password.trim() != confirmPassword.trim())
            {
                $("#confirmPassword").onfocus = function () {
                    // $("#confirmPassword").style.background = "#FFFFFF";
                }
            }
            else
            {
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

    function checkMobileValidation(tableName1,tableName2,fieldName, obj, fnct, msg) {
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
   
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endsection