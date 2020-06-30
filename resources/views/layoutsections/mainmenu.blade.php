<?php

use Illuminate\Support\Facades\Request;

$role = session('role');
$dashboard = '';
$manage = '';
$item = '';

if (isset($role['App\Http\Controllers\Dashboard\DashboardController']['index']) && ($role['App\Http\Controllers\Dashboard\DashboardController']['index'] == "allow"))
    $dashboard = '<li  class="dropdown nav-item" id="dashboard" ><a class="dropdown-item single" href="/dashboard" data-toggle=""><i class="la la-home white"></i><span data-i18n="dashboard" class="white" >Dashboard</span></a></li>';

if ((isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\User\\UserController']['index']) && ($role['App\\Http\\Controllers\\User\\UserController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\BranchType\\BranchTypeController']['index']) && ($role['App\\Http\\Controllers\\BranchType\\BranchTypeController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Branches\\BranchesController']['index']) && ($role['App\\Http\\Controllers\\Branches\\BranchesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Countries\\CountriesController']['index']) && ($role['App\\Http\\Controllers\\Countries\\CountriesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Vendors\\VendorsController']['index']) && ($role['App\\Http\\Controllers\\Vendors\\VendorsController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\VendorsType\\VendorsTypeController']['index']) && ($role['App\\Http\\Controllers\\VendorsType\\VendorsTypeController']['index'] == "allow"))) {
    $manage .= '<li class="dropdown nav-item" data-menu="dropdown" id="manage"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-cogs"></i><span data-i18n="Templates">Manage</span></a>
                <ul class="dropdown-menu">';
    if (isset($role['App\Http\Controllers\Roles\RolesController']['index']) && ($role['App\Http\Controllers\Roles\RolesController']['index'] == "allow"))
        $manage .= '<li data-menu=""><a class="dropdown-item" href="/roles/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Role</span></span></a></li>';
    if (isset($role['App\Http\Controllers\User\UserController']['index']) && ($role['App\Http\Controllers\User\UserController']['index'] == "allow"))
        $manage .= '<li data-menu=""><a class="dropdown-item" href="/user/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>User</span></span></a></li>';
    if (isset($role['App\Http\Controllers\BranchType\BranchTypeController']['index']) && ($role['App\Http\Controllers\BranchType\BranchTypeController']['index'] == "allow"))
        $manage .= '<li data-menu=""><a class="dropdown-item" href="/branchtype/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Branch Type</span></span></a></li>';
    if (isset($role['App\Http\Controllers\Branches\BranchesController']['index']) && ($role['App\Http\Controllers\Branches\BranchesController']['index'] == "allow"))
        $manage .= ' <li data-menu=""><a class="dropdown-item" href="/branches/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Branches</span></span></a></li>';
    if (isset($role['App\Http\Controllers\Countries\CountriesController']['index']) && ($role['App\Http\Controllers\Countries\CountriesController']['index'] == "allow"))
        $manage .= ' <li data-menu=""><a class="dropdown-item" href="/countries/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Countries</span></span></a></li>';
    if (isset($role['App\Http\Controllers\Vendors\VendorsController']['index']) && ($role['App\Http\Controllers\Vendors\VendorsController']['index'] == "allow"))
        $manage .= '<li data-menu=""><a class="dropdown-item" href="/vendors/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Vendors</span></span></a></li>';
    if (isset($role['App\Http\Controllers\VendorsType\VendorsTypeController']['index']) && ($role['App\Http\Controllers\VendorsType\VendorsTypeController']['index'] == "allow"))
        $manage .= '<li data-menu=""><a class="dropdown-item" href="/vendorstype/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Vendors Type</span></span></a></li>';
    $manage .= '</ul></li>';
}

if ((isset($role['App\\Http\\Controllers\\ItemCategory\\ItemCategoryController']['index']) && ($role['App\\Http\\Controllers\\ItemCategory\\ItemCategoryController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\ItemType\\ItemTypeController']['index']) && ($role['App\\Http\\Controllers\\ItemType\\ItemTypeController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Unit\\UnitController']['index']) && ($role['App\\Http\\Controllers\\Unit\\UnitController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\UnitConversion\\UnitConversionController']['index']) && ($role['App\\Http\\Controllers\\UnitConversion\\UnitConversionController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Brand\\BrandController']['index']) && ($role['App\\Http\\Controllers\\Brand\\BrandController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Item\\ItemController']['index']) && ($role['App\\Http\\Controllers\\Item\\ItemController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Rfq\\RfqController']['index']) && ($role['App\\Http\\Controllers\\Rfq\\RfqController']['index'] == "allow"))) {
    $item .= ' <li class="dropdown nav-item" data-menu="dropdown" id="item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="ft-life-buoy"></i><span data-i18n="Templates">Item</span></a>
                <ul class="dropdown-menu">';
    if (isset($role['App\Http\Controllers\Item\ItemController']['index']) && ($role['App\Http\Controllers\Item\ItemController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/item/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Item</span></span></a>
        </li>';
    if (isset($role['App\Http\Controllers\ItemCategory\ItemCategoryController']['index']) && ($role['App\Http\Controllers\ItemCategory\ItemCategoryController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/itemCategory/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Item Category</span></span></a>
        </li>';
    if (isset($role['App\Http\Controllers\ItemType\ItemTypeController']['index']) && ($role['App\Http\Controllers\ItemType\ItemTypeController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/itemType/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Item Type</span></span></a>
        </li>';
    if (isset($role['App\Http\Controllers\Unit\UnitController']['index']) && ($role['App\Http\Controllers\Unit\UnitController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/unit/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Unit</span></span></a>
        </li>';
    if (isset($role['App\Http\Controllers\UnitConversion\UnitConversionController']['index']) && ($role['App\Http\Controllers\UnitConversion\UnitConversionController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/unitconversion/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Unit Conversion</span></span></a>
        </li>';
    if (isset($role['App\Http\Controllers\Brand\BrandController']['index']) && ($role['App\Http\Controllers\Brand\BrandController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/brand/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Brand</span></span></a>
        </li>';
    if (isset($role['App\Http\Controllers\Rfq\RfqController']['index']) && ($role['App\Http\Controllers\Rfq\RfqController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/rfq/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>RFQ</span></span></a>
        </li>';
    if (isset($role['App\Http\Controllers\Quotes\QuotesController']['index']) && ($role['App\Http\Controllers\Quotes\QuotesController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/quotes/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Quotes</span></span></a></li>';
    if (isset($role['App\Http\Controllers\PurchaseOrder\PurchaseOrderController']['index']) && ($role['App\Http\Controllers\PurchaseOrder\PurchaseOrderController']['index'] == "allow"))
        $item .= '<li data-menu=""><a class="dropdown-item" href="/purchaseorder/" data-toggle=""><span data-i18n="Collapsed Menu"><i class="ft-chevrons-right"></i><span>Purchase Order</span></span></a></li>';
    $item .= '</ul></li>';
}

?>
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content " data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            @php echo $dashboard; @endphp
            @php echo $manage; @endphp
            @php echo $item; @endphp
        </ul>
    </div>
</div>