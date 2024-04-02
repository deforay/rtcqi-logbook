<!--

    Date               : 28 May 2021
    Description        : Test Kit add screen
    Last Modified Date : 28 May 2021

-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Test Kit</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/testkit/">Test Kit</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add Test Kit</h4>
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
                                <form class="form form-horizontal" role="form" name="addTestKit" id="addTestKit" method="post" action="/testkit/add" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Kit Name ID
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="kit_name_id" class="form-control" autocomplete="off" placeholder="Enter Kit Name ID" name="kit_name_id" title="Please Enter Kit Name ID">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Kit Name ID 1 <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="kit_name_id1" class="form-control isRequired" autocomplete="off" placeholder="Enter Kit Name ID 1" name="kit_name_id1" title="Please Enter Kit Name ID 1">
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Kit Name Short
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="kit_name_short" class="form-control " autocomplete="off" placeholder="Enter Kit Name Short" name="kit_name_short" title="Please Enter Kit Name Short">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Kit Name <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="kit_name" class="form-control isRequired" autocomplete="off" placeholder="Enter Kit Name" name="kit_name" title="Please Enter Kit Name" onblur="checkNameValidation('test_kits','test_kit_name', this.id,'','Entered Kit Name is already exist.')">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Kit Manufacturer <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="kit_manufacturer" class="form-control  isRequired" autocomplete="off" placeholder="Enter Kit Manufacturer" name="kit_manufacturer" title="Please Enter Kit Manufacturer">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Kit Expiry Date <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="kit_expiry_date" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter Kit Expiry Date" name="kit_expiry_date" title="Please Enter Kit Expiry Date">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Comments
                                                </h5>
                                                <div class="form-group">
                                                    <textarea id="kit_name_comments" name="kit_name_comments" class="form-control" placeholder="Enter Comments" title="Please enter the comments"></textarea>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Test Kit Status<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testKitStatus" name="testKitStatus" title="Please Select Test Kit Status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/testkit">
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
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            // startDate:'today',
            todayHighlight: true,
            clearBtn: true,
        });
    });
    duplicateName = true;

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addTestKit'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addTestKit').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
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
