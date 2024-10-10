<?php

namespace App\Model\TestSite;

use App\Model\District\DistrictTable;
use App\Model\Province\ProvinceTable;
use App\Model\SubDistrict\SubDistrictTable;
use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;
use App\Service\CommonService;
use App\Service\ProvinceService;
use App\Service\DistrictService;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;

class TestSiteTable extends Model
{
    protected $table = 'test_sites';

    //add TestSite
    public function saveTestSite($request)
    {
        //to get all request values
        $userId = null;
        $data = $request->all();
        $user_name = session('name');
        $commonservice = new CommonService();
        $latLng = $this->getLatitudeLongitude($data);
        if ($request->input('siteName') != null && trim($request->input('siteName')) != '') {
            $site_type = "";

            if (count($data['sitetypeId']) > 0) {

                $site_type = implode(",", $data['sitetypeId']);
            }
            $id = DB::table('test_sites')->insertGetId(
                [
                    'site_ID' => $data['siteId'],
                    'external_site_id' => $data['externalSiteID'],
                    'site_name' => $data['siteName'],
                    'site_latitude' => $latLng['lat'],
                    'site_longitude' => $latLng['lng'],
                    'site_primary_email' => $data['primaryEmail'],
                    'site_secondary_email' => $data['secondaryEmail'],
                    'site_primary_mobile_no' => $data['primaryMobileNo'],
                    'site_secondary_mobile_no' => $data['secondaryMobileNo'],
                    'site_address1' => $data['address1'],
                    'site_address2' => $data['address2'],
                    'site_postal_code' => $data['postalCode'],
                    'site_city' => $data['city'],
                    'site_country' => $data['country'],
                    'test_site_status' => $data['testSiteStatus'],
                    'site_province' => $data['provincesssId'],
                    'site_district' => $data['districtId'],
                    'site_sub_district' => $data['subDistrictId'],
                    'site_type' => $site_type,
                    'site_implementing_partner_id' => $data['implementingPartnerId'],
                    'created_by' => session('userId'),
                    'created_on' => $commonservice->getDateTime(),
                ]
            );

            $list_users = DB::table('users_location_map')
                ->select('users_location_map.user_id')
                ->where('users_location_map.province_id', '=', $data['provincesssId'])
                ->where('users_location_map.district_id', '=', $data['districtId'])
                ->get();
            if (count($list_users) == 0) {
                $list_users = DB::table('users_location_map')
                    ->select('user_id')
                    ->where('users_location_map.province_id', '=', $data['provincesssId'])
                    ->get();
            }
            if (count($list_users) > 0) {
                for ($i = 0; $i < count($list_users); $i++) {
                    DB::table('users_testsite_map')->insertGetId(
                        [
                            'user_id' => $list_users[$i]->user_id,
                            'ts_id' => $id
                        ]
                    );
                }
            }
            $commonservice->eventLog('add-test-site-request', $user_name . ' has added the test site information for ' . $data['siteName'] . ' Name', 'test-site', $userId);
        }

        return $id;
    }

    private function getLatitudeLongitude($data)
    {

        $commonservice = new CommonService();
        $provinceservice = new ProvinceService();
        $districtservice = new DistrictService();
        $latLng = array();

        $latLng['lat'] = $data['latitude'];
        $latLng['lng'] = $data['longitude'];

        if ($latLng['lat'] == '' || $latLng['lng'] == '') {
            $address = '';

            if (!empty($data["address1"])) {
                $address .= $data["address1"] . ",";
            }
            if (!empty($data['address2'])) {
                $address .= $data['address2'] . ',';
            }
            if (!empty($data['city'])) {
                $address .= $data['city'] . ',';
            }
            if (!empty($data['provincesssId'])) {
                $provinceId = base64_encode($data['provincesssId']);
                $address .= $provinceservice->getProvinceById($provinceId)[0]->province_name . ',';
            }
            if (!empty($data['districtId'])) {
                $districtid = base64_encode($data['districtId']);
                $address .= $districtservice->getDistrictById($districtid)[0]->district_name . ',';
            }
            if (!empty($data['postalCode'])) {
                $address .= $data['postalCode'];
            }
            if (!empty($data['country'])) {
                $address .= $data['country'];
            }
            //echo 'formatted address '.$address.'<br>';
            $formattedAddress = str_replace(' ', '+', $address);

            if ($formattedAddress != '') {

                $latLng = $commonservice->getSiteLatLon($formattedAddress);
            }
        }
        return $latLng;
    }

    // Fetch All TestSite List
    public function fetchAllTestSite()
    {
        return DB::table('test_sites')
            ->leftjoin('districts', 'districts.district_id', '=', 'test_sites.site_district')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'test_sites.site_province')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'test_sites.site_sub_district')
            ->get();
    }

    // Fetch All Active TestSite List
    public function fetchAllActiveTestSite()
    {
        return DB::table('test_sites')
            ->where('test_site_status', '=', 'active')
            ->get();
    }

    // fetch particular TestSite details
    public function fetchTestSiteById($id)
    {

        $id = base64_decode($id);
        return DB::table('test_sites')
            ->where('test_sites.ts_id', '=', $id)
            ->get();
    }

    // Update particular TestSite details
    public function updateTestSite($params, $id)
    {

        $userId = null;
        $user_name = session('name');
        $commonservice = new CommonService();
        $data = $params->all();
        $latLng = $this->getLatitudeLongitude($data);
        $site_type = "";

        if (count($data['sitetypeId']) > 0) {

            $site_type = implode(",", $data['sitetypeId']);
        }

        $testData = array(
            'site_ID' => $data['siteId'],
            'external_site_id' => $data['externalSiteID'],
            'site_name' => $data['siteName'],
            'site_latitude' => $latLng['lat'],
            'site_longitude' => $latLng['lng'],
            'site_primary_email' => $data['primaryEmail'],
            'site_secondary_email' => $data['secondaryEmail'],
            'site_primary_mobile_no' => $data['primaryMobileNo'],
            'site_secondary_mobile_no' => $data['secondaryMobileNo'],
            'site_address1' => $data['address1'],
            'site_address2' => $data['address2'],
            'site_postal_code' => $data['postalCode'],
            'site_city' => $data['city'],
            'site_country' => $data['country'],
            'test_site_status' => $data['testSiteStatus'],
            'site_province' => $data['provincesssId'],
            'site_district' => $data['districtId'],
            'site_sub_district' => $data['subDistrictId'],
            'site_type' => $site_type,
            'site_implementing_partner_id' => $data['implementingPartnerId'],
            'updated_by' => session('userId')
        );
        $response = DB::table('test_sites')
            ->where('ts_id', '=', base64_decode($id))
            ->update($testData);
        if ($response == 1) {

            $response = DB::table('test_sites')
                ->where('ts_id', '=', base64_decode($id))
                ->update(
                    array(
                        'updated_on' => $commonservice->getDateTime()
                    )
                );
            $testSiteResponse = DB::delete('delete from users_testsite_map where ts_id = ?', [base64_decode($id)]);
            $list_users = DB::table('users_location_map')
                ->select('users_location_map.user_id')
                ->where('users_location_map.province_id', '=', $data['provincesssId'])
                ->where('users_location_map.district_id', '=', $data['districtId'])
                ->get();
                // print_r($list_users); die;
            if (count($list_users) == 0) {
                $list_users = DB::table('users_location_map')
                    ->select('user_id')
                    ->where('users_location_map.province_id', '=', $data['provincesssId'])
                    ->get();
            }
            if (count($list_users) > 0) {
                for ($i = 0; $i < count($list_users); $i++) {
                    DB::table('users_testsite_map')->insertGetId(
                        [
                            'user_id' => $list_users[$i]->user_id,
                            'ts_id' => base64_decode($id)
                        ]
                    );
                }
            }
            $commonservice->eventLog('update-test-site-request', $user_name . ' has updated the test site information for ' . $data['siteName'] . ' Name', 'test-site', $userId);
        }
        return $response;
    }

    // Fetch Current User Active TestSite List
    public function fetchAllCurrentUserActiveTestSite()
    {
        if (Session::get('tsId') != '') {
            $data = DB::table('test_sites')
                ->join('users_testsite_map', 'users_testsite_map.ts_id', '=', 'test_sites.ts_id')
                ->whereIn('users_testsite_map.ts_id', Session::get('tsId'))
                ->groupBy('test_sites.ts_id')
                ->get();
        } else {
            $data = DB::table('test_sites')
                ->where('test_site_status', '=', 'active')
                ->groupBy('ts_id')
                ->get();
        }
        return $data;
    }

    //Fetch some particular test site values
    public function fetchTestSiteData($id)
    {

        return DB::table('test_sites')
            ->select('monthly_reports.site_manager', 'monthly_reports.tester_name', 'monthly_reports.contact_no', 'monthly_reports.book_no', 'test_sites.ts_id', 'test_sites.site_id', 'test_sites.site_latitude', 'test_sites.site_longitude', 'test_sites.site_province', 'provinces.province_name', 'provinces.province_id',  'districts.district_name', 'districts.district_id',  'sub_districts.sub_district_name', 'sub_districts.sub_district_id')
            ->leftjoin('monthly_reports', 'monthly_reports.ts_id', '=', 'test_sites.ts_id')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'test_sites.site_province')
            ->leftjoin('districts', 'districts.district_id', '=', 'test_sites.site_district')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'test_sites.site_sub_district')
            ->where('test_sites.ts_id', '=', $id)
            ->orWhere('monthly_reports.ts_id', '=', $id)
            ->orderBy('mr_id', 'desc')
            ->limit(1)
            ->get();
    }

    //Fetch some particular site district values
    public function fetchDistrictId($id)
    {
        return DB::table('test_sites')
            ->select('site_district')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_district');
    }
    //Fetch some particular site sub district values
    public function fetchSubDistrictId($id)
    {
        return DB::table('test_sites')
            ->select('site_Sub_district')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_Sub_district');
    }

    //Fetch some particular latitude values
    public function fetchLatitudeValue($id)
    {
        return DB::table('test_sites')
            ->select('site_latitude')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_latitude');
    }
    //Fetch some particular longitude values
    public function fetchLongitudeValue($id)
    {
        return DB::table('test_sites')
            ->select('site_longitude')
            ->where('test_sites.ts_id', '=', $id)
            ->value('site_longitude');
    }

    public function fetchAllTestSiteList($params)
    {
        $query = DB::table('test_sites')
            ->select('test_sites.ts_id', 'test_sites.site_name')
            ->leftjoin('districts', 'districts.district_id', '=', 'test_sites.site_district')
            ->leftjoin('provinces', 'provinces.province_id', '=', 'test_sites.site_province')
            ->leftjoin('sub_districts', 'sub_districts.sub_district_id', '=', 'test_sites.site_sub_district');

        if (isset($params['provinceId']) && count($params['provinceId']) > 0) {
            $query = $query->whereIn('test_sites.site_province', $params['provinceId']);
        }
        if (isset($params['districtId']) && count($params['districtId']) > 0) {
            $query = $query->whereIn('test_sites.site_district', $params['districtId']);
        }
        if (isset($params['subDistrictId']) && count($params['subDistrictId']) > 0) {
            $query = $query->whereIn('test_sites.site_sub_district', $params['subDistrictId']);
        }
        if (isset($params['searchTo']) && count($params['searchTo']) > 0) {
            $query = $query->whereNotIn('test_sites.ts_id', $params['searchTo']);
        }
        $query = $query->orderBy('site_name', 'asc');
        return $query->get()->toArray();
    }

    public function getTestsiteEmail($tsId)
    {
        $query = DB::table('test_sites')
            ->select('ts_id', 'site_primary_email', 'site_secondary_email')
            ->where('ts_id', '=', $tsId);
        return $query->first();
    }


    public function bulkUploadTestSite($params)
    {
        $commonservice = new CommonService();
        if (isset($params['test_site_excel']) && $params['test_site_excel']->isValid()) {
            DB::beginTransaction();
            try {
                $dateTime = date('Ymd_His');
                $file = $params['test_site_excel'];
                $fileName = $dateTime . '-' . $file->getClientOriginalName();
                $savePath = public_path('/uploads/');
                $file->move($savePath, $fileName);
    
                $filePath = $savePath . $fileName;
                $file_type = IOFactory::identify($filePath);
                $reader = IOFactory::createReader($file_type);
                $reader->setReadDataOnly(true);
                $reader->setReadEmptyCells(false);
                $spreadsheet = $reader->load($filePath);
                unlink($filePath);
    
                $sheetDatas = $spreadsheet->getActiveSheet()->toArray();
                // unset($sheetDatas[0]);
                foreach($sheetDatas as $key=>$val)
                {
                    $province = new ProvinceTable();
                    $districtTable = new DistrictTable();
                    $subDistrict = new SubDistrictTable();
                    $provincesssId = $province->checkProvince($val[14]);
                    $districtId = $districtTable->checkDistrict($val[15], $provincesssId);
                    $subDistrictId = $subDistrict->checkSubDistrict($val[16], $districtId);
                    $id = DB::table('test_sites')->insertGetId(
                        [
                            'site_ID' => $val[0],
                            'external_site_id' => $val[1],
                            'site_name' => $val[2],
                            'site_latitude' => $val[5],
                            'site_longitude' => $val[6],
                            'site_primary_email' => $val[7],
                            'site_secondary_email' => $val[8],
                            'site_primary_mobile_no' => $val[9],
                            'site_secondary_mobile_no' => $val[10],
                            'site_address1' => $val[11],
                            'site_address2' => $val[12],
                            'site_postal_code' => $val[13],
                            'site_city' => $val[18],
                            'site_country' => $val[17],
                            'test_site_status' => $val[19],
                            'site_province' => $provincesssId, //check 14
                            'site_district' => $districtId, // check 15
                            'site_sub_district' => $subDistrictId, //check 16
                            'created_by' => session('userId'), //check
                            'created_on' => $commonservice->getDateTime(),
                        ]
                    );
                }   
                return $id;
            } catch (Exception $exc) {
                DB::rollBack();
                $result = "Error: " . $exc->getMessage();
                return $result;
            }
            DB::commit();
            return "File uploaded and processed successfully";
        } else {
            return "No file uploaded or invalid file.";
        }
    }
    
}
