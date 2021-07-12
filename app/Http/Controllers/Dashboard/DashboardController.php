<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Service\GlobalConfigService;
use App\Service\MonthlyReportService;
use App\Service\ProvinceService;
use Illuminate\Http\Request;
use Redirect;

class DashboardController extends Controller
{
    //View Dashboard main screen
    public function index()
    {
        if (session('login') == true) {
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getMonthlyData();
        $ProvinceService = new ProvinceService();
            $province = $ProvinceService->getAllActiveProvince();
            return view('dashboard.index', array('province' => $province,'data'=>$data));
        } else {
            return Redirect::to('login')->with('status', 'Please Login');
        }

    }

    public function getDashboardData(Request $request)
    {
        $monthlyReportService = new MonthlyReportService();
        $data = $monthlyReportService->getDashboardData($request);
        return response()->json($data);

    }
}
