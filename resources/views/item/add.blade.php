<!-- 
    Author             : Prasath M
    Date               : 18 June 2020
    Description        : Item  add screen
    Last Modified Date : 18 June 2020
    Last Modified Name : Prasath M
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Item </h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/item/">Item </a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Add Item </h4>
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
                            <form class="form form-horizontal" role="form" name="addItem" id="addItem" method="post" action="/item/add" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Item  Name <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="itemName" class="form-control isRequired" autocomplete="off" placeholder="Enter Item  name" name="itemName" title="Please enter Item  name" onblur="checkNameValidation('items','item_name', this.id,'', 'Entered Item  Name is already exist.')">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Item  Code <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="itemCode" class="form-control isRequired" autocomplete="off" placeholder="Enter Item  code" name="itemCode" title="Please enter Item  name" onblur="checkNameValidation('items','item_code', this.id,'', 'Entered Item  Code is already exist.')">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Item Category<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control select2 isRequired" autocomplete="off" style="width:100%;" id="itemCatId" name="itemCatId" title="Please select Item Category Name" onchange="addNewField('item_categories','item_category',this.id,'item_category_status');" >
                                            @foreach($itemCat as $itemCats)
                                                <option value="{{ $itemCats->item_category_id}}" >{{$itemCats->item_category}}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Item Type<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control select2 isRequired" autocomplete="off" style="width:100%;" id="itemTypeId" name="itemTypeId" title="Please select Item Type Name" onchange="addNewField('item_types','item_type',this.id,'item_type_status');" >
                                            @foreach($itemType as $itemTypes)
                                                <option value="{{ $itemTypes->item_type_id}}" >{{$itemTypes->item_type}}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Brand Name<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control select2 isRequired" autocomplete="off" style="width:100%;" id="brandId" name="brandId" title="Please select Brand Name" onchange="addNewField('brands','brand_name',this.id,'brand_status');">
                                            @foreach($brand as $brands)
                                                <option value="{{ $brands->brand_id}}" >{{$brands->brand_name}}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Unit Name<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control select2 isRequired" autocomplete="off" style="width:100%;" id="unitId" name="unitId" title="Please select unit Name" onchange="addNewField('units_of_measure','unit_name',this.id,'unit_status');">
                                            @foreach($unit as $units)
                                                <option value="{{ $units->uom_id}}" >{{$units->unit_name}}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Stockable<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="stockable" name="stockable" title="Please select Stockable">
                                            <option value="yes" >Yes</option>
                                            <option value="no" >No</option>
                                            </select>
											</div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/item" >
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
$(document).ready(function() {
    $(".select2").select2({
    tags: true
    });
});
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addItem'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addItem').submit();
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

</script>
@endsection