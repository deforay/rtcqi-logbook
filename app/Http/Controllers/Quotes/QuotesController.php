<?php
/*
Author             : Sriram V
Date               : 25 June 2020
Description        : Quotes Controller Page
Last Modified Date : 
Last Modified Name : 
*/
namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\QuotesService;
use App\Service\RfqService;
use App\Service\ItemService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;
use View;

class QuotesController extends Controller
{
    //View Quotes main screen
    public function index()
    {
        if(session('login')==true)
        {
            $service = new RfqService();
            $rfq = $service->getAllRfq();
            return view('quotes.index',array('rfqList' => $rfq));
        }
        else{
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    // Get all the Quotes list
    public function getAllQuotes(Request $request)
    {
        $service = new QuotesService();
        $data = $service->getAllQuotes($request);
        return DataTables::of($data)
                    ->editColumn('rfq_issued_on', function($data){
                        $issOn = $data->rfq_issued_on;
                        if($issOn){
                            $issOn = date("d-M-Y", strtotime($issOn));
                            return $issOn;
                        }
                    })
                    ->editColumn('last_date', function($data){
                        $lastDate = $data->last_date;
                        if($lastDate){
                            $lastDate = date("d-M-Y", strtotime($lastDate));
                            return $lastDate;
                        }
                    })
                    ->editColumn('responded_on', function($data){
                        $respOn = $data->responded_on;
                        if($respOn){
                            // $respOn = date("d-M-Y", strtotime($respOn));
                            return $respOn;
                        }
                    })
                    ->editColumn('invited_on', function($data){
                        $invOn = $data->invited_on;
                        if($invOn){
                            $invOn = date("d-M-Y", strtotime($invOn));
                            return $invOn;
                        }
                    })
                    ->addColumn('quotes_status', function($data){
                        $rfqSts = $data->quotes_status;
                        if($rfqSts == 'pending'){
                           $sts = '<span class="badge badge-warning"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else if($rfqSts == 'active'){
                            $sts = '<span class="badge badge-success"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else if($rfqSts == 'responded'){
                            $sts = '<span class="badge badge-info"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else if($rfqSts == 'closed'){
                            $sts = '<span class="badge badge-danger"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else{
                            $sts='';
                        }
                        return $sts;
                    })
                    ->addColumn('action', function($data){
                        $button = '';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit']) && ($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit'] == "allow")){
                            if($data->quotes_status!='closed' ){
                                $button .= '&nbsp;&nbsp;<a href="/quotes/edit/'. base64_encode($data->quote_id).'" name="edit" id="'.$data->quote_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            }
                        }else{
                            $button .= '';
                        }
                        if($data->approve_status=='no' && $data->quotes_status=='responded' && session('loginType')=='users'){
                            $button .= '&nbsp;&nbsp;<a href="/purchaseorder/add/'. base64_encode($data->quote_id).'" name="edit" id="'.$data->quote_id.'" class="btn btn-outline-primary btn-sm" title="Edit">Approve</a>';
                        }
                        // $button .= '<div class = "row">';
                        // $button .= '<div class = "col-md-6 mt-1">
                        $button .= '&nbsp;&nbsp;<button type="button" name="quoteDetails" id="quoteDetails" class="btn btn-outline-success btn-sm" onclick="showAjaxModal(\'/quoteDetailsView/'.base64_encode($data->quote_id).'\' );" title="Quote Details"><b><i class="ft-eye"></i></b></button>';
                        return $button;
                    })
                    ->rawColumns(['quotes_status','action'])
                    ->make(true);
    }

    // Get all the active Quotes list for datatable
    public function getAllActiveQuotesDisplay(Request $request)
    {
        $service = new QuotesService();
        $data = $service->getAllRespondedQuotes($request);
        return DataTables::of($data)
                    ->editColumn('rfq_issued_on', function($data){
                        $issOn = $data->rfq_issued_on;
                        if($issOn){
                            $issOn = date("d-M-Y", strtotime($issOn));
                            return $issOn;
                        }
                    })
                    ->editColumn('last_date', function($data){
                        $lastDate = $data->last_date;
                        if($lastDate){
                            $lastDate = date("d-M-Y", strtotime($lastDate));
                            return $lastDate;
                        }
                    })
                    // ->editColumn('responded_on', function($data){
                    //     $respOn = $data->responded_on;
                    //     if($respOn){
                    //         $respOn = date("d-M-Y", strtotime($respOn));
                    //         return $respOn;
                    //     }
                    // })
                    ->editColumn('invited_on', function($data){
                        $invOn = $data->invited_on;
                        if($invOn){
                            $invOn = date("d-M-Y", strtotime($invOn));
                            return $invOn;
                        }
                    })
                    ->addColumn('quotes_status', function($data){
                        $rfqSts = $data->quotes_status;
                        if($rfqSts == 'pending'){
                           $sts = '<span class="badge badge-warning"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else if($rfqSts == 'active'){
                            $sts = '<span class="badge badge-success"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else if($rfqSts == 'responded'){
                            $sts = '<span class="badge badge-info"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else if($rfqSts == 'closed'){
                            $sts = '<span class="badge badge-danger"><b>'.ucfirst($rfqSts).'</b></span>';
                        }
                        else{
                            $sts='';
                        }
                        return $sts;
                    })
                    ->addColumn('action', function($data){
                        $button = '';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit']) && ($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit'] == "allow")){
                            if($data->quotes_status!='closed' ){
                                $button .= '&nbsp;&nbsp;<a href="/quotes/edit/'. base64_encode($data->quote_id).'" name="edit" id="'.$data->quote_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            }
                        }else{
                            $button .= '';
                        }
                        if($data->approve_status=='no' && $data->quotes_status=='responded' && session('loginType')=='users'){
                            $button .= '&nbsp;&nbsp;<a href="/purchaseorder/add/'. base64_encode($data->quote_id).'" name="edit" id="'.$data->quote_id.'" class="btn btn-outline-primary btn-sm" title="Edit">Approve</a>';
                        }
                        // $button .= '<div class = "row">';
                        // $button .= '<div class = "col-md-6 mt-1">
                        $button .= '&nbsp;&nbsp;<button type="button" name="quoteDetails" id="quoteDetails" class="btn btn-outline-success btn-sm" onclick="showAjaxModal(\'/quoteDetailsView/'.base64_encode($data->quote_id).'\' );" title="Quote Details"><b><i class="ft-eye"></i></b></button>';
                        return $button;
                    })
                    ->rawColumns(['quotes_status','action'])
                    ->make(true);
    }

    // Quote details modal view
    public function quoteDetailsView($id,Request $request){
        $service = new QuotesService();
        $quote = $service->getQuotesById($id);
        $view = View::make('quotes.quoteDetailsViewModal', ['quoteId'=>$id,'quote'=>$quote]);
        $contents = (string) $view;
        return $contents;
    }

    //edit Quotes
    public function edit(Request $request,$id)
    {
        // if(session('login')==true){
            if ($request->isMethod('post')) 
            {
                $service = new QuotesService();
                $edit = $service->updateQuotes($request,$id);
                return Redirect::route('quotes.index')->with('status', $edit);
            }
            else
            {
                $service = new QuotesService();
                $result = $service->getQuotesById($id);
                // dd($result);
                $service = new ItemService();
                $itemResult = $service->getAllActiveItem();
                // dd($itemResult);
                return view('quotes.edit',array('result'=>$result,'items'=>$itemResult));
            }
        // }
        // else{
        //     print_r(url()->current());die;
        //     session(['url' => url()->current()]);
        // }
    }
}
