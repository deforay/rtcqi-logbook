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
    return view('layouts.main');
});

Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard.index');

//Role module
Route::get('/roles', 'Roles\RolesController@index')->name('roles.index');
Route::post('/roles/add', 'Roles\RolesController@add');
Route::get('/roles/add', 'Roles\RolesController@add');
Route::post('/getRole', 'Roles\RolesController@getRole');
Route::get('/roles/edit/{id}', 'Roles\RolesController@edit');
Route::post('/roles/edit/{id}', 'Roles\RolesController@edit');


//Common module
Route::post('/duplicateValidation', 'Common\CommonController@duplicateValidation');
Route::post('/checkNameValidation', 'Common\CommonController@checkNameValidation');
Route::post('/changeStatus', 'Common\CommonController@changeStatus');

//Vendorstype
Route::get('/vendorstype', 'VendorsType\VendorsTypeController@index')->name('vendorstype.index');
Route::post('/getAllVendorType', 'VendorsType\VendorsTypeController@getAllVendorType');

Route::post('/vendorstype/add', 'VendorsType\VendorsTypeController@add');
Route::get('/vendorstype/add', 'VendorsType\VendorsTypeController@add');

Route::get('/vendorstype/edit/{id}', 'VendorsType\VendorsTypeController@edit');
Route::post('/vendorstype/edit/{id}', 'VendorsType\VendorsTypeController@edit');



//Vendors
Route::get('/vendors', 'Vendors\VendorsController@index')->name('vendors.index');
Route::post('/getVendors', 'Vendors\VendorsController@getVendors');

Route::post('/vendors/add', 'Vendors\VendorsController@add');
Route::get('/vendors/add', 'Vendors\VendorsController@add');

Route::get('/vendors/edit/{id}', 'Vendors\VendorsController@edit');
Route::post('/vendors/edit/{id}', 'Vendors\VendorsController@edit');