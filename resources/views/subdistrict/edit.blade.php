<!-- 
    Author             : Prasath M
    Date               : 31 May 2021
    Description        : District edit screen
    Last Modified Date : 31 May 2021
    Last Modified Name : Prasath M
-->
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Sub District</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/subdistrict/">Sub District</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Sub District</h4>
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
                            <form class="form form-horizontal" role="form" name="editSubDistrict" id="editSubDistrict" method="post" action="/subdistrict/edit/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "sub_district_id##".($result[0]->sub_district_id);
                            @endphp
                            <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Sub District Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="subDistrictName" value="{{$result[0]->sub_district_name}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Sub District Name" name="subDistrictName" title="Please Enter Sub District Name" onblur="checkNameValidation('sub_districts','sub_district_name', this.id,'{{$fnct}}','Entered Sub District Name is already exist.')">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>District Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="districtId" name="districtId" title="Please Select District Name">
                                                <option value="">Select District Name</option>   
                                                @foreach($district as $row)
                                                    <option value="{{$row->district_id}}" {{ $result[0]->district_id == $row->district_id ?  'selected':''}}>{{$row->district_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Sub District Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="subDistrictId" name="subDistrictId" title="Please Select Sub District Name">
                                                <option value="">Select Sub District Name</option>   
                                                @foreach($subdistrict as $row)
                                                    <option value="{{$row->sub_district_id}}" {{ $result[0]->sub_district_id == $row->sub_district_id ?  'selected':''}}>{{$row->sub_district_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/subdistrict" >
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
 duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editSubDistrict'
        });
        
        if (flag == true) {
            if (duplicateName) {
				document.getElementById('editSubDistrict').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $(".infocus").focus();
        }
	}
    function checkNameValidation(tableName, fieldName, obj,fnct, msg)
    {
        checkValue = document.getElementById(obj).value;
        if(checkValue!='')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/checkNameValidation') }}",
                method: 'post',
                data: {
                    tableName: tableName, fieldName: fieldName, value: checkValue, fnct:fnct
                },
                success: function(result){
                    // console.log(result)
                    if (result > 0)
                    {
                        $("#showAlertIndex").text(msg);
                        $('#showAlertdiv').show();
                        duplicateName = false;
                        document.getElementById(obj).value = "";
                        $('#'+obj).focus();
                        $('#'+obj).css('background-color', 'rgb(255, 255, 153)')
                        $('#showAlertdiv').delay(3000).fadeOut();
                    }
                    else {
                        duplicateName = true;
                    }
                }
            });
        }
    }
</script>
@endsection