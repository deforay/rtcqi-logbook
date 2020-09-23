<!-- 
    Author             : Sriram V
    Date               : 15 Sep 2020
    Description        : Maintenance view screen
    Last Modified Date : 
    Last Modified Name :
-->
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <!-- <li class="breadcrumb-item active">Maintenance
                        </li> -->
                        <li class="breadcrumb-item"><a href="/maintenance/">Maintenance</a>
                        </li>
                        <li class="breadcrumb-item active">All Records</li>
                    </ol>
                </div>
            </div>
            
        </div>
        <div class="content-header-right col-md-6 col-12 ">
            <div class="dropdown float-md-right">
            <?php
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\Maintenance\\MaintenanceController']['add']) && ($role['App\\Http\\Controllers\\Maintenance\\MaintenanceController']['add'] == "allow")){ ?>
                <a href="/maintenance/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                <b><i class="ft-plus icon-left"></i> Add Maintenance</b></a>
            <?php } ?>
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
                            <h3 class="content-header-title mb-0">Maintenance</h3>
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
                                <p class="card-text"></p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="maintenanceList" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width:20%">Item Name</th>
                                                <th style="width:20%">Service Date</th>
                                                <th style="width:10%">Service Done By</th>
                                                <th style="width:10%">Verified By</th>
                                                <th style="width:10%">Regular Service</th>
                                                <th style="width:10%">Next Maintenance Date</th>
                                                <th style="width:10%">Status</th>
                                                <th style="width:20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        </table>
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
        $.blockUI();
        getAllMaintenance();
        $.unblockUI();
    });
    function getAllMaintenance()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#maintenanceList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllMaintenance") }}',
                type: 'POST',
            },
            columns: [
                    { data: 'item_name', name: 'item_name'},
                    { data: 'service_date', name: 'service_date'},
                    { data: 'service_done_by', name: 'service_done_by'},
                    { data: 'verified_by', name: 'verified_by'},
                    { data: 'regular_service', name: 'regular_service'},
                    { data: 'next_maintenance_date', name: 'next_maintenance_date'},
                    { data: 'maintenance_status', name: 'maintenance_status'},
                    { data: 'action', name: 'action', orderable: false},
                ],
            // order: [[2, 'desc']],
            // columnDefs : [{"targets":1, "type":"date"}],
        }); 
    }   
  </script>
@endsection