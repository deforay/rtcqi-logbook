<?php

namespace App\Http\Controllers\Countries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\CountriesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;

class CountriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['role-authorization'])->except('getAllCountries');        

    }
    //View Customers main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('countries.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add customers (display add screen )
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $AddCountries = new CountriesService();
            $addCountries = $AddCountries->saveCountries($request);
            return Redirect::route('countries.index')->with('status', $addCountries);
        }else{
            return view('countries.add');
        }
    }

    // Get all the countries list
    public function getAllCountries(Request $request)
    {
        $countriesService = new CountriesService();
        $data = $countriesService->getAllCountries();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $button = '<div style="width: 180px;">';
                $role = session('role');
                if (isset($role['App\\Http\\Controllers\\Countries\\CountriesController']['edit']) && ($role['App\\Http\\Controllers\\Countries\\CountriesController']['edit'] == "allow")) {
                    $button .= '<a href="/countries/edit/' . base64_encode($data->country_id) . '" name="edit" id="' . $data->country_id . '" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                } else {
                    $button .= '';
                }

                if ($data->country_status == 'active') {
                    $buttonStatus = "changeStatus('countries','country_id',$data->country_id,'country_status', 'inactive','countryList')";
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus' . $data->country_id . '" onclick="' . $buttonStatus . '" class="btn btn-outline-warning btn-sm">Change to Inactive</button>';
                } else {
                    $buttonStatus = "changeStatus('countries','country_id',$data->country_id,'country_status', 'active','countryList')";
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="changeStatus" id="changeStatus' . $data->country_id . '" onclick="' . $buttonStatus . '" class="btn btn-outline-success btn-sm">Change to Active</button>';
                }
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Edit Customer Screen
    public function edit($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $countriesService = new CountriesService();
            $editCountries = $countriesService->updateCountries($request, $id);
            return Redirect::route('countries.index')->with('status', $editCountries);
        } else {
            $countriesService = new CountriesService();
            $result = $countriesService->getCountriesById($id);
            return view('countries.edit', array('countries' => $result));
        }
    }
}
