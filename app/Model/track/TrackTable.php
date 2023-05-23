<?php

namespace App\Model\track;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class TrackTable extends Model
{
    protected $table = 'track';

    // Fetch All User Activity List
    public function fetchAllActivity($params)
    {
         //dd($params);die;
        $commonservice = new CommonService();
        $start_date = '';
        $end_date = '';
        if (isset($params['searchDate']) && $params['searchDate'] != '') {
            $sDate = explode("to", $params['searchDate']);
            if (isset($sDate[0]) && trim($sDate[0]) != "") {
                $monthYr = Date("d-M-Y", strtotime("$sDate[0]"));
                $start_date = $commonservice->dateFormat(trim($monthYr));
            }
            if (isset($sDate[1]) && trim($sDate[1]) != "") {
                $monthYr2 = Date("d-M-Y", strtotime("$sDate[1]"));
                $end_date = $commonservice->dateFormat(trim($monthYr2));
            }
        }
        $query = DB::table('track');

        if (trim($start_date) != "" && trim($end_date) != "") {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $query->where(DB::raw('date(date_time)'),  '>=', $start_date)
                    ->where(DB::raw('date(date_time)'), '<=', $end_date);
            });
        }
        if (isset($params['userId']) && $params['userId'] != '') {
            $query = $query->whereIn('user_id', $params['userId']);
        }

        $salesResult = $query->get();
        
        return $salesResult;
    }

    // Fetch All Activity By ID
    public function fetchAllActivityById($id)
    {
        $data = DB::table('track')
            ->where('action_id','=',base64_decode($id))
            ->get();
        return $data;
    }
   
}
