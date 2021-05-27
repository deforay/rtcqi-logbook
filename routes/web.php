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