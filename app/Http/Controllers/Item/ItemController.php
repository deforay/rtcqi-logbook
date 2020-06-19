<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ItemService;
use App\Service\UnitService;
use App\Service\BrandService;
use App\Service\ItemTypeService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class ItemController extends Controller
{
    //View Item main screen
    public function index()
    {
        // if(session('login')==true)
        // {
            return view('item.index');
        // }
        // else
        //     return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Item (display add screen and add the Item values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new ItemService();
            $add = $service->saveItem($request);
            return Redirect::route('item.index')->with('status', $add);
        }
        else
        {
            $brandService = new BrandService();
            $brand = $brandService->getAllActiveBrand();
            $unitService = new UnitService();
            $unit = $unitService->getAllActiveUnit();
            $service = new ItemTypeService();
            $itemType = $service->getAllActiveItemType($request);
            return view('item.add',array('itemType'=>$itemType, 'brand'=>$brand, 'unit'=>$unit));
        }
    }

    // Get all the Item list
    public function getAllItem(Request $request)
    {
        $service = new ItemService();
        $data = $service->getAllItem();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div >';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/item/edit/'. base64_encode($data->item_id).'" name="edit" id="'.$data->item_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit roles
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new ItemService();
            $edit = $service->updateItem($request,$id);
            return Redirect::route('item.index')->with('status', $edit);
        }
        else
        {
            $service = new ItemService();
            $result = $service->getItemById($id);
            $brandService = new BrandService();
            $brand = $brandService->getAllActiveBrand();
            $unitService = new UnitService();
            $unit = $unitService->getAllActiveUnit();
            $itemTypeService = new ItemTypeService();
            $itemType = $itemTypeService->getAllActiveItemType($request);
            return view('item.edit',array('result'=>$result, 'itemType'=>$itemType, 'brand'=>$brand, 'unit'=>$unit));
        }
    }
}
