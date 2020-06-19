<!-- 
    Author             : Prasath M
    Date               : 18 June 2020
    Description        : Item Type add screen
    Last Modified Date : 18 June 2020
    Last Modified Name : Prasath M
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Item Type</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/itemType/">Item type</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Add Item Type</h4>
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
                            <form class="form form-horizontal" role="form" name="addItemType" id="addItemType" method="post" action="/itemType/add" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Item Type Name <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="itemTypeName" class="form-control isRequired" autocomplete="off" placeholder="Enter a Item Type name" name="itemTypeName" title="Please enter Item Type name" onblur="checkNameValidation('item_types','item_type', this.id,'', 'Entered Item Type Name is already exist.')">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>item Category<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="itemCategoryId" name="itemCategoryId" title="Please select Item Category Name">
                                            @foreach($itemCategory as $itemCategories)
                                                <option value="{{ $itemCategories->item_category_id}}" >{{$itemCategories->item_category}}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Item Type Status<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="itemTypeStatus" name="itemTypeStatus" title="Please select Item Type status">
													<option value="active" selected>Active</option>
													<option value="inactive">Inactive</option>
												</select>
											</div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/itemType" >
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
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addItemType'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addItemType').submit();
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

</script>
@endsection