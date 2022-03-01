<!-- 
    Author             : Sakthi
    Date               : 28 Feb 2022
    Description        : Role view screen
    Last Modified Date : 28 Feb 2022
    Last Modified Name : Sakthi
-->

@extends('layouts.main')

@section('content')
<div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
              <h3 class="content-header-title mb-0 d-inline-block">Roles Details</h3>
              <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">Manage
                </li>
                <li class="breadcrumb-item"><a href="/roles/">Roles</a></li>
                </ol>
              </div>
              </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['add']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['add'] == "allow")) {?>
                 <a href="/roles/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1" >
                    <b><i class="ft-user-plus icon-left"></i> ADD</b></a>
                <?php } ?>
                   
                </div>
            </div>
      </div>
      <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts">
          <!-- <div class="row match-height">
            <div class="col-md-12"> -->
              <div class="card">
              <div class="card-header">
              <!-- <h4 class="form-section"><i class="la la-plus-square"></i>Roles Details</h4> -->
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
              </div>
            </div>
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index" ><div class="text-center" style="font-size: 18px;"><b>
                        {{ session('status') }}</b></div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <script>$('#show_alert_index').delay(3000).fadeOut();</script>
                @endif
                <div class="card-content collapse show">
                  <div class="card-body">
                    <div class="table-responsive p-t-10">
                      <table class="table table-striped table-bordered custom-toolbar-elements" id="rolesList">
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
                          <!-- <tfoot>
                            <tr>
                            <th>Role Name</th>
                            <th>Role Code</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                          </tfoot> -->
                        </table>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            <!-- </div>
          </div> -->

        </section>
        <!-- // Basic form layout section end -->
      </div>
    </div>
  <script>
    $(document).ready(function() {
      $('.custom-toolbar-elements').DataTable({
        "dom": '<"toolbar">frtip'
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