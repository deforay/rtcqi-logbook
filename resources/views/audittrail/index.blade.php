<!--
    Author             : Sakthi
    Date               : 10 Mar 2022
    Description        : {{ __('messages.audit_trail') }} view screen
    Last Modified Date : 10 Mar 2022
    Last Modified Name : Sakthi
-->

@extends('layouts.main')

@section('content')

<?php
$enddate = date('d-M-Y');
$startdate = date('d-M-Y', strtotime('-29 days'));
if(isset($params))
{
    $siteId = $params['testsiteId'];
    $month = $params['reportingMon'];
}
if(isset($result))
{
$auditInfo = json_decode(json_encode($result['auditValues']), true);
$currentRecord = json_decode(json_encode($result['currentRecord']), true);
}
//echo '<pre>'; print_r($currentRecord); die;
?>
<style>
	#current, #auditTable {
		display: block;
		overflow-x: auto;
		white-space: nowrap;
	}
</style>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/auditTrail/">{{ __('messages.audit_trail') }}</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
    <br>
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
        <div class="text-center" style=""><b>
                {{ session('status') }}</b></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <script>
        $('#show_alert_index').delay(3000).fadeOut();
    </script>
    @endif
    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="content-body">
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="content-header-title mb-0">{{ __('messages.audit_trail') }}</h3>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                            <div id="show_alert" class="mt-1"></div>
                                    <h4 class="card-title">{{ __('messages.filter_the_data') }}</h4><br>
                                    <form class="form" role="form" name="auditFilter" id="auditFilter" method="post" action="/auditTrail" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.site_name') }} <span class="mandatory">*</span>
                                                    </h5>
                                                    <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="testsiteId" name="testsiteId" title="{{ __('messages.select') }} {{ __('messages.site_name') }}">
                                                        @foreach($testSite ?? '' as $row2)
                                                        <option <?php if(isset($siteId) && $siteId==$row2->ts_id) echo "selected='selected'"; ?> value="{{$row2->ts_id}}">{{$row2->site_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                <h5>{{ __('messages.reporting_month') }}
                                                    </h5>
                                                    <div class="form-group">
                                                    <input type="text" id="reportingMon" value="<?php if(isset($month)) echo $month; ?>" class="form-control isRequired" autocomplete="off" placeholder="{{ __('messages.enter') }} {{ __('messages.reporting_month') }}" name="reportingMon" title="Please {{ __('messages.enter') }} {{ __('messages.reporting_month') }}" >
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-7" style="color:#FFF;">
                                                <div class="form-group row">

                                                    <div class="col-md-8">
                                                        <button type="submit" class="btn btn-info"> {{ __('messages.search') }}</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href="/auditTrail"><span>{{ __('messages.reset') }}</span></a>&nbsp;&nbsp;
                                                    </div>
                                                </div></div>
                                        </div>
</form>
                                <p class="card-text"></p>
                                <?php  if(!empty($siteId))
                                    { ?>
                                <div class="table-responsive">
                                    <?php
                                    if(!empty($auditInfo))
                                    {
                                    ?>
                                     <select name="auditColumn[]" id="auditColumn" class="form-control" multiple="multiple">
	<?php
	$i=0;
	foreach($result['auditColumns'] as $col)
	{
	?>
	<option value="<?php echo $i; ?>"><?php echo $col; ?></option>
	<?php
	$i++;
	}
	?>
	</select>
    <table id="auditTable" class="table table-bordered table-striped table-vcenter" aria-hidden="true">
                                        <thead>
                                            <tr>
                                            <?php
                                        $colArr = array();
										foreach ($result['auditColumns'] as $col) {
											$colArr[] = $col;
										?>
											<th>
												<?php
												echo $col;
												?>
											</th>
										<?php } ?>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
									//echo count($auditInfo).'  ---  '.count($colArr); die;
                                    for ($i = 0; $i < count($auditInfo); $i++) {
                                ?>
                                        <tr>
                                        <?php
												for ($j = 0; $j < count($colArr); $j++) {

													if (($j > 3) && ($i > 0) && $auditInfo[$i][$colArr[$j]] != $auditInfo[$i - 1][$colArr[$j]]) {
														echo '<td style="background: orange; color:black;" >' . $auditInfo[$i][$colArr[$j]] . '</td>';
													} else {

														echo '<td>' . $auditInfo[$i][$colArr[$j]] . '</td>';
													}
												?>
												<?php }
												?>
                                        </tr>
                                <?php
                                    }
                                
                                ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <h3> Current Record for Monthly Report</h3>
                                        <table id="current" class="table table-striped table-hover table-bordered" aria-hidden="true">
								<thead>
									<tr>
										<?php
										$colValue=array();
										foreach ($result['currentColumns'] as $col) {
                                                       $colValue[] = $col;
										?>
											<th>
												<?php
												echo $col;
												?>
											</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($currentRecord)) {
									?>
											<tr>
												<?php
												for ($j = 3; $j < count($colValue); $j++) {
												?>
													<td>
														<?php
														echo $currentRecord[0][$colValue[$j]];
														?>
													</td>
												<?php }
												?>
											</tr>
									<?php
										
									} 
									?>
								</tbody>

							</table>
                                    <?php
                                    }
                                    else
							{
								echo '<h3 align="center">Records are not available for this sample code. Please enter  valid sample code</h3>';
							}
						}
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>

<script>
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'auditFilter'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('auditFilter').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

function printString(columnNumber)
{
    // To store result (Excel column name)
        let columnName = [];
  
        while (columnNumber > 0) {
            // Find remainder
            let rem = columnNumber % 26;
  
            // If remainder is 0, then a
            // 'Z' must be there in output
            if (rem == 0) {
                columnName.push("Z");
                columnNumber = Math.floor(columnNumber / 26) - 1;
            }
            else // If remainder is non-zero
            {
                columnName.push(String.fromCharCode((rem - 1) + 'A'.charCodeAt(0)));
                columnNumber = Math.floor(columnNumber / 26);
            }
        }
  
        // Reverse the string and print result
        return columnName.reverse().join("");
}
oTable = null;
$(document).ready(function() {
    $('#reportingMon').datepicker({
            autoclose: true,
            format: 'M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            viewMode: "months",
            minViewMode: "months",
            // startDate:'today',
            todayHighlight: true,
            clearBtn: true,
        });

        $("#auditColumn").select2({
      placeholder: 'Select Columns',
      width: '100%'
    });

    $selectElement = $('#testsiteId').prepend('<option selected></option>').select2({
            placeholder: "{{ __('messages.select') }} {{ __('messages.site_name') }}"
        });
        $("#testsiteId").val(<?php if(isset($siteId)) echo $siteId; ?>).trigger('change');

		oTable = $('#auditTable').DataTable( {
			dom: 'Bfrtip',
    buttons: [ 
	   {
	            extend: 'excelHtml5',
				exportOptions: {
                    columns: ':visible'
                },
	            text: 'Export To Excel',
	            title:'AuditTrailSample-<?php if(isset($month)) echo $month; ?>',
	            extension:'.xlsx',
				customize: function ( xlsx ) {
        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        // Map used to map column index to Excel index
		
		var excelMap = [];
	b=0;
	for(a=1;a<=27;a++)
		{
				excelMap[b] = printString(a);
				b++;
		}
        var count = 0;
        var skippedHeader = 0;
		
        $('row', sheet).each( function () {
          var row = this;
          if (skippedHeader==2) {
//             var colour = $('tbody tr:eq('+parseInt(count)+') td:eq(2)').css('background-color');
            
            // Output first row
            if (count === 0) {
              console.log(this);
            }
            
            for (td=0; td<27; td++) {
              
              // Output cell contents for first row
              if (count === 0) {
                console.log($('c[r^="' + excelMap[td] + '"]', row).text());
              }
              var colour = $(oTable.cell(':eq('+count+')',td).node()).css('background-color');            

              if (colour === 'rgb(255, 165, 0)' || colour == 'orange') {
                $('c[r^="' + excelMap[td] + '"]', row).attr( 's', '35' );
              }
             
            }
            count++;
          }
          else {
            skippedHeader++;
          }
        });
      }
	        }
    ],
        // scrollY: '250vh',
		//	scrollX: true,
			scrollCollapse: true,
			paging: false,
			"aaSorting": [1, "asc"],
		   } );

        $('#auditColumn').on("select2:select select2:unselect", function(e) {
		
		var columns = $(this).val();

		if(columns=="" || columns==null)
		{
			oTable.columns().visible(true);
		}
		else{
			oTable.columns().visible(false);
			oTable.columns(columns).visible(true);
		}
	
		});
    });

   
</script>
@endsection
