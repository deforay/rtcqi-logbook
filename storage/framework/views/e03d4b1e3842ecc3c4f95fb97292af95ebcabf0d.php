<!--
    Author             : Prasath M
    Date               : 27 May 2021
    Description        : Dashboard screen
    Last Modified Date : 27 May 2021
    Last Modified Name : Prasath M
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

<?php $__env->startSection('content'); ?>

<div class="middle"> <h1 style="font-size: -webkit-xxx-large;">Coming Soon...</h1></div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/rtcqi-logbook/resources/views/dashboard/index.blade.php ENDPATH**/ ?>