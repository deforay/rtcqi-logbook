<!--

    Date               : 31 May 2021
    Description        : District view screen
    Last Modified Date : 31 May 2021

-->

@extends('layouts.main')

@section('content')


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/subdistrict/">Sub District</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['add']) && ($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['add'] == "allow")) { ?>
                    <a href="/subdistrict/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                        <b><i class="ft-plus icon-left"></i> Add Sub District</b></a>
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
                            <h3 class="content-header-title mb-0">Sub District</h3>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="subDistrictList">
                                        <thead>
                                            <tr>
                                                <th>Sub District Name</th>
                                                <th>District Name</th>
                                                <th>Province Name</th>
                                                <th>Province ID</th>
                                                <th>External ID</th>
                                                <th>Status</th>
                                                <?php $role = session('role');
                                                if (isset($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['edit']) && ($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['edit'] == "allow")) { ?>
                                                    <th>Action</th>
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
        $.blockUI();
        getAllDistrict();
        $.unblockUI();
    });

    function getAllDistrict() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#subDistrictList').DataTable({
            processing: true,
            destroy: true,
            serverSide: true,
            scrollX: false,
            autoWidth: false,
            ajax: {
                url: '{{ url("getAllSubDistrict") }}',
                type: 'POST',
            },

            columns: [

                {
                    data: 'sub_district_name',
                    name: 'sub_district_name',
                    className: 'firstcaps'
                },
                {
                    data: 'district_name',
                    name: 'district_name',
                    className: 'firstcaps'
                },
                {
                    data: 'province_name',
                    name: 'province_name',
                    className: 'firstcaps'
                },
                {
                    data: 'province_id',
                    name: 'province_id',
                    className: 'firstcaps'
                },
                {
                    data: 'sub_district_external_id',
                    name: 'sub_district_external_id',
                    className: 'firstcaps'
                },
                {
                    data: 'sub_district_status',
                    name: 'sub_district_status',
                    className: 'firstcaps'
                },
                <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['edit']) && ($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['edit'] == "allow")) { ?> {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                <?php } ?>
            ],
            order: [
                [0, 'desc']
            ]
        });
    }
</script>
@endsection
