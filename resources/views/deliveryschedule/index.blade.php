<!-- 
    Author             : Sriram V
    Created Date       : 26 June 2020
    Description        : Purchase Order view screen
    Last Modified Date :   
    Last Modified Name :
-->

@extends('layouts.main')

@section('content')


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/deliveryschedule/">Delivery Schedule</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    
        <div class="content-header-right col-md-4 col-12 ">
            <div class="dropdown float-md-right">
            <?php
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['add']) && ($role['App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController']['add'] == "allow")){ ?>
                    <a href="/deliveryschedule/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="ft-user-plus icon-left"></i> Add Delivery Schedule</b></a>
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
                            <h3 class="content-header-title mb-0">Delivery Schedule Details</h3>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="purchaseOrderList">
                                        <thead>
                                            <tr>
                                                <th>Po Number</th>
                                                <th>Po Issued On</th>
                                                <th>Vendor</th>
                                                <th>Total Amount</th>
                                                <th>Purchase Order Status</th>
                                                <th>Quote Number</th>
                                                <th>Action</th>
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
        getAllActivePurchaseOrder();
        $.unblockUI();
    });
    function getAllActivePurchaseOrder()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#purchaseOrderList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllPurchaseOrder") }}',
                type: 'POST',
            },
            columns: [
                    
                    { data: 'po_number', name: 'po_number'},
                    { data: 'po_issued_on', name: 'po_issued_on'},
                    { data: 'vendor_name', name: 'vendor_name'},
                    { data: 'total_amount', name: 'total_amount'},
                    { data: 'order_status', name: 'order_status',className:'firstcaps'},
                    { data: 'quote_number', name: 'quote_number' },
                    {data: 'action', name: 'action', orderable: false},
                ],
            order: [[0, 'desc']]
        });
    }

    
  </script>
@endsection