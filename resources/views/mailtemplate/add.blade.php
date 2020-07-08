<!-- 
    Author             : Sudarmathi M
    Date               : 26 Mar 2020
    Description        : mail template screen
    Last Modified Date : 26 Mar 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Mail Template</h3>
		<div class="row breadcrumbs-top d-inline-block">
			
		</div>
	</div>
</div>
<div class="content-body">
	<!-- horizontal grid start -->
	<div class="content-body">
		<!-- horizontal grid start -->
		<section class="horizontal-grid" id="horizontal-grid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<!-- <h4 class="form-section"><i class="la la-edit"></i>Edit Mail Template</h4> -->
							<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
									<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
								</ul>
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
								<form enctype="multipart/form-data" class="form form-horizontal" role="form" name="updateMailTemplate" id="updateMailTemplate"  method="post" action="/mailtemplate/add" autocomplete="off" >
									@csrf
									<div class="row">
										<div class="col-md-8">
											<div class="form-group row">
												<label class="col-md-4 label-control" for="fromName">Template Name<span class="mandatory">*</span></label>
												<div class="col-md-8">
												<input type="text" id="templateName" name="templateName" class="form-control col-md-7 col-xs-12 isRequired" placeholder="Enter Template Name" title="Please enter the Template name">
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="form-group row">
												<label class="col-md-4 label-control" for="fromName">From Name<span class="mandatory">*</span></label>
												<div class="col-md-8">
												<input type="text" id="fromName" name="fromName" class="form-control col-md-7 col-xs-12 isRequired" placeholder="Enter From Name" title="Please enter the from name">
												</div>
											</div>
										</div>
										
										<div class="col-md-8">
											<div class="form-group row">
												<label class="col-md-4 label-control" for="fromMail">From Email<span class="mandatory">*</span></label>
												<div class="col-md-8">
													<div class="input-group">
													<input type="text" id="fromMail" name="fromMail" class="form-control isEmail col-md-7 col-xs-12 isRequired" placeholder="Enter From Mail" title="Please enter the from mail">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="form-group row">
												<label class="col-md-4 label-control" for="mailCc">Mail cc</label>
												<div class="col-md-8">
													<div class="input-group">
													<input type="text" id="mailCc" name="mailCc" class="form-control col-md-7 col-xs-12 isEmail" placeholder="Enter Mail CC" title="Please enter the mail cc">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="form-group row">
												<label class="col-md-4 label-control" for="mailBcc">Mail Bcc</label>
												<div class="col-md-8">
												<input type="text" id="mailBcc" name="mailBcc" class="form-control col-md-7 col-xs-12 isEmail" placeholder="Enter Mail BCC" title="Please enter the mail bcc">
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="form-group row">
												<label class="col-md-4 label-control" for="subject">Subject</label>
												<div class="col-md-8">
												<textarea id="subject" name="subject" class="form-control richtextarea isRequired" placeholder="Enter Subject" title="Please enter the subject"></textarea>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group row" >
												<label class="col-md-2 label-control" for="mainContent" style="margin-left: 64px !important;">Message</label>
												<div class="col-md-8">
												<textarea id="mainContent" name="mainContent" class="form-control richtextarea isRequired ckeditor" placeholder="Enter Message" title="Please enter the message" ></textarea>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group row" >
												<label class="col-md-2 label-control" for="mailPurpose" style="margin-left: 64px !important;">Mail Purpose</label>
												<div class="col-md-8">
												<input type="text" id="mailPurpose" name="mailPurpose" class="form-control col-md-7 col-xs-12" placeholder="Enter Mail Purpose" title="Please enter Mail Purpose"/>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group row">
												<div class="alert" style="margin-left:22%;">
														
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
									<div class="form-actions right">
										<a href="" class="btn btn-warning mr-1"><i class="ft-x"></i> Cancel</a>
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
		<!-- horizontal grid end -->
	</div>
	<!-- horizontal grid end -->
</div>
</div>
<script type="text/javascript">
    duplicateName = true;
    function validateNow() {
		var mainCont = CKEDITOR.instances['mainContent'].getData();
		$("#mainContent").html(mainCont);
        flag = deforayValidator.init({
            formId: 'updateMailTemplate'
        });
        if (flag) {
            if (duplicateName) {
                $.blockUI();
                document.getElementById('updateMailTemplate').submit();
            }
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

	
</script>
@endsection
