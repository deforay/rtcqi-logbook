<!-- 
    Author             : Sudarmathi M
    Date               : 18 June 2020
    Description        : Branches view screen
    Last Modified Date : 18 June 2020
    Last Modified Name : Sudarmathi M
-->

@extends('layouts.main')

@section('content')


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/branches/">Branches</a>
                        </li>
                        <li class="breadcrumb-item active">Manage
                        </li>
                    </ol>
                </div>
            </div>
            <h3 class="content-header-title mb-0">Branches Details</h3>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
            <?php
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\Branches\\BranchesController']['add']) && ($role['App\\Http\\Controllers\\Branches\\BranchesController']['add'] == "allow")){ ?>
                    <a href="/branches/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="ft-user-plus icon-left"></i> Add Branches</b></a>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="branchList">
                                        <thead>
                                            <tr>
                                                <th>Branch Name</th>
                                                <th>Branch Type</th>
                                                <th>Mobile No</th>
                                                <th>Email</th>
                                                <th>Country</th>
                                                <th>State</th>
                                                <th>Status</th>
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
        getAllUser();
        $.unblockUI();
    });
    function getAllUser()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#branchList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllBranches") }}',
                type: 'POST',
            },
            columns: [
                    
                    { data: 'branch_name', name: 'branch_name',className:'firstcaps' },
                    { data: 'branch_type', name: 'branch_type',className:'firstcaps' },
                    { data: 'phone', name: 'phone'},
                    { data: 'email', name: 'email'},
                    { data: 'country_name', name: 'country_name',className:'firstcaps' },
                    { data: 'state', name: 'state',className:'firstcaps' },
                    { data: 'branch_status', name: 'branch_status',className:'firstcaps' },
                    {data: 'action', name: 'action', orderable: false},
                ],
            order: [[0, 'desc']]
        });
    }

    function changeStatus(tableName, fieldIdName,fieldIdValue,fieldName, fieldVal,functionName)
    {
       
        if(fieldIdValue!='')
        {

          swal("Are you sure you want to make "+fieldVal+" this?", {
          buttons: {
            cancel: {
                text: "No, Don't change pls!",
                value: null,
                visible: true,
                className: "btn-warning",
                closeModal: true,
            },
            confirm: {
                text: "Yes, Change it!",
                value: true,
                visible: true,
                className: "",
                closeModal: true
            }
          }
        })
        .then(isConfirm => {
          if (isConfirm) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                $.ajax({
                      url: "{{ url('/changeStatus') }}",
                      method: 'post',
                      data: {
                          tableName: tableName, fieldIdName: fieldIdName, fieldIdValue: fieldIdValue, fieldName:fieldName, fieldValue:fieldVal
                      },
                      success: function(result){
                        // getAllUser();
                        $("#showAlertIndex").text('Status has been changed to '+fieldVal);
                        $('#showAlertdiv').show();
                        $('#showAlertdiv').delay(3000).fadeOut();
                        $('#branchList').DataTable().ajax.reload();
                      }
                  });
              }
          });
        }
    }
  </script>
@endsection