<?php

namespace App\Http\Controllers\RequestItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\RequestItemService;
use App\Service\ItemService;
use Yajra\DataTables\Facades\DataTables;
use App\Service\BranchesService;
use Redirect;
use View;

class RequestItemController extends Controller
{
    //View Request Item main screen
    public function index(Request $request)
    {
        if(session('login')==true)
        {
            return view('requestitem.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new RequestItemService();
            $add = $service->saveRequestItem($request);
            return Redirect::route('requestitem.add')->with('status', $add);
        }
        else
        {
            $branchService = new BranchesService();
            $branch = $branchService->getBranchesByUser();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            return view('requestitem.add',array('branch'=>$branch,'item'=>$item));
        }
    }

    public function getRequestItemByLogin(Request $request)
    {
        $service = new RequestItemService();
        $data = $service->getRequestItemByLogin();
        // print_r($data);die;
        return DataTables::of($data)
                    ->editColumn('requested_on', function($data){
                            $issuedOn = $data->requested_on;
                            if($issuedOn){
                                // $issuedOn = date("d-M-Y", strtotime($issuedOn));
                                return $issuedOn;
                            }
                    })
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                      
                        if (isset($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['edit']) && ($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['edit'] == "allow")){
                            $button .= '&nbsp;&nbsp;&nbsp;<a href="/requestitem/edit/'. base64_encode($data->requested_item_id).'" name="edit" id="'.$data->requested_item_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        }else{
                            $button .= '';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new RequestItemService();
            $edit = $service->updateRequestItem($request,$id);
            return Redirect::route('requestitem.index')->with('status', $edit);
        }
        else
        {
            $service = new RequestItemService();
            $result = $service->getRequestItemById($id);
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $branchService = new BranchesService();
            $branch = $branchService->getAllActiveBranches();
            // dd($result);
            return view('requestitem.edit',array('result'=>$result,'item'=>$item,'branch'=>$branch));
        }
    }

}
