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
            if ($request->isMethod('post')) 
            {
                $service = new RequestItemService();
                $add = $service->saveRequestItem($request);
                return Redirect::route('requestitem.index')->with('status', $add);
            }
            else
            {
                $branchService = new BranchesService();
                $branch = $branchService->getBranchesByUser();
                $itemservice = new ItemService();
                $item = $itemservice->getAllActiveItem();
                return view('requestitem.index',array('branch'=>$branch,'item'=>$item));
            }
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }
}
