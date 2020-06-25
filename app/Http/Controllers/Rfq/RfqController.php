<?php

namespace App\Http\Controllers\Rfq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\RfqService;
use App\Service\VendorsService;
use App\Service\ItemService;
use App\Service\UnitService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;

class RfqController extends Controller
{
    //View rfq main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('rfq.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add rfq (display add screen and add the rfq values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $service = new RfqService();
            $add = $service->saveRfq($request);
            return Redirect::route('rfq.index')->with('status', $add);
        }
        else
        {
            $service = new VendorsService();
            $vendor = $service->getAllActiveVendors();
            $itemservice = new ItemService();
            $item = $itemservice->getAllItem();
            $uomservice = new UnitService();
            $uom = $uomservice->getAllActiveUnit();
            return view('rfq.add',array('vendor'=>$vendor,'item'=>$item,'uom'=>$uom));
        }
    }

    // Get all the Rfq list
    public function getAllRfq(Request $request)
    {
        $service = new RfqService();
        $data = $service->getAllRfq();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Rfq\\RfqController']['edit']) && ($role['App\\Http\\Controllers\\Rfq\\RfqController']['edit'] == "allow")){
                           $button .= '<a href="/rfq/edit/'. base64_encode($data->uom_id).'" name="edit" id="'.$data->uom_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        }else{
                            $button .= '';
                        }
                        if($data->Rfq_status == 'active'){
                            $buttonStatus="changeStatus('Rfqs_of_measure','uom_id',$data->uom_id,'Rfq_status', 'inactive', 'RfqList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->uom_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                        }else{
                            $buttonStatus="changeStatus('Rfqs_of_measure','uom_id',$data->uom_id,'Rfq_status', 'active', 'RfqList')";
                           $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus'.$data->uom_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-success btn-sm">Change to Active</button>';
                        }
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit Rfq
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $service = new RfqService();
            $edit = $service->updateRfq($request,$id);
            return Redirect::route('rfq.index')->with('status', $edit);
        }
        else
        {
            $service = new RfqService();
            $result = $service->getRfqById($id);
            return view('rfq.edit',array('result'=>$result));
        }
    }
}
