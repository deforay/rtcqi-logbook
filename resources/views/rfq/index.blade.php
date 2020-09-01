<!-- 
    Author             : Sudarmathi M
    Date               : 25 June 2020
    Description        : Unit view screen
    Last Modified Date : 25 June 2020
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
                        <li class="breadcrumb-item active">Procurement
                        </li>
                        <li class="breadcrumb-item"><a href="/rfq/">RFQ</a>
                        </li>
                    </ol>
                </div>
            </div>
            
        </div>
        <div class="content-header-right col-md-4 col-12 ">
            <div class="dropdown float-md-right">
            <?php
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\Rfq\\RfqController']['add']) && ($role['App\\Http\\Controllers\\Rfq\\RfqController']['add'] == "allow")){ ?>
                <a href="/rfq/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                <b><i class="ft-user-plus icon-left"></i> Add RFQ</b></a>
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
                            <h3 class="content-header-title mb-0">RFQ</h3>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="RfqList" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width:20%">RFQ Number</th>
                                                <th style="width:15%">Issued On</th>
                                                <th style="width:15%">Last Date</th>
                                                <th style="width:10%">Status</th>
                                                <th style="width:25%">Action</th>
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
        getAllRfq();
        $.unblockUI();

    });
    function getAllRfq()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#RfqList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllRfq") }}',
                type: 'POST',
            },
            columns: [
                    
                    { data: 'rfq_number', name: 'rfq_number'},
                    { data: 'rfq_issued_on', name: 'rfq_issued_on',type:'date',
                    "render": function(data, type) {
                        if (data == null){
                                return '';
                            }else{
                                return type === 'sort' ? data : moment(data).format('DD-MMM-YYYY');
                            }
                        }
                    },
                    { data: 'last_date', name: 'last_date'},
                    { data: 'rfq_status', name: 'rfq_status',className:'firstcaps'},
                    { data: 'action', name: 'action', orderable: false},
                ],
            order: [[1, 'desc']],
            // columnDefs : [{"targets":1, "type":"date"}],
        });
        
    }

    function changeQuotesStatus(tableName, fieldIdName,fieldIdValue,fieldName, fieldVal, dataTableName)
    {
        if(fieldIdValue!='')
        {

          swal("Are you sure you want to make "+fieldVal+" this?", {
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
                      url: "{{ url('/changeQuotesStatus') }}",
                      method: 'post',
                      data: {
                          tableName: tableName, fieldIdName: fieldIdName, fieldIdValue: fieldIdValue, fieldName:fieldName, fieldValue:fieldVal
                      },
                      success: function(result){
                        // getAllItemCategory();
                        $("#showAlertIndex").text('Status has been changed to '+fieldVal);
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