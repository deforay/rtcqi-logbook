<?php 

use App\Service\CommonService;
$common = new CommonService();
$invitedOn = $common->humanDateFormat($quote[0]->invited_on);
$estDelDate = $common->humanDateFormat($quote[0]->estimated_date_of_delivery);

?>
<section class="horizontal-grid" id="horizontal-grid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 3%;margin-left:3%;border: solid;margin-right:3%;">
                <div class="card-header">
                    <center><h2 class="form-section" style="font-weight: 600;">Quote Order</h2></center><hr>
                </div>
                <div class="card-content collapse show" style="margin-top: -40px;">
                    <div class="card-body">
                        <form class="form form-horizontal" role="form" name="updateBatchNumber" action="/quotes/updateBatchNumber" id="updateBatchNumber" method="post" autocomplete="off" >
                        @csrf
                        <div>
                            <center><h4><b>QUOTE</b></h4><center>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>RFQ Number : </b> <span id="rfqNumber" class="spanFont">{{$quote[0]->rfq_number}} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Quote Number : </b><span id="quoteNumber" class="spanFont">{{$quote[0]->quote_number}}</span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Invited On : </b><span id="invitedDate" class="spanFont">{{$invitedOn}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Quote Status : </b><span id="quoteSts" class="spanFont" style="text-transform: capitalize;">{{$quote[0]->quotes_status}} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Delivery Mode : </b><span id="deliveryMode" class="spanFont">{{$quote[0]->mode_of_delivery}} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Estimated Date : </b><span id="deliveryDate" class="spanFont">{{$estDelDate}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Vendor Notes : </b><span id="vendorNotes" class="spanFont">{{$quote[0]->vendor_notes}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div>
                            <center><h4><b>Order Details</b></h4><center>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="table-responsive">
                                <div class="bd-example">
                                    <table class="table table-striped table-bordered table-condensed table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th style="width:20%;">Item</th>
                                            <th style="width:20%;">Quantity</th>
                                            <th style="width:15%;">Unit Price<span class="mandatory">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="stoSaleDetails">
                                        @php $z=0; @endphp
                                        @foreach($quote['quotesdetails'] as $quotes)
                                            <tr>
                                                <input type="hidden" name="qdId[]" id="qdId{{$z}}" value="{{$quotes->qd_id}}"/>
                                                <td>{{$quotes->item_name}}</td>
                                                <td style="text-align:right;">{{$quotes->quantity}}</td>
                                                <td>{{$quotes->unit_price}}</td>
                                            </tr>
                                            @php $z++; @endphp
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$quoteId}}" id="quoteId" name="quoteId" >
                        </form>
                        <br/>
                        <div class="form-actions right" style="margin-bottom: 5%;">
                        <button type="button" class="btn btn-warning mr-1 float-right ml-2" data-dismiss = "modal">
                        <i class="ft-x"></i> Close
                        </button>
                        <?php if(session('loginType')=='users' && $quotes->quotes_status=='responded' && $quotes->approve_status=='no' ){ ?>
                        <a href="/purchaseorder/add/<?php echo $quoteId ?>" name="edit" id="'.$quoteId.'" class="btn btn-primary  float-right" title="Edit">
                        <!-- <button type="submit" onclick="validateNow();return false;" class="btn btn-primary float-right">  -->
                        <i class="la la-check-square-o"></i> Approve
                        <!-- </button> -->
                        </a>
                        <?php }?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'updateBatchNumber'
        });
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('updateBatchNumber').submit();
            }
        }
        else{
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $(".infocus").focus();
        }
    }

</script>