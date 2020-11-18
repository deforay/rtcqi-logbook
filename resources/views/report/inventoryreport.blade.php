<!-- 
    Author             : Sudarmathi M
    Date               : 04 Sep 2020
    Description        : Inventory Report view screen
    Last Modified Date : 04 Sep 2020
    Last Modified Name : Sudarmathi M
-->

@extends('layouts.main')

@section('content')


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Report
                        </li>
                        <li class="breadcrumb-item"><a href="/inventoryReport/">Inventory Report</a>
                        </li>
                    </ol>
                </div>
            </div>
            
        </div>
        <div class="content-header-right col-md-4 col-12 ">
            <div class="dropdown float-md-right">
            </div>
        </div>
    </div>
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
                            <h4 class="card-title"></h4>
                            <h3 class="content-header-title mb-0">Inventory Report</h3>
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
                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Location<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branches" name="branches" title="Please select locations" onchange="getInventoryReport(this.value)">
                                                <option value="">Select Locations</option>
                                                @foreach($branch as $type)
                                                    <option value="{{ $type->branch_id }}">{{ $type->branch_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-3 col-lg-12 mt-2">
                                        <a class="btn btn-default" href="/report/exportDownload/" style="display:none;" onclick="location.href=this.href+'?file='+excelFile;return false;"id="excelDownload" ></a>
                                        <a href="javascript:void(0)" onclick="getExportData();" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                                            <b><i class="ft-download icon-left"></i> Export Inventory Report</b></a>
                                    </div>
                                </div>
                                <p class="card-text"></p>
                                <div id="tabs">
                                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified" id="myTab">
                                      <li class="nav-item">
                                        <a class="nav-link active" id="reportConstab-tab1" data-toggle="tab" href="#reportConstab"
                                        aria-controls="reportConstab" aria-expanded="true"><i class="ft-edit"></i>Consolidated Data</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" id="reportBrktab-tab1" data-toggle="tab" href="#reportBrktab" aria-controls="reportBrktab"
                                        aria-expanded="false"><i class="ft-package"></i> Detailed Data</a>
                                      </li>
                                    </ul>
                                    <div class="tab-content px-1 pt-1">
                                        <div role="tabpanel" class="tab-pane active" id="reportConstab" aria-labelledby="reportConstab-tab1" aria-expanded="true">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered zero-configuration" id="inventoryReport" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:25%">Item Name</th>
                                                            <th style="width:25%">Item Code</th>
                                                            <th style="width:25%">Current Inventory</th>
                                                            <th style="width:25%">Location</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="inventoryReportDetails">
            
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="reportBrktab" role="tabpanel" aria-labelledby="reportBrktab-tab1" aria-expanded="false">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered zero-configuration" id="inventoryReportBrk" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:0%">Item Name</th>
                                                            <th style="width:0%">Item Code</th>
                                                            <th style="width:0%">Current Inventory</th>
                                                            <th style="width:0%">Location</th>
                                                            <th style="width:0%">PO Number</th>
                                                            <th style="width:0%">PO Issued On</th>
                                                            <th style="width:0%">Vendor</th>
                                                            <th style="width:0%">Expiry<br/>Date</th>
                                                            <th style="width:0%">Manufacturing<br/>Date</th>
                                                            <th style="width:0%">Received<br/>Date</th>
                                                            <th style="width:0%">Brand</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="inventoryReporBrkDetails">
            
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
    $(document).ready(function() {
        $('#inventoryReportBrk').DataTable( {
            "scrollX": true
        });
        $.blockUI();
        getInventoryReport();
        getDetailedInventoryReport();
        $.unblockUI();
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
          localStorage.setItem('activeTab', $(e.target).attr('href'));
          $('#tabStatus').val('');
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
            if(activeTab=='#reportConstab'){
                getInventoryReport();
            }
            if(activeTab=='#reportBrktab'){
                getDetailedInventoryReport();
            }
            
        }

    });
    function getInventoryReport(val='')
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getInventoryReport') }}",
            method: 'post',
            data: {
                branchId : val
            },
            success: function(result) {
                var data = JSON.parse(result);
                console.log(data)
                var opt = '';
                if(data.length>0){
                    for(var k=0;k<data.length;k++){
                        opt += '<tr>'
                        opt += '<td class="firstcaps">'+data[k]['item_name']+'</td>'
                        opt += '<td>'+data[k]['item_code']+'</td>'
                        opt += '<td>'+data[k]['stock_quantity']+'</td>'
                        opt += '<td>'+data[k]['branch_name']+'</td>'
                        opt += '</tr>'
                    }
                }
                else{
                    opt += '<tr colspan="11">No Data Available</tr>'
                }
                $('#inventoryReportDetails').html(opt)
            }
        });
        
    }
    function getDetailedInventoryReport(val='')
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getDetailedInventoryReport') }}",
            method: 'post',
            data: {
                branchId : val
            },
            success: function(result) {
                var data = JSON.parse(result);
                console.log(data)
                var opt = '';
                if(data.length>0){
                    for(var k=0;k<data.length;k++){
                        opt += '<tr>'
                        opt += '<td class="firstcaps">'+data[k]['item_name']+'</td>'
                        opt += '<td>'+data[k]['item_code']+'</td>'
                        opt += '<td>'+data[k]['stock_quantity']+'</td>'
                        opt += '<td>'+data[k]['branch_name']+'</td>'
                        opt += '<td>'+data[k]['po_number']+'</td>'
                        opt += '<td>'+data[k]['po_issued_on']+'</td>'
                        opt += '<td>'+data[k]['vendor_name']+'</td>'
                        opt += '<td>'+data[k]['expiry_date']+'</td>'
                        opt += '<td>'+data[k]['manufacturing_date']+'</td>'
                        opt += '<td>'+data[k]['received_date']+'</td>'
                        opt += '<td>'+data[k]['brand_name']+'</td>'
                        opt += '</tr>'
                        
                    }
                }
                else{
                    opt += '<tr colspan="4">No Data Available</tr>'
                }
                $('#inventoryReporBrkDetails').html(opt)
               
            }
        });
        
    }

    var excelFile;
    function getExportData(){
        var branches = $('#branches').val();

        $.post("{{ url('/report/export') }}",
         { branches:branches},
        function(data){
            console.log("{{ base_path()}}");
            storage = "{{ base_path() . "/storage/app/"}}"+data;
            console.log(data)
            // storage = "/storage/app/"+data;
            // $('#excelDownload').attr("href", data);
            excelFile = data;
            $("#excelDownload").click()
            // window.open(storage, '_blank');
            // window.location.href = storage;
        });
    }
    
  </script>
@endsection