<!--
    Author             : Sudarmathi M
    Date               : 22 June 2020
    Description        : Login screen
    Last Modified Date : 22 June 2020
    Last Modified Name : Sudarmathi M
-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Procurement & Inventory Manager">
    <meta name="keywords" content="Procurement & Inventory Manager">
    <meta name="author" content="Deforay">
    <title>Procurement & Inventory Manager</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png')}}">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/logo/asm_logo.png')}}"> -->
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

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-overlay-menu 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-overlay-menu" data-col="1-column">
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
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                        <h3>Procurement & Inventory Manager</h3>
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Login</span>
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
                    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                  <div class="card-body">
                    <form class="form-horizontal" method="post" name="userLogin" id="userLogin" action="login/validate" autocomplete="off">
                        @csrf
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Your Username"
                        required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"
                        required>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>

                      <button type="button" class="btn btn-outline-info btn-block" onclick="validateNow()"><i class="ft-unlock"></i> Login</button>
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
    duplicateName = true;
    ismob = true;

    function validateNow() {
        userNameVal = $('#username').val();
        var EmailValidation = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (EmailValidation.test(userNameVal)) {
            ismob = true;
        } else {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            $("#showAlertIndex").text('Please give valid email address');
            $('#showAlertdiv').show();
            ismob = false;
        }

        if (ismob == true) {
            flag = deforayValidator.init({
                formId: 'userLogin'
            });

            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('userLogin').submit();
                }
            } else {
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display", "block");
                $(".infocus").focus();
            }
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
