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


//branch type module
Route::get('/branchtype', 'BranchType\BranchTypeController@index')->name('branchtype.index');
Route::post('/branchtype/add', 'BranchType\BranchTypeController@add');
Route::get('/branchtype/add', 'BranchType\BranchTypeController@add');
Route::post('/getAllBranchType', 'BranchType\BranchTypeController@getAllBranchType');
Route::get('/branchtype/edit/{id}', 'BranchType\BranchTypeController@edit');
Route::post('/branchtype/edit/{id}', 'BranchType\BranchTypeController@edit');