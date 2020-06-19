<?php

namespace App\Model\Countries;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CountriesService;
use App\Service\CommonService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Mail;

class CountriesTable extends Model
{
    //
    protected $table = 'country_name';

    public function saveCountries($request)
    {
        $data = $request->all();
        $id = ' ';
        $commonservice = new CommonService();
        if ($request->input('countryName') != null && trim($request->input('countryName')) != '') {
            $id = DB::table('countries')->insertGetId(
                [
                    'country_name'   => $data['countryName'],
                    'country_status' => $data['status'],
                    'created_on'     => $commonservice->getDateTime(),
                ]
            );
            if ($id) {
                //Event Log
                $commonservice = new CommonService();
                $commonservice->eventLog(session('userId'), $id, 'Countries-add', 'Added Countries Type ' . $data['countryName'], 'country_name');
            }
        }

        return $id;
        // }
    }

    // Fetch All Countries List
    public function fetchAllCountries()
    {
        $data = DB::table('countries')
            ->orderBy('country_name', 'asc')
            ->get();
        return $data;
    }

    // Fetch All Active Countries List
    public function fetchAllActiveCountries()
    {
        $data = DB::table('countries')
            ->where('countries.country_status', '=', 'active')
            ->orderBy('country_name', 'asc')
            ->get();
        return $data;
    }

    // fetch particular Countries details(edit)
    public function fetchCountriesById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('countries')
            ->where('countries.country_id', '=', $id)->get();
        return $data;
    }

    // Update Countries details
    public function updateCountries($params, $id)
    {

        $response = 0;
        $data = $params->all();
        $countryUp = '';
        //Country details
        $commonservice = new CommonService();   
        if ($params->input('countryName') != null && trim($params->input('countryName')) != '') {
            $params = array(
                'country_name' => $data['countryName'],
                'country_status'=> $data['status'],
                'updated_on' => $commonservice->getDateTime(),
            );
            $countryUp = DB::table('countries')
                ->where('country_id', '=', base64_decode($id))
                ->update(
                    $params
                );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Country-update', 'Update Country Name ' . $data['countryName'], 'country_name');
        }
        if ($countryUp) {
            $response = 1;
        }
        return $response;
    }
}
