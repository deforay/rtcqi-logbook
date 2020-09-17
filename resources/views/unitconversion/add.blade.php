<!-- 
    Author             : Sriram V
    Date               : 22 June 2020
    Description        : Unit Conversion add screen
    Last Modified Date : 
    Last Modified Name : 
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Unit Conversion</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Item
                        </li>
                        <li class="breadcrumb-item"><a href="/unitconversion/">Unit Conversion</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add Unit Conversion</h4>
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
                                <form class="form form-horizontal" role="form" name="addunitconversion" id="addunitconversion" method="post" action="/unitconversion/add" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Base Unit<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="baseUnit" name="baseUnit" title="Please select Base Unit">
                                                        <option value="">Select Base Unit</option>
                                                        @foreach($unit_type as $type)
                                                        <option value="{{ $type->uom_id }}">{{ $type->unit_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Multiplier<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="multiplier" onkeypress="return isNumberKey(event);" class="form-control isRequired" autocomplete="off" placeholder="Enter multiplier" name="multiplier" title="Please enter multiplier">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>To Unit<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="toUnit" name="toUnit" title="Please select To Unit">
                                                        <option value="">Select To Unit</option>
                                                        @foreach($unit_type as $type)
                                                        <option value="{{ $type->uom_id }}">{{ $type->unit_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Unit Conversion Status<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="unitConversionStatus" name="unitConversionStatus" title="Please select Unit status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/unitconversion">
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
    isbase = true;

    function validateNow() {
        var baseUnit = $("#baseUnit option:selected").text();
        var toUnit = $("#toUnit option:selected").text();
        if (baseUnit == toUnit) {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            $("#showAlertIndex").text('Base Unit and To Unit Cannot be same');
            $('#showAlertdiv').show();
            isbase = false;
            $('#toUnit').css('background-color', 'rgb(255, 255, 153)')
            $('#toUnit').focus()
            $('#showAlertdiv').delay(3000).fadeOut();
        } else {
            isbase = true;
        }
        if (isbase == true) {
            flag = deforayValidator.init({
                formId: 'addunitconversion'
            });
            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('addunitconversion').submit();
                }
            } else {
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display", "block");
                $(".infocus").focus();
            }
        }
    }
    $('#baseUnit').on('change', function() {
        $('option').prop('disabled', false); //reset all the disabled options on every change event
        $('#baseUnit').each(function() { //loop through all the select elements
            var val = this.value;
            $('#toUnit').not(this).find('option').filter(function() { //filter option elements having value as selected option
                return this.value === val;
            }).prop('disabled', true); //disable those option elements
        });
    }).change();
    $('#toUnit').on('change', function() {
        $('option').prop('disabled', false); //reset all the disabled options on every change event
        $('#toUnit').each(function() { //loop through all the select elements
            var val = this.value;
            $('#baseUnit').not(this).find('option').filter(function() { //filter option elements having value as selected option
                return this.value === val;
            }).prop('disabled', true); //disable those option elements
        });
    }).change();

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endsection