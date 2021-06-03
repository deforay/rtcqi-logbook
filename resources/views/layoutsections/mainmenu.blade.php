<?php

use Illuminate\Support\Facades\Request;

$role = session('role');
// dd($role);
$dashboard = '';
$manage = '';
    $dashboard = '<li class=" nav-item" id="dashboard"><a href="/dashboard"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a></li>';

    $manage .= '<li class=" nav-item" id="manage"><a href="javascript:void(0)"><i class="la la-toggle-down"></i><span class="menu-title">Manage</span></a>
                <ul class="menu-content">';
    $manage .= '<li id="li-user"><a class="menu-item" href="/user/">User</a></li>';
    $manage .= '<li id="li-testsite"><a class="menu-item" href="/testsite/">Test Site</a></li>';
    $manage .= '<li id="li-testkit"><a class="menu-item" href="/testkit/">Test Kit</a></li>';
    $manage .= '<li id="li-facility"><a class="menu-item" href="/facility/">Facility</a></li>';
    $manage .= '<li id="li-province"><a class="menu-item" href="/province/">Province</a></li>';
    $manage .= '<li id="li-district"><a class="menu-item" href="/district/">District</a></li>';
    $manage .= '<li id="li-sitetype"><a class="menu-item" href="/sitetype/">Site Type</a></li>';
    $manage .= '</ul></li>';

    $manage .= '<li class=" nav-item" id="tests"><a href="javascript:void(0)"><i class="la la-file"></i><span class="menu-title">Tests</span></a>
                <ul class="menu-content">';
    $manage .= '<li id="li-monthlyreport"><a class="menu-item" href="/monthlyreport/">Monthly Report</a></li>';
    $manage .= '<li id="li-monthlyreportpages"><a class="menu-item" href="/monthlyreportpages/">Monthly Report Pages</a></li>';
    $manage .= '</ul></li>';

?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-border" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        @php echo $dashboard; @endphp
        @php echo $manage; @endphp
      </ul>
    </div>
  </div>
