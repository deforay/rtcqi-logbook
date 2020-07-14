<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\RfqService;
use App\Service\QuotesService;
use App\Service\DashboardService;
use Redirect;

class DashboardController extends Controller
{
    //View Dashboard main screen
    public function index()
    {
        if(session('login')==true)
        {
            // $rfqservice = new RfqService();
            // $rfqDetails = $rfqservice->getAllActiveRfq();
            // $quotesService = new QuotesService();
            // $quotesDetails = $quotesService->getAllActiveQuotes();
            $service = new DashboardService();
            $details = $service->getAllDashboardDetails();
            return view('dashboard.index',array('details'=>$details));
           
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // public function getAllDashboardDetails(){
    //     if(session('login')==true){
            
    //     }
    // }
}
