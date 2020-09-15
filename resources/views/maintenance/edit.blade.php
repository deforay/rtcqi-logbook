<!-- 
    Author             : Sriram V
    Date               : 14 sep 2020
    Description        : Asset Tag Edit screen
    Last Modified Date : 
    Last Modified Name : 
-->
@extends('layouts.main')

@section('content')
@php

use App\Service\CommonService;
// dd($result[0]->quotes_upload_file);
$common = new CommonService();
$serviceDate = $common->humanDateFormat($result[0]->service_date);
$maintenanceDate = $common->humanDateFormat($result[0]->next_maintenance_date);
@endphp
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<!-- <h3 class="content-header-title mb-0 d-inline-block">Maintenance</h3> -->
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/maintenance/">Maintenance</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Maintenance</h4>
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
						<div id="show_alert"  class="mt-1" style=""></div>
                            <form class="form form-horizontal" role="form" name="editMaintenance" id="editMaintenance" method="post" action="/maintenance/edit/{{base64_encode($result[0]->maintenance_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "maintenance_id##".($result[0]->maintenance_id);
                            @endphp
                                <div class="row">
                                <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Service Date<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="serviceDate" readonly value="{{$serviceDate}}"  class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter service date" name="serviceDate" title="Please enter service date">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Service Done By<span class="mandatory">*</span>
                                                </h5>
                                                <input type="text" id="serviceDoneBy" class="form-control isRequired" value="{{$result[0]->service_done_by}}" autocomplete="off" placeholder="Enter service done by" name="serviceDoneBy" title="Please enter service done by">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Verified By<span class="mandatory">*</span>
                                                </h5>
                                                <input type="text" id="verifiedBy" class="form-control isRequired" value="{{$result[0]->verified_by}}"  autocomplete="off" placeholder="Enter verified by" name="verifiedBy" title="Please enter verify by">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Is This Regular Service<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="regularService" name="regularService" title="Please select if regular service">
                                                        <option value="yes" {{ $result[0]->regular_service == 'yes' ?  'selected':''}}>Yes</option>
                                                        <option value="no"  {{ $result[0]->regular_service == 'no' ?  'selected':''}}>No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>Next Scheduled Maintenance Date<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="nextMaintenanceDate" readonly value="{{$maintenanceDate}}" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter next Maintenance date" name="nextMaintenanceDate" title="Please enter service date">
                                                </div>
                                            </fieldset>
                                        </div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Maintenance Status<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="maintenanceStatus" name="maintenanceStatus" title="Please select Asset tag status">
                                                    <option value="active" {{ $result[0]->maintenance_status == 'active' ?  'selected':''}}>Active</option>
                                                    <option value="inactive" {{ $result[0]->maintenance_status == 'inactive' ?  'selected':''}}>Inactive</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/maintenance" >
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
                formId: 'editAssetTag'
            });
            
            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('editAssetTag').submit();
                }
            }
            else{
                // Swal.fire('Any fool can use a computer');
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display","block");
                $(".infocus").focus();
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
    function createAssetId(itemId) {
        var location = $("#location").val();
        if (itemId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/createAssetId') }}",
                method: 'post',
                data: {
                    itemId: itemId,
                    location: location
                },
                success: function(result) {

                    console.log(result);
                    if (result != '') {
                        $('#assetTag').val(result)
                    }
                }
            });
        }
    }
</script>
@endsection