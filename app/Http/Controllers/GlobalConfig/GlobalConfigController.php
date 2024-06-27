<?php

namespace App\Http\Controllers\GlobalConfig;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\GlobalConfigService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class GlobalConfigController extends Controller
{
    //View GlobalConfig main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('globalconfig.index');
        }
        else {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }

    // Get all the  GlobalConfig list
    public function getAllGlobalConfig(Request $request)
    {
        $service = new GlobalConfigService();
        $data = $service->getAllGlobalConfig();
        return DataTables::of($data)
                    ->make(true);
    }

    //edit GlobalConfig
    public function edit(Request $request)
    {
        if ($request->isMethod('post')) 
       {
            $GlobalConfigService = new GlobalConfigService();
            $edit = $GlobalConfigService->updateGlobalConfig($request);
            return Redirect::route('globalconfig.index')->with('status', $edit);
        }
        else
        {
            $GlobalConfigService = new GlobalConfigService();
            $result = $GlobalConfigService->getAllGlobalConfig();
            $arr = array();
            // now we create an associative array so that we can easily create view variables
            $counter = count($result);
            // now we create an associative array so that we can easily create view variables
            for ($i = 0; $i < $counter; $i++) {
                $arr[$result[$i]->global_name] = $result[$i]->global_value;
            }
            // print_r($arr); die;
            return view('globalconfig.edit',array('result'=>$arr));
        }
    }

    public function updateglobal(Request $request)
    {
        $GlobalConfigService = new GlobalConfigService();
        $edit = $GlobalConfigService->updateGlobalConfig($request);
        return Redirect::route('globalconfig.index')->with('status', $edit);
    }
    
}

