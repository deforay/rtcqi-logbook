<!-- 
    Author             : Sudarmathi M
    Date               : 3 Feb 2020
    Description        : customers add screen
    Last Modified Date : 3 Feb 2020
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
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Customer</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/customers/">Customer</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add Customer</h4>
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
                                <form class="form form-horizontal" role="form" name="addcustomers" id="addcustomers" method="post" action="/customers/add/{{$customerId}}" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer Name <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="customerName" value="{{ $prospect[0]->prospect_name }}" class="form-control isRequired" autocomplete="off" placeholder="Enter a customer name" name="customerName" title="Please enter customer name">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer SAP code <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="customerSapcode" class="form-control isRequired" autocomplete="off" placeholder="Enter a customer SAP code" name="customerSapcode" title="Please enter customer SAP code" onblur="duplicateValidation('customers','customer_SAP_code', this.id, 'Entered customer SAP code is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer GST No
                                                    <!-- <span class="mandatory">*</span> -->
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="customerGstno" class="form-control " autocomplete="off" placeholder="Enter a customer GST number" name="customerGstno" title="Please enter customer GST number">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer PAN
                                                    <!-- <span class="mandatory">*</span> -->
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="customerPan" class="form-control " autocomplete="off" placeholder="Enter a customer PAN" name="customerPan" title="Please enter customer PAN">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer Email
                                                    <!-- <span class="mandatory">*</span> -->
                                                </h5>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" value="{{ $prospect[0]->primary_email }}" autocomplete="off" placeholder="Enter a customer email" autocomplete="off" id="customerEmail" name="customerEmail" title="Please enter valid email address" onblur="duplicateValidation('customers','customer_email', this.id, 'Entered customer Mail Id is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer Mobile No <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="tel" class="form-control isMobNo isRequired" value="{{ $prospect[0]->primary_phone }}" onkeypress="return isNumberKey(event);" autocomplete="off" placeholder="Enter a customer mobile number" autocomplete="off" maxlength=10 id="cutomerPhoneNo" name="cutomerPhoneNo" title="Please enter mobile number" onblur="duplicateValidation('customers','customer_phno', this.id, 'Entered customer mobile Number is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Address Line 1
                                                    <!-- <span class="mandatory">*</span> </h5> -->
                                                    <div class="form-group">
                                                        <input type="text" value="{{ $prospect[0]->prospect_address_one }}" name="addrline1" id="addrline1" class="form-control " placeholder="Enter Address" title="Please enter address line 1" value="" />
                                                    </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Address Line 2 </h5>
                                                <div class="form-group">
                                                    <input type="text" value="{{ $prospect[0]->prospect_address_two }}" name="addrline2" id="addrline2" class="form-control" placeholder="Enter Address" title="Please enter address line 2" value="" />
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Address Line 3 </h5>
                                                <div class="form-group">
                                                    <input type="text" value="{{ $prospect[0]->prospect_address_three }}" name="addrline3" id="addrline3" class="form-control" placeholder="Enter Address" title="Please enter address line 3" value="" />
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Address Line 4 </h5>
                                                <div class="form-group">
                                                    <input type="text" value="{{ $prospect[0]->prospect_address_four }}" name="addrline4" id="addrline4" class="form-control" placeholder="Enter Address" title="Please enter address line 4" value="" />
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer City
                                                    <!-- <span class="mandatory">*</span> -->
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="customerCity" class="form-control" value="{{ $prospect[0]->prospect_city }}" autocomplete="off" placeholder="Enter a customer city" name="customerCity" title="Please enter customer city">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer State<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="customerState" name="customerState" title="Please select customer state" onchange="getLocation(this.value)">
                                                        <option value="">Select State</option>
                                                        @foreach($states as $type)
                                                        <option value="{{ $type->state_id }}" {{ $prospect[0]->prospect_state == $type->state_id ?  'selected':''}}>{{ $type->state_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer Location <span class="mandatory">*</span>
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="customerLocation" name="customerLocation" title="Please select customer location">
                                                        <option value="">Select Location</option>
                                                        @foreach($location as $locations)
                                                        <option value="{{ $locations->location_id }}" {{ $prospect[0]->prospect_location == $locations->location_id ?  'selected':''}}>{{ $locations->location_name }}</option>
                                                        @endforeach
                                                    </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer Pincode
                                                    <!-- <span class="mandatory">*</span> -->
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="customerPincode" value="{{ $prospect[0]->pincode }}" maxlength='6' onkeypress="return isNumberKey(event);" class="form-control isPincode" autocomplete="off" placeholder="Enter a customer pincode" name="customerPincode" title="Please enter customer pincode">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer Status<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="customerStatus" name="customerStatus" title="Please select customer status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Agent<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="agentId" name="agentId" title="Please select an agent">
                                                        @foreach($agent as $list)
                                                        <option value="{{ $list->agent_id }}">{{ $list->agent_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Customer Group<span class="mandatory">*</span> </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="customerGroupId" name="customerGroupId" title="Please select customer group">
                                                        <option value="">Select customer group</option>
                                                        @foreach($customerGroup as $types)
                                                        <option value="{{ $types->customer_group_id }}">{{ $types->group_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>End Product
                                                    <!-- <span class="mandatory">*</span> </h5> -->
                                                    <div class="form-group">
                                                        <select class="select2 form-control " multiple="multiple" autocomplete="off" style="width:100%;" placeholder="Select  End Product" id="endProductId[]" name="endProductId[]" title="Please select End Product Name">
                                                            @foreach($endProductList as $list)
                                                            <option value="{{ $list->ep_id }}">{{ $list->end_product_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Password
                                                    <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="password" id="password" class="form-control" autocomplete="off" placeholder="Enter a Password" name="password" title="Please enter Password">
                                                    <div class="invalid-feedback">
                                                        must contain atleast 6 characters, 1 number , 1 alphabet and 1 special character
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <fieldset>
                                                <h5>Confirm Password
                                                    <!-- <span class="mandatory">*</span> -->
                                                </h5>
                                                <div class="form-group">
                                                    <input type="password" id="confirmPassword" class="form-control " autocomplete="off" placeholder="Enter a Confirm Pasword" name="confirmPassword" title="Please enter Confirm Pasword">
                                                    <!-- <span id="confirmresult"></span>
                      <input type="hidden" id="passwordCheck" name="passwordCheck" class="isRequired" title="Passwords do not match."> -->
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <br /><br />
                                    <div class="row">
                                        <h4>Consumption Quantity</h4>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="table-responsive">
                                            <div class="bd-example">
                                                <table class="table table-striped table-bordered table-condensed table-responsive-lg">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:55%;">Grade Category<span class="mandatory">*</span></th>
                                                            <th style="width:25%;">Capacity <span class="mandatory">*</span></th>
                                                            <th style="width:20%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="consumptionQuantityDetails">
                                                        <?php $j = 0; ?>
                                                        @foreach($prospectConsumption as $consumptionDetail)
                                                        <tr>
                                                            <td>
                                                                <!-- <select id="grade0" name="gradeCategory[]" class="grade isRequired gradeName form-control datas" title="Please select grade Category">
                                                                    <option value="">Select Grade Category </option>
                                                                    @foreach ($gradeCategoryList as $grades)
                                                                    <option value="{{ $grades->grade_cat_id }}">{{ $grades->grade_cat_name }}</option>
                                                                    @endforeach
                                                                </select> -->
                                                                <select id="grade{{$j}}" name="gradeCategory[]" class="grade isRequired form-control datas" title="Please select grade Category">
                                                                    <option value="">Select Grade Category </option>
                                                                    @foreach ($gradeCategoryList as $grades)
                                                                    <option value="{{ $grades->grade_cat_id }}" {{ $consumptionDetail->grade_cat_id == $grades->grade_cat_id ?  'selected':''}}>{{ $grades->grade_cat_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" value="{{$consumptionDetail->capacity}}" id="capacity{{$j}}" name="capacity[]" class="form-control isRequired" placeholder="capacity" title="Please enter the capacity" value="" />

                                                                <!-- <input type="number" id="capacity0" name="capacity[]" class="form-control isRequired" placeholder="capacity" title="Please enter the capacity" value="" /> -->
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-6">
                                                                        <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insConsumptionQuantityDetailsRow();"><i class="ft-plus"></i></a>
                                                                    </div>
                                                                    <!--    <div class="col-md-6 col-6">
                                                            <a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeConsumptionQuantityDetailsRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a>
                                                        </div> -->
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $j++; ?>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <br />
                                    <div class="row">
                                        <h4>Delivery Address</h4>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="table-responsive">
                                            <div class="bd-example">
                                                <table class="table table-striped table-bordered table-condensed table-responsive-lg" id="addresstable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Location<span class="mandatory">*</span></th>
                                                            <th scope="col">Contact Person</th>
                                                            <th scope="col">Contact No.</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Address I <span class="mandatory">*</span></th>
                                                            <th scope="col">Address II</th>
                                                            <th scope="col">Address III</th>
                                                            <th scope="col">Address IV</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="deliveryAddress">
                                                        <?php $z = 0; ?>
                                                        @foreach($prospect as $locationDetail)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control isRequired" id="location-{{ $z }}" name="location[]" placeholder="Enter Location" title="Please enter location name" value="{{ $locationDetail->location }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" id="locationContactPerson-{{ $z }}" name="locationContactPerson[]" placeholder="Enter Contact Person" title="Please enter contact person" value="{{ $locationDetail->contact_person }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" id="locationContactNo-{{ $z }}" name="locationContactNo[]" placeholder="Enter Contact Number" title="Please enter contact number" value="{{ $locationDetail->contact_no }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" id="locationEmail-{{ $z }}" name="locationEmail[]" placeholder="Enter Email" title="Please enter email" value="{{ $locationDetail->email }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="locationAddress1[]" id="locationAddress1-{{ $z }}" class="form-control isRequired" placeholder="Enter Address" title="Please enter address" value="{{ $locationDetail->address_one }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="locationAddress2[]" id="locationAddress2-{{ $z }}" class="form-control " placeholder="Enter Address" title="Please enter address" value="{{ $locationDetail->address_two }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="locationAddress3[]" id="locationAddress3-{{ $z }}" class="form-control " placeholder="Enter Address" title="Please enter address" value="{{ $locationDetail->address_three }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="locationAddress4[]" id="locationAddress4-{{ $z }}" class="form-control " placeholder="Enter Address" title="Please enter address" value="{{ $locationDetail->address_four }}" />
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-6" style="margin-left: -0px;margin-right: 2px; width:100px">
                                                                        <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insDeliveryRow();"><i class="ft-plus"></i></a>
                                                                    </div>
                                                                    <?php if ($z != '0') { ?>

                                                                        <div class="col-md-6 col-6">
                                                                            <a class="btn btn-sm btn-warning" id="{{$locationDetail->delivery_id}}" href="javascript:void(0);" onclick="removeDeliveryRow(this.parentNode.parentNode);deleteProspectLoc(this.id);"><i class="ft-minus"></i></a>
                                                                        </div>
                                                                    <?php }  ?>
                                                                </div>
                                                            </td>
                                                            <?php $z++; ?>
                                                            @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/customers">
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
    $(document).ready(function() {
        $(".select2").select2();
        $(".select2").select2({
            placeholder: "Select end product",
            allowClear: true
        });
        $("#customerState").select2({
            placeholder: "Select State",
            allowClear: true
        });
        $("#customerLocation").select2({
            placeholder: "Select Location",
            allowClear: true
        });
        $("#customerGroupId").select2({
            placeholder: "Select Customer Group",
            allowClear: true
        });
        $("#agentId").select2({
            placeholder: "Select Agent",
            allowClear: true
        });

        $('#password').change(function() {
            $('#result').html(checkStrength($('#password').val()))
        })

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


    });

    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();
        if (password.trim() && confirmPassword.trim()) {
            console.log("test");
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

    ismob = true;
    ispin = true;


    $('#confirmPassword').change(function() {
        var nPws = $('#password').val();
        var cPws = $('#confirmPassword').val();
        console.log(nPws + '!=' + cPws);
        if (nPws != cPws) {
            $('#confirmresult').html('Passwords do not match.')
            $('#passwordCheck').val('');
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            $("#showAlertIndex").text('Passwords do not match');
            $('#showAlertdiv').show();
            $('#confirmPassword').val('');
            ispin = false;
            $('#confirmPassword').css('background-color', 'rgb(255, 255, 153)')
            $('#confirmPassword').focus()
            $('#showAlertdiv').delay(3000).fadeOut();

        } else {
            $('#passwordCheck').val('passwordCheck');
            $('#confirmresult').html('')
        }
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    duplicateName = true;

    function validateNow() {

        pinNum = $('#customerPincode').val();
        if (pinNum.length != 6) {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            $("#showAlertIndex").text('Please give 6 digit pincode number');
            $('#showAlertdiv').show();
            ispin = false;
            $('#customerPincode').css('background-color', 'rgb(255, 255, 153)')
            $('#customerPincode').focus()
            $('#showAlertdiv').delay(3000).fadeOut();
        } else {
            ispin = true;
        }
        mobNum = $('#cutomerPhoneNo').val();
        if (mobNum.length != 10) {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            $("#showAlertIndex").text('Please give 10 digit mobile number');
            $('#showAlertdiv').show();
            ismob = false;
            $('#cutomerPhoneNo').css('background-color', 'rgb(255, 255, 153)')
            $('#cutomerPhoneNo').focus()
            $('#showAlertdiv').delay(3000).fadeOut();
        } else {
            ismob = true;
        }
        if (ismob == true && ispin == true) {
            flag = deforayValidator.init({
                formId: 'addcustomers'
            });

            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('addcustomers').submit();
                }
            } else {
                // Swal.fire('Any fool can use a computer');
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display", "block");
                $(".infocus").focus();
            }
        }
    }

    function getLocation(val) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getLocationByState') }}",
            method: 'post',
            data: {
                val: val,
            },
            success: function(result) {
                $('#customerLocation').html(result);
            }
        });
    }

    rowDeliveryCount = 0;

    function insDeliveryRow() {
        rowDeliveryCount++;
        rl = document.getElementById("deliveryAddress").rows.length;
        var a = document.getElementById("deliveryAddress").insertRow(rl);
        a.setAttribute("style", "display:none;");
        a.setAttribute("class", "data");
        var b = a.insertCell(0);
        var c = a.insertCell(1);
        var d = a.insertCell(2);
        var e = a.insertCell(3);
        var f = a.insertCell(4);
        var g = a.insertCell(5);
        var h = a.insertCell(6);
        var i = a.insertCell(7);
        var j = a.insertCell(8);

        rl = document.getElementById("deliveryAddress").rows.length - 1;
        b.innerHTML = '<input type="text" id="location-' + rowDeliveryCount + '" name="location[]" class="form-control isRequired" placeholder="Enter Location" title="Please enter location name"/>';
        c.innerHTML = '<input type="text" id="locationContactPerson-' + rowDeliveryCount + '" name="locationContactPerson[]" class="form-control" placeholder="Enter Contact Person Name" title="Please enter contact person name"/>';
        d.innerHTML = '<input type="text" id="locationContactNo-' + rowDeliveryCount + '" name="locationContactNo[]" class="form-control" placeholder="Enter Contact Number" title="Please enter contact number"/>';
        e.innerHTML = '<input type="text" id="locationEmail-' + rowDeliveryCount + '" name="locationEmail[]" class="form-control" placeholder="Enter Email" title="Please enter email"/>';
        f.innerHTML = '<input type="text" id="locationAddress1-' + rowDeliveryCount + '" name="locationAddress1[]" class="form-control isRequired" placeholder="Enter Address" title="Please enter address" ></textarea>';
        g.innerHTML = '<input type="text" id="locationAddress2-' + rowDeliveryCount + '" name="locationAddress2[]" class="form-control " placeholder="Enter Address" title="Please enter address" ></textarea>';
        h.innerHTML = '<input type="text" id="locationAddress3-' + rowDeliveryCount + '" name="locationAddress3[]" class="form-control " placeholder="Enter Address" title="Please enter address" ></textarea>';
        i.innerHTML = '<input type="text" id="locationAddress4-' + rowDeliveryCount + '" name="locationAddress4[]" class="form-control " placeholder="Enter Address" title="Please enter address" ></textarea>';
        j.innerHTML = '<div class="row"><div class="col-md-6 col-6" style="margin-left: -2px;margin-right: -10px;"><a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insDeliveryRow();"><i class="ft-plus"></i></a></div><div class="col-md-6 col-6"><a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeDeliveryRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a></div></div>';
        $(a).fadeIn(800);
    }

    function removeDeliveryRow(el) {
        $(el).parent().parent().fadeOut("slow", function() {
            $(el).parent().parent().remove();
            rl = document.getElementById("deliveryAddress").rows.length;
            if (rl == 0) {
                insDeliveryRow();
            }
        });
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


    rowOrderCount = 0;

    function insConsumptionQuantityDetailsRow() {

        rowOrderCount++;
        rl = document.getElementById("consumptionQuantityDetails").rows.length;
        var a = document.getElementById("consumptionQuantityDetails").insertRow(rl);
        a.setAttribute("style", "display:none;");
        a.setAttribute("class", "data");
        var b = a.insertCell(0);
        var c = a.insertCell(1);
        var d = a.insertCell(2);


        rl = document.getElementById("consumptionQuantityDetails").rows.length - 1;
        b.innerHTML = '<select id="grade' + rowOrderCount + '" name="gradeCategory[]" class="grade isRequired gradeName form-control datas"  title="Please select grade" >\
                            <option value="">Select Grade Category  </option>@foreach ($gradeCategoryList as $grades)<option value="{{ $grades->grade_cat_id }}">{{ $grades->grade_cat_name }}</option>@endforeach</select>';
        c.innerHTML = '<input type="number" id="capacity' + rowOrderCount + '" name="capacity[]" class="form-control isRequired " placeholder="capacity" title="Please enter capacity "/>';

        d.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insConsumptionQuantityDetailsRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeConsumptionQuantityDetailsRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a>';
        $(a).fadeIn(800);
    }

    function removeConsumptionQuantityDetailsRow(el) {
        $(el).parent().parent().fadeOut("slow", function() {
            $(el).parent().parent().remove();
            rl = document.getElementById("consumptionQuantityDetails").rows.length;
            if (rl == 0) {
                insConsumptionQuantityDetailsRow();
            }
        });
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endsection