<!--
    Date : 27 May 2021
    Desc : Main page to integrate all the pages
    Modified : Prasath M
    Modified Date : 27 May 2021
-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  @include('layoutsections.header')
  <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" />
  <style>
    .white {
      color: white;
    }

    .mandatory {
      color: #f30f00;
    }

    .single:hover {
      background-color: rgba(255, 255, 255, 0.05);
    }

    .firstcaps {
      text-transform: capitalize;
    }

    .profil {
      position: absolute;
      right: 0;
      top: 0;
      padding-right: 1rem;
    }

    #trendTable .sorting,
    .sorting_asc,
    .sorting_desc {
      background: none;
    }

    .marquee-container {
        background-color: #dc3545;
        color: white;
        overflow: hidden;
        white-space: nowrap;
        /* position: fixed; */
        top: 0;
        width: 100%;
        z-index: 1000;
        /* height: 40px; */
    }

    .marquee {
      display: inline-block;
      padding-left: 100%;
      animation: marquee 20s linear infinite;
      padding-bottom: 10px;
      padding-top: 10px;
      /* font-weight: bold; */
      font-size: 20px;
  }

    @keyframes marquee {
      from {
        transform: translateX(0);
      }

      to {
        transform: translateX(-100%);
      }
    }
  </style>
</head>

<body class="horizontal-layout horizontal-menu 2-columns menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
 
  @include('layoutsections.mainmenu')

  <br>
  <div class="app-content container center-layout mt-2" style="min-height: 600px;">
    <div class="content-overlay"></div>

    @section('content')
    @show
  </div>
  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  @include('layoutsections.footer')

  @include('layoutsections.scripts')

  <div class="modal fade" id="modal_ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:1000px">
      <div class="modal-content" id="modal-content"></div>
    </div>
  </div>
</body>

</html>
<script>
  ispin = true;
  ismob = true;
  $(document).ready(function () {
    var path = '<?php echo Request::path(); ?>';
    var splitUrl = path.split('/');
    setTimeout(function () {
      if (splitUrl[0] == "dashboard") {
        $("#dashboard").addClass('active');
      } else if (splitUrl[0] == "allowedtestkit" || splitUrl[0] == "testsite" || splitUrl[0] == "user" || splitUrl[0] == "testkit" || splitUrl[0] == "facility" || splitUrl[0] == "province" || splitUrl[0] == "district" || splitUrl[0] == "sitetype" || splitUrl[0] == "globalconfig") {
        $("#manage").addClass('active');
      } else if (splitUrl[0] == "monthlyreport" || splitUrl[0] == "monthlyreportpages" || splitUrl[0] == "monthlyreportdata") {
        $("#tests").addClass('active');
      } else if (splitUrl[0] == "trendreport" || splitUrl[1] == "logbook" || splitUrl[0] == "testKitReport" || splitUrl[0] == "invalidresultreport" || splitUrl[0] == "customreport") {
        $("#reports").addClass('active');
      }
    }, 1000);
  });

  function showAjaxModal(url) {
    jQuery('#modal_ajax .modal-content').html('');
    jQuery('#modal_ajax').modal('show', { backdrop: 'true' });
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url,
      method: 'post',
      success: function (response) {
        jQuery('#modal_ajax .modal-content').html(response);
      }
    });
  }

  function scrolltoptocontent() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  }

  function changeStatus(tableName, fieldIdName, fieldIdValue, fieldName, fieldVal, dataTableName) {
    if (fieldIdValue != '') {
      swal("Are you sure you want to make " + fieldVal + " this?", {
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
              url: "{{ url('/changeStatus') }}",
              method: 'post',
              data: {
                tableName: tableName,
                fieldIdName: fieldIdName,
                fieldIdValue: fieldIdValue,
                fieldName: fieldName,
                fieldValue: fieldVal
              },
              success: function (result) {
                $("#showAlertIndex").text('Status has been changed to ' + fieldVal);
                $('#showAlertdiv').show();
                $('#showAlertdiv').delay(3000).fadeOut();
                $('#' + dataTableName).DataTable().ajax.reload();
              }
            });
          }
        });
    }
  }

  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }

  function checkNameValidation(tableName, fieldName, obj, fnct, msg) {
    checkValue = document.getElementById(obj).value;
    if (checkValue != '') {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('/checkNameValidation') }}",
        method: 'post',
        data: {
          tableName: tableName,
          fieldName: fieldName,
          value: checkValue,
          fnct: fnct
        },
        success: function (result) {
          if (result > 0) {
            $("#showAlertIndex").text(msg);
            $('#showAlertdiv').show();
            duplicateName = false;
            document.getElementById(obj).value = "";
            $('#' + obj).focus();
            $('#' + obj).css('background-color', 'rgb(255, 255, 153)')
            $('#showAlertdiv').delay(3000).fadeOut();
          } else {
            duplicateName = true;
          }
        }
      });
    }
  }
</script>
