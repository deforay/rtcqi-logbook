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
use View;

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
            $item = $itemservice->getAllActiveItem();
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
        // dd($data);
        return DataTables::of($data)
                    ->editColumn('rfq_issued_on', function($data){
                            $issuedOn = $data->rfq_issued_on;
                            if($issuedOn){
                                $issuedOn = date("d-M-Y", strtotime($issuedOn));
                                return $issuedOn;
                            }
                    })
                    ->editColumn('last_date', function($data){
                            $lastDate = $data->last_date;
                            if($lastDate){
                                $lastDate = date("d-M-Y", strtotime($lastDate));
                                return $lastDate;
                            }
                    })
                    ->addColumn('action', function($data){
                        // $button = '<div style="width: 180px;">';
                        $button = '';
                        $role = session('role');
                        // $closeStatus="changeStatus('rfq','rfq_id',$data->rfq_id,'rfq_status', 'closed', 'RfqList');";
                        $closeStatus = "changeQuotesStatus('rfq','rfq_id',$data->rfq_id,'rfq_status', 'closed', 'RfqList')";
                        if($data->rfq_status == 'draft'){
                            // $buttonStatus="changeStatus('rfq','rfq_id',$data->rfq_id,'rfq_status', 'active', 'RfqList');";
                            $buttonStatus ="changeQuotesStatus('rfq','rfq_id',$data->rfq_id,'rfq_status', 'active', 'RfqList')";
                            $button .= '<button type="button" name="changeStatus" id="changeStatus'.$data->rfq_id.'" onclick="'.$buttonStatus.'" class="btn btn-outline-warning btn-sm">Activate</button>&nbsp;&nbsp;';
                            $button .= '<button type="button" name="closeStatus" id="closeStatus'.$data->rfq_id.'" onclick="'.$closeStatus.'" class="btn btn-outline-warning btn-sm">Change to Close</button>&nbsp;&nbsp;';
                            if (isset($role['App\\Http\\Controllers\\Rfq\\RfqController']['edit']) && ($role['App\\Http\\Controllers\\Rfq\\RfqController']['edit'] == "allow")){
                            $button .= '<a href="/rfq/edit/'. base64_encode($data->rfq_id).'" name="edit" id="'.$data->rfq_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            }else{
                                $button .= '';
                            }
                        }else if($data->rfq_status == 'active'){
                            $button .= '<button type="button" name="closeStatus" id="closeStatus'.$data->rfq_id.'" onclick="'.$closeStatus.'" class="btn btn-outline-warning btn-sm">Change to Close</button>&nbsp;&nbsp;';
                            if (isset($role['App\\Http\\Controllers\\Rfq\\RfqController']['edit']) && ($role['App\\Http\\Controllers\\Rfq\\RfqController']['edit'] == "allow")){
                                $button .= '<a href="/rfq/edit/'. base64_encode($data->rfq_id).'" name="edit" id="'.$data->rfq_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            }else{
                                $button .= '';
                            }
                        }

                        $button .= '<div class = "row">';
                        $button .= '<div class = "col-md-6 mt-1">
                        <button type="button" name="rfqDetails" id="rfqDetails" class="btn btn-success btn-sm" onclick="showAjaxModal(\'/rfqDetailsView/'.base64_encode($data->rfq_id).'\' );" title="RFQ Details"><b><i class="la la-eye"></i></b></button></div></div>';

                        // $button .= '</div>';
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
            $vendorservice = new VendorsService();
            $vendor = $vendorservice->getAllActiveVendors();
            $itemservice = new ItemService();
            $item = $itemservice->getAllActiveItem();
            $uomservice = new UnitService();
            $uom = $uomservice->getAllActiveUnit();
            $service = new RfqService();
            $result = $service->getRfqById($id);
            // dd($result);
            return view('rfq.edit',array('result'=>$result,'vendor'=>$vendor,'item'=>$item,'uom'=>$uom));
        }
    }

    public function changeQuotesStatus(Request $request)
    {
        $rfqService = new RfqService();
        $data = $rfqService->changeQuotesStatus($request);
        return $data;
    }

    public function rfqDetailsView($id,Request $request){
        $vendorservice = new VendorsService();
        $vendor = $vendorservice->getAllActiveVendors();
        $itemservice = new ItemService();
        $item = $itemservice->getAllActiveItem();
        $uomservice = new UnitService();
        $uom = $uomservice->getAllActiveUnit();
        $service = new RfqService();
        $result = $service->getRfqById($id);
        $view = View::make('rfq.rfqDetailsViewModal', ['rfqId'=>$id,'result'=>$result,'vendor'=>$vendor,'item'=>$item,'uom'=>$uom]);
        $contents = (string) $view;
        return $contents;
    }
}
