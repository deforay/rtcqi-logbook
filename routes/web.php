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

//Item Category module
Route::get('/itemCategory', 'ItemCategory\ItemCategoryController@index')->name('itemCategory.index');
Route::post('/itemCategory/add', 'ItemCategory\ItemCategoryController@add');
Route::get('/itemCategory/add', 'ItemCategory\ItemCategoryController@add');
Route::post('/getAllItemCategory', 'ItemCategory\ItemCategoryController@getAllItemCategory');
Route::get('/itemCategory/edit/{id}', 'ItemCategory\ItemCategoryController@edit');
Route::post('/itemCategory/edit/{id}', 'ItemCategory\ItemCategoryController@edit');

//unit module
Route::get('/unit', 'Unit\UnitController@index')->name('unit.index');
Route::post('/unit/add', 'Unit\UnitController@add');
Route::get('/unit/add', 'Unit\UnitController@add');
Route::post('/getAllUnit', 'Unit\UnitController@getAllUnit');
Route::get('/unit/edit/{id}', 'Unit\UnitController@edit');
Route::post('/unit/edit/{id}', 'Unit\UnitController@edit');