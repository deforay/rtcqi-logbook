<!--
    Author             : Sakthivel P
    Date               : 3 June 2021
    Description        : Allowed Kit Test view screen
    Last Modified Date : 3 June 2021
    Last Modified Name : Sakthivel P
-->

@extends('layouts.main')

@section('content')


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/allowedtestkit/">{{ __('messages.allowed_test_kit') }}</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
            <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['add']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['add'] == "allow")) {?>
                <a href="/allowedtestkit/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                <b><i class="ft-plus icon-left"></i> {{ __('messages.add') }} {{ __('messages.allowed_test_kit') }}</b></a>
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
                            <h3 class="content-header-title mb-0">{{ __('messages.allowed_test_kit') }}</h3>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="allowedTestKitList">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.test_kit') }}</th>
                                                <th>{{ __('messages.test_kit_name') }}</th>
                                                <?php $role = session('role');
                                                if (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['edit']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['edit'] == "allow")) {?>
                                                <th>{{ __('messages.action') }}</th>
                                                <?php } ?>
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
      $('.zero-configuration').DataTable({
        "dom": '<"toolbar">frtip'
    });
    $.blockUI();
    getAllUserFacility();
    $.unblockUI();
    });
    function getAllUserFacility()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#allowedTestKitList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllAllowedTestKit") }}',
                type: 'POST',
            },
            columns: [

                    { data: 'test_kit_no', name: 'test_kit_no',className:'firstcaps' },
                    { data: 'test_kit_name', name: 'test_kit_name',className:'firstcaps' },
                    <?php $role = session('role');
                    if (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['edit']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['edit'] == "allow")) {?>
                    {data: 'action', name: 'action', orderable: false},
                    <?php } ?>
                ],
            order: [[0, 'desc']]
        });
    }
  </script>
@endsection
