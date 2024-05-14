<?php

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use App\Service\GlobalConfigService;

$role = session('role');
// dd($role);
$dashboard = '';
$manage = '';
$test = '';
$report = '';
$import = '';
$accessControl = '';

$profileURl="/user/profile/".base64_encode(session('userId'));
$GlobalConfigService = new GlobalConfigService();
$glob = $GlobalConfigService->getAllGlobalConfig();
$messages=Lang::get('messages');

// dd($globData);die;
$arr = array();
// now we create an associative array so that we can easily create view variables
for ($i = 0; $i < sizeof($glob); $i++) {
	$arr[$glob[$i]->global_name] = $glob[$i]->global_value;
}


if(($arr["logo"])){
	$Logo = '<img class="brand-logo" alt="rtcqi logbook logo" src="{{ url($arr["logo"])}}" style="max-height: 70px;">';
}
else{
	$Logo = '<img class="brand-logo" alt="rtcqi logbook logo" src="{{ asset("assets/images/default-logo.png")}}" style="max-height: 70px;">';
}


						
if (isset($role['App\\Http\\Controllers\\Dashboard\\DashboardController']['index']) && ($role['App\\Http\\Controllers\\Dashboard\\DashboardController']['index'] == "allow"))
	$dashboard = '<li class="dropdown nav-item"   ><a href="/dashboard" id="dashboard" class=" nav-link" ><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">'.Lang::get('messages.dashboard').'</span></a></li>';
if ((isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\District\\DistrictController']['index']) && ($role['App\\Http\\Controllers\\District\\DistrictController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Facility\\FacilityController']['index']) && ($role['App\\Http\\Controllers\\Facility\\FacilityController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index']) && ($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Province\\ProvinceController']['index']) && ($role['App\\Http\\Controllers\\Province\\ProvinceController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index']) && ($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index']) && ($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index']) && ($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\User\\UserController']['index']) && ($role['App\\Http\\Controllers\\User\\UserController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index']) && ($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index'] == "allow"))) {
	$manage .= '<li class="dropdown nav-item" data-menu="dropdown"><a  id="manage" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-toggle-down"></i><span class="menu-title">'.Lang::get('messages.manage').'</span></a>
                <ul class="dropdown-menu">';
	$manage .= '<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span data-i18n="Access Control">'.Lang::get('messages.access_control').'</span></a>
	<ul class="dropdown-menu">';
	if (isset($role['App\\Http\\Controllers\\User\\UserController']['index']) && ($role['App\\Http\\Controllers\\User\\UserController']['index'] == "allow"))
		$manage .= '<li id="li-user"><a class="dropdown-item" data-toggle="dropdown" href="/user/">'.Lang::get('messages.users').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow"))
		$manage .= '<li id="li-roles"><a class="dropdown-item" data-toggle="dropdown" href="/roles/">'.Lang::get('messages.roles').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\User\\UserController']['userloginhistory']) && ($role['App\\Http\\Controllers\\User\\UserController']['userloginhistory'] == "allow"))
		$manage .= '<li id="li-loginHistory"><a class="dropdown-item" data-toggle="dropdown" href="/user/userloginhistory">'.Lang::get('messages.user_login_history').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\User\\UserController']['userActivityLog']) && ($role['App\\Http\\Controllers\\User\\UserController']['userActivityLog'] == "allow"))
		$manage .= '<li id="li-activityLog"><a class="dropdown-item" data-toggle="dropdown" href="/user/userActivityLog">'.Lang::get('messages.user_activity_log').'</a></li>';
	$manage .= '</ul></li>';
	if (isset($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index']) && ($role['App\\Http\\Controllers\\TestSite\\TestSiteController']['index'] == "allow"))
		$manage .= '<li id="li-testsite"><a class="dropdown-item" data-toggle="dropdown" href="/testsite/">'.Lang::get('messages.test_sites').'</a></li>';
	$manage .= '<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><span data-i18n="Locations">'.Lang::get('messages.locations').'</span></a>
		<ul class="dropdown-menu">';
	if (isset($role['App\\Http\\Controllers\\Province\\ProvinceController']['index']) && ($role['App\\Http\\Controllers\\Province\\ProvinceController']['index'] == "allow"))
		$manage .= '<li id="li-province"><a class="dropdown-item" data-toggle="dropdown" href="/province/">'.Lang::get('messages.provinces').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\District\\DistrictController']['index']) && ($role['App\\Http\\Controllers\\District\\DistrictController']['index'] == "allow"))
		$manage .= '<li id="li-district"><a class="dropdown-item" data-toggle="dropdown" href="/district/">'.Lang::get('messages.districts').'</a></li>';

	if (isset($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['index']) && ($role['App\\Http\\Controllers\\SubDistrict\\SubDistrictController']['index'] == "allow"))
		$manage .= '<li id="li-district"><a class="dropdown-item" data-toggle="dropdown" href="/subdistrict/">'.Lang::get('messages.sub_districts').'</a></li>';
	$manage .= '</ul></li>';
	if (isset($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index']) && ($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index'] == "allow"))
		$manage .= '<li id="li-globalconfig"><a class="dropdown-item" data-toggle="dropdown" href="/globalconfig/">'.Lang::get('messages.global_config').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index']) && ($role['App\\Http\\Controllers\\SiteType\\SiteTypeController']['index'] == "allow"))
		$manage .= '<li id="li-sitetype"><a class="dropdown-item" data-toggle="dropdown" href="/sitetype/">'.Lang::get('messages.entry_point').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index']) && ($role['App\\Http\\Controllers\\TestKit\\TestKitController']['index'] == "allow"))
		$manage .= '<li id="li-testkit"><a class="dropdown-item" data-toggle="dropdown" href="/testkit/">'.Lang::get('messages.test_kits').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index']) && ($role['App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController']['index'] == "allow"))
		$manage .= '<li id="li-allowedtestkit"><a class="dropdown-item" data-toggle="dropdown" href="/allowedtestkit/">'.Lang::get('messages.allowed_test_kits').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index']) && ($role['App\\Http\\Controllers\\AuditTrail\\AuditTrailController']['index'] == "allow"))
		$manage .= '<li id="li-roles"><a class="dropdown-item" data-toggle="dropdown" href="/auditTrail/">'.Lang::get('messages.audit_trail').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController']['index']) && ($role['App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController']['index'] == "allow"))
		$manage .= '<li id="li-district"><a class="dropdown-item" data-toggle="dropdown" href="/implementingpartners/">'.Lang::get('messages.implementing_partners').'</a></li>';
	
	$manage .= '</ul></li>';
}
$test .= '<li class="dropdown nav-item" data-menu="dropdown"><a id="tests" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-file"></i><span class="menu-title">'.Lang::get('messages.audits').'</span></a>
                <ul class="dropdown-menu">';
if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['index']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['index'] == "allow"))
	$test .= '<li id="li-monthlyreport"><a class="dropdown-item" data-toggle="dropdown" href="/monthlyreport/">'.Lang::get('messages.monthly_report').'</a></li>';
if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['notUpload']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['notUpload'] == "allow"))
		$test .= '<li id="li-monthlyreport"><a class="dropdown-item" data-toggle="dropdown" href="/monthlyreport/notUpload">'.Lang::get('messages.failed_imports_excel_upload').'</a></li>';
$test .= '</ul></li>';

if ((isset($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport'] == "allow")) || (isset($role['App\\Http\\Controllers\\Report\\ReportController']['customreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['customreport'] == "allow"))) {
	$report .= '<li class="dropdown nav-item" data-menu="dropdown"><a id="reports" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-columns"></i><span class="menu-title">'.Lang::get('messages.reports').'</span></a>
                <ul class="dropdown-menu">';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['trendreport'] == "allow"))
		$report .= '<li id="li-trendreport"><a class="dropdown-item" data-toggle="dropdown" href="/trendreport/">'.Lang::get('messages.trend_report').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['logbookreport'] == "allow"))
		$report .= '<li id="li-logbook"><a class="dropdown-item" data-toggle="dropdown" href="/report/logbook/">'.Lang::get('messages.logbook_report').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['testkitreport'] == "allow"))
		$report .= '<li id="li-testKitReport"><a class="dropdown-item" data-toggle="dropdown" href="/testKitReport/">'.Lang::get('messages.test_kit_report').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['invalidresultreport'] == "allow"))
		$report .= '<li id="li-invalidresultreport"><a class="dropdown-item" data-toggle="dropdown" href="/invalidresultreport/">'.Lang::get('messages.invalid_result_report').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['customreport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['customreport'] == "allow"))
		$report .= '<li id="li-customreport"><a class="dropdown-item" data-toggle="dropdown" href="/customreport/">'.Lang::get('messages.custom_report').'</a></li>';
	if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['notreportedsites']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['notreportedsites'] == "allow"))
		$report .= '<li id="li-notreportedsites"><a class="dropdown-item" data-toggle="dropdown" href="/notreportedsites/">'.Lang::get('messages.not_reported_sites_report').'</a></li>';

		$report .= '</ul></li>';
}

$monitoringReport='';

if (isset($role['App\\Http\\Controllers\\MonitoringReport\\MonitoringReportController']['sitewisereport']) && ($role['App\\Http\\Controllers\\MonitoringReport\\MonitoringReportController']['sitewisereport'] == "allow")){
	$monitoringReport .= '<li id="li-sitewisereport"><a class="dropdown-item" data-toggle="dropdown" href="'.url('sitewisereport').'">'.Lang::get('Site-Wise Report').'</a></li>';
}
// $import .= '<li class="dropdown nav-item" ><a id="import" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-upload"></i><span class="menu-title">Import</span></a>
//             <ul class="dropdown-menu">';
// $import .= '<li id="li-monthlyreportdata"><a class="dropdown-item" data-toggle="dropdown" href="/monthlyreportdata/">Import Monthly Report</a></li>';
// $import .= '</ul></li>';

?>
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
	<div class="navbar-container main-menu-content" data-menu="menu-container">
		<ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
			@php echo $Logo; @endphp
			@php echo $dashboard; @endphp
			@php echo $manage; @endphp
			@php echo $test; @endphp
			@php echo $report; @endphp

			
			<?php if(trim($monitoringReport)!=""){ ?>
				<li class="dropdown nav-item" data-menu="dropdown"><a id="monitoringReport" href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="la la-columns"></i><span class="menu-title"><?php echo Lang::get('Monitoring Reports') ?> </span></a>
					<ul class="dropdown-menu">
						<?php echo $monitoringReport; ?>
					</ul>
				</li>		
			<?php } ?>

			<li class="dropdown nav-item profil" data-menu="dropdown" style="float-align: right"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700">@if (session('username')) {{ ucfirst(session('username')) }} @endif</span><span class="avatar avatar-online"><img src="{{ asset('assets/images/default-profile-picture.jpg')}}" alt="avatar"><i></i></span></a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="{{$profileURl}}"><i class="ft-user"></i> {{ $messages['edit_profile']}}</a>
					<a class="dropdown-item" href="/changePassword"><i class="ft-user"></i> {{ $messages['change_password']}}</a>
					<!-- <a class="dropdown-item" href="app-kanban.html"><i class="ft-clipboard"></i> Todo</a>
					<a class="dropdown-item" href="user-cards.html"><i class="ft-check-square"></i> Task</a> -->
					<div class="dropdown-divider"></div>
					<form action="/logout/{{ base64_encode(session('name'))}}" name="logoutForm" id="logoutForm" method="POST">
						@csrf
						<button type="submit" class="dropdown-item"><i class="ft-power"></i> {{ $messages['logout']}}</button>
					</form>
				</div>
			</li>
		</ul>
	</div>

</div>
