<!-- 
    Author             : Sudarmathi M
    Date               : 02 Mar 2021
    Description        : request item view screen
    Last Modified Date : 02 Mar 2021
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
                        <li class="breadcrumb-item active">Request Item
                        </li>
                        <li class="breadcrumb-item"><a href="/requestitem">Request Items</a>
                        </li>
                    </ol>
                </div>
            </div>
            
        </div>
        <div class="content-header-right col-md-4 col-12 ">
            <div class="dropdown float-md-right">
            <?php
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['add']) && ($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['add'] == "allow")){ ?>
                <a href="/requestitem/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                <b><i class="ft-user-plus icon-left"></i> Request Item</b></a>
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
                            <h3 class="content-header-title mb-0">Requested Items</h3>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="ReqList" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width:20%">Item Name</th>
                                                <th style="width:10%">Quantity</th>
                                                <th style="width:10%">Requested On</th>
                                                <th style="width:10%">Needed On</th>
                                                <th style="width:10%">Location</th>
                                                <th style="width:15%">Reason</th>
                                                <th style="width:10%">Status</th>
                                                <th style="width:15%">Action</th>
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
        getRequestItemByLogin();
        $.unblockUI();

    });
    function getRequestItemByLogin()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#ReqList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getRequestItemByLogin") }}',
                type: 'POST',
            },
            columns: [
                    
                    { data: 'item_name', name: 'item_name'},
                    { data: 'request_item_qty', name: 'request_item_qty'},
                    { data: 'requested_on', name: 'requested_on',type:'date',
                    "render": function(data, type) {
                        if (data == null){
                                return '';
                            }else{
                                return type === 'sort' ? data : moment(data).format('DD-MMM-YYYY');
                            }
                        }
                    },
                    { data: 'needed_on', name: 'needed_on',type:'date',
                    "render": function(data, type) {
                        if (data == null){
                                return '';
                            }else{
                                return type === 'sort' ? data : moment(data).format('DD-MMM-YYYY');
                            }
                        }
                    },
                    { data: 'branch_name', name: 'branch_name'},
                    { data: 'reason', name: 'reason'},
                    { data: 'request_item_status', name: 'request_item_status'},
                    { data: 'action', name: 'action', orderable: false},
                ],
            order: [[1, 'desc']],
            // columnDefs : [{"targets":1, "type":"date"}],
        });
        
    }

    function changeApproveStatus(id,sts,dataTableName)
    {
        if(id!='')
        {
            if(sts == "approved"){
                stsmsg = "approve"
            }
            else if(sts == "declined"){
                stsmsg = "decline"
            }
          swal("Are you sure you want to "+stsmsg+" this?", {
          buttons: {
            cancel: {
                text: "No",
                value: null,
                visible: true,
                className: "btn-warning",
                closeModal: true,
            },
            confirm: {
                text: "Yes",
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
                      url: "{{ url('/changeApproveStatus') }}",
                      method: 'post',
                      data: {
                        id: id, dataTableName : dataTableName,sts : sts,
                      },
                      success: function(result){
                        // getAllItemCategory();
                        $("#showAlertIndex").text('Status has been changed to '+sts);
                        $('#showAlertdiv').show();
                        $('#showAlertdiv').delay(3000).fadeOut();
                        $('#'+dataTableName).DataTable().ajax.reload();
                      }
                  });
              }
          });
        }
    }
    
  </script>
@endsection