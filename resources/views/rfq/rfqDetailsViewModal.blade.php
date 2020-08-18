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
    
    
foreach($vendor as $type){
    if (in_array($type->vendor_id, $vendors)) {
       $vendor_name= $type->vendor_name;
    } 
}
                          
                    
    ?>
<section class="horizontal-grid" id="horizontal-grid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 3%;margin-left:3%;border: solid;margin-right:3%;">
                <div class="card-header">
                    <center><h2 class="form-section" style="font-weight: 600;">RFQ</h2></center>
                <hr>
                </div>
                <div class="card-content collapse show" style="margin-top: -40px;">
                    <div class="card-body">
                        @csrf
                        <div>
                            <center><h4><b>RFQ DETAILS</b></h4><center>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>RFQ Number : </b> <span id="rfqNumber" class="spanFont">{{$result['rfq'][0]->rfq_number}} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Issued On : </b><span id="quoteSts" class="spanFont" style="text-transform: capitalize;">{{$issuedOn}} </span></h4>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Vendors : </b><span id="invitedDate" class="spanFont">{{$vendor_name}}</span></h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <h4><b>Last On : </b><span id="quoteSts" class="spanFont" style="text-transform: capitalize;">{{$lastDate}} </span></h4>
                            </div>
                        </div>
                        <br/>
                        <!-- <div class="row">
                          
                                <h4><b>Attachment Files : </b><span id="deliveryMode" class="spanFont">
                                     <?php 
                                                // $fileVaL= explode(",", $result['rfq'][0]->rfq_upload_file);
                                                // $filecount=count($fileVaL);
                                                // if($filecount<1){
                                                //     $forcount=$filecount-1;
                                                // }else{
                                                //     $forcount=$filecount;
                                                // }
                                                // for($i=0;$i<$forcount;$i++)
                                                // {
                                                // $imagefile= str_replace('/var/www/asm-pi/public', '', $fileVaL[$i]);
                   
                                                // echo  '<a href="'.$imagefile.'" target="_blank"><i class="ft-file">Attachment File</i></a></br>';
                                                //  }
                                                ?> 
                                                </span></h4>
                            
                          
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
                                            <th style="width:15%;">Quantity</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="stoSaleDetails">
                                        @php $z=0; @endphp
                                        @foreach($result['rfq'] as $rfq)
                                            <tr>
                                                
                                                <td><?php 
                                                foreach($item as $items) {
                                                if ($rfq->item_id== $items->item_id) {
                                                $item_name=$items->item_name;
                                                         }
                                                    }                                                      
                                                ?>
                                               {{$item_name}}
                                                </td>
                                                <td>{{$rfq->unit_name}}</td>
                                                <td style="text-align:right;">{{$rfq->quantity}}</td>
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

