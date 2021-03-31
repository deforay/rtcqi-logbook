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
            return Redirect::route('requestitem.index')->with('status', $add);
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
        return DataTables::of($data)
                    ->editColumn('requested_on', function($data){
                            $issuedOn = $data->requested_on;
                            if($issuedOn){
                                // $issuedOn = date("d-M-Y", strtotime($issuedOn));
                                return $issuedOn;
                            }
                    })
                    ->editColumn('request_item_status', function($data){
                        $request_item_status = $data->request_item_status;
                        $sts = "<div>";
                        if($request_item_status == "pending"){
                            $sts .= '<span class="badge badge-warning"><strong>'.ucfirst($request_item_status).'</strong></span>';
                        }
                        else if($request_item_status == "approved"){
                            $sts .= '<span class="badge badge-success"><strong>'.ucfirst($request_item_status).'</strong></span>';
                        }
                        else if($request_item_status == "declined"){
                            $sts .= '<span class="badge badge-danger"><strong>'.ucfirst($request_item_status).'</strong></span>';
                        }
                        $sts .= "</div>";
                        return $sts;
                    })
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        $approveStatus = "changeApproveStatus($data->request_id,'approved', 'ReqList')";
                        $declineStatus = "changeApproveStatus($data->request_id,'declined', 'ReqList')";
                        
                        if($data->request_item_status == 'pending'){
                            if (isset($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['edit']) && ($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['edit'] == "allow")){
                                $button .= '&nbsp;&nbsp;&nbsp;<a href="/requestitem/edit/'. base64_encode($data->request_id).'" name="edit" id="'.$data->request_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            }else{
                                $button .= '';
                            }
                        }

                            if (isset($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem']) && ($role['App\\Http\\Controllers\\RequestItem\\RequestItemController']['approverequestitem'] == "allow")){
                                $button .= '&nbsp;&nbsp;<a href="/requestitem/updateStatus/'. base64_encode($data->request_id).'" name="updateSts" id="'.$data->request_id.'" class="btn btn-outline-info btn-sm" title="Approve/Decline">Approve/Decline</a>';
                                // $button .= '&nbsp;&nbsp;<button onclick="'.$declineStatus.'" name="edit" id="'.$data->request_id.'" class="btn btn-outline-danger btn-sm" title="Decline"><i class="ft-x"></i></button>';
                            }else{
                                $button .= '';
                            }
                        // }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['request_item_status','action'])
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
            $rejReason = $service->getRejectionReason();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $branchService = new BranchesService();
            $branch = $branchService->getAllActiveBranches();
            // dd($rejReason);
            return view('requestitem.edit',array('result'=>$result,'item'=>$item,'branch'=>$branch,'rejReason'=>$rejReason));
        }
    }

    public function updateStatus(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new RequestItemService();
            // dd(($id));
            $msg = "";
            $edit = $service->changeApproveStatus($request,$id);
            if($edit){
                $msg = "Status Updated Successfully!";
            }
            return Redirect::route('requestitem.index')->with('status', $msg);
        }
        else
        {
            $service = new RequestItemService();
            $result = $service->getRequestItemById($id);
            $rejReason = $service->getRejectionReason();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $branchService = new BranchesService();
            $branch = $branchService->getAllActiveBranches();
            // dd($id);
            return view('requestitem.updatestatus',array('result'=>$result,'item'=>$item,'branch'=>$branch,'rejReason'=>$rejReason,'id'=>$id));
        }
    }

    public function changeApproveStatus(Request $request)
    {
        $service = new RequestItemService();
        $data = $service->changeApproveStatus($request);
        return $data;
    }

}
