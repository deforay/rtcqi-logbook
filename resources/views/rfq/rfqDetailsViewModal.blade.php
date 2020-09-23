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

$vendor_name = '';
foreach($vendor as $type){
    if(session('loginType')=='users'){
        if (in_array($type->vendor_id, $vendors)) {
            if($vendor_name){
                $vendor_name = $vendor_name.','.$type->vendor_name;
            }
            else{
                $vendor_name = $type->vendor_name;
            }
        }
    }
    else{
        $userId=session('userId');
        if ($type->vendor_id == $userId) {
            $vendor_name = $type->vendor_name;
        }
    }
}

if($result['rfq'][0]->description){
    $specification = $result['rfq'][0]->description;
}
else{
    $specification = '';
}

?>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js')}}"></script>
<section class="horizontal-grid" id="horizontal-grid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 3%;margin-left:3%;border: solid;margin-right:3%;">
                <div class="card-header">
                    <center><h2 class="form-section" style="font-weight: 600;">RFQ</h2></center>

                </div>
                <div class="card-content collapse show" style="">
                    <div class="card-body">
                        @csrf
<div class="row">
    <div class="col-12">
      <div class="card border-blue-grey border-lighten-4" id="blue-grey-box-shadow">
        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3 col-md-6 col-12 border-right-blue-grey border-right-lighten-5">
                <div class="text-center">
                  <span class="font-medium-5 info text-bold-300">{{Str::upper($result['rfq'][0]->rfq_number)}}</span>
                </div>
                <div class="text-center">
                    <span class="blue-grey darken-1 font-medium-3 text-bold-500">RFQ Number </span>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-12 border-right-blue-grey border-right-lighten-5">
                <div class="text-center">
                  <span class="font-medium-5 info text-bold-300">{{$issuedOn}}</span>
                </div>
                <div class="text-center">
                    <span class="blue-grey darken-1 font-medium-3 text-bold-500">Issued On</span>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-12 border-right-blue-grey border-right-lighten-5">
                <div class="text-center">
                  <span class="font-medium-5 info text-bold-300">{{ucfirst($vendor_name)}}</span>
                </div>
                <div class="text-center">
                    <span class="blue-grey darken-1 font-medium-3 text-bold-500">Vendors</span>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-12">
                <div class="text-center">
                    <span class="font-medium-5 info text-bold-300">{{$lastDate}}</span>
                  </div>
                  <div class="text-center">
                      <span class="blue-grey darken-1 font-medium-3 text-bold-500">Last On</span>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
        <div class="card accordion collapse-icon accordion-icon-rotate" style="border: 1px solid #dbf2fe !important;">
            <a id="heading11" class="card-header info collapsed" data-toggle="collapse" href="#accordion11" aria-expanded="false" aria-controls="accordion11">
                <div class="card-title lead">Specification</div>
            </a>
            <div id="accordion11" role="tabpanel" data-parent="#accordionWrap1" aria-labelledby="heading11" class="collapse" style="">
                <div class="card-content">
                    <div class="card-body">
                        <?php echo $specification; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
                                <div class="bd-example p-1">
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

