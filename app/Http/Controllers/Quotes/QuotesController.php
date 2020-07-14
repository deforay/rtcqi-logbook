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
    //View Item main screen
    public function index()
    {
        if(session('login')==true)
        {
            $service = new RfqService();
            $rfq = $service->getAllRfq();
            return view('quotes.index',array('rfqList' => $rfq));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Get all the Quotes list
    public function getAllQuotes(Request $request)
    {
        $service = new QuotesService();
        $data = $service->getAllQuotes($request);
        return DataTables::of($data)
                    ->editColumn('responded_on', function($data){
                        $respOn = $data->responded_on;
                        if($respOn){
                            $respOn = date("d-M-Y", strtotime($respOn));
                            return $respOn;
                        }
                    })
                    ->editColumn('invited_on', function($data){
                        $invitedon = $data->invited_on;
                        if($invitedon){
                            $lastDate = date("d-M-Y", strtotime($invitedon));
                            return $lastDate;
                        }
                })
                    ->addColumn('action', function($data){
                        $button = '';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit']) && ($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit'] == "allow")){
                            if($data->quotes_status!='closed' ){
                           $button .= '<a href="/quotes/edit/'. base64_encode($data->quote_id).'" name="edit" id="'.$data->quote_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            }
                        }else{
                            $button .= '';
                        }
                        if($data->approve_status=='no' && $data->quotes_status=='responded' && session('loginType')=='users'){
                            $button .= '&nbsp;&nbsp;&nbsp;<a href="/purchaseorder/add/'. base64_encode($data->quote_id).'" name="edit" id="'.$data->quote_id.'" class="btn btn-outline-primary btn-sm" title="Edit">Approve</a>';
                        }
                        $button .= '<div class = "row">';
                        $button .= '<div class = "col-md-6 mt-1">
                        <button type="button" name="quoteDetails" id="quoteDetails" class="btn btn-success btn-sm" onclick="showAjaxModal(\'/quoteDetailsView/'.base64_encode($data->quote_id).'\' );" title="Quote Details"><b><i class="la la-eye"></i></b></button></div></div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
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
    }
}
