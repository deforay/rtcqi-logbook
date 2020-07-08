<!-- 
    Author             : Sudarmathi M
    Date               : 27 Mar 2020
    Description        : preview mail template screen
    Last Modified Date : 27 Mar 2020
    Last Modified Name : Sudarmathi M
-->
<?php
    $oneTon = $result['oneTon'];
    $mainContent = array('##ORDER-DETAILS##');
    $content = $mail[0]->mail_content;
    if($salesType == 'dopw'){
        $salesTypeName = $result['result'][0]->dopw_name;
    }
    else if($salesType == 'rsc'){
        $salesTypeName = $result['result'][0]->rsc_name;
    }

    $mailContent = '<table border="1" cellpadding="1" cellspacing="1" style="width:100%">
                            <thead>
                                <tr>
                                    <th><strong>Indent No</strong></th>
                                    <th><strong>Sap Order No</strong></th>
                                    <th><strong>Sales Type</strong></th>
                                    <th><strong>Customer Name</strong></th>
                                    <th><strong>Location</strong></th>
                                    <th><strong>Product</strong></th>
                                    <th><strong>Grade</strong></th>
                                    <th><strong>Prime/NP/OG</strong></th>
                                    <th><strong>Qty in MTs</strong></th>
                                    <th><strong>Qty of Bags</strong></th>
                                    <th><strong>Truck No</strong></th>
                                    <th><strong>Authorized Transporter Name</strong></th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach($result['result'] as $results){
                                $qtyOfBags = $results->qty * $oneTon;
                                $mailContent .= "<tr>
                                                    <td>".$results->indent_no."</td>
                                                    <td>".$results->customer_SAP_code."</td>
                                                    <td>".$results->sales_type."-".$salesTypeName."</td>
                                                    <td>".$results->customer_name."</td>
                                                    <td>".$results->location_name."</td>
                                                    <td>".$results->product_name."</td>
                                                    <td>".$results->grade_name."</td>
                                                    <td>".$results->grade_quality."</td>
                                                    <td>".$results->qty."</td>
                                                    <td>".$qtyOfBags."</td>
                                                    <td>".$results->vehicle_no."</td>
                                                    <td>".$results->driver_name."</td>
                                                </tr>";
                            }
        $mailContent .= '</tbody></table>';
        $message = str_replace($mainContent, $mailContent, $content);
        $customerName = $result['result'][0]->customer_name;

        if($result['result'][0]->cc_email){
            $ccMail = $result['result'][0]->cc_email;
        }
        else{
            $ccMail = $mail[0]->mail_cc;
        }
?>
<section class="horizontal-grid" id="horizontal-grid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 3%;margin-left:3%;border: solid;margin-right:3%;">
                <div class="card-header">
                    <center><h4 class="form-section" style="font-weight: 600;">Edit Mail Template</h4></center>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <!-- <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul> -->
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index" ><div class="text-center" style="font-size: 18px;"><b>
                        {{ session('status') }}</b></div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <script>$('#show_alert_index').delay(3000).fadeOut();</script>
                @endif
                <div class="card-content collapse show">
                    <div class="card-body">
                    <div id="show_alert"  class="mt-1"></div>
                        <form enctype="multipart/form-data" class="form form-horizontal" role="form" name="addTempMail" id="addTempMail"  method="post" action="/addTempMail" autocomplete="off" >
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="fromName">From Name<span class="mandatory">*</span></label>
                                        <div class="col-md-8">
                                        <input type="text" id="fromName" name="fromName" class="form-control col-md-7 col-xs-12 isRequired" placeholder="Enter From Name" title="Please enter the from name" value="{{$mail[0]->from_name}}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="fromMail">From Email<span class="mandatory">*</span></label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                            <input type="text" id="fromMail" name="fromMail" class="form-control isEmail col-md-7 col-xs-12 isRequired" placeholder="Enter From Mail" title="Please enter the from mail" value="{{$mail[0]->mail_from}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="toMail">to Email<span class="mandatory">*</span></label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                            <input type="text" id="toMail" name="toMail" class="form-control isEmail col-md-7 col-xs-12 isRequired" placeholder="Enter To Mail" title="Please enter the To mail" value="{{$result['result'][0]->to_email}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="mailCc">Mail cc</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                            <input type="text" id="mailCc" name="mailCc" class="form-control col-md-7 col-xs-12" placeholder="Enter Mail CC" title="Please enter the mail cc" value="{{$ccMail}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="mailBcc">Mail Bcc</label>
                                        <div class="col-md-8">
                                        <input type="text" id="mailBcc" name="mailBcc" class="form-control col-md-7 col-xs-12" placeholder="Enter Mail BCC" title="Please enter the mail bcc" value="{{$mail[0]->mail_bcc}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="subject">Subject</label>
                                        <div class="col-md-8">
                                        <textarea id="subject" name="subject" class="form-control richtextarea isRequired" placeholder="Enter Subject" title="Please enter the subject">{{$mail[0]->mail_subject}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row" >
                                        <label class="col-md-2 label-control" for="mainContent" style="margin-left: 64px !important;">Message</label>
                                        <div class="col-md-8">
                                        <textarea id="mainContent" name="mainContent" class="form-control richtextarea isRequired ckeditor" placeholder="Enter Message" title="Please enter the message" >{{$message}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="mailTempId"  name="mailTempId"  value="{{$mail[0]->mail_temp_id}}"/>
                                <input type="hidden" id="mailPurpose" name="mailPurpose" value="{{$mail[0]->mail_purpose}}"/>
                            
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="alert" style="margin-left:22%;">
                                            <div><b>##ORDER-DETAILS##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Order Details</div>
                                            <!-- <div><b>##INDENT-NUMBER##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Indent Number</div>
                                            <div><b>##SAP-ORDER##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Sap Order Number</div>
                                            <div><b>##SALES-TYPE##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Sales Type Name</div>
                                            <div><b>##CUSTOMER-NAME##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Customer Name</div>
                                            <div><b>##LOCATION##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Location</div>
                                            <div><b>##PRODUCT-NAME##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Product Name</div>
                                            <div><b>##GRADE-NAME##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Grade Name</div>
                                            <div><b>##GRADE-QUALITY##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Grade Quality</div>
                                            <div><b>##QTY##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Quantity in MTs</div>
                                            <div><b>##QTY-OF-BAGS##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Quantity of Bags</div>
                                            <div><b>##TRUCK-NUMBER##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Truck Number </div>
                                            <div><b>##TRANSPORTER-NAME##</b>&nbsp&nbsp&nbsp --- &nbsp&nbsp Authorized Transporter Name</div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="orderId" name="orderId" value="{{$orderId}}">
                            <input type="hidden" id="salesType" name="salesType" value="{{$salesType}}">
                            <input type="hidden" id="customerName" name="customerName" value="{{$customerName}}">
                            <div class="form-actions right">
                                <button class="btn btn-warning mr-1" data-dismiss = "modal"><i class="ft-x"></i> Cancel</button>
                                <button type="submit" class="btn btn-info" onclick="validateNow();return false;">
                                    <i class="la la-check-square-o"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section class="horizontal-grid" id="horizontal-grid">


<script type="text/javascript">
    duplicateName = true;
    function validateNow() {
		var mainCont = CKEDITOR.instances['mainContent'].getData();
		$("#mainContent").html(mainCont);
        flag = deforayValidator.init({
            formId: 'addTempMail'
        });
        if (flag == true) {
            if (duplicateName) {
                $.blockUI();
                document.getElementById('addTempMail').submit();
            }
        }
        else{
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $(".infocus").focus();
        }
    }
	
    
    // $(function () {
    // //bootstrap WYSIHTML5 - text editor
    // //$(".richtextarea").wysihtml5();

	// 	CKEDITOR.editorConfig = function( config )
	// 	{
    //         alert(config)
	// 		config.toolbar_Full = [
	// 			{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', 'Templates', 'document' ] },
	// 		];
	// 	};
    // });

    $(document).ready(function(e) {
        CKEDITOR.replace('mainContent');
    });

    

	
</script>

