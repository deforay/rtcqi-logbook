<!-- 
    Author             : Sudarmathi M
    Date               : 25 June 2020
    Description        : RFQ add screen
    Last Modified Date : 25 June 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">RFQ</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/rfq/">RFQ</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Add RFQ</h4>
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
                            <form class="form form-horizontal" role="form" enctype="multipart/form-data" name="addRfq" id="addRfq" method="post" action="/rfq/add" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>RFQ Number <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="rfqNumber" class="form-control isRequired" autocomplete="off" placeholder="Enter a RFQ Number" name="rfqNumber" title="Please enter RFQ Number" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Vendors
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control select2" multiple="multiple" autocomplete="off" style="width:100%;" id="vendors" name="vendors[]" title="Please select vendors">
                                                <option value="">Select Vendors</option>
                                                @foreach($vendor as $type)
													<option value="{{ $type->vendor_id }}">{{ $type->vendor_name }}</option>
												@endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Issued On <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="issuedOn" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter a Issued On" name="issuedOn" title="Please enter Issued On">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Last Date <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="lastdate" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter a last date" name="lastdate" title="Please enter last date">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                    <fieldset class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="uploadFile" name="uploadFile" >
                                            <label class="custom-file-label" for="uploadFile" aria-describedby="uploadFile">Choose file</label>
                                            <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                        </div>
                                    </fieldset>
                                </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="table-responsive">
                                        <div class="bd-example">
                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg">
                                            <thead>
                                                <tr>
                                                <th style="width:30%;">Item<span class="mandatory">*</span></th>
                                                <th style="width:25%;">Unit<span class="mandatory">*</span></th>
                                                <th style="width:25%;">Quantity<span class="mandatory">*</span></th>
                                                <th style="width:20%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemDetails">
                                                <tr>
                                                <td>
                                                <select id="item0" name="item[]" class="item select2 isRequired itemName form-control datas"  title="Please select item" onchange="unitByItem(0,this.value)">
                                                    <option value="">Select Item </option>
                                                    @foreach ($item as $items)
                                                        <option value="{{ $items->item_id }}">{{ $items->item_name }}</option>
                                                    @endforeach
                                                </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="unitName0" readonly name="unitName[]" class="isRequired form-control"  title="Please enter unit" placeholder="Unit">
                                                    <input type="hidden" id="unitId0" name="unitId[]" class="isRequired form-control"  title="Please enter unit">
                                                </td>
                                                <td>
                                                <input type="number" id="qty0" name="qty[]" class="form-control isRequired linetot" placeholder="Enter Qty" title="Please enter the qty" value="" />
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-6 col-6" >
                                                            <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>
                                                        </div>
                                                        <!-- <div class="col-md-6 col-6">
                                                            <a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode.parentNode);"><i class="ft-minus"></i></a>
                                                        </div> -->
                                                    </div>
                                                </td>
                                                </tr>
                                            </tbody>
                                            <!-- <tfoot>
                                                <tr>
                                                    <td colspan="1"></td>
                                                    <td colspan="1"><strong style="float:right;">Total Quantity</strong></td>
                                                    <td colspan="1">
                                                    <input type="text" class="form-control isRequired grandtot"  id="totalValue" name="totalValue" placeholder="Enter Total Quantity" title="Please enter total quantity" disabled/></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot> -->
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- <button type="submit" id="submitBtn" class="btn gradient-3 float-right ml-3" style="display:none;">Submit</button> -->
                            <!-- </form> -->
                            <!-- <form action=""  id="fileUpload" method="POST" enctype="multipart/form-data">
                                <div class="col-xl-6 col-lg-12">
                                    <fieldset class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="uploadFile" name="uploadFile" onchange="readURL(this);">
                                            <label class="custom-file-label" for="uploadFile" aria-describedby="uploadFile">Choose file</label>
                                            <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                        </div>
                                    </fieldset>
                                </div>
                            </form> -->
								<div class="form-actions right">
                                    <a href="/rfq" >
                                    <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                    </button>
                                    </a>
                                    <button type="submit" onclick="triggerSubmit();" class="btn btn-primary">
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

function triggerSubmit(){
    $('#submitBtn').click();
}

function readURL(input) {
    $('#upload').click();
}

$( "#fileUpload" ).on( "submit", function( event ) {
            alert()
    event.preventDefault();
    let formData = new FormData($(this)[0]);
    console.log(formData);
    $.ajax({
        url: "{{ url('/imageupload') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: formData,
        // beforeSend: function(){$("#body-overlay").show();},
        cache: false,
        contentType: false,
        processData:false,
        success: function(data)
        {
            console.log(data)
            // if(data==1){
            //     swal("It is not a Valid Image");
            // }
            // else{
            //     swal("Image Added Successfully");
            //     $("#personimgdata").val(data);
            // }

        },
        
        error: function() 
        {
        }
    });
});
$(document).ready(function() {
    $(".select2").select2();
    $("#vendors").select2({
        placeholder: "Select Vendors",
        allowClear: true
    });
    
    $("#itemName").select2({
        placeholder: "Select Item",
        allowClear: true
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
            formId: 'addRfq'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addRfq').submit();
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

    function unitByItem(id,val){
        unit = '';
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getItemUnit') }}",
            method: 'post',
            data: {
                val:val,
            },
            success: function(result){
                console.log(result)
                if(result.length>0)
                {
                    $("#unitName"+id).val(result[0]['unit_name']);
                    $("#unitId"+id).val(result[0]['uom_id']);
				}
			}

		});
    }

    rowCount = 0;
    function insRow() {
        rowCount++;
        rl = document.getElementById("itemDetails").rows.length;
        var a = document.getElementById("itemDetails").insertRow(rl);
        a.setAttribute("style", "display:none;");
        // a.setAttribute("class", "data");
        var b = a.insertCell(0);
        var d = a.insertCell(1);
        var c = a.insertCell(2);
        var f = a.insertCell(3);

        
        rl = document.getElementById("itemDetails").rows.length - 1;
        b.innerHTML = '<select id="item'+ rowCount + '" name="item[]" class="item select2 isRequired itemName form-control datas"  title="Please select item" onchange="unitByItem('+rowCount+',this.value)">\
                            <option value="">Select Item </option>@foreach ($item as $items)<option value="{{ $items->item_id }}">{{ $items->item_name }}</option>@endforeach</select>';
        d.innerHTML = '<input type="text" id="unitName' + rowCount + '" readonly name="unitName[]" class="isRequired form-control"  title="Please enter unit" placeholder="Unit">\
                        <input type="hidden" id="unitId' + rowCount + '" name="unitId[]" class="isRequired form-control"  title="Please enter unit">';
        c.innerHTML = '<input type="number" id="qty' + rowCount + '" name="qty[]" class="linetot form-control isRequired" placeholder="Enter Qty" title="Please enter quantity" />';
        f.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
        $(a).fadeIn(800);
        $(".select2").select2();
        $(".item").select2({
            placeholder: "Select Item",
            allowClear: true
        });
    }

    function removeRow(el) {
        $(el).parent().fadeOut("slow", function () {
            $(el).parent().remove();
            rowCount = rowCount-1;
            rl = document.getElementById("itemDetails").rows.length;
            if (rl == 0) {
                insRow();
            }
        });
    }


    function uploadFile(){
        alert()
        // var fd = new FormData();
        // var files = $('#uploadFile')[0].files[0];
        // fd.append('file',files);
        // console.log(fd)
        // $.ajax({
        //     url: "{{ url('/imageupload') }}",
        //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //     type: "POST",
        //     data: formData,
        //     // beforeSend: function(){$("#body-overlay").show();},
        //     cache: false,
        //     contentType: false,
        //     processData:false,
        //     success: function(data)
        //     {
        //         console.log(data)
        //         if(data==1){
        //             swal("It is not a Valid Image");
        //         }
        //         else{
        //             swal("Image Added Successfully");
        //             $("#personimgdata").val(data);
        //         }

        //     },
            
        //     error: function() 
        //     {
        //     }
        // });
    }

</script>
@endsection