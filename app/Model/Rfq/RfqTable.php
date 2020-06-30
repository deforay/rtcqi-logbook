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
                if ($request->input('item')!=null) {
                    for($j=0;$j<count($data['item']);$j++){
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

    // Fetch All rfq List
    public function fetchAllActiveRfq()
    {
        $data = DB::table('rfq')
            ->where('rfq_status','=','active')
            ->orderBy('rfq_number', 'asc')
            ->get();
        return $data;
    }

    // fetch particular rfq details(edit)
    public function fetchRfqById($id)
    {
        $id = base64_decode($id);
        // dd($id);
        $data['rfq'] = DB::table('rfq')
                        ->join('rfq_details', 'rfq_details.rfq_id', '=', 'rfq.rfq_id')
                        ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'rfq_details.uom')
                        ->where('rfq.rfq_id', '=', $id)->get();

        $data['quotes'] = DB::table('quotes')
                            ->join('quote_details', 'quote_details.quote_id', '=', 'quotes.quote_id')
                            ->where('quotes.rfq_id', '=', $id)->get();
        return $data;
    }

    // Update particular rfq details
    public function updateRfq($params, $id)
    {
        $id = base64_decode($id);
        $response = 0;
        $data = $params->all();
        dd($data);
        $commonservice = new CommonService();
        if(isset($data['vendorDetail']) && ($data['vendorDetail']!=null) && trim($data['vendorDetail'])!=''){
            $delVen = explode(",",$data['vendorDetail']);
            if(isset($data['vendors']) && ($data['vendors']!=null)){
                $diffVendor = array_diff($delVen, $data['vendors']);
            }
            else{
                $diffVendor = $delVen;
            }
            // dd($diffVendor);
            // $quotesVen = DB::table('quotes')
            //             ->where('rfq_id', '=', $id)
            //             ->get();
            for($d = 0;$d<count($diffVendor);$d++){
                $delUp = DB::table('quotes','quote_details')
                            ->join('quote_details', 'quote_details.quote_id', '=', 'quotes.quote_id')
                            ->where('quotes.vendor_id', '=', $diffVendor[$d])
                            ->where('quotes.rfq_id', '=', $id)->delete();
            }

        }
        if(isset($data['deleteRfqDetail']) && ($data['deleteRfqDetail']!=null) && trim($data['deleteRfqDetail'])!=''){
            $delRfq = explode(",",$data['deleteRfqDetail']);
            // dd($delRfq);
            for($s = 0;$s<count($delRfq);$s++){
                $delRfqItem = DB::table('rfq_details')
                                // ->join('rfq', 'rfq.rfq_id', '=', 'rfq_details.rfq_id')
                                // ->join('quotes', 'quotes.rfq_id', '=', 'rfq_details.rfq_id')
                                // ->join('quote_details', 'quote_details.quote_id', '=', 'quotes.quote_id')
                                ->where('rfq_details.rfqd_id', '=', $delRfq[$s])
                                ->where('rfq_details.rfq_id', '=', $id)->delete();

                
            }
        }
        if ($params->input('rfqNumber') != null && trim($params->input('rfqNumber')) != '') {
            $issuedOn = $commonservice->dateFormat($data['issuedOn']);
            $lastDate = $commonservice->dateFormat($data['lastdate']);
            $rfq = array(
                'rfq_number' => $data['rfqNumber'],
                'rfq_issued_on' => $issuedOn,
                'last_date' => $lastDate,
                'rfq_status' => 'draft',
                'updated_by' => session('userId'),
                'updated_on' => $commonservice->getDateTime(),
            );
           
            $rfqUp = DB::table('rfq')
                    ->where('rfq_id', '=', $id)
                    ->update(
                        $rfq
                    );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'RFQ-update', 'Update Rfq ' . $data['rfqNumber'], 'Rfq');
        }

        // rfq detail
        for($i=0;$i<count($data['item']);$i++){
            $rfqItemDetails = array(
                                'rfq_id' => $id,
                                'item_id' => $data['item'][$i],
                                'uom' => $data['unitId'][$i],
                                'quantity' => $data['qty'][$i],
                            );

            if(isset($data['rdId'][$i]) && $data['rdId'][$i]!=''){
                $rfqItemUp = DB::table('rfq_details') ->where('rfqd_id','=', $data['rdId'][$i])
                        ->update($rfqItemDetails);
            }else{
                $rfqItemUp = DB::table('rfq_details')->insert($rfqItemDetails);
            }
        }

        //quotes and quotes detail
        if(isset($data['vendors']) && ($data['vendors']!=null)){
            for($f=0;$f<count($data['vendors']);$f++){
                $result = DB::table('quotes')
                            ->where('quotes.vendor_id', '=', $data['vendors'][$f])
                            ->where('quotes.rfq_id', '=', $id)->get();
                // print_r($result);
                $quotes = array(
                    'rfq_id' => $id,
                    'vendor_id' => $data['vendors'][$f],
                );
                if(count($result)>0){
                    print_r($result[0]->vendor_id);
                    $quotesUp = DB::table('quotes')
                                ->where('rfq_id', '=', $id)
                                ->where('vendor_id', '=', $data['vendors'][$f])
                                ->update(
                                    $quotes
                                );
                }
                else{
                    $quotesIns = DB::table('quotes')->insertGetId(
                                    [
                                    'rfq_id' => $id,
                                    'vendor_id' => $data['vendors'][$f],
                                    ]
                                );
                    if ($request->input('item')!=null) {
                        for($j=0;$j<count($data['item']);$j++){
                            $quotesDetails = DB::table('quote_details')->insertGetId(
                                [
                                'quote_id' => $quotesIns,
                                'item_id' => $data['item'][$j],
                                'uom' => $data['unitId'][$j],
                                'quantity' => $data['qty'][$j],
                                ]
                            );
                        }
                    }
                }
                
            }
        }
        if ($rfqUp) {
            $response = 1;
        }
        return $response;
    }
}
