<!--
Author             : Sriram V
Date               : 25 June 2020
Description        : Quotes View Page
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
                        <li class="breadcrumb-item active">Procurement
                        </li>
                        <li class="breadcrumb-item"><a href="/quotes/">Quotes</a>
                        </li>
                    </ol>
                </div>
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
                            <h3 class="content-header-title mb-0">Quotes</h3>
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
                                <div class="row pl-1">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>RFQ
                                            </h5>
                                            <div class="form-group">
                                            <select class="form-control" autocomplete="off" style="width:100%;" id="rfqId" name="rfqId"  onchange="getAllQuotes(this.value)">
                                            <option value=''>Select RFQ</option>
                                                @foreach ($rfqList as $rfq)
                                                <option value="{{$rfq->rfq_id}}" >{{$rfq->rfq_number}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="quotesList" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width:10%">Vendor Name</th>
                                                <th style="width:12%">Quote Number</th>
                                                <th style="width:10%">Quote Date</th>
                                                <th style="width:10%">RFQ Number</th>
                                                <th style="width:10%">RFQ Date</th>
                                                <th style="width:10%">RFQ Last Date</th>
                                                <th style="width:10%">Invited On</th>
                                                <th style="width:10%">Status</th>
                                                <th style="width:18%">Action</th>
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
    getAllQuotes();
    $.unblockUI();
    });
    function getAllQuotes(val = '')
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#quotesList').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: true,
            autoWidth:false,
            ajax: {
                url:'{{ url("getAllQuotes") }}',
                type: 'POST',
                data : {
                    rfqId : val,
                }
            },
            columns: [
                    { data: 'vendor_name', name: 'vendor_name' },
                    { data: 'quote_number', name: 'quote_number' },
                    { data: 'responded_on', name: 'responded_on', },
                    { data: 'rfq_number', name: 'rfq_number' },
                    { data: 'rfq_issued_on', name: 'rfq_issued_on' },
                    { data: 'last_date', name: 'last_date' },
                    { data: 'invited_on', name: 'invited_on'},
                    { data: 'quotes_status', name: 'quotes_status',className: 'firstcaps' },
                    { data: 'action', name: 'action', orderable: false,className: 'text-center'},
                ],
            order: [[0, 'desc']]
        });
    }


  </script>
@endsection
