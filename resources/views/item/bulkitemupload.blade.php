<!-- 
    Author             : Sudarmathi M
    Date               : 16 Sep 2020
    Description        : Item  add screen
    Last Modified Date : 16 Sep 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-9 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Item </h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/item/">Item </a>
			</li>
			<li class="breadcrumb-item active">Bulk Item Upload</li>
			</ol>
		</div>
		</div>
    </div>
    <div class="content-header-right col-md-3 col-12">
        <div class="dropdown float-md-right">
            <a href="{{ asset('bulk-item-excel/sample.xlsx') }}" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1" ><b><i class="ft-file icon-left"></i> Sample excel File</b></a>
        </div>
    </div>
</div>
@if (session('status'))
<div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
    <div class="text-center" style=""><b>
        {{ session('status') }}</b></div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<script>
    $('#show_alert_index').delay(3000).fadeOut();
</script>
@endif
<div class="content-body">
	<!-- horizontal grid start -->
	<section class="horizontal-grid" id="horizontal-grid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="form-section"><i class="la la-plus-square"></i> Bulk Item Upload </h4>
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
                            <form class="form form-horizontal" enctype="multipart/form-data" role="form" name="uploadItem" id="uploadItem" method="post" action="/item/bulkItemUpload" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <label>Select File for Upload</label> <span class="mandatory">*</span>	
                                        <span class="text-muted">.xls, .xslx</span>
                                        <fieldset class="form-group mt-1">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="uploadFile" name="uploadFile" title="Please Select File">
                                                <label class="custom-file-label" for="uploadFile" aria-describedby="uploadFile">Choose file</label>
                                                <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="form-group mt-3">
                                            <input type="submit" name="upload" onclick="validateNow();return false;" class="btn btn-primary " value="Upload">
                                            <a href="/item" >
                                                <button type="button" class="btn btn-warning ml-1" >
                                                <i class="ft-x"></i> Cancel
                                                </button>
                                            </a>
                                        </div>
                                    </div>
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
$(document).ready(function() {
    $(".select2").select2({
    tags: true
    });
});
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'uploadItem'
        });
        


        var msg='Entered Item  Name is already exist.';
        var itemName = $("#itemName").val();
        var itemTypeId = $("#itemTypeId").val();
        var brandId = $("#brandId").val();
        var unitId = $("#unitId").val();
        if(itemName!='')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/checkItemNameValidation') }}",
                method: 'post',
                data: {
                    itemName: itemName, itemTypeId: itemTypeId, brandId: brandId, unitId: unitId
                },
                success: function(result){
                    // console.log(result)
                    if (result > 0)
                    {
                        $("#showAlertIndex").text(msg);
                        $('#showAlertdiv').show();
                        $('#itemName').val('');
                        $('#itemName').focus();
                        $('#itemName').css('background-color', 'rgb(255, 255, 153)')
                        $('#showAlertdiv').delay(3000).fadeOut();
                    }else{

                        if (flag == true) {
                            if (duplicateName) {
                                document.getElementById('uploadItem').submit();
                            }
                        }
                        else{
                            // Swal.fire('Any fool can use a computer');
                            $('#show_alert').html(flag).delay(3000).fadeOut();
                            $('#show_alert').css("display","block");
                            $(".infocus").focus();
                        }
                    }
                
                }
            });
        }
      
	}
	
	function checkNameValidation(tableName, fieldName, obj,fnct, msg)
    {
        // alert(fnct)
        checkValue = document.getElementById(obj).value;
        // alert(checkValue)
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
                    tableName: tableName, fieldName: fieldName, value: checkValue,
                },
                success: function(result){
                    console.log(result)
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

    function addNewField(tableName,fieldName,obj,sts)
    {
        // checkValue = document.getElementById(obj).value;
        checkValue = $("#"+obj+" option:selected").html();
        itemCat = $('#itemCatId').val();
        if(checkValue!='')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/addNewField') }}",
                method: 'post',
                data: {
                    tableName: tableName, fieldName: fieldName, value: checkValue,itemCat:itemCat,sts:sts
                },
                success: function(result){
                    console.log(result)
                    if (result['option'])
                    {
                        // opt = '<option value="'+data['id']+'">'+data['item']+'</option>'
                        $('#'+obj).html(result['option'])
                    }
                }
            });
        }
    }
    function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
@endsection