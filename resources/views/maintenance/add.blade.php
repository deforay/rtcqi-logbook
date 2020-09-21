<!-- 
    Author             : Sriram V
    Date               : 14 Sep 2020
    Description        : Maintenance add screen
    Last Modified Date : 
    Last Modified Name : 
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Maintenance</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/maintenance/">Maintenance</a>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add Maintenance</h4>
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
                                <form class="form form-horizontal" role="form" name="addMaintenance" id="addMaintenance" method="post" action="/maintenance/add" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Service Date<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="serviceDate" readonly class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter service date" name="serviceDate" title="Please enter service date">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Service Done By<span class="mandatory">*</span>
                                                </h5>
                                                <input type="text" id="serviceDoneBy" class="form-control isRequired" autocomplete="off" placeholder="Enter service done by" name="serviceDoneBy" title="Please enter service done by">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Verified By<span class="mandatory">*</span>
                                                </h5>
                                                <input type="text" id="verifiedBy" class="form-control isRequired" autocomplete="off" placeholder="Enter verified by" name="verifiedBy" title="Please enter verify by">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Is This Regular Service<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="regularService" name="regularService" title="Please select if regular service">
                                                        <option value="yes" selected>Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Next Scheduled Maintenance Date<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="nextMaintenanceDate" readonly class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter next Maintenance date" name="nextMaintenanceDate" title="Please enter service date">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Maintenance Status<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="maintenanceStatus" name="maintenanceStatus" title="Please select maintenance status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                      <a href="/assettag">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Close
                                            </button>
                                        </a>
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Add
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
        $(".select2").select2({
            tags: true
        });
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
            formId: 'addMaintenance'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addMaintenance').submit();
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

    function getItemByLoc(val, id) {
        if (val != '') {
            $("#itemName").html('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/getItemByLoc') }}",
                method: 'post',
                data: {
                    id: val
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    console.log(data)
                    var opt = '<option value="">Select Item</option>';
                    for (var k = 0; k < data.length; k++) {

                        expiryDate = data[k]['expiry_date'];
                        if (expiryDate) {
                            let anyDate = new Date(expiryDate);
                            exp = ' (' + anyDate.toShortFormat() + ')';
                        } else {
                            exp = '';
                        }
                        opt += '<option value="' + data[k]['item_id'] + '">' + data[k]['item_name'] + exp + '</option>'
                    }
                    $('#itemName').html(opt)
                }
            });
        } else {
            swal("Please select location")
        }
    }

    Date.prototype.toShortFormat = function() {

        let monthNames = ["Jan", "Feb", "Mar", "Apr",
            "May", "Jun", "Jul", "Aug",
            "Sep", "Oct", "Nov", "Dec"
        ];

        let day = this.getDate();

        let monthIndex = this.getMonth();
        let monthName = monthNames[monthIndex];

        let year = this.getFullYear();

        return `${day}-${monthName}-${year}`;
    }


    // function createAssetId(itemId) {
    //     var location = $("#location").val();
    //     if (itemId != '') {
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //         $.ajax({
    //             url: "{{ url('/createAssetId') }}",
    //             method: 'post',
    //             data: {
    //                 itemId: itemId,
    //                 location: location
    //             },
    //             success: function(result) {

    //                 console.log(result);
    //                 if (result != '') {
    //                     $('#assetTag').val(result)
    //                 }
    //             }
    //         });
    //     }
    // }
</script>
@endsection