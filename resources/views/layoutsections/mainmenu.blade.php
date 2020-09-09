<?php

use Illuminate\Support\Facades\Request;

$role = session('role');
// dd($role);
$dashboard = '';
$manage = '';
$item = '';
$procurement = '';
$report = '';
$inventory='';

if (isset($role['App\Http\Controllers\Dashboard\DashboardController']['index']) && ($role['App\Http\Controllers\Dashboard\DashboardController']['index'] == "allow"))
    $dashboard = '<li class=" nav-item" id="dashboard"><a href="/dashboard"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a></li>';

if ((isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\User\\UserController']['index']) && ($role['App\\Http\\Controllers\\User\\UserController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\BranchType\\BranchTypeController']['index']) && ($role['App\\Http\\Controllers\\BranchType\\BranchTypeController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Branches\\BranchesController']['index']) && ($role['App\\Http\\Controllers\\Branches\\BranchesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Countries\\CountriesController']['index']) && ($role['App\\Http\\Controllers\\Countries\\CountriesController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Vendors\\VendorsController']['index']) && ($role['App\\Http\\Controllers\\Vendors\\VendorsController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\VendorsType\\VendorsTypeController']['index']) && ($role['App\\Http\\Controllers\\VendorsType\\VendorsTypeController']['index'] == "allow"))) {
    $manage .= '<li class=" nav-item" id="manage"><a href="javascript:void(0)"><i class="la la-toggle-down"></i><span class="menu-title">Manage</span></a>
                <ul class="menu-content">';
    if (isset($role['App\Http\Controllers\Roles\RolesController']['index']) && ($role['App\Http\Controllers\Roles\RolesController']['index'] == "allow")){
        $manage .= '<li id="li-roles"><a class="menu-item" href="/roles">Roles</a></li>';
    }
    if (isset($role['App\Http\Controllers\User\UserController']['index']) && ($role['App\Http\Controllers\User\UserController']['index'] == "allow")){
        $manage .= '<li id="li-user"><a class="menu-item" href="/user/">User</a></li>';
    }
    if (isset($role['App\Http\Controllers\BranchType\BranchTypeController']['index']) && ($role['App\Http\Controllers\BranchType\BranchTypeController']['index'] == "allow")){
        $manage .= '<li id="li-li-branchtype"><a class="menu-item" href="/branchtype/">Location Type</a></li>';
    }
    if (isset($role['App\Http\Controllers\Branches\BranchesController']['index']) && ($role['App\Http\Controllers\Branches\BranchesController']['index'] == "allow")){
        $manage .= '<li id="li-li-branches"><a class="menu-item" href="/branches/">Locations</a></li>';
    }
    if (isset($role['App\Http\Controllers\Countries\CountriesController']['index']) && ($role['App\Http\Controllers\Countries\CountriesController']['index'] == "allow"))
        $manage .= '<li id="li-countries"><a class="menu-item" href="/countries/">Countries</a></li>';

    if (isset($role['App\Http\Controllers\Vendors\VendorsController']['index']) && ($role['App\Http\Controllers\Vendors\VendorsController']['index'] == "allow"))
        $manage .= '<li id="li-vendors"><a class="menu-item" href="/vendors/">Vendors</a></li>';

    if (isset($role['App\Http\Controllers\VendorsType\VendorsTypeController']['index']) && ($role['App\Http\Controllers\VendorsType\VendorsTypeController']['index'] == "allow"))
        $manage .= '<li id="li-vendorstype"><a class="menu-item" href="/vendorstype/">Vendors Type</a></li>';

    if (isset($role['App\\Http\\Controllers\\MailTemplate\\MailTemplateController']['index']) && ($role['App\\Http\\Controllers\\MailTemplate\\MailTemplateController']['index'] == "allow"))
        $manage .= '<li id="li-mailtemplate"><a class="menu-item" href="/mailtemplate/">Mail Template</a></li>';

    if (isset($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index']) && ($role['App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController']['index'] == "allow"))
        $manage .= '<li id="li-globalconfig"><a class="menu-item" href="/globalconfig/">Global Config</a></li>';

    if (isset($role['App\Http\Controllers\Item\ItemController']['index']) && ($role['App\Http\Controllers\Item\ItemController']['index'] == "allow"))
        $manage .= '<li id="li-item"><a class="menu-item" href="/item/" >Item</a>
        </li>';
    $manage .= '</ul></li>';
}


if ((isset($role['App\\Http\\Controllers\\ItemCategory\\ItemCategoryController']['index']) && ($role['App\\Http\\Controllers\\ItemCategory\\ItemCategoryController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\ItemType\\ItemTypeController']['index']) && ($role['App\\Http\\Controllers\\ItemType\\ItemTypeController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Unit\\UnitController']['index']) && ($role['App\\Http\\Controllers\\Unit\\UnitController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\UnitConversion\\UnitConversionController']['index']) && ($role['App\\Http\\Controllers\\UnitConversion\\UnitConversionController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Brand\\BrandController']['index']) && ($role['App\\Http\\Controllers\\Brand\\BrandController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Item\\ItemController']['index']) && ($role['App\\Http\\Controllers\\Item\\ItemController']['index'] == "allow")) ) {
    $item .= '<li class=" nav-item" id="item"><a href="javascript:void(0)"><i class="la la-toggle-down"></i><span class="menu-title" data-i18n="nav.item.main">Item</span></a>
                <ul class="menu-content">';
    if (isset($role['App\Http\Controllers\ItemCategory\ItemCategoryController']['index']) && ($role['App\Http\Controllers\ItemCategory\ItemCategoryController']['index'] == "allow"))
        $item .= '<li id="li-itemCategory"><a class="menu-item" href="/itemCategory/" >Item Category</a>
        </li>';
    if (isset($role['App\Http\Controllers\ItemType\ItemTypeController']['index']) && ($role['App\Http\Controllers\ItemType\ItemTypeController']['index'] == "allow"))
        $item .= '<li id="li-itemType"><a class="menu-item" href="/itemType/" >Item Type</a>
        </li>';
    if (isset($role['App\Http\Controllers\Unit\UnitController']['index']) && ($role['App\Http\Controllers\Unit\UnitController']['index'] == "allow"))
        $item .= '<li id="li-unit"><a class="menu-item" href="/unit/" >Unit</a>
        </li>';
    if (isset($role['App\Http\Controllers\UnitConversion\UnitConversionController']['index']) && ($role['App\Http\Controllers\UnitConversion\UnitConversionController']['index'] == "allow"))
        $item .= '<li id="li-unitconversion"><a class="menu-item" href="/unitconversion/" >Unit Conversion</a>
        </li>';
    if (isset($role['App\Http\Controllers\Brand\BrandController']['index']) && ($role['App\Http\Controllers\Brand\BrandController']['index'] == "allow"))
        $item .= '<li id="li-brand"><a class="menu-item" href="/brand/" >Brand</a>
        </li>';
        $item .= '</ul></li>';
}

if ((isset($role['App\\Http\\Controllers\\Rfq\\RfqController']['index']) && ($role['App\\Http\\Controllers\\Rfq\\RfqController']['index'] == "allow")) || (isset($role['App\Http\Controllers\Quotes\QuotesController']['index']) && ($role['App\Http\Controllers\Quotes\QuotesController']['index'] == "allow")) || (isset($role['App\Http\Controllers\PurchaseOrder\PurchaseOrderController']['index']) && ($role['App\Http\Controllers\PurchaseOrder\PurchaseOrderController']['index'] == "allow"))) {
    $procurement .= '<li class=" nav-item" id="procurement"><a href="javascript:void(0)"><i class="la la-toggle-down"></i><span class="menu-title" data-i18n="nav.item.main">Procurement</span></a>
                        <ul class="menu-content">';

    if (isset($role['App\Http\Controllers\Rfq\RfqController']['index']) && ($role['App\Http\Controllers\Rfq\RfqController']['index'] == "allow"))
        $procurement .= '<li id="li-rfq"><a class="menu-item" href="/rfq/" >RFQ</a>
        </li>';
    if (isset($role['App\Http\Controllers\Quotes\QuotesController']['index']) && ($role['App\Http\Controllers\Quotes\QuotesController']['index'] == "allow"))
        $procurement .= '<li id="li-quotes"><a class="menu-item" href="/quotes/" >Quotes</a></li>';
    if (isset($role['App\Http\Controllers\PurchaseOrder\PurchaseOrderController']['index']) && ($role['App\Http\Controllers\PurchaseOrder\PurchaseOrderController']['index'] == "allow"))
        $procurement .= '<li id="li-purchaseorder"><a class="menu-item" href="/purchaseorder/" >Purchase Order</a></li>';
    if (isset($role['App\Http\Controllers\DeliverySchedule\DeliveryScheduleController']['index']) && ($role['App\Http\Controllers\DeliverySchedule\DeliveryScheduleController']['index'] == "allow"))
        $procurement .= '<li id="li-deliveryschedule"><a class="menu-item" href="/deliveryschedule/" >Delivery Schedule</a></li>';
    if (isset($role['App\Http\Controllers\DeliverySchedule\DeliveryScheduleController']['itemreceive']) && ($role['App\Http\Controllers\DeliverySchedule\DeliveryScheduleController']['itemreceive'] == "allow"))
        $procurement .= '<li id="li-itemreceive"><a class="menu-item" href="/itemreceive/" >Receive Deliveries</a></li>';
    // if (isset($role['App\Http\Controllers\InventoryOutwards\InventoryOutwardsController']['index']) && ($role['App\Http\Controllers\InventoryOutwards\InventoryOutwardsController']['index'] == "allow"))
    //     $procurement .= '<li id="li-inventoryoutwards"><a class="menu-item" href="/inventoryoutwards/" >Issue Items</a></li>';
    $procurement .= '</ul></li>';

}
if ((isset($role['App\Http\Controllers\InventoryOutwards\InventoryOutwardsController']['index']))) {
    $inventory .= '<li class=" nav-item" id="inventory"><a href="javascript:void(0)"><i class="la la-toggle-down"></i><span class="menu-title" data-i18n="nav.item.main">Inventory</span></a>
                        <ul class="menu-content">';
    if (isset($role['App\Http\Controllers\InventoryOutwards\InventoryOutwardsController']['index']) && ($role['App\Http\Controllers\InventoryOutwards\InventoryOutwardsController']['index'] == "allow"))
    $inventory .= '<li id="li-inventoryoutwards"><a class="menu-item" href="/inventoryoutwards/" >Issue Items</a></li>';
    $inventory .= '</ul></li>';

}
if (isset($role['App\Http\Controllers\Report\ReportController']['inventoryReport']) && ($role['App\Http\Controllers\Report\ReportController']['inventoryReport'] == "allow")){
    $report .= '<li class=" nav-item" id="report"><a href="javascript:void(0)"><i class="la la-toggle-down"></i><span class="menu-title" data-i18n="nav.item.main">Report</span></a>
                    <ul class="menu-content">';
    if (isset($role['App\Http\Controllers\Report\ReportController']['inventoryReport']) && ($role['App\Http\Controllers\Report\ReportController']['inventoryReport'] == "allow"))
        $report .= '<li id="li-inventoryReport"><a class="menu-item" href="/inventoryReport/" >Inventory Report</a></li>';
    $report .= '</ul></li>';
}

?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-border" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        @php echo $dashboard; @endphp
        @php echo $manage; @endphp
        @php echo $item; @endphp
        @php echo $procurement; @endphp
        @php echo $inventory; @endphp
        @php echo $report; @endphp
      </ul>
    </div>
  </div>
