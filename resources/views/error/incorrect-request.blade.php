<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<title>RTCQI LOGBOOK</title>
<!--vendors-->

<link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
<!--Material Icons-->
<link rel="stylesheet" type="text/css" href="{{ asset('error/fonts/materialdesignicons/materialdesignicons.min.css') }}">
<!--Bootstrap + atmos Admin CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('error/css/atmos.min.css') }}">
<!-- Additional library for page -->

</head>
<style>
.bg-pattern {
    background-image: url("{{ asset('app-assets/images/backgrounds/bg-9.jpg')}}");
}
</style>
<body class="jumbo-page">


<main class="admin-main  bg-pattern">
    <div class="container">
        <div class="row m-h-100 ">
            <div class="col-md-8 col-lg-4  m-auto">
                <div class="card shadow-lg p-t-20 p-b-20">
                    <div class="card-body text-center">
                            
                        
                        <img width="200" alt="image" src="{{ asset('error/img/502.svg') }}">
                        <h4 class="display-5 fw-600 font-secondary">Incorrect URL</h4>
                        <h5>We are Sorry! You have tried entering incorrect url format.Try a valid URL</h5>
                        <p class="opacity-75">
                                You may have to head back to the dashboard. If you think something is broken, report a problem to the Administrator.
                                <!-- of <strong>IASBYHEART Team</strong>. -->
                        </p>
                        <div class="p-t-10">
                            @if(session('login') == true)
                                <a href="/dashboard" class="btn btn-lg " style="background-color: #812720;color: #fff;">Go Back Dashboard</a>
                            @else
                            <a href="/login" class="btn btn-lg " style="background-color: #812720;color: #fff;">Go Back Login</a>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>





</body>
</html>