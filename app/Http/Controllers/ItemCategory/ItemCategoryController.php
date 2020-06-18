<?php

namespace App\Http\Controllers\ItemCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ItemCategoryService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class ItemCategoryController extends Controller
{
    //View ItemCategory main screen
    public function index()
    {
        // if(session('login')==true)
        // {
            return view('itemCategory.index');
        // }
        // else
        //     return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add ItemCategory (display add screen and add the ItemCategory values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new ItemCategoryService();
            $add = $service->saveItemCategory($request);
            return Redirect::route('itemCategory.index')->with('status', $add);
        }
        else
        {
            return view('itemCategory.add');
        }
    }

    // Get all the ItemCategory list
    public function getAllItemCategory(Request $request)
    {
        $service = new ItemCategoryService();
        $data = $service->getAllItemCategory();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        // if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                           $button .= '<a href="/itemCategory/edit/'. base64_encode($data->item_category_id).'" name="edit" id="'.$data->item_category_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        // }else{
                        //     $button .= '';
                        // }
                        if($data->item_category_status == 'active'){
                            $buttonStatus="changeStatus('item_categories','item_category_id',$data->item_category_id,'item_category_status', 'inactive', 'itemCategoryList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->item_category_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('item_categories','item_category_id',$data->item_category_id,'item_category_status', 'active', 'itemCategoryList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->item_category_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
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
            $service = new ItemCategoryService();
            $edit = $service->updateItemCategory($request,$id);
            return Redirect::route('itemCategory.index')->with('status', $edit);
        }
        else
        {
            $service = new ItemCategoryService();
            $result = $service->getItemCategoryById($id);
            return view('itemCategory.edit',array('result'=>$result));
        }
    }
}
