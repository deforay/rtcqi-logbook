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
use App\Service\ItemService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class QuotesController extends Controller
{
    //View Item main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('quotes.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Get all the Quotes list
    public function getAllQuotes(Request $request)
    {
        $service = new QuotesService();
        $data = $service->getAllQuotes();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div >';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit']) && ($role['App\\Http\\Controllers\\Quotes\\QuotesController']['edit'] == "allow")){
                           $button .= '<a href="/quotes/edit/'. base64_encode($data->quote_id).'" name="edit" id="'.$data->quote_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        }else{
                            $button .= '';
                        }
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
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
            $service = new ItemService();
            $itemResult = $service->getAllActiveItem();
            // dd($itemResult);
            return view('quotes.edit',array('result'=>$result,'items'=>$itemResult));
        }
    }
}
