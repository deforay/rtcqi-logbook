<!-- 
    Author             : Sudarmathi M
    Date               : 25 June 2020
    Description        : RFQ add screen
    Last Modified Date : 25 June 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')

@section('content')
<style>
    td {
        padding-left: 0.50rem !important;
        padding-right: 0.50rem !important;
    }
</style>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js')}}"></script>
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
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>RFQ Number <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="rfqNumber" class="form-control isRequired" autocomplete="off" placeholder="Enter RFQ Number" name="rfqNumber" title="Please enter RFQ Number" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Vendor
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control select2" multiple="multiple" autocomplete="off" style="width:100%;" id="vendors" name="vendors[]" title="Please select vendor">
                                                <option value="">Select Vendor</option>
                                                @foreach($vendor as $type)
													<option value="{{ $type->vendor_id }}">{{ $type->vendor_name }}</option>
												@endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-1 col-lg-12 mt-2">
										<fieldset>
                                        <button type="button" class="btn btn-primary" title="Add Vendor" data-placement="left" data-toggle="modal" data-target="#vendorAdd">
                                                        <i class="ft-user-plus"></i>
                                                        </button>
										</fieldset>
									</div>
                               
                                    <div class="col-xl-3 col-lg-12">
                                        <fieldset>
                                            <h5>Issued On <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="issuedOn" onchange="checkDate('issue');return false;" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter Issued On" name="issuedOn" title="Please enter Issued On">
                                            </div>
                                        </fieldset>
                                    </div>
                                    </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Last Date <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" onchange="checkDate('last');return false;" id="lastdate" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter last date" name="lastdate" title="Please enter last date">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Notes<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text"  id="iNotes" class="form-control isRequired" autocomplete="off" placeholder="Enter notes" name="iNotes" title="Please enter notes">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="col-md-2 label-control pl-0" for="mainContent" >Specification</label>
                                        <div class="form-group row" >
                                            <div class="col-md-12">
                                            <textarea id="description" name="description" class="form-control richtextarea ckeditor" placeholder="Enter Description" title="Please enter the description" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                            <h5>Attachment <span class="mandatory">*</span></h5>
                                        </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="uploadFile" name="uploadFile[]" multiple>
                                                <label class="custom-file-label" for="uploadFile" aria-describedby="uploadFile">Choose file</label>
                                                <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="table-responsive" style="overflow-x: hidden;">
                                        <div class="bd-example">
                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg" style="width:100%">
                                            <thead style="background-color:#ebecd2">
                                                <tr>
                                                <th style="width:20%;">Item<span class="mandatory">*</span></th>
                                                <th style="width:15%;">Unit<span class="mandatory">*</span></th>
                                                <th style="width:30%;">Description</th>
                                                <th style="width:20%;">Quantity<span class="mandatory">*</span></th>
                                                <th style="width:15%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemDetails">
                                                <tr>
                                                <td>
                                                <select id="item0" name="item[]" class="item select2 isRequired itemName form-control datas"  title="Please select item" onchange="addNewItemField(this.id,0);">
                                                    <option value="">Select Item </option>
                                                    @foreach ($item as $items)
                                                        <option value="{{ $items->item_id }}">{{ $items->item_name }}</option>
                                                    @endforeach
                                                </select>
                                                </td>
                                                <td>
                                                    <!-- <select id="unitName0" name="unitName[]" class="unitName select2 isRequired form-control"  title="Please select unit" onchange="addNewUnitField(this.id,0);">
                                                    </select> -->
                                                    <input type="text" id="unitName0" readonly name="unitName[]" class="isRequired form-control"  title="Please enter unit" placeholder="Unit">
                                                    <input type="hidden" id="unitId0" name="unitId[]" class="isRequired form-control"  title="Please enter unit" >
                                                </td>
                                                <td>
                                                    <input type="text"  value="" id="rfqDesc" name="rfqDesc[]" class="form-control" placeholder="Item description"  />
                                                </td>
                                                <td>
                                                    <input type="number" id="qty0" name="qty[]" min="0" class="form-control isRequired linetot" placeholder="Enter Qty" title="Please enter the qty" value="" />
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
    <!--Start vendor Modal -->
            <div class="modal fade" id="vendorAdd" tabindex="-1" role="dialog" aria-labelledby="vendorAddLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="vendorAddLabel">Add New Vendor</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showModalAlertdiv" role="alert" style="display:none"><span id="showModalAlertIndex"></span>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
                    <div id="show_modal_alert" class="mt-1" style=""></div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>Vendor Name<span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                    <input type="text" id="vendorName" class="form-control isRequired"  autocomplete="off" placeholder="Enter Vendor Name" name="vendorName" title="Please enter Vendor Name">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>Email<span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                    <input type="email" id="vendorEmail" class="form-control isEmail" autocomplete="off" placeholder="Enter Vendor Email" name="vendorEmail" title="Please Enter Valid Email" onblur="duplicateValidation('vendors','email', this.id, 'Entered Vendor is already exist.')">
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addNewVendor();">Save</button>
                </div>
                </div>
            </div>
            </div>
                                <!-- End Vendor Modal   -->  
    </section>
</div>
</div>

<script>

$(document).ready(function() {
    $(".select2").select2();
    $(".select2").select2({
        tags: true
    });
    $("#vendors").select2({
        placeholder: "Select Vendor",
        allowClear: true
    });
    
    $("#itemName").select2({
        placeholder: "Select Item",
        allowClear: true,
        // tags: true
    });

    $("#unitName").select2({
        placeholder: "Select Unit",
        allowClear: true,
        // tags: true
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

    $(function () {
    //bootstrap WYSIHTML5 - text editor
    //$(".richtextarea").wysihtml5();

		CKEDITOR.editorConfig = function( config )
		{
			config.toolbar_Full = [
				{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', 'Templates', 'document' ] },
			];
		};
    });

	
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
                    // unit = '<option value="'+result[0]['uom_id']+'">'+result[0]['unit_name']+'</option>'
                    // $("#unitName"+id).html(unit);
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
        var g = a.insertCell(2);
        var c = a.insertCell(3);
        var f = a.insertCell(4);

        rl = document.getElementById("itemDetails").rows.length - 1;
        b.innerHTML = '<select id="item'+ rowCount + '" name="item[]" class="item select2 isRequired itemName form-control datas"  title="Please select item" onchange="addNewItemField(this.id,'+rowCount+');">\
                            <option value="">Select Item </option>@foreach ($item as $items)<option value="{{ $items->item_id }}">{{ $items->item_name }}</option>@endforeach</select>';
        // d.innerHTML = '<select id="unitName' + rowCount + '" name="unitName[]" class="unitName select2 isRequired form-control datas"  title="Please select unit" onchange="addNewUnitField(this.id,'+rowCount+');">\
        //                 </select>\
        d.innerHTML = '<input type="text" id="unitName' + rowCount + '" readonly name="unitName[]" class="isRequired form-control" placeholder="Unit"  title="Please enter unit">\
                        <input type="hidden" id="unitId' + rowCount + '" name="unitId[]" class="isRequired form-control"  title="Please enter unit">';
        g.innerHTML = '<input type="text"  value="" id="rfqDesc' + rowCount + '" name="rfqDesc[]" class="form-control" placeholder="Item description"  />'
        c.innerHTML = '<input type="number" min="0" id="qty' + rowCount + '" name="qty[]" class="linetot form-control isRequired" placeholder="Enter Qty" title="Please enter quantity" />';
        f.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
        $(a).fadeIn(800);
        $(".select2").select2({
            tags: true
        });
        $(".item").select2({
            placeholder: "Select Item",
            allowClear: true,
            tags: true
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


    function addNewItemField(obj,id)
    {
        // checkValue = document.getElementById(obj).value;
        checkValue = $("#"+obj+" option:selected").html();
        if(checkValue!='')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/addNewItemField') }}",
                method: 'post',
                data: {
                   value: checkValue,
                },
                success: function(result){
                    if (result['id'] > 0)
                    {
                        $('#item'+id).html(result['option'])
                    }
                    value = $('#item'+id).val();
                    unitByItem(id,value);
                }
            });
        }
    }

    function checkDate(field)
    {
        let lastDate  = new Date($("#lastdate").val())
        let issuedOn  = new Date($("#issuedOn").val())

        if(lastDate  && issuedOn)
        {
            if(issuedOn > lastDate)
            {
                if(field == 'issue')
                {
                    swal("Issued on date should be lesser than last date")
                    $("#issuedOn").val('')
                }
                else
                {
                    swal("Last date should be Greater than issued on date")
                    $("#lastdate").val('')
                }
                return false
            }
            else
            {
                return true
            }
        }
    }

    function addNewVendor()
    {
        let vendorName  = $("#vendorName").val()
        let vendorEmail  = $("#vendorEmail").val()

        if(!(vendorName.trim()))
        {
            flag='<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" role="alert" ><div class="text-center" style="font-size: 18px;"><b>Please enter vendor name</b></div>';
            flag+='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            $('#show_modal_alert').html(flag).delay(3000).fadeOut();
			$('#show_modal_alert').css("display","block");
        }
        else if(!(vendorEmail.trim()))
        {
            flag='<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" role="alert" ><div class="text-center" style="font-size: 18px;"><b>Please enter vendor email</b></div>';
            flag+='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            $('#show_modal_alert').html(flag).delay(3000).fadeOut();
			$('#show_modal_alert').css("display","block");
        }
        else
        {
            let vendorList = [];
            vendorList = $("#vendors").val();
            console.log(vendorList)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(duplicateName){
                $.ajax({
                    url: "{{ url('/addVendor') }}",
                    method: 'post',
                    data: {
                        vendorEmail: vendorEmail,
                        vendorName: vendorName,
                    },
                    success: function(result){
                        console.log(result);
                        if(result['id'])
                        {
                            let option = '';
                            for(i=0;i<result['list'].length;i++)
                            {
                                option+= '<option value='+result["list"][i]["vendor_id"]+'>'+result["list"][i]["vendor_name"]+'</option>'
                            }
                            $("#vendors").html(option);
                            vendorList.push(result['id'])
                            console.log(vendorList);
                            $("#vendors").val(vendorList);
                            $('#vendorAdd').modal('hide');
                            $("#vendorName").val('')
                            $("#vendorEmail").val('')
                        }
                        
                    }
                });
            }
            else{
                swal("Entered Mail id is already there")
            }
        }
    }

    function duplicateValidation(tableName, fieldName, obj, msg) {
        // alert(fnct)
        checkValue = document.getElementById(obj).value;
        // alert(checkValue)
        if (checkValue != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/duplicateValidation') }}",
                method: 'post',
                data: {
                    tableName: tableName,
                    fieldName: fieldName,
                    value: checkValue,
                },
                success: function(result) {
                    //   console.log(result)
                    if (result > 0) {
                        $("#showModalAlertIndex").text(msg);
                        $('#showModalAlertdiv').show();
                        duplicateName = false;
                        document.getElementById(obj).value = "";
                        $('#' + obj).focus();
                        $('#' + obj).css('background-color', 'rgb(255, 255, 153)')
                        $('#showModalAlertdiv').delay(3000).fadeOut();
                    } else {
                        duplicateName = true;
                    }
                }
            });
        }
    }

    function addNewUnitField(obj,id)
    {
        tableName = 'units_of_measure';
        fieldName = 'unit_name';
        sts = 'unit_status';
        item = $('#item'+id).val()
        
        // checkValue = document.getElementById(obj).value;
        checkValue = $("#"+obj+" option:selected").html();
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
                    tableName: tableName, fieldName: fieldName, value: checkValue,sts:sts,item:item
                },
                success: function(result){
                    console.log(result)
                    if (result['option'])
                    {
                        $('#'+obj).html(result['option'])
                    }
                }
            });
        }
    }

</script>
@endsection