<!-- 
    Author             : Sudarmathi M
    Date               : 15 June 2020
    Description        : Roles view screen
    Last Modified Date : 15 June 2020
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
                        <li class="breadcrumb-item"><a href="index.html">Role</a>
                        </li>
                        <li class="breadcrumb-item active">Manage
                        </li>
                    </ol>
                </div>
            </div>
            <h3 class="content-header-title mb-0">Role Details</h3>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <a href="/roles/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                <b><i class="ft-user-plus icon-left"></i> Add Role</b></a>
            </div>
        </div>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="rolesList">
                                        <thead>
                                            <tr>
                                                <th>Role Name</th>
                                                <th>Role Code</th>
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
      $('#roleTable').DataTable({
        });
    $.blockUI();
    getRole();
    $.unblockUI();
    });
    function getRole()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#rolesList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getRole") }}',
                type: 'POST',
            },
            columns: [
                    
                    { data: 'role_name', name: 'role_name',className:'firstcaps' },
                    { data: 'role_code', name: 'role_code' },
                    { data: 'role_status', name: 'role_status',className:'firstcaps' },
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
                        getRole();
                        $("#showAlertIndex").text('status changed to '+fieldVal);
                        $('#showAlertdiv').show();
                        $('#showAlertdiv').delay(3000).fadeOut();                
                      }
                  });
              }
          });
        }
    }
  </script>
@endsection