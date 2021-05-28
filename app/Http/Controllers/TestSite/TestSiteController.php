<?php

namespace App\Http\Controllers\TestSite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\TestSiteService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class TestSiteController extends Controller
{
    //View TestSite main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('testsite.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add TestSite (display add screen and add the TestSite values)
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $addTestSite = new TestSiteService();
            $result = $addTestSite->saveTestSite($request);
            return Redirect::route('testsite.index')->with('status', $result);
        }
        else
        {
            
            return view('testsite.add');
        }
    }

    // Get all the test site list
    public function getAllTestSite(Request $request)
    {
        $service = new TestSiteService();
        $data = $service->getAllTestSite();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div>';
                        $button .= '<a href="/testsite/edit/'. base64_encode($data->ts_id).'" name="edit" id="'.$data->ts_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    //edit test site
    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $TestSiteService = new TestSiteService();
            $edit = $TestSiteService->updateTestSite($request,$id);
            return Redirect::route('testsite.index')->with('status', $edit);
        }
        else
        {
            $TestSiteService = new TestSiteService();
            $result = $TestSiteService->getTestSiteById($id);
            return view('testsite.edit',array('result'=>$result,'id'=>$id));
        }
    }
}

