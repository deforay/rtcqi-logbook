
<?php
use App\Service\CommonService;
$common = new CommonService();
$deliveryDate = $common->humanDateFormat($result[0]->expected_date_of_delivery);
?>
<section class="horizontal-grid" id="horizontal-grid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 3%;margin-left:3%;border: solid;margin-right:3%;">
                <div class="card-header">
                    <center><h2 class="form-section" style="font-weight: 600;">DELIVERY SCHEDULE DETAILS</h2></center><hr>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div id="show_alert"  class="mt-1" style=""></div>
                        <form class="form form-horizontal" role="form" name="updateItemReceive" id="updateItemReceive" method="post" action="/itemreceive/updateItemReceive/{{$deliveryId}}" autocomplete="off" onsubmit="validateNow();return false;">
                        @csrf
                        <!-- <div>
                            <center><h4><b>PURCHASE ORDER DETAILS</b></h4><center>
                        </div> -->
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>PO Number : </b> <span id="rfqNumber" class="spanFont">{{$result[0]->po_number }} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>PO Issued On : </b><span id="quoteNumber" class="spanFont">{{$result[0]->po_issued_on}}</span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Vendors : </b><span id="invitedDate" class="spanFont">{{$result[0]->vendor_name}}</span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Total Amount : </b><span id="quoteSts" class="spanFont" style="text-transform: capitalize;">{{$result[0]->total_amount}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Order Status : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$result[0]->order_status}} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Payment Status : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->payment_status}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Item Name : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$result[0]->item_name}} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Delivery Quantity : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->delivery_qty}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Expected Delivery : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$deliveryDate}} </span></h4>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Delivery Mode : </b><span id="deliveryDate" class="spanFont" style="text-transform: capitalize;">{{$result[0]->delivery_mode}} </span></h4>
                            </div>
                        </div>
                        <br/>
                       
                        <!-- <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Attachment Files : </b><span id="vendorNotes" class="spanFont">
                                        <?php 
                                            // if(isset($result[0]->upload_path)){

                                            //     $fileVaL= explode(",", $result[0]->upload_path);
                                            //     $filecount=count($fileVaL);
                                            //     if($filecount<1){
                                            //         $forcount=$filecount-1;
                                            //     }else{
                                            //         $forcount=$filecount;
                                            //     }
                                            //     for($i=0;$i<$forcount;$i++)
                                            //     {
                                            //     $imagefile= str_replace('/var/www/asm-pi/public', '', $fileVaL[$i]);
                   
                                            //     echo  '<a href="'.$imagefile.'" target="_blank"><i class="ft-file">Attachment File</i></a></br>';
                                            //      }
                                            // }
                                        ?> </span></h4>
                            </div>
                        </div> -->
                        <br/>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Received Quantity<span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <input type="text" id="receivedQty" oninput="changeScheduleStatus()" value="" class="form-control isRequired" autocomplete="off" placeholder="Enter Received Quantity" name="receivedQty" title="Please enter Received Quantity" >
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Damaged Quantity<span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <input type="text" id="damagedQty" oninput="changeScheduleStatus();" value="" class="form-control isRequired" autocomplete="off" placeholder="Enter Damaged Quantity" name="damagedQty" title="Please enter Damaged Quantity" >
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Delivery Schedule Status<span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <input type="text" id="status" value="" readonly class="form-control isRequired" autocomplete="off" placeholder="Enter Delivery Schedule Status" name="status" title="Please enter Delivery Schedule Status" >
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Short Description <span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <textarea id="description" class="form-control" name="description" placeholder="Enter the reason for editing delivery schedule"  title="Please Enter Description"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <br/>
                        <input type="hidden" value="{{$deliveryId}}" id="deliveryId" name="deliveryId" >
                        <input type="hidden" value="{{$result[0]->pod_id}}" id="pod_id" name="pod_id" >
                        </form>
                        <div class="form-actions right" style="margin-bottom: 5%;">
                            <button type="button" class="btn btn-warning mr-1 float-right ml-2" data-dismiss = "modal">
                            <i class="ft-x"></i> Close
                            </button>
                            <button type="submit" onclick="validateNow();return false;" class="btn btn-primary float-right">
                                <i class="la la-check-square-o"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
var deliveryQty = '{{$result[0]->delivery_qty}}';
$(document).ready(function() {
    $('.datepicker').datepicker({
        // format: 'dd-M-yyyy',
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
    let total = 0;
    receivedQty = $('#receivedQty').val();
    damagedQty = $('#damagedQty').val();
    total = parseInt(receivedQty) + parseInt(damagedQty);
    flag = deforayValidator.init({
        formId: 'updateItemReceive'
    });
    if(total > deliveryQty){
        swal("Please enter valid received and damaged quantity")
    }
    else{
        if (flag == true) {
            $('#status').prop('disabled',false)
            if (duplicateName) {
                document.getElementById('updateItemReceive').submit();
            }
        }
        else{
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $(".infocus").focus();
        }
    }
}

function changeScheduleStatus(){
    receivedQty = $('#receivedQty').val();
    damagedQty = $('#damagedQty').val();
    if(damagedQty>0){
        $('#description').addClass('isRequired');
    }
    if(receivedQty){
        if(receivedQty>deliveryQty){
            $('#receivedQty').val('')
            swal("Entered Received Quantity cannot be greater than Delivery Quantity")
            return
        }
        if(damagedQty>deliveryQty){
            $('#damagedQty').val('')
            swal("Entered Damaged Quantity cannot be greater than Delivery Quantity")
            return
        }
        if(deliveryQty == receivedQty && (damagedQty=='' || damagedQty==0)){
            $('#status').val('Received')
            // $('#damagedQty').val(0);
        }
        else{
            $('#status').val('Non Conformity')
        }
    }
}
</script>