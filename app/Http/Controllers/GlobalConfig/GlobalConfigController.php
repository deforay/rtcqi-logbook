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

    //View Global Config main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('globalconfig.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    // Get all the Global Config list
    public function getConfig(Request $request)
    {
        $configService = new GlobalConfigService();
        $data = $configService->getAllGlobalConfig();
        return DataTables::of($data)
                    ->make(true);
    }

    // Edit Global Config (display edit screen and edit the Global Config values)
    public function edit(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $configService = new GlobalConfigService();
            $editGlobalConfig = $configService->updateGlobalConfig($request);
            return Redirect::route('globalconfig.index')->with('status', $editGlobalConfig);
        }
        else
        {
            $configService = new GlobalConfigService();
            $result = $configService->getAllGlobalConfigEdit();
            // dd($result);
            return view('globalconfig.edit',array('config'=>$result));
        }
    }
}
