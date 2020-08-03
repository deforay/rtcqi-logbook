<!-- 
    Author             : Sudarmathi M
    Created Date       : 17 July 2020
    Description        : Delivery Schedule view screen
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
                                <?php if(session('loginType')=='users'){ ?>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Purchase Order
                                            </h5>
                                            <div class="form-group">
                                            <select class="form-control" autocomplete="off" style="width:100%;" id="rfqId" name="rfqId"  onchange="getAllDeliverySchedule(this.value)">
                                            <option value=''>Select Purchase Order</option>
                                                @foreach ($poList as $po)
                                                <option value="{{$po->po_id}}" >{{$po->po_number}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <?php }?>
                                <br/>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="deliveryScheduleList" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:15%;">Purchase Order</th>
                                                <th style="width:10%;">Item Name</th>
                                                <th style="width:10%;">Quantity</th>
                                                <th style="width:15%;">Estimated Delivery Date</th>
                                                <th style="width:10%;">Delivery Mode</th>
                                                <th style="width:10%;">Location</th>
                                                <th style="width:20%;">Comments</th>
                                                <th style="width:10%;">Action</th>
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
        getAllDeliverySchedule();
        $.unblockUI();
    });
    function getAllDeliverySchedule(val = '')
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#deliveryScheduleList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllDeliverySchedule") }}',
                type: 'POST',
                data : {
                    poId : val,
                }
            },
            columns: [
                    { data: 'po_number', name: 'po_number'},
                    { data: 'item_name', name: 'item_name',className:'firstcaps'},
                    { data: 'delivery_qty', name: 'delivery_qty'},
                    { data: 'expected_date_of_delivery', name: 'expected_date_of_delivery'},
                    { data: 'delivery_mode', name: 'delivery_mode'},
                    { data: 'branch_name', name: 'branch_name' },
                    { data: 'comments', name: 'comments' },
                    {data: 'action', name: 'action', orderable: false},
                ],
            order: [[0, 'desc']]
        });
    }

    
  </script>
@endsection