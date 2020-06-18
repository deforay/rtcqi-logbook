<!-- 
    Author             : Prasath M
    Date               : 18 June 2020
    Description        : Item  Edit screen
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Item </h4>
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
                            <form class="form form-horizontal" role="form" name="editItem" id="editItem" method="post" action="/item/edit/{{base64_encode($result[0]->item_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "item_id##".($result[0]->item_id);
                            @endphp
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Item Name <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="itemName" value="{{$result[0]->item_name}}" class="form-control isRequired" autocomplete="off" placeholder="Enter a item name" name="itemName" title="Please enter item  name" onblur="checkNameValidation('items','item_name', this.id,'{{$fnct}}', 'Entered Item name is already exist.')">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Item  Code <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="itemCode" value="{{$result[0]->item_code}}" class="form-control isRequired" autocomplete="off" placeholder="Enter a Item  code" name="itemCode" title="Please enter Item  name" onblur="checkNameValidation('items','item_code', this.id,'{{$fnct}}', 'Entered Item  Code is already exist.')">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>item Type<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="itemTypeId" name="itemTypeId" title="Please select Item Type Name">
                                            @foreach($itemType as $itemTypes)
                                                <option value="{{ $itemTypes->item_type_id}}" {{ $result[0]->item_type == $itemTypes->item_type_id ?  'selected':''}}>{{$itemTypes->item_type}}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Brand Name<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="brandId" name="brandId" title="Please select Brand Name">
                                            @foreach($brand as $brands)
                                                <option value="{{ $brands->brand_id}}" {{ $result[0]->brand == $brands->brand_id ?  'selected':''}}>{{$brands->brand_name}}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Unit Name<span class="mandatory">*</span>
										</h5>
										<div class="form-group">
											<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="unitId" name="unitId" title="Please select unit Name">
                                            @foreach($unit as $units)
                                                <option value="{{ $units->uom_id}}" {{ $result[0]->base_unit == $units->uom_id ?  'selected':''}}>{{$units->unit_name}}</option>
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
                                            <option value="yes" {{ $result[0]->stockable == 'yes' ?  'selected':''}}>Yes</option>
                                            <option value="no" {{ $result[0]->stockable == 'no' ?  'selected':''}}>No</option>
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
            formId: 'editItem'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editItem').submit();
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
                    tableName: tableName, fieldName: fieldName, value: checkValue,fnct :fnct
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