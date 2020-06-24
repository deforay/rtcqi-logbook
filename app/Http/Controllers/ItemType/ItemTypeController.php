<?php

namespace App\Http\Controllers\ItemType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ItemTypeService;
use App\Service\ItemCategoryService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class ItemTypeController extends Controller
{
    //View ItemType main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('itemType.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add ItemType (display add screen and add the ItemType values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new ItemTypeService();
            $add = $service->saveItemType($request);
            return Redirect::route('itemType.index')->with('status', $add);
        }
        else
        {
            $service = new ItemCategoryService();
            $itemCategory = $service->getAllActiveItemCategory($request);
            return view('itemType.add',array('itemCategory'=>$itemCategory));
        }
    }

    // Get all the ItemType list
    public function getAllItemType(Request $request)
    {
        $service = new ItemTypeService();
        $data = $service->getAllItemType();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\ItemType\\ItemTypeController']['edit']) && ($role['App\\Http\\Controllers\\ItemType\\ItemTypeController']['edit'] == "allow")){
                           $button .= '<a href="/itemType/edit/'. base64_encode($data->item_type_id).'" name="edit" id="'.$data->item_type_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        }else{
                            $button .= '';
                        }
                        if($data->item_type_status == 'active'){
                            $buttonStatus="changeStatus('item_types','item_type_id',$data->item_type_id,'item_type_status', 'inactive', 'itemTypeList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->item_type_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('item_types','item_type_id',$data->item_type_id,'item_type_status', 'active', 'itemTypeList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->item_type_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit item type
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new ItemTypeService();
            $edit = $service->updateItemType($request,$id);
            return Redirect::route('itemType.index')->with('status', $edit);
        }
        else
        {
            $service = new ItemTypeService();
            $result = $service->getItemTypeById($id);
            $itemCategoryService = new ItemCategoryService();
            $itemCategory = $itemCategoryService->getAllActiveItemCategory($request);
            return view('itemType.edit',array('result'=>$result, 'itemCategory'=>$itemCategory));
        }
    }
}
