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
                    <center><h2 class="form-section" style="font-weight: 600;">Quote Order</h2></center>
                </div>
                <div class="card-content collapse show" style="margin-top: -40px;">
                    <div class="card-body">
                        <form class="form form-horizontal" role="form" name="updateBatchNumber" action="/quotes/updateBatchNumber" id="updateBatchNumber" method="post" autocomplete="off" >
                        @csrf
                        <div class="row mt-3">
                            <div class="col-12">
                              <div class="card" style="border: 1px solid #ebeff0 !important;" id="blue-grey-box-shadow">
                                <div class="card-content">
                                  <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                      <div class=" text-center">
                                        <div class="card-header" style=" background-color: #90a4ae2e; padding: 8px 2px 8px; ">
                                            <span class="display-4 blue-grey darken-1 font-medium-5">RFQ Number - </span>
                                            <span class="display-4 info darken-1 font-medium-5 pr-5">{{Str::upper($quote[0]->rfq_number)}}</span>
                                            <span class="display-4 blue-grey darken-1 font-medium-5 pl-5">Quote Number - </span>
                                            <span class="display-4 info darken-1 font-medium-5">@php echo (trim($quote[0]->quote_number)!='')?$quote[0]->quote_number:'' @endphp</span>
                                        </div>
                                        <div class="card-content mt-1">

                                          <ul class="row list-inline clearfix">

                            <li class="col-md-3 border-right-blue-grey border-right-lighten-2">
                                              <h1 class="success text-bold-400"> {{$quote[0]->quotes_status}}</h1>
                                              <span class="blue-grey darken-1"> Quote Status</span>
                                            </li>
                            <li class="col-md-3 border-right-blue-grey border-right-lighten-2 ">
                                              <h1 class="success text-bold-400">{{$invitedOn}}</h1>
                                              <span class="blue-grey darken-1"> Invited On</span>
                                            </li><li class="col-md-3 border-right-blue-grey border-right-lighten-2">
                                              <h1 class="success text-bold-400">@php echo (trim($estDelDate)!='')?$estDelDate:'-' @endphp</h1>
                                              <span class="blue-grey darken-1"> Estimated Date</span>
                                            </li>
                                            <li class="col-md-3 pl-0">
                                              <h1 class="success text-bold-400">@php echo (trim($quote[0]->mode_of_delivery)!='')?$quote[0]->mode_of_delivery:'-' @endphp</h1>
                                              <span class="blue-grey darken-1">Delivery Mode</span>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>


                                  </div>
                                </div>
                              </div>
                            <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                                <div class="card accordion collapse-icon accordion-icon-rotate" style="border: 1px solid #dbf2fe !important;">
                                    <a id="heading11" class="card-header info collapsed" data-toggle="collapse" href="#accordion11" aria-expanded="false" aria-controls="accordion11">
                                        <div class="card-title lead">Vendor Notes</div>
                                    </a>
                                    <div id="accordion11" role="tabpanel" data-parent="#accordionWrap1" aria-labelledby="heading11" class="collapse" style="">
                                        <div class="card-content">
                                            <div class="card-body">
                                                {{$quote[0]->vendor_notes}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="accordionWrap2" role="tablist" aria-multiselectable="true">
                                <div class="card accordion collapse-icon accordion-icon-rotate" style="border: 1px solid #dbf2fe !important;">
                                    <a id="heading12" class="card-header info collapsed" data-toggle="collapse" href="#accordion12" aria-expanded="false" aria-controls="accordion12">
                                        <div class="card-title lead">Specification</div>
                                    </a>
                                    <div id="accordion12" role="tabpanel" data-parent="#accordionWrap2" aria-labelledby="heading12" class="collapse" style="">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <?php echo $quote[0]->description; ?>
                                            </div>
                                        </div>
                                    </div>
                        
                                </div>
                            </div>
                            </div>
                          </div>


                        <div>
                            <center><h4><b>Order Details</b></h4><center>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="table-responsive">
                                <div class="bd-example pr-1 pl-1">
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
                        <button type="button" class="btn btn-warning mr-0 float-right ml-2" data-dismiss = "modal">
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
