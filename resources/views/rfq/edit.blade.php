<!-- 
    Author             : Sudarmathi M
    Date               : 25 June 2020
    Description        : RFQ edit screen
    Last Modified Date : 25 June 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')

@section('content')
<script src="{{ asset('assets/js/ckeditor/ckeditor.js')}}"></script>
<?php
    use App\Service\CommonService;
    $common = new CommonService();
    $issuedOn = $common->humanDateFormat($result['rfq'][0]->rfq_issued_on);
    $lastDate = $common->humanDateFormat($result['rfq'][0]->last_date);

    $vendors = array();
    $vendorDetail = '';
    foreach($result['quotes'] as $list)
    {
        // print_r(count($vendors));
        if(count($vendors)==0){
            array_push($vendors, $list->vendor_id);
            $vendorDetail = $list->vendor_id;
        }
        else{
            // print_r(!(in_array($list->vendor_id,$vendors)));
            if(!(in_array($list->vendor_id,$vendors))){
                array_push($vendors, $list->vendor_id);
                $vendorDetail = $vendorDetail.','.$list->vendor_id;
            }
        }
    }
    // print_r($vendors);die;
?>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit RFQ</h4>
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
                            <form class="form form-horizontal" role="form" name="editRfq" id="editRfq" method="post" action="/rfq/edit/{{base64_encode($result['rfq'][0]->rfq_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>RFQ Number <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="rfqNumber" value="{{$result['rfq'][0]->rfq_number}}" class="form-control isRequired" autocomplete="off" placeholder="Enter RFQ Number" name="rfqNumber" title="Please enter RFQ Number" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Vendors
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control select2" multiple="multiple" autocomplete="off" style="width:100%;" id="vendors" name="vendors[]" title="Please select vendors">
                                                <option value="">Select Vendors</option>
                                                @foreach($vendor as $type)
													<option value="{{ $type->vendor_id }}" {{ in_array($type->vendor_id, $vendors) ?  'selected':''}} >{{ $type->vendor_name }}</option>
												@endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Issued On <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="issuedOn" value="{{$issuedOn}}" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter Issued On" name="issuedOn" title="Please enter Issued On">
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
                                                <input type="text" id="lastdate" value="{{$lastDate}}" class="form-control datepicker isRequired" autocomplete="off" placeholder="Enter last date" name="lastdate" title="Please enter last date">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <label class="col-md-2 label-control" for="mainContent">Description</label>
                                    <div class="form-group row" >
                                        <div class="col-md-12">
                                        <textarea id="description" name="description" class="form-control richtextarea ckeditor" placeholder="Enter Description" title="Please enter the description" >{{$result['rfq'][0]->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <?php if(isset($result['rfq'][0]->rfq_upload_file)){ ?>
                                        <div class="row p-1">
                                            <div class="col-xl-6 col-md-12">
                                                <div class="card" style="border: 1px solid #b7defa">
                                                  <div class="card-content">
                                                    <div class="card-body cleartfix">
                                                      <div class="media align-items-stretch">
                                                        <div class="align-self-center">
                                                          <i class="la la-file-text info font-large-2 mr-2"></i>
                                                        </div>
                                                        <div class="media-body">
                                                          <h4>Attachments</h4>
                                                          <?php
                                                    $fileVaL= explode(",", $result['rfq'][0]->rfq_upload_file);
                                                    $filecount=count($fileVaL);
                                                    if($filecount>1){
                                                        $forcount=$filecount-1;
                                                    }else{
                                                        $forcount=$filecount;
                                                    }
                                                    for($i=0;$i<$forcount;$i++)
                                                    {
                                                        $attach = explode('/',$fileVaL[$i])[8];
                                                        $attachext = explode('.',$attach);
                                                        $attachext = end($attachext);
                                                        $attachfile = explode('@@',$attach)[0];
                                                        if($attachfile){
                                                            if($attachext){
                                                                $attachmentFile = $attachfile.'.'.$attachext;
                                                            }
                                                            else{
                                                                $attachmentFile = $attachfile;
                                                            }
                                                        }
                                                        else{
                                                            $attachfile = 'Attachment';
                                                        }
                                                        $imagefile= str_replace('/var/www/asm-pi/public', '', $fileVaL[$i]);
                                                        echo  '<div><a href="'.$imagefile.'" target="_blank">'.$attachmentFile.'  <i class="ft-download"></i></a></div>';
                                                    }
                                                    ?>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>
                                    <?php  } ?>


                                    <hr>
                                <div class="row">
                                    <div class="table-responsive">
                                        <div class="bd-example">
                                            <table class="table table-striped table-bordered table-condensed table-responsive-lg">
                                            <thead style="background-color:#ebecd2">
                                                <tr>
                                                <th style="width:30%;">Item<span class="mandatory">*</span></th>
                                                <th style="width:25%;">Unit<span class="mandatory">*</span></th>
                                                <th style="width:25%;">Quantity<span class="mandatory">*</span></th>
                                                <th style="width:20%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemDetails">
                                            <?php $z=0; ?>
                                            @foreach($result['rfq'] as $rfq)
                                                <tr>
                                                <input type="hidden" name="rdId[]" id="rdId{{$z}}" value="{{ $rfq->rfqd_id }}"/>
                                                <td>
                                                <select id="item{{$z}}" name="item[]" class="item select2 isRequired itemName form-control datas"  title="Please select item" onchange="addNewItemField(this.id,{{$z}})">
                                                    <option value="">Select Item </option>
                                                    @foreach ($item as $items)
                                                        <option value="{{ $items->item_id }}" {{ $rfq->item_id == $items->item_id ?  'selected':''}}>{{ $items->item_name }}</option>
                                                    @endforeach
                                                </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="unitName{{$z}}" readonly name="unitName[]" value="{{ $rfq->unit_name }}" class="isRequired form-control"  title="Please enter unit" placeholder="Unit">
                                                    <input type="hidden" id="unitId{{$z}}" name="unitId[]" value="{{ $rfq->uom }}" class="isRequired form-control"  title="Please zenter unit">
                                                </td>
                                                <td>
                                                <input type="number" min="0" id="qty{{$z}}" name="qty[]" value="{{ $rfq->quantity }}" class="form-control isRequired linetot" placeholder="Enter Qty" title="Please enter the qty" value="" />
                                                </td>
                                                <td>
                                                    <!-- <div class="row"> -->
                                                        <a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>
                                                        &nbsp;&nbsp;
                                                        <a class="btn btn-sm btn-warning" href="javascript:void(0);" id="{{$rfq->rfqd_id}}" onclick="removeRow(this.parentNode);deleteItemDet(this.id,{{$z}})"><i class="ft-minus"></i></a>
                                                    <!-- </div> -->
                                                </td>
                                                </tr>
                                            <?php $z++; ?>
                                            @endforeach
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
                                <input type="hidden" name="deleteRfqDetail" id="deleteItemDetail" value="" />
                                <input type="hidden" name="vendorDetail" id="vendorDetail" value="{{$vendorDetail}}" />
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
deleteItemDetail = [];
$(document).ready(function() {
    $(".select2").select2();
    $(".select2").select2({
        tags: true
    });
    $("#vendors").select2({
        placeholder: "Select Vendors",
        allowClear: true
    });
    
    $(".itemName").select2({
        placeholder: "Select Item",
        allowClear: true,
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
            formId: 'editRfq'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editRfq').submit();
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

    rowCount = {{$z}};
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
        b.innerHTML = '<select id="item'+ rowCount + '" name="item[]" class="item select2 isRequired itemName form-control datas"  title="Please select item" onchange="addNewItemField(this.id,'+rowCount+')">\
                            <option value="">Select Item </option>@foreach ($item as $items)<option value="{{ $items->item_id }}">{{ $items->item_name }}</option>@endforeach</select>';
        d.innerHTML = '<input type="text" id="unitName' + rowCount + '" readonly name="unitName[]" class="isRequired form-control"  title="Please enter unit" placeholder="Unit">\
                        <input type="hidden" id="unitId' + rowCount + '" name="unitId[]" class="isRequired form-control"  title="Please enter unit">';
        c.innerHTML = '<input type="number" id="qty' + rowCount + '" name="qty[]" min="0" class="linetot form-control isRequired" placeholder="Enter Qty" title="Please enter quantity" />';
        f.innerHTML = '<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="insRow();"><i class="ft-plus"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="removeRow(this.parentNode);"><i class="ft-minus"></i></a>';
        $(a).fadeIn(800);
        $(".select2").select2();
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

    function deleteItemDet(rfqdId,rowId) {
        deleteItemDetail.push(rfqdId);
        document.getElementById("deleteItemDetail").value=deleteItemDetail;
        console.log(document.getElementById("deleteItemDetail").value)
    }
    function addNewItemField(obj,id)
    {
        // alert(id);
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
</script>
@endsection