<?php

namespace App\Model\Rfq;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\RfqService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class RfqTable extends Model
{
    //add Rfq
    public function saveRfq($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        // dd($data);
        if ($request->input('rfqNumber')!=null && trim($request->input('rfqNumber')) != '') {
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $lastDate = $commonservice->dateFormat($data['lastdate']);
            $id = DB::table('rfq')->insertGetId(
                ['rfq_number' => $data['rfqNumber'],
                'rfq_issued_on' => $issuedOn,
                'last_date' => $lastDate,
                'rfq_status' => 'draft',
                'created_by' => session('userId'),
                'created_on' => $commonservice->getDateTime(),
                ]
            );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'RFQ-add', 'Add Rfq '.$data['rfqNumber'], 'Rfq');
        }

        if ($request->input('vendors')!=null) {
            for($k=0;$k<count($data['vendors']);$k++){
                $quotes = DB::table('quotes')->insertGetId(
                        [
                        'rfq_id' => $id,
                        'vendor_id' => $data['vendors'][$k],
                        ]
                    );
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'quotes-add', 'add quotes '.$data['rfqNumber'], 'quotes');
        }

        if ($request->input('item')!=null) {
            for($j=0;$j<count($data['item']);$j++){
                $rfqDetails = DB::table('rfq_details')->insertGetId(
                                [
                                'rfq_id' => $id,
                                'item_id' => $data['item'][$j],
                                'uom' => $data['unitId'][$j],
                                'quantity' => $data['qty'][$j],
                                ]
                            );

                $quotesDetails = DB::table('quote_details')->insertGetId(
                                    [
                                    'quote_id' => $quotes,
                                    'item_id' => $data['item'][$j],
                                    'uom' => $data['unitId'][$j],
                                    'quantity' => $data['qty'][$j],
                                    ]
                                );
            }
        }
        return $id;
    }

    // Fetch All Rfq List
    public function fetchAllRfq()
    {
        $data = DB::table('rfq')
                ->get();
        return $data;
    }
}
