<!--
    Author             : Sudarmathi M
    Date               : 15 June 2020
    Description        : Dashboard screen
    Last Modified Date : 15 June 2020
    Last Modified Name : Sudarmathi M
-->
<style>

.middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}
.nav.nav-tabs.nav-top-border .nav-item a.nav-link.active {
  border-top: 3px solid #1e9ff2;
}
.nav.nav-tabs.nav-top-border .nav-item a {
  color: #1e9ff2;
}
</style>
@extends('layouts.main')
@section('content')

@php
$loginType = session('loginType');
if(isset($details['vendorsCount'])){
  $vendorsCount = $details['vendorsCount'];
}
else{
  $vendorsCount = '';
}
@endphp
<!-- <div class="middle"> <h1 style="font-size: -webkit-xxx-large;">Coming Soon...</h1></div> -->
<div class="row" id="activeCards">
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card pull-up border-info border-lighten-2">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-left">
                <h3 class="info">{{$details['rfqCount']}}</h3>
                <h6>Active RFQ</h6>
              </div>
              <div>
                <i class="icon-note info font-large-2 float-right"></i>
              </div>
            </div>
            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
              <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: @php echo (int)(($details['rfqCount']/100)*100) @endphp%"
              aria-valuenow="@php echo (int)(($details['rfqCount']/100)*100) @endphp" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up border-success border-lighten-2">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">{{$details['quotesCount']}}</h3>
                  <h6>Active Quotes</h6>
                </div>
                <div>
                  <i class="icon-pie-chart success font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: @php echo (int)(($details['quotesCount']/100)*100) @endphp%"
                aria-valuenow="@php echo (int)(($details['quotesCount']/100)*100) @endphp" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up border-primary border-lighten-2">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="primary">{{$details['poCount']}}</h3>
                  <h6>Active Purchase Orders</h6>
                </div>
                <div>
                  <i class="icon icon-basket-loaded primary font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-primary" role="progressbar" style="width: @php echo (int)(($details['poCount']/100)*100) @endphp%"
                aria-valuenow="@php echo (int)(($details['poCount']/100)*100) @endphp" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if(session('loginType') == 'users')
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card pull-up border-blue-grey border-lighten-2">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-left">
                <h3 class="blue-grey">{{$vendorsCount}}</h3>
                <h6>Vendors</h6>
              </div>
              <div>
                <i class="icon-users blue-grey font-large-2 float-right"></i>
              </div>
            </div>
            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
              <div class="progress-bar bg-gradient-x-blue-grey" role="progressbar" style="width: @php echo (int)(($vendorsCount/100)*100) @endphp%"
              aria-valuenow="@php echo (int)(($vendorsCount/100)*100) @endphp" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>

 <!-- Procurement Details display start -->
 <div class="row" id="rfqTable">
    <div class="col-12">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    <div id="procurement">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified mt-3" id="myTab">
                            <li class="nav-item">
                            <a class="nav-link active" id="rfq-tab1" data-toggle="tab"  href="#rfq" aria-controls="rfq" aria-expanded="true">
                                <i class="ft-edit"></i>RFQ</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" id="quotes-tab2" data-toggle="tab"  href="#quotes" aria-controls="quotes" aria-expanded="true">
                                <i class="ft-edit"></i> Quotes</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1 " id="tabcontent" >
                            <div role="tabpanel" class="tab-pane active" id="rfq" aria-labelledby="rfq-tab1" aria-expanded="true">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="RfqList" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width:25%">RFQ Number</th>
                                                <th style="width:15%">Issued On</th>
                                                <th style="width:15%">Last Date</th>
                                                <th style="width:10%">Status</th>
                                                <th style="width:35%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="quotes" aria-labelledby="quotes-tab1" aria-expanded="true">
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
    </div>
</div>
 <!-- Procurement Details display End -->


<!-- <div class="row" id="rfqTable">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"></h4>
                <h3 class="content-header-title mb-0">RFQ Details</h3>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"></h4>
                <h3 class="content-header-title mb-0">Quotes Details</h3>
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
                        <table class="table table-striped table-bordered zero-configuration" id="quotesList" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:20%">RFQ Number</th>
                                    <th style="width:15%">Vendor Name</th>
                                    <th style="width:20%">Quote Number</th>
                                    <th style="width:15%">Invited On</th>
                                    <th style="width:15%">Responded On</th>
                                    <th style="width:15%">Status</th>
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
</div> -->
<script>
loginType = '{{$loginType}}';
roleName = "{{session('roleName')}}";

$(document).ready(function() {
  if(loginType != 'vendor' && roleName !='admin'){
      $('#rfqTable').hide();
      $('#activeCards').hide();
  }
  else{
    $.blockUI();
    getAllRfq();
    getAllQuotes();
    $.unblockUI();
  }
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
                url:'{{ url("getAllActiveRfqDisplay") }}',
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
            order: [[1, 'desc']]
        });
    }

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
                url:'{{ url("getAllActiveQuotesDisplay") }}',
                type: 'POST',
                data : {
                    rfqId : val,
                }
            },
            columns: [

                { data: 'vendor_name', name: 'vendor_name' },
                { data: 'quote_number', name: 'quote_number' },
                { data: 'responded_on', name: 'responded_on', type:'date',
                  "render": function(data, type) {
                      if (data == null){
                              return '';
                          }else{
                              return type === 'sort' ? data : moment(data).format('DD-MMM-YYYY');
                          }
                      }
                  },
                { data: 'rfq_number', name: 'rfq_number' },
                { data: 'rfq_issued_on', name: 'rfq_issued_on' },
                { data: 'last_date', name: 'last_date' },
                { data: 'invited_on', name: 'invited_on'},
                { data: 'quotes_status', name: 'quotes_status',className: 'firstcaps' },
                { data: 'action', name: 'action', orderable: false},
                ],
            order: [[2, 'desc']]
        });
    }
</script>

@endsection

