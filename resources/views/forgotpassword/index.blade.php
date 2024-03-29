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
  }
  }) !important;
  background-size: cover !important;
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
                  @if($arr["logo"])
                  <img class="brand-logo" alt="rtcqui logbook logo" src="{{ url($arr["logo"])}}" style="height: 100px;width: 100px;">
                  @else
                  <img class="brand-logo" alt="rtcqui logbook logo" src="{{ asset('assets/images/default-logo.png')}}" style="height: 100px;width: 100px;">
                  @endif
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Reset Password</span>
                  </h6>
                </div>
                <div class="card-content">

                  @if(Session::has('error'))
                  <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                  </div>
                  @endif

                  @if(Session::has('message'))
                  <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                  </div>
                  @endif
                  <div class="card-body">
                    <form class="form-horizontal" method="post" name="resetPassword" id="resetPassword" action="/reset-new-password" autocomplete="off">
                      @csrf
                      <input type="hidden" name="token" value="{{ $token }}">
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                        <span class="text-danger" id="error-password" style="display:none;"></span>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>

                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                        @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                        <span class="text-danger" id="error-confirm-password" style="display:none;"></span>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>

                      <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-unlock"></i> Reset Password</button>
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
    $("#password").on('keyup', function() {
      if ($(this).val().length <= 5) {
        $("#error-password").show();
        $("#error-password").text("Atleast minimum 5 characters required");
      } else {
        $("#error-password").text("");
        $("#error-password").hide();
      }
    });

    $("#password_confirmation").on('keyup', function() {
      if ($(this).val() != $("#password").val()) {
        $("#error-confirm-password").show();
        $("#error-confirm-password").text("New Password and Confirm Password does not match");
      } else {
        $("#error-confirm-password").text("");
        $("#error-confirm-password").hide();
      }
    })
  })
</script>
