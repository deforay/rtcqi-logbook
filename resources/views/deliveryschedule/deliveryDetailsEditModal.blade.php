
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
                        <form class="form form-horizontal" role="form" name="updateDeliverySchedule" id="updateDeliverySchedule" method="post" action="/deliveryschedule/updateDeliverySchedule/{{$deliveryId}}" autocomplete="off" onsubmit="validateNow();return false;">
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
                        <!-- <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <h4><b>Attachment Files : </b><span id="vendorNotes" class="spanFont">                        <?php 
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
                                    <h5>Item Name<span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                    <select class="form-control select2 isRequired" autocomplete="off" style="width:100%;" id="ItemId" name="ItemId">
                                        <option value="{{$result[0]->item_id}}">{{$result[0]->item_name}}</option>
                                    </select>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Delivery Quantity<span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <input type="text" id="deliverQty" value="{{$result[0]->delivery_qty}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Delivery Quantity" name="deliverQty" title="Please Delivery Quantity" >
                                    </div>
                                    <input type="hidden" id="hiddenPo_id">
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Expected Delivery <span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <input type="text" id="expectedDelivery"  value="{{$deliveryDate}}" class="form-control datepicker isRequired" autocomplete="off" placeholder="Select Expected Delivery Date" name="expectedDelivery" title="Please Select Expected Delivery Date">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Delivery Mode<span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <input type="text" id="deliveryMode"  value="{{$result[0]->delivery_mode}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Delivery Mode" name="deliveryMode" title="Please Delivery mode" >
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <fieldset>
                                    <h5>Comments <span class="mandatory">*</span>
                                    </h5>
                                    <div class="form-group">
                                        <textarea id="comments" class="form-control isRequired" name="comments" placeholder="Enter the reason for editing delivery schedule"  title="Please Enter Comments"></textarea>
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
   
    flag = deforayValidator.init({
        formId: 'updateDeliverySchedule'
    });
    
    if (flag == true) {
        if (duplicateName) {
            document.getElementById('updateDeliverySchedule').submit();
        }
    }
    else{
        $('#show_alert').html(flag).delay(3000).fadeOut();
        $('#show_alert').css("display","block");
        $(".infocus").focus();
    }
}
</script>