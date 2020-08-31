<!-- 
    Author             : Sudarmathi M
    Date               : 31 Aug 2020
    Description        : global config view screen
    Last Modified Date : 31 Aug 2020
    Last Modified Name : Sudarmathi M
-->

@extends('layouts.main')

@section('content')
<div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
              <h3 class="content-header-title mb-0 d-inline-block">Global Config</h3>
              <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">Manage
                </li>
                <li class="breadcrumb-item"><a href="/globalconfig/">Global Config</a></li>
                </ol>
              </div>
              </div>
            </div>
            <div class="content-header-right col-md-2 col-12">
                <div class="dropdown float-md-right">
                    <a href="/globalconfig/edit" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1" ><b><i class="ft-edit icon-left"></i> Edit Config</b></a>
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
              <!-- <h4 class="form-section"><i class="la la-plus-square"></i>List of Global Config</h4> -->
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
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
                <div class="card-content collapse show">
                  <div class="card-body">
                    <div class="table-responsive p-t-10">
                      <table class="table table-striped table-bordered custom-toolbar-elements" id="configLists">
                          <thead>
                            <tr>
                                <th style="width:50%;">Config Name</th>
                                <th style="width:50%;">Value</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          
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
      getConfig();
      $.unblockUI();
    });
    function getConfig()
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#configLists').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: false,
            autoWidth:false,

            ajax: {
                url:'{{ url("getConfig") }}',
                type: 'POST',
            },
            columns: [
                    
                    { data: 'display_name', name: 'display_name' ,className:'firstcaps'},
                    { data: 'global_value', name: 'global_value' },
                ],
            order: [[0, 'desc']]
        });
    }
  </script>
@endsection