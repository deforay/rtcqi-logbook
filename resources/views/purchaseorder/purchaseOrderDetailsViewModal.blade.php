
<?php
use App\Service\CommonService;
// $common = new CommonService();
// $issuedOn = $common->humanDateFormat($result[0]->po_issued_on);
?>
<section class="horizontal-grid" id="horizontal-grid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 3%;margin-left:3%;border: solid;margin-right:3%;">
                <div class="card-header">
                    <center><h2 class="form-section" style="font-weight: 600;">PURCHASE ORDER</h2></center><hr>
                </div>
                <div class="card-content collapse show" style="margin-top: -40px;">
                    <div class="card-body">
                        @csrf
                        <!-- <div>
                            <center><h4><b>PURCHASE ORDER DETAILS</b></h4><center>
                        </div> -->
                        <br/>
                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>PO Number : </b> <span id="rfqNumber" class="spanFont">{{$result[0]->po_number }} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>PO Issued On : </b><span id="quoteNumber" class="spanFont">{{$result[0]->po_issued_on}}</span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Vendors : </b><span id="invitedDate" class="spanFont">@foreach($vendor as $type){{ $result[0]->vendor == $type->vendor_id ?  $type->vendor_name:''}} @endforeach </span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Total Amount : </b><span id="quoteSts" class="spanFont" style="text-transform: capitalize;">{{$result[0]->total_amount}} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Order Status : </b><span id="deliveryMode" class="spanFont" style="text-transform: capitalize;">{{$result[0]->order_status}} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
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
                                            <th style="width:20%;">Unit</th>
                                            <th style="width:20%;">Quantity</th>
                                            <th style="width:15%;">Unit Price<span class="mandatory">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="stoSaleDetails">
                                        @php $z=0; @endphp
                                        @foreach($purchaseOrderDetails as $orderDetail)
                                            <tr>
                                               
                                                <td> @foreach ($item as $items)
                                                     {{ $orderDetail->item_id == $items->item_id ?  $items->item_name:''}}
                                                                    @endforeach</td>
                                                <td >{{$orderDetail->unit_name}}</td>
                                                <td style="text-align:right;">{{$orderDetail->quantity}}</td>
                                                <td style="text-align:right;">{{$orderDetail->unit_price}}</td>
                                            </tr>
                                            @php $z++; @endphp
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                       
                        <br/>
                        <div class="form-actions right" style="margin-bottom: 5%;">
                        <button type="button" class="btn btn-warning mr-1 float-right ml-2" data-dismiss = "modal">
                        <i class="ft-x"></i> Close
                        </button>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
