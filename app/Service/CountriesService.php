<?php

namespace App\Service;

use App\Model\Countries\CountriesTable;
use App\EventLog\EventLog;
use DB;
use Redirect;

class CountriesService
{

	public function saveCountries($request)
	{
		$data =  $request->all();
		DB::beginTransaction();
		try {
			$countriesmodel = new CountriesTable();
			$addvendors = $countriesmodel->saveCountries($request);
			if ($addvendors > 0) {
				DB::commit();
				$msg = 'Countries Added Successfully';
				return $msg;
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}

	//Get All Countries List
	public function getAllCountries()
	{
		$countriesmodel = new CountriesTable();
		$result = $countriesmodel->fetchAllCountries();
		return $result;
	}

	//Get All Active Countries
	public function getAllActiveCountries()
	{
		$countriesmodel = new CountriesTable();
		$result = $countriesmodel->fetchAllActiveCountries();
		return $result;
	}

	//Get Particular Countries Details
	public function getCountriesById($id)
	{
		$countriesmodel = new CountriesTable();
		$result = $countriesmodel->fetchCountriesById($id);
		return $result;
	}
	//Update Particular Vendors Details
	public function updateCountries($params, $id)
	{
		DB::beginTransaction();
		try {
			$countriesmodel = new CountriesTable();
			$updateCountries = $countriesmodel->updateCountries($params, $id);
			if ($updateCountries > 0) {
				DB::commit();
				$msg = 'Countries Updated Successfully';
				return $msg;
			}
		} catch (Exception $exc) {
			DB::rollBack();
			$exc->getMessage();
		}
	}
}
