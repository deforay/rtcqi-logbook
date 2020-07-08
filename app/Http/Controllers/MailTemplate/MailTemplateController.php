<?php

namespace App\Http\Controllers\MailTemplate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\MailTemplateService;
use App\Service\SalesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use View;

class MailTemplateController extends Controller
{
    public function __construct()
    {      
        
       
    }
    //View mail template main screen
    public function index()
    {
        if(session('login')==true)
        {
            $mailTemplate = new MailTemplateService();
            $mail = $mailTemplate->getMailTemplate();
            return view('mailtemplate.index',array('mail'=>$mail));
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    public function updateMailTemplate(Request $request){
        dd("updateMailTemplate");
        $mailTemplateService = new MailTemplateService();
        $mail = $mailTemplateService->updateMailTemplate($request);
        return Redirect::route('mailtemplate.index')->with('status', $mail);
    }

    public function previewMailTemplate($id,$salesType){
        $mailTemplateService = new MailTemplateService();
        $mail = $mailTemplateService->getMailTemplate();
        $salesService = new SalesService();
        $result = $salesService->getAllSaleOrderDetailsById($id,$salesType);
        // dd($result);
        $view = View::make('mailtemplate.previewMailTemplate', ['orderId'=>$id,'mail'=>$mail,'salesType'=>$salesType,'result'=>$result]);
        $contents = (string) $view;
        return $contents;
    }

    public function getTemplates(Request $request)
    {
        $mailTemplateService = new MailTemplateService();
        $result = $mailTemplateService->getAllTemplates();        
        return DataTables::of($result)
                    ->addColumn('action', function($result){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\MailTemplate\\MailTemplateController']['edit']) && ($role['App\\Http\\Controllers\\MailTemplate\\MailTemplateController']['edit'] == "allow")){
                            $button .= '<a href="/mailtemplate/edit/'. base64_encode($result->mail_temp_id).'" name="edit" id="'.$result->mail_temp_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                            
                        }else{
                            $button .= '';
                        }

                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function add(Request $request)
    {
        
        if ($request->isMethod('post')) 
        {
            $mailTemplateService = new MailTemplateService();
            $addTemplate = $mailTemplateService->saveTemplate($request);
            return Redirect::route('mailtemplate.index')->with('status', $addTemplate);
        }
        else
        {
            return view('mailtemplate.add');
        }
    }

    public function edit($id,Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $mailTemplateService = new MailTemplateService();
            $editTemplate = $mailTemplateService->updateMailTemplate($request,$id);
             if($editTemplate==2){
                return Redirect::to('/dashboard');
               }else{
                return Redirect::route('mailtemplate.index')->with('status', $editTemplate);
               }
        }
        else
        {
            $mailTemplateService = new MailTemplateService();
            $result = $mailTemplateService->getTemplateById($id);
            return view('mailtemplate.edit',array('mail'=>$result));
        }
    }

}
