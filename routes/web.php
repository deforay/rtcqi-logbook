<?php

use Illuminate\Support\Facades\Route;
use App\Model\User\UserTable;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(session('login')!=true)
    {
        $model = new UserTable();
        $activeUsers = $model->fetchAllActiveUser();
        $activeUsersCount=$activeUsers->count();
        if($activeUsersCount > 0){
            return view('login.index');
        }else{
            return view('login.register');
        }
    }else{
        return Redirect::to('/dashboard');
    }

    
    
});



Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard.index');

//Common module
Route::post('/duplicateValidation', 'Common\CommonController@duplicateValidation');
Route::post('/mobileDuplicateValidation', 'Common\CommonController@mobileDuplicateValidation');
Route::post('/checkMobileValidation', 'Common\CommonController@checkMobileValidation');
Route::post('/checkNameValidation', 'Common\CommonController@checkNameValidation');
Route::post('/changeStatus', 'Common\CommonController@changeStatus');
Route::post('/addNewField', 'Common\CommonController@addNewField');
Route::post('/addNewUnitField', 'Common\CommonController@addNewUnitField');
Route::get('/changePassword', 'Common\CommonController@changePassword');
Route::post('/changePassword', 'Common\CommonController@changePassword');
Route::post('/addNewBranchType', 'Common\CommonController@addNewBranchType');
Route::post('/checkItemNameValidation', 'Common\CommonController@checkItemNameValidation');
//setup module
Route::get('/setup', 'User\UserController@register');
Route::post('/setup', 'User\UserController@register');
//user module
Route::get('/user', 'User\UserController@index')->name('user.index')->middleware('access');
Route::post('/user/add', 'User\UserController@add');
Route::get('/user/add', 'User\UserController@add')->middleware('access');
Route::post('/getAllUser', 'User\UserController@getAllUser');
Route::post('/getUserLoginHistory','User\UserController@getUserLoginHistory')->name('user.getUserLoginHistory')->middleware('access');
Route::get('/user/edit/{id}', 'User\UserController@edit')->middleware('access');
Route::post('/user/edit/{id}', 'User\UserController@edit');
Route::get('/user/profile/{id}', 'User\UserController@profile')->middleware('access');
Route::post('/user/profile/{id}', 'User\UserController@profile');
Route::get('/user/userloginhistory', 'User\UserController@userloginhistory')->name('user.userloginhistory')->middleware('access');
Route::get('/user/userActivityLog', 'User\UserController@userActivityLog')->name('user.userActivityLog')->middleware('access');
Route::post('/getAllUserActivity', 'User\UserController@getAllUserActivity')->name('user.getAllUserActivity');


//login module
Route::get('/login', 'Login\LoginController@index')->name('login.index');
Route::post('/login/validate', 'Login\LoginController@validateEmployee');
Route::match(['get','post'],'/logout/{name}', 'Login\LoginController@logout');

//password reset module
Route::post('/forgot/sendemailresetlink', 'ForgotPassword\ForgotPasswordController@sendEmailWithResetLink');
Route::get('/reset-password/{token}', 'ForgotPassword\ForgotPasswordController@showResetPasswordForm')->name('reset.password');
Route::post('/reset-new-password', 'ForgotPassword\ForgotPasswordController@submitResetPasswordForm');

Route::post('/testsite/bulk-upload', 'TestSite\TestSiteController@bulkUpload');
Route::get('/testsite/bulk-upload', 'TestSite\TestSiteController@bulkUpload');

Route::post('/user/bulk-upload', 'User\UserController@userBulkUpload');
Route::get('/user/bulk-upload', 'User\UserController@userBulkUpload');

// Handle Error - Unathorized Access Page, Page Not Found , Incorrect Request
Route::get('/unauthorized', function()
{
    return view('error.not-authorized');
});

Route::get('/pagenotfound', function()
{
    return view('error.page-not-found');
});

Route::get('/incorrectrequest', function()
{
    return view('error.incorrect-request');
});

Route::get('/dashboarderror', function()
{
    return view('error.dashboard-error');
});


//test site module
Route::get('/testsite', 'TestSite\TestSiteController@index')->name('testsite.index')->middleware('access');
Route::post('/testsite/add', 'TestSite\TestSiteController@add');
Route::get('/testsite/add', 'TestSite\TestSiteController@add')->middleware('access');

Route::get('/testsite/edit/{id}', 'TestSite\TestSiteController@edit')->middleware('access');
Route::post('/testsite/edit/{id}', 'TestSite\TestSiteController@edit');
Route::post('/getAllTestSite', 'TestSite\TestSiteController@getAllTestSite');

//test kit module
Route::get('/testkit', 'TestKit\TestKitController@index')->name('testkit.index')->middleware('access');
Route::post('/testkit/add', 'TestKit\TestKitController@add');
Route::get('/testkit/add', 'TestKit\TestKitController@add')->middleware('access');
Route::get('/testkit/edit/{id}', 'TestKit\TestKitController@edit')->middleware('access');
Route::post('/testkit/edit/{id}', 'TestKit\TestKitController@edit');
Route::post('/getAllTestKit', 'TestKit\TestKitController@getAllTestKit');

//Facility module
Route::get('/facility', 'Facility\FacilityController@index')->name('facility.index')->middleware('access');
Route::post('/facility/add', 'Facility\FacilityController@add');
Route::get('/facility/add', 'Facility\FacilityController@add')->middleware('access');
Route::get('/facility/edit/{id}', 'Facility\FacilityController@edit')->middleware('access');
Route::post('/facility/edit/{id}', 'Facility\FacilityController@edit');
Route::post('/getAllFacility', 'Facility\FacilityController@getAllFacility');

//Province module
Route::get('/province', 'Province\ProvinceController@index')->name('province.index')->middleware('access');
Route::post('/province/add', 'Province\ProvinceController@add');
Route::get('/province/add', 'Province\ProvinceController@add')->middleware('access');
Route::get('/province/edit/{id}', 'Province\ProvinceController@edit')->middleware('access');
Route::post('/province/edit/{id}', 'Province\ProvinceController@edit');
Route::post('/getAllProvince', 'Province\ProvinceController@getAllProvince');

//District module
Route::get('/district', 'District\DistrictController@index')->name('district.index')->middleware('access');
Route::post('/district/add', 'District\DistrictController@add');
Route::get('/district/add', 'District\DistrictController@add')->middleware('access');
Route::get('/district/edit/{id}', 'District\DistrictController@edit')->middleware('access');
Route::post('/district/edit/{id}', 'District\DistrictController@edit');
Route::post('/getAllDistrict', 'District\DistrictController@getAllDistrict');

//SubDistrict module
Route::get('/subdistrict', 'SubDistrict\SubDistrictController@index')->name('subdistrict.index')->middleware('access');
Route::post('/subdistrict/add', 'SubDistrict\SubDistrictController@add');
Route::get('/subdistrict/add', 'SubDistrict\SubDistrictController@add')->middleware('access');
Route::get('/subdistrict/edit/{id}', 'SubDistrict\SubDistrictController@edit')->middleware('access');
Route::post('/subdistrict/edit/{id}', 'SubDistrict\SubDistrictController@edit');
Route::post('/getAllSubDistrict', 'SubDistrict\SubDistrictController@getAllSubDistrict');

//Implementing Partners module
Route::get('/implementingpartners', 'ImplementingPartners\ImplementingPartnersController@index')->name('implementingpartners.index')->middleware('access');
Route::post('/implementingpartners/add', 'ImplementingPartners\ImplementingPartnersController@add');
Route::get('/implementingpartners/add', 'ImplementingPartners\ImplementingPartnersController@add')->middleware('access');
Route::get('/implementingpartners/edit/{id}', 'ImplementingPartners\ImplementingPartnersController@edit')->middleware('access');
Route::post('/implementingpartners/edit/{id}', 'ImplementingPartners\ImplementingPartnersController@edit');
Route::post('/getAllImplementingPartners', 'ImplementingPartners\ImplementingPartnersController@getAllImplementingPartners');

//monthlyreport module
Route::get('/monthlyreport', 'MonthlyReport\MonthlyReportController@index')->name('monthlyreport.index')->middleware('access');
Route::post('/monthlyreport/add', 'MonthlyReport\MonthlyReportController@add');
Route::get('/monthlyreport/add', 'MonthlyReport\MonthlyReportController@add')->middleware('access');
Route::get('/monthlyreport/edit/{id}', 'MonthlyReport\MonthlyReportController@edit')->middleware('access');
Route::post('/monthlyreport/edit/{id}', 'MonthlyReport\MonthlyReportController@edit');
Route::post('/getAllMonthlyReport', 'MonthlyReport\MonthlyReportController@getAllMonthlyReport');
Route::post('/getSelectedSiteMonthlyReport', 'MonthlyReport\MonthlyReportController@getSelectedSiteMonthlyReport');
Route::post('/getDuplicateMonthlyReport', 'MonthlyReport\MonthlyReportController@getDuplicateMonthlyReport');


Route::post('/CheckPreLot', 'MonthlyReport\MonthlyReportController@CheckPreLot');

Route::get('/monthlyreport/notUpload', 'MonthlyReport\MonthlyReportController@notUpload')->name('monthlyreport.notUpload')->middleware('access');
Route::post('/getAllNotUploadMonthlyReport', 'MonthlyReport\MonthlyReportController@getAllNotUploadMonthlyReport');
Route::post('/notuploadexcelexport', 'Report\ReportController@notUploadExport');
//sitetype module
Route::get('/sitetype', 'SiteType\SiteTypeController@index')->name('sitetype.index')->middleware('access');
Route::post('/sitetype/add', 'SiteType\SiteTypeController@add');
Route::get('/sitetype/add', 'SiteType\SiteTypeController@add')->middleware('access');
Route::get('/sitetype/edit/{id}', 'SiteType\SiteTypeController@edit')->middleware('access');
Route::post('/sitetype/edit/{id}', 'SiteType\SiteTypeController@edit');
Route::post('/getAllSiteType', 'SiteType\SiteTypeController@getAllSiteType');


//user facility map module
Route::get('/userfacilitymap', 'UserFacilityMap\UserFacilityMapController@index')->name('userfacilitymap.index')->middleware('access');
Route::post('/userfacilitymap/add', 'UserFacilityMap\UserFacilityMapController@add');
Route::get('/userfacilitymap/add', 'UserFacilityMap\UserFacilityMapController@add')->middleware('access');
Route::get('/userfacilitymap/edit/{id}', 'UserFacilityMap\UserFacilityMapController@edit')->middleware('access');
Route::post('/userfacilitymap/edit/{id}', 'UserFacilityMap\UserFacilityMapController@edit');
Route::post('/getAllUserFacility', 'UserFacilityMap\UserFacilityMapController@getAllUserFacility');


//user facility map module
Route::get('/allowedtestkit', 'AllowedTestKit\AllowedTestKitController@index')->name('allowedtestkit.index')->middleware('access');
Route::post('/allowedtestkit/add', 'AllowedTestKit\AllowedTestKitController@add');
Route::get('/allowedtestkit/add', 'AllowedTestKit\AllowedTestKitController@add')->middleware('access');
Route::get('/allowedtestkit/edit/{id}', 'AllowedTestKit\AllowedTestKitController@edit')->middleware('access');
Route::post('/allowedtestkit/edit/{id}', 'AllowedTestKit\AllowedTestKitController@edit');
Route::post('/getAllAllowedTestKit', 'AllowedTestKit\AllowedTestKitController@getAllAllowedTestKit');

//globalconfig module
Route::get('/globalconfig', 'GlobalConfig\GlobalConfigController@index')->name('globalconfig.index')->middleware('access');
Route::get('/globalconfig/edit/', 'GlobalConfig\GlobalConfigController@edit')->middleware('access');
Route::post('/globalconfig/updateglobal', 'GlobalConfig\GlobalConfigController@updateglobal');
Route::post('/getAllGlobalConfig', 'GlobalConfig\GlobalConfigController@getAllGlobalConfig');

//Trend Report
Route::get('/trendreport', 'Report\ReportController@trendReport')->name('trendreport.trendReport')->middleware('access');
Route::post('/getTrendMonthlyReport', 'Report\ReportController@getTrendMonthlyReport');
Route::post('/trendexcelexport', 'Report\ReportController@trendExport');
Route::post('/getDistrictByProvinceId', 'Report\ReportController@getDistrictByProvinceId');
Route::post('/getSubDistrictByDistrictId', 'Report\ReportController@getSubDistrictByDistrictId');


Route::post('/getLogbookReport', 'Report\ReportController@getLogbookReport');
Route::get('/report/logbook', 'Report\ReportController@logbook')->name('report.logbook')->middleware('access');
Route::get('/report/overallagreement/{id}', 'Report\ReportController@overallagreement')->middleware('access');
Route::post('/logbookexcelexport', 'Report\ReportController@logBookExport');

//Test Kit Report
Route::get('/testKitReport', 'Report\ReportController@testKitReport')->name('testKitReport.testKitReport')->middleware('access');
Route::post('/getTestKitMonthlyReport', 'Report\ReportController@getTestKitMonthlyReport');
Route::post('/testkitexcelexport', 'Report\ReportController@testKitExport');

Route::get('/monthlyreportdata', 'MonthlyReport\MonthlyReportController@monthlyreportdata')->name('monthlyreportdata.index')->middleware('access');
Route::post('/monthlyreportdata', 'MonthlyReport\MonthlyReportController@monthlyreportdata');

// Custom Report
Route::get('/customreport', 'Report\ReportController@customReport')->name('customreport.customReport')->middleware('access');
Route::post('/getCustomMonthlyReport', 'Report\ReportController@getCustomMonthlyReport');
Route::post('/customerexcelexport', 'Report\ReportController@customerExport');

// Custom Report
Route::get('/notreportedsites', 'Report\ReportController@notReportedSites')->name('notreportedsites.notReportedSites')->middleware('access');
Route::post('/getNotReportedSites', 'Report\ReportController@getNotReportedSites');
Route::post('/notreportedsitesexcelexport', 'Report\ReportController@notReportedSitesExport');

// Invalid Results Report
Route::get('/invalidresultreport', 'Report\ReportController@invalidresultReport')->name('invalidresultreport.invalidresultReport')->middleware('access');
Route::post('/getInvalidResultReport', 'Report\ReportController@getInvalidResultReport');
Route::post('/invalidresultexcelexport', 'Report\ReportController@invalidResultExport');


Route::get('/getDistrict/{id}', 'TestSite\TestSiteController@getDistrict');
Route::get('/getSubDistrict/{id}', 'TestSite\TestSiteController@getSubDistrict');

Route::post('/getDashboardData', 'Dashboard\DashboardController@getDashboardData');
Route::get('/insertTrackTable', 'MonthlyReport\MonthlyReportController@insertTrackTable');
Route::get('/getProvince/{id}', 'TestSite\TestSiteController@getProvince');

//Role module
Route::get('/roles', 'Roles\RolesController@index')->name('roles.index');
Route::post('/roles/add', 'Roles\RolesController@add');
Route::get('/role/add', 'Roles\RolesController@add');
Route::post('/getRole', 'Roles\RolesController@getRole');
Route::get('/roles/edit/{id}', 'Roles\RolesController@edit');
Route::post('/roles/edit/{id}', 'Roles\RolesController@edit');


//Audit Trail
Route::get('/auditTrail', 'AuditTrail\AuditTrailController@index')->name('auditTrail.index');
Route::post('/auditTrail', 'AuditTrail\AuditTrailController@index');
Route::get('/auditTrail', 'AuditTrail\AuditTrailController@index')->middleware('access');
Route::post('/getAllAuditData', 'AuditTrail\AuditTrailController@getAllAuditData');
Route::post('/getAuditTrail', 'AuditTrail\AuditTrailController@getAuditTrail')->middleware('access');


Route::post('/getReportingMonth', 'MonthlyReport\MonthlyReportController@getReportingMonth');
Route::post('/getIdReportingMonth', 'MonthlyReport\MonthlyReportController@getIdReportingMonth');

//Monitoring Report
Route::get('/sitewisereport','MonitoringReport\MonitoringReportController@sitewiseReport')->name('sitewisereport.sitewiseReport');
Route::post('/getSiteWiseReport', 'MonitoringReport\MonitoringReportController@getSiteWiseReport');
Route::post('/sitewisereportexport', 'MonitoringReport\MonitoringReportController@sitewiseReportExport');
Route::post('/sendMail', 'MonitoringReport\MonitoringReportController@sendMail');

Route::post('/getAllTestSiteList', 'TestSite\TestSiteController@getAllTestSiteList');