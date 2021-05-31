<?php

use Illuminate\Support\Facades\Route;

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
    return view('login.index');
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
Route::get('/changePassword/{id}', 'Common\CommonController@changePassword');
Route::post('/changePassword/{id}', 'Common\CommonController@changePassword');
Route::post('/addNewBranchType', 'Common\CommonController@addNewBranchType');
Route::post('/checkItemNameValidation', 'Common\CommonController@checkItemNameValidation');

//user module
Route::get('/user', 'User\UserController@index')->name('user.index');
Route::post('/user/add', 'User\UserController@add');
Route::get('/user/add', 'User\UserController@add');
Route::post('/getAllUser', 'User\UserController@getAllUser');
Route::get('/user/edit/{id}', 'User\UserController@edit');
Route::post('/user/edit/{id}', 'User\UserController@edit');
Route::get('/user/profile/{id}', 'User\UserController@profile');
Route::post('/user/profile/{id}', 'User\UserController@profile');

//login module
Route::get('/login', 'Login\LoginController@index')->name('login.index');
Route::post('/login/validate', 'Login\LoginController@validateEmployee');
Route::match(['get','post'],'/logout', 'Login\LoginController@logout');

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


//test site module
Route::get('/testsite', 'TestSite\TestSiteController@index')->name('testsite.index');
Route::post('/testsite/add', 'TestSite\TestSiteController@add');
Route::get('/testsite/add', 'TestSite\TestSiteController@add');
Route::get('/testsite/edit/{id}', 'TestSite\TestSiteController@edit');
Route::post('/testsite/edit/{id}', 'TestSite\TestSiteController@edit');
Route::post('/getAllTestSite', 'TestSite\TestSiteController@getAllTestSite');

//test kit module
Route::get('/testkit', 'TestKit\TestKitController@index')->name('testkit.index');
Route::post('/testkit/add', 'TestKit\TestKitController@add');
Route::get('/testkit/add', 'TestKit\TestKitController@add');
Route::get('/testkit/edit/{id}', 'TestKit\TestKitController@edit');
Route::post('/testkit/edit/{id}', 'TestKit\TestKitController@edit');
Route::post('/getAllTestKit', 'TestKit\TestKitController@getAllTestKit');

//Facility module
Route::get('/facility', 'Facility\FacilityController@index')->name('facility.index');
Route::post('/facility/add', 'Facility\FacilityController@add');
Route::get('/facility/add', 'Facility\FacilityController@add');
Route::get('/facility/edit/{id}', 'Facility\FacilityController@edit');
Route::post('/facility/edit/{id}', 'Facility\FacilityController@edit');
Route::post('/getAllFacility', 'Facility\FacilityController@getAllFacility');

//Province module
Route::get('/province', 'Province\ProvinceController@index')->name('province.index');
Route::post('/province/add', 'Province\ProvinceController@add');
Route::get('/province/add', 'Province\ProvinceController@add');
Route::get('/province/edit/{id}', 'Province\ProvinceController@edit');
Route::post('/province/edit/{id}', 'Province\ProvinceController@edit');
Route::post('/getAllProvince', 'Province\ProvinceController@getAllProvince');

//District module
Route::get('/district', 'District\DistrictController@index')->name('district.index');
Route::post('/district/add', 'District\DistrictController@add');
Route::get('/district/add', 'District\DistrictController@add');
Route::get('/district/edit/{id}', 'District\DistrictController@edit');
Route::post('/district/edit/{id}', 'District\DistrictController@edit');
Route::post('/getAllDistrict', 'District\DistrictController@getAllDistrict');


//sitetype module
Route::get('/sitetype', 'SiteType\SiteTypeController@index')->name('sitetype.index');
Route::post('/sitetype/add', 'SiteType\SiteTypeController@add');
Route::get('/sitetype/add', 'SiteType\SiteTypeController@add');
Route::get('/sitetype/edit/{id}', 'SiteType\SiteTypeController@edit');
Route::post('/sitetype/edit/{id}', 'SiteType\SiteTypeController@edit');
Route::post('/getAllSiteType', 'SiteType\SiteTypeController@getAllSiteType');