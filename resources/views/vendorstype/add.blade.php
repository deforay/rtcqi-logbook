<!-- 
    Author             : Prasath M
    Date               : 28 Jan 2020
    Description        : suppliers add screen
    Last Modified Date : 29 Jan 2020
    Last Modified Name : Prasath M
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
      <h3 class="content-header-title mb-0 d-inline-block">Vendors Type</h3>
      <div class="row breadcrumbs-top d-inline-block">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">Manage
            </li>
            <li class="breadcrumb-item"><a href="/vendorstype/">Vendors Type</a>
            </li>
            <li class="breadcrumb-item active">Add</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content-body">
    <!-- horizontal grid start -->
    <section class="horizontal-grid" id="horizontal-grid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="form-section"><i class="la la-plus-square"></i> Add Vendors Type</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="card-content collapse show">
              <div class="card-body">
                <div id="show_alert" class="mt-1" style=""></div>
                <form class="form form-horizontal" role="form" name="addvendorstype" id="addvendorstype" method="post" action="/vendorstype/add" autocomplete="off" onsubmit="validateNow();return false;">
                  @csrf
                  <div class="row">
                    <div class="col-xl-4 col-lg-12">
                      <fieldset>
                        <h5>Vendor Type<span class="mandatory">*</span>
                        </h5>
                        <div class="form-group">
                          <input type="text" id="vendorType" class="form-control isRequired" onblur="duplicateValidation('vendor_types','vendor_type', this.id, 'Entered Vendor Type is already exist.')" autocomplete="off" placeholder="Enter Vendor Type" name="vendorType" title="Please enter Vendor Type">
                        </div>
                      </fieldset>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                      <fieldset>
                        <h5>Status<span class="mandatory">*</span> </h5>
                        <div class="form-group">
                          <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="status" name="status" title="Please select status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                          </select>
                        </div>
                      </fieldset>
                    </div>

                  </div>
                  <div class="form-actions right">
                    <a href="/vendorstype">
                      <button type="button" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                      </button>
                    </a>
                    <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                      <i class="la la-check-square-o"></i> Save
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- horizontal grid end -->
    </section>
  </div>
</div>

<script>
  duplicateName = true;
  $(document).ready(function() {
	$(".select2").select2();
	$(".select2").select2({
        placeholder: "Select",
		allowClear: true
	});
});
  function validateNow() {
    flag = deforayValidator.init({
      formId: 'addvendorstype'
    });

    if (flag == true) {
      if (duplicateName) {
        document.getElementById('addvendorstype').submit();
      }
    } else {
      // Swal.fire('Any fool can use a computer');
      $('#show_alert').html(flag).delay(3000).fadeOut();
      $('#show_alert').css("display", "block");
      $(".infocus").focus();
    }
  }

  function duplicateValidation(tableName, fieldName, obj, msg) {
    // alert(fnct)
    checkValue = document.getElementById(obj).value;
    // alert(checkValue)
    if (checkValue != '') {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('/duplicateValidation') }}",
        method: 'post',
        data: {
          tableName: tableName,
          fieldName: fieldName,
          value: checkValue,
        },
        success: function(result) {
        //   console.log(result)
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
@endsection