<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<title>RTCQI LOGBOOK</title>
<link rel="icon" type="image/x-icon" href="<?php echo e(asset('app-assets/images/logo/asm_logo.png')); ?>"/>
<link rel="icon" href="<?php echo e(asset('app-assets/images/logo/asm_logo.png')); ?>" type="image/png" sizes="16x16">
<!--vendors-->

<link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
<!--Material Icons-->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('error/fonts/materialdesignicons/materialdesignicons.min.css')); ?>">
<!--Bootstrap + atmos Admin CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('error/css/atmos.min.css')); ?>">
<!-- Additional library for page -->

</head>
<style>
.bg-pattern {
    background-image: url("<?php echo e(asset('app-assets/images/backgrounds/bg-9.jpg')); ?>");
}
</style>
<body class="jumbo-page">


<main class="admin-main  bg-pattern">
    <div class="container">
        <div class="row m-h-100 ">
            <div class="col-md-8 col-lg-4  m-auto">
                <div class="card shadow-lg p-t-20 p-b-20">
                    <div class="card-body text-center">
                            
                        
                        <img width="200" alt="image" src="<?php echo e(asset('error/img/404.svg')); ?>">
                        <h1 class="display-1 fw-600 font-secondary" style="color: #812720">404</h1>
                        <h5>Oops, the page you are looking for does not exist.</h5>
                        <p class="opacity-75">
                                You may want to head back to the dashboard. If you think something is broken, report a problem to the Administrator.
                                 <!-- of <strong>IASBYHEART Team</strong>. -->
                        </p>
                        <div class="p-t-10">
                                <?php if(session('login') == true): ?>
                                <a href="/dashboard" class="btn btn-lg"  style="background-color: #812720;color: #fff;">Go Back Dashboard</a>
                            <?php else: ?>
                            <a href="/login" class="btn btn-lg"  style="background-color: #812720;color: #fff;">Go Back Login</a>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>





</body>
</html><?php /**PATH /var/www/rtcqi-logbook/resources/views/error/page-not-found.blade.php ENDPATH**/ ?>