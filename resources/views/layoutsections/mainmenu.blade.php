<style>
	.navbar {
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
$accessControl = '';
if (isset($role['App\\Http\\Controllers\\Dashboard\\DashboardController']['index']) && ($role['App\\Http\\Controllers\\Dashboard\\DashboardController']['index'] == "allow"))
	$dashboard = '<li class="dropdown nav-item"   ><a href="/dashboard" id="dashboard" class=" nav-link" ><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a></li>';
if ((isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\District\\DistrictController']['index']) && ($role['App\\Http\\Controllers\\District\\DistrictController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Facility\\FacilityController']['index']) && ($role['App\\Http\\Controllers\\Facility\\FacilityController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index']) && ($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Province\\ProvinceController']['index']) && ($role['App\\Http\\Controllers\\Province\\ProvinceController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index']) && ($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index']) && ($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index']) && ($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\User\\UserController']['index']) && ($role['App\\Http\\Controllers\\User\\UserController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index']) && ($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index'] == "allow"))) {
	$manage .= '<li class="dropdown nav-item" data-menu="dropdown"><a  id="manage" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-toggle-down"></i><span class="menu-title" >Manage</span></a>
                <ul class="dropdown-menu">';
	$manage .= '<li class="dropdown nav-item dropdown-item" data-menu="dropdown"><a id="accessControl" href="javascript:void(0)" data-toggle="dropdown"><span class="menu-title" style="color: #212529;">Access Control</span></a>';
    $manage .= '<ul class="dropdown-menu">';
	if (isset($role['App\\Http\\Controllers\\User\\UserController']['index']) && ($role['App\\Http\\Controllers\\User\\UserController']['index'] == "allow"))
	$manage .= '<li id="li-user"><a class="dropdown-item" data-toggle="dropdown" href="/user/">Users</a></li>';
	if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow"))
		$manage .= '<li id="li-roles"><a class="dropdown-item" data-toggle="dropdown" href="/roles/">Roles</a></li>';
	$manage .= '</ul></li>';
	if (isset($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index']) && ($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index'] == "allow"))
		$manage .= '<li id="li-testsite"><a class="dropdown-item" data-toggle="dropdown" href="/testsite/">Test Sites</a></li>';
		$manage .= '<li class="dropdown nav-item dropdown-item" data-menu="dropdown"><a id="locations" href="javascript:void(0)" data-toggle="dropdown"><span class="menu-title" style="color: #212529;">Locations</span></a>';
    $manage .= '<ul class="dropdown-menu">';
	if (isset($role['App\\Http\\Controllers\\Province\\ProvinceController']['index']) && ($role['App\\Http\\Controllers\\Province\\ProvinceController']['index'] == "allow"))
		$manage .= '<li id="li-province"><a class="dropdown-item" data-toggle="dropdown" href="/province/">Provinces</a></li>';
	if (isset($role['App\\Http\\Controllers\\District\\DistrictController']['index']) && ($role['App\\Http\\Controllers\\District\\DistrictController']['index'] == "allow"))
		$manage .= '<li id="li-district"><a class="dropdown-item" data-toggle="dropdown" href="/district/">Districts</a></li>';
	$manage .= '</ul></li>';
	if (isset($role['App\\Http\\Controllers\\Facility\\FacilityController']['index']) && ($role['App\\Http\\Controllers\\Facility\\FacilityController']['index'] == "allow"))
		$manage .= '<li id="li-facility"><a class="dropdown-item" data-toggle="dropdown" href="/facility/">Facilities</a></li>';
		if (isset($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index']) && ($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index'] == "allow"))
		$manage .= '<li id="li-globalconfig"><a class="dropdown-item" data-toggle="dropdown" href="/globalconfig/">Global Config</a></li>';
		if (isset($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index']) && ($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index'] == "allow"))
		$manage .= '<li id="li-sitetype"><a class="dropdown-item" data-toggle="dropdown" href="/sitetype/">Site Types</a></li>';
		if (isset($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index']) && ($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index'] == "allow"))
		$manage .= '<li id="li-testkit"><a class="dropdown-item" data-toggle="dropdown" href="/testkit/">Test Kits</a></li>';
	if (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index'] == "allow"))
		$manage .= '<li id="li-allowedtestkit"><a class="dropdown-item" data-toggle="dropdown" href="/allowedtestkit/">Allowed Test kits</a></li>';
	if (isset($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index']) && ($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index'] == "allow"))
		$manage .= '<li id="li-roles"><a class="dropdown-item" data-toggle="dropdown" href="/auditTrail/">Audit Trail</a></li>';
	$manage .= '</ul></li>';
}
$test .= '<li class="dropdown nav-item" data-menu="dropdown"><a id="tests" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-file"></i><span class="menu-title">Audits</span></a>
                <ul class="dropdown-menu">';
if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['index']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['index'] == "allow"))
	$test .= '<li id="li-monthlyreport"><a class="dropdown-item" data-toggle="dropdown" href="/monthlyreport/">Monthly Report</a></li>';
$test .= '</ul></li>';

if ((isset($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['customreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['customreport'] == "allow"))) {
	$report .= '<li class="dropdown nav-item" data-menu="dropdown"><a id="reports" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-columns"></i><span class="menu-title">Reports</span></a>
                <ul class="dropdown-menu">';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport'] == "allow"))
		$report .= '<li id="li-trendreport"><a class="dropdown-item" data-toggle="dropdown" href="/trendreport/">Trend Report</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport'] == "allow"))
		$report .= '<li id="li-logbook"><a class="dropdown-item" data-toggle="dropdown" href="/report/logbook/">Logbook Report</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport'] == "allow"))
		$report .= '<li id="li-testKitReport"><a class="dropdown-item" data-toggle="dropdown" href="/testKitReport/">Test Kit Report</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport'] == "allow"))
		$report .= '<li id="li-invalidresultreport"><a class="dropdown-item" data-toggle="dropdown" href="/invalidresultreport/">Invalid Result Report</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['customreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['customreport'] == "allow"))
		$report .= '<li id="li-customreport"><a class="dropdown-item" data-toggle="dropdown" href="/customreport/">Custom Report</a></li>';
	$report .= '</ul></li>';
}
// $import .= '<li class="dropdown nav-item" ><a id="import" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-upload"></i><span class="menu-title">Import</span></a>
//             <ul class="dropdown-menu">';
// $import .= '<li id="li-monthlyreportdata"><a class="dropdown-item" data-toggle="dropdown" href="/monthlyreportdata/">Import Monthly Report</a></li>';
// $import .= '</ul></li>';

?>
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
	<div class="navbar-container main-menu-content" data-menu="menu-container">
		<ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
			@php echo $dashboard; @endphp
			@php echo $manage; @endphp
			@php echo $test; @endphp
			@php echo $report; @endphp
		</ul>
	</div>
</div>