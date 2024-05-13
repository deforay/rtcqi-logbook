<!--

    Date               : 27 May 2021
    Description        : Login screen
    Last Modified Date : 27 May 2021

-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<?php
$profileURl = "/user/profile/" . base64_encode(session('userId'));

use App\Service\GlobalConfigService;

$GlobalConfigService = new GlobalConfigService();
$glob = $GlobalConfigService->getAllGlobalConfig();
$globData = $GlobalConfigService->getGlobalConfigData('title_name');
$arr = array();
// now we create an associative array so that we can easily create view variables
for ($i = 0; $i < sizeof($glob); $i++) {
  $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
}
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="RTCQI LOGBOOK">
  <meta name="keywords" content="RTCQI LOGBOOK">
  <meta name="author" content="Deforay">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>{{$globData}}</title>
  <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png')}}">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css')}}">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css')}}">
  <!-- END: Theme CSS-->

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/login-register.css')}}">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}">
  <!-- END: Custom CSS-->




</head>
<!-- END: Head-->
<style>
  html body.bg-full-screen-image {
    /*background: #63bef9  !important;*/
    background:url({{ asset('assets/images/1.jpg')
  }}) !important;
  background-size: cover !important;
  }

  .bottomgap {
    margin-bottom: 5px;
  }

  .error-msg {
    color: red;
  }

  .success-msg {
    color: green;
  }
</style>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-overlay-menu 1-column menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-overlay-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0 text-center">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <h3>{{$globData}}</h3>
                    </div>
                  </div>
                  @if(!empty($arr["logo"]))
                  <img class="brand-logo" alt="rtcqui logbook logo" src="" style="height: 100px;width: 100px;">
                  @else
                  <img class="brand-logo" alt="rtcqui logbook logo" src="{{ asset('assets/images/default-logo.png')}}" style="height: 100px;width: 100px;">
                  @endif
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Register</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div id="show_alert" class="mt-1" style="display:none;"></div>
                  @if (session('status'))
                  <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
                    <div class="text-center" style="font-size: 18px;"><b>
                        {{ session('status') }}</b></div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <script>
                    $('#show_alert_index').delay(3000).fadeOut();
                  </script>
                  @endif

                  @if (session('success'))
                  <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index_success">
                    <div class="text-center" style="font-size: 18px;"><b>
                        {{ session('success') }}</b></div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <script>
                    $('#show_alert_index_success').delay(3000).fadeOut();
                  </script>
                  @endif
                  <div id="alert-new" style="display:none;"></div>
                  <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="card-body">
                    <form class="form-horizontal" method="post" name="userLogin" id="userLogin" action="/setup" autocomplete="off" onsubmit="validateNow();return false;">
                      @csrf
                      <fieldset class="form-group position-relative">
                        <input type="text" class="form-control isRequired" id="firstName" name="firstName" placeholder="Your First Name" title="Please Enter First Name">

                      </fieldset>
                      <fieldset class="form-group position-relative">
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Your Last Name" title="Please Enter Last Name">

                      </fieldset>

                      <fieldset class="form-group position-relative">
                        <input type="text" id="email" class="form-control isEmail isRequired" autocomplete="off" placeholder="Enter Email" name="email" title="Please Enter Email">

                      </fieldset>
                      <fieldset class="form-group position-relative">

                        <input type="password" id="password" class="form-control isRequired" autocomplete="off" placeholder="Enter Password" name="password" title="Please Enter Password">
                        <div class="invalid-feedback">
                          must contain atleast 6 characters, 1 number , 1 alphabet and 1 special character

                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative">
                        <input type="password" id="confirmPassword" onkeyup="checkPasswordMatch()" class="form-control isRequired" autocomplete="off" placeholder="Enter Confirm Pasword" name="confirmPassword" title="Please Enter Confirm Pasword">
                        <span id="confirmresult" style="width: 100%;margin-top: 0.25rem;font-size: 80%;color: #FF4961;"></span>
                        <input type="hidden" id="passwordCheck" name="passwordCheck" class="isRequired" title="Passwords do not match.">
                      </fieldset>

                      <button type="submit" class="btn btn-outline-info btn-block" onclick="validateNow();return false;"><i class="ft-user"></i> Signup</button>

                    </form>


                  </div>


                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- END: Content-->


  <!-- BEGIN: Vendor JS-->
  <script src="{{ asset('app-assets/vendors/js/vendors.min.js')}}"></script>
  <!-- BEGIN Vendor JS-->



</body>
<!-- END: Body-->

</html>
<script src="{{ asset('assets/js/deforayValidation.js') }}"></script>

<script>
  $(document).ready(function() {
    $('#confirmPassword').keyup(function() {
      var nPws = $('#password').val();
      var cPws = $('#confirmPassword').val();
      if (nPws != cPws) {
        $('#confirmresult').html('Passwords do not match.')
        $('#passwordCheck').val('');
      } else {
        $('#passwordCheck').val('passwordCheck');
        $('#confirmresult').html('')
      }
    })
    $('#password').change(function() {
      $('#result').html(checkStrength($('#password').val()))
    })
  });

  function checkPasswordMatch() {

    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();
    if (password.trim() && confirmPassword.trim()) {
      if (password.trim() != confirmPassword.trim()) {
        $("#confirmPassword").onfocus = function() {
          $("#confirmPassword").style.background = "#FFFFFF";
        }
      } else {
        $("#password").focusout();
        $("#confirmPassword").focusout();
      }
    }
  }

  function checkStrength(password) {
    var strength = 0
    if (password.length < 7) {
      $('#result').removeClass()
      $('#result').addClass('short')
      $('#passwordCheck').val('')
      $("#password").val("");
      $(".invalid-feedback").show();
      return 'Too short'
    }
    if (password.length > 7) strength += 1
    // If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
    // If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
    // If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
    // If it has two special characters, increase strength value.
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
    // Calculated strength value, we can return messages
    // If value is less than 2
    if (strength < 2) {
      $('#result').removeClass()
      $('#result').addClass('weak')
      $('#passwordCheck').val('')
      $("#password").val("");
      $(".invalid-feedback").show();
      return 'Weak'
    } else if (strength == 2) {
      $('#result').removeClass()
      $('#result').addClass('good')
      $('#passwordCheck').val('good')
      $(".invalid-feedback").hide();
      return 'Good'
    } else {
      $('#result').removeClass()
      $('#result').addClass('strong')
      $('#passwordCheck').val('strong')
      $(".invalid-feedback").hide();
      return 'Strong'
    }
  }


  function validateNow() {

    flag = deforayValidator.init({
      formId: 'userLogin'
    });

    if (flag == true) {
      document.getElementById('userLogin').submit();
    } else {
      // Swal.fire('Any fool can use a computer');
      $('#show_alert').html(flag).delay(3000).fadeOut();
      $('#show_alert').css("display", "block");
      $(".infocus").focus();
    }
  }
</script>
