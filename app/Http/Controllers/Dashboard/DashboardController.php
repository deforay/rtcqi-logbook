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

            $GlobalConfigService = new GlobalConfigService();
            $latitude = $GlobalConfigService->getGlobalConfigLatitude('latitude');
            $longitude = $GlobalConfigService->getGlobalConfigLongitude('longitude');

            $total = $monthlyReportService->getTotalCountOfMonthlyReport();
            $monthly = $monthlyReportService->getCountOfMonthlyReport();
            $siteMonthly = $monthlyReportService->getSiteCountOfMonthlyReport();
            return view('dashboard.index', array(
                'province' => $province,
                'data' => $data,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'total' => $total,
                'monthly' => $monthly,
                'siteMonthly' => $siteMonthly
            ));
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
