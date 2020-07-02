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

Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard.index')->middleware('access');

//Role module
Route::get('/roles', 'Roles\RolesController@index')->name('roles.index');
// ->middleware('access');
Route::post('/roles/add', 'Roles\RolesController@add');
Route::get('/roles/add', 'Roles\RolesController@add');
Route::post('/getRole', 'Roles\RolesController@getRole');
Route::get('/roles/edit/{id}', 'Roles\RolesController@edit');
Route::post('/roles/edit/{id}', 'Roles\RolesController@edit');


//Common module
Route::post('/duplicateValidation', 'Common\CommonController@duplicateValidation');
Route::post('/mobileDuplicateValidation', 'Common\CommonController@mobileDuplicateValidation');
Route::post('/checkMobileValidation', 'Common\CommonController@checkMobileValidation');
Route::post('/checkNameValidation', 'Common\CommonController@checkNameValidation');
Route::post('/changeStatus', 'Common\CommonController@changeStatus');


//branch type module
Route::get('/branchtype', 'BranchType\BranchTypeController@index')->name('branchtype.index')->middleware('access');
Route::post('/branchtype/add', 'BranchType\BranchTypeController@add');
Route::get('/branchtype/add', 'BranchType\BranchTypeController@add');
Route::post('/getAllBranchType', 'BranchType\BranchTypeController@getAllBranchType');
Route::get('/branchtype/edit/{id}', 'BranchType\BranchTypeController@edit');
Route::post('/branchtype/edit/{id}', 'BranchType\BranchTypeController@edit');

//Item Category module
Route::get('/itemCategory', 'ItemCategory\ItemCategoryController@index')->name('itemCategory.index')->middleware('access');
Route::post('/itemCategory/add', 'ItemCategory\ItemCategoryController@add');
Route::get('/itemCategory/add', 'ItemCategory\ItemCategoryController@add');
Route::post('/getAllItemCategory', 'ItemCategory\ItemCategoryController@getAllItemCategory');
Route::get('/itemCategory/edit/{id}', 'ItemCategory\ItemCategoryController@edit');
Route::post('/itemCategory/edit/{id}', 'ItemCategory\ItemCategoryController@edit');

//unit module
Route::get('/unit', 'Unit\UnitController@index')->name('unit.index')->middleware('access');
Route::post('/unit/add', 'Unit\UnitController@add');
Route::get('/unit/add', 'Unit\UnitController@add');
Route::post('/getAllUnit', 'Unit\UnitController@getAllUnit');
Route::get('/unit/edit/{id}', 'Unit\UnitController@edit');
Route::post('/unit/edit/{id}', 'Unit\UnitController@edit');

//itemType module
Route::get('/itemType', 'ItemType\ItemTypeController@index')->name('itemType.index')->middleware('access');
Route::post('/itemType/add', 'ItemType\ItemTypeController@add');
Route::get('/itemType/add', 'ItemType\ItemTypeController@add');
Route::post('/getAllItemType', 'ItemType\ItemTypeController@getAllItemType');
Route::get('/itemType/edit/{id}', 'ItemType\ItemTypeController@edit');
Route::post('/itemType/edit/{id}', 'ItemType\ItemTypeController@edit');

//Vendorstype
Route::get('/vendorstype', 'VendorsType\VendorsTypeController@index')->name('vendorstype.index')->middleware('access');
Route::post('/getAllVendorType', 'VendorsType\VendorsTypeController@getAllVendorType');
Route::post('/vendorstype/add', 'VendorsType\VendorsTypeController@add');
Route::get('/vendorstype/add', 'VendorsType\VendorsTypeController@add');
Route::get('/vendorstype/edit/{id}', 'VendorsType\VendorsTypeController@edit');
Route::post('/vendorstype/edit/{id}', 'VendorsType\VendorsTypeController@edit');

//Vendors
Route::get('/vendors', 'Vendors\VendorsController@index')->name('vendors.index')->middleware('access');
Route::post('/getVendors', 'Vendors\VendorsController@getVendors');
Route::post('/vendors/add', 'Vendors\VendorsController@add');
Route::get('/vendors/add', 'Vendors\VendorsController@add');
Route::get('/vendors/edit/{id}', 'Vendors\VendorsController@edit');
Route::post('/vendors/edit/{id}', 'Vendors\VendorsController@edit');


//item module
Route::get('/item', 'Item\ItemController@index')->name('item.index')->middleware('access');
Route::post('/item/add', 'Item\ItemController@add');
Route::get('/item/add', 'Item\ItemController@add');
Route::post('/getAllItem', 'Item\ItemController@getAllItem');
Route::get('/item/edit/{id}', 'Item\ItemController@edit');
Route::post('/item/edit/{id}', 'Item\ItemController@edit');
Route::post('/getItemUnit', 'Item\ItemController@getItemUnit');

//user module
Route::get('/user', 'User\UserController@index')->name('user.index')->middleware('access');
Route::post('/user/add', 'User\UserController@add');
Route::get('/user/add', 'User\UserController@add');
Route::post('/getAllUser', 'User\UserController@getAllUser');
Route::get('/user/edit/{id}', 'User\UserController@edit');
Route::post('/user/edit/{id}', 'User\UserController@edit');

//Countries
Route::get('/countries', 'Countries\CountriesController@index')->name('countries.index')->middleware('access');
Route::post('/getAllCountries', 'Countries\CountriesController@getAllCountries');
Route::post('/countries/add', 'Countries\CountriesController@add');
Route::get('/countries/add', 'Countries\CountriesController@add');
Route::get('/countries/edit/{id}', 'Countries\CountriesController@edit');
Route::post('/countries/edit/{id}', 'Countries\CountriesController@edit');

//branches module
Route::get('/branches', 'Branches\BranchesController@index')->name('branches.index')->middleware('access');
Route::post('/branches/add', 'Branches\BranchesController@add');
Route::get('/branches/add', 'Branches\BranchesController@add');
Route::post('/getAllBranches', 'Branches\BranchesController@getAllBranches');
Route::get('/branches/edit/{id}', 'Branches\BranchesController@edit');
Route::post('/branches/edit/{id}', 'Branches\BranchesController@edit');

//login module
Route::get('/login', 'Login\LoginController@index')->name('login.index');
Route::post('/login/validate', 'Login\LoginController@validateEmployee');
Route::match(['get','post'],'/logout', 'Login\LoginController@logout');

//unit Conversion module
Route::get('/unitconversion', 'UnitConversion\UnitConversionController@index')->name('unitconversion.index')->middleware('access');
Route::post('/unitconversion/add', 'UnitConversion\UnitConversionController@add');
Route::get('/unitconversion/add', 'UnitConversion\UnitConversionController@add');
Route::post('/getAllUnitConversion', 'UnitConversion\UnitConversionController@getAllUnitConversion');
Route::get('/unitconversion/edit/{id}', 'UnitConversion\UnitConversionController@edit');
Route::post('/unitconversion/edit/{id}', 'UnitConversion\UnitConversionController@edit');


//Quotes module
Route::get('/quotes', 'Quotes\QuotesController@index')->name('quotes.index')->middleware('access');
Route::post('/getAllQuotes', 'Quotes\QuotesController@getAllQuotes');
Route::get('/quotes/edit/{id}', 'Quotes\QuotesController@edit');
Route::post('/quotes/edit/{id}', 'Quotes\QuotesController@edit');

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

//brand module
Route::get('/brand', 'Brand\BrandController@index')->name('brand.index')->middleware('access');
Route::post('/brand/add', 'Brand\BrandController@add');
Route::get('/brand/add', 'Brand\BrandController@add');
Route::post('/getAllBrand', 'Brand\BrandController@getAllBrand');
Route::get('/brand/edit/{id}', 'Brand\BrandController@edit');
Route::post('/brand/edit/{id}', 'Brand\BrandController@edit');

//rfq module
Route::get('/rfq', 'Rfq\RfqController@index')->name('rfq.index')->middleware('access');
Route::post('/rfq/add', 'Rfq\RfqController@add');
Route::get('/rfq/add', 'Rfq\RfqController@add');
Route::post('/getAllRfq', 'Rfq\RfqController@getAllRfq');
Route::get('/rfq/edit/{id}', 'Rfq\RfqController@edit');
Route::post('/rfq/edit/{id}', 'Rfq\RfqController@edit');
Route::post('/changeQuotesStatus', 'Rfq\RfqController@changeQuotesStatus');

//Purchase Order module
Route::get('/purchaseorder', 'PurchaseOrder\PurchaseOrderController@index')->name('purchaseorder.index')->middleware('access');
Route::post('/purchaseorder/add/{id}', 'PurchaseOrder\PurchaseOrderController@add');
Route::get('/purchaseorder/add/{id}', 'PurchaseOrder\PurchaseOrderController@add');
Route::post('/getAllPurchaseOrder', 'PurchaseOrder\PurchaseOrderController@getAllPurchaseOrder');
Route::get('/purchaseorder/edit/{id}', 'PurchaseOrder\PurchaseOrderController@edit');
Route::post('/purchaseorder/edit/{id}', 'PurchaseOrder\PurchaseOrderController@edit');