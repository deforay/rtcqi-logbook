<style>
.navbar{ 
  padding: .1rem .1rem;
}
</style>

<?php

use Illuminate\Support\Facades\Request;

$role = session('role');
// dd($role);
$dashboard = '';
$manage = '';
$test = '';
$report = '';
$import = '';
    $dashboard = '<li class="dropdown nav-item"   ><a href="/dashboard" id="dashboard" class=" nav-link" ><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a></li>';

    $manage .= '<li class="dropdown nav-item" data-menu="dropdown"><a  id="manage" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-toggle-down"></i><span class="menu-title">Manage</span></a>
                <ul class="dropdown-menu">';
    $manage .= '<li id="li-user"><a class="dropdown-item" data-toggle="dropdown" href="/user/">Users</a></li>';
    $manage .= '<li id="li-testsite"><a class="dropdown-item" data-toggle="dropdown" href="/testsite/">Test Sites</a></li>';
    $manage .= '<li id="li-testkit"><a class="dropdown-item" data-toggle="dropdown" href="/testkit/">Test Kits</a></li>';
    $manage .= '<li id="li-facility"><a class="dropdown-item" data-toggle="dropdown" href="/facility/">Facilities</a></li>';
    $manage .= '<li id="li-province"><a class="dropdown-item" data-toggle="dropdown" href="/province/">Provinces</a></li>';
    $manage .= '<li id="li-district"><a class="dropdown-item" data-toggle="dropdown" href="/district/">Districts</a></li>';
    $manage .= '<li id="li-sitetype"><a class="dropdown-item" data-toggle="dropdown" href="/sitetype/">Site Types</a></li>';
    $manage .= '<li id="li-globalconfig"><a class="dropdown-item" data-toggle="dropdown" href="/globalconfig/">Global Config</a></li>';
    $manage .= '<li id="li-allowedtestkit"><a class="dropdown-item" data-toggle="dropdown" href="/allowedtestkit/">Allowed Test kits</a></li>';
    $manage .= '<li id="li-allowedtestkit"><a class="dropdown-item" data-toggle="dropdown" href="/roles/">Roles</a></li>';
    $manage .= '</ul></li>';
    
    $test .= '<li class="dropdown nav-item" data-menu="dropdown"><a id="tests" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-file"></i><span class="menu-title">Audits</span></a>
                <ul class="dropdown-menu">';
    $test .= '<li id="li-monthlyreport"><a class="dropdown-item" data-toggle="dropdown" href="/monthlyreport/">Monthly Report</a></li>';
    $test .= '</ul></li>';

    $report .= '<li class="dropdown nav-item" data-menu="dropdown"><a id="reports" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-columns"></i><span class="menu-title">Reports</span></a>
                <ul class="dropdown-menu">';
    $report .= '<li id="li-trendreport"><a class="dropdown-item" data-toggle="dropdown" href="/trendreport/">Trend Report</a></li>';
    $report .= '<li id="li-logbook"><a class="dropdown-item" data-toggle="dropdown" href="/report/logbook/">Logbook Report</a></li>';
    $report .= '<li id="li-testKitReport"><a class="dropdown-item" data-toggle="dropdown" href="/testKitReport/">Test Kit Report</a></li>';
    $report .= '<li id="li-invalidresultreport"><a class="dropdown-item" data-toggle="dropdown" href="/invalidresultreport/">Invalid Result Report</a></li>';
    $report .= '<li id="li-customreport"><a class="dropdown-item" data-toggle="dropdown" href="/customreport/">Custom Report</a></li>';
    $report .= '</ul></li>';

    // $import .= '<li class="dropdown nav-item" ><a id="import" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-upload"></i><span class="menu-title">Import</span></a>
    //             <ul class="dropdown-menu">';
    // $import .= '<li id="li-monthlyreportdata"><a class="dropdown-item" data-toggle="dropdown" href="/monthlyreportdata/">Import Monthly Report</a></li>';
    // $import .= '</ul></li>';

?>
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
  role="navigation" data-menu="menu-wrapper">
  <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        @php echo $dashboard; @endphp
        @php echo $manage; @endphp
        @php echo $test; @endphp
        @php echo $report; @endphp
      </ul>
    </div>
  </div>

