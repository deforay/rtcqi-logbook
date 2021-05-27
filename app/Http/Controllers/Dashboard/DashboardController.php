<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Redirect;

class DashboardController extends Controller
{
    //View Dashboard main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('dashboard.index');
           
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

}
