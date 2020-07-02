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
        // dd($_FILES['uploadFile']['name']);
        // dd($data);
        $filePath = '';
        $fileName = '';
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
        if (isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != '') {
            if (!file_exists(public_path('uploads')) && !is_dir(public_path('uploads'))) {
                mkdir(public_path('uploads'),0755,true);
                // chmod (getcwd() .public_path('uploads'), 0755 );
            }
            
            if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "rfq") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "rfq")) {
                mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "rfq", 0755);
            }

            $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "rfq" . DIRECTORY_SEPARATOR . $id;
            
            if (!file_exists($pathname) && !is_dir($pathname)) {
                mkdir($pathname);
            }

            $extension = strtolower(pathinfo($pathname . DIRECTORY_SEPARATOR . $_FILES['uploadFile']['name'], PATHINFO_EXTENSION));
            $fileName = time(). "." . $extension;

            $filePath = $pathname . DIRECTORY_SEPARATOR .$fileName;
            if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $pathname . DIRECTORY_SEPARATOR .$fileName)) {
                $uploadData = array('rfq_upload_file' => $filePath);
                $rfqUp = DB::table('rfq')
                        ->where('rfq_id', '=', $id)
                        ->update(
                            $uploadData
                        );
            }
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
                if (file_exists($filePath)) {
                    if (!file_exists(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes") && !is_dir(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes")) {
                        mkdir(public_path('uploads') . DIRECTORY_SEPARATOR . "quotes", 0755);
                    }
        
                    $pathname = public_path('uploads') . DIRECTORY_SEPARATOR . "quotes" . DIRECTORY_SEPARATOR . $quotes;
                    
                    if (!file_exists($pathname) && !is_dir($pathname)) {
                        mkdir($pathname);
                    }
                    
                    $quotesFilePath = $pathname . DIRECTORY_SEPARATOR .$fileName;
                    if (copy($filePath, $quotesFilePath)) {
                        $uploadData = array('quotes_upload_file' => $quotesFilePath);
                        $quotesUp = DB::table('quotes')
                                ->where('quote_id', '=', $quotes)
                                ->update(
                                    $uploadData
                                );
                    }
                }
            }
            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), $id, 'quotes-add', 'add quotes '.$id, 'quotes');
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
        // dd($data);
        $commonservice = new CommonService();
        if(isset($data['vendorDetail']) && ($data['vendorDetail']!=null) && trim($data['vendorDetail'])!=''){

            $delVen = explode(",",$data['vendorDetail']);
            if(isset($data['vendors']) && ($data['vendors']!=null)){
                $diffVendor = array_diff($delVen, $data['vendors']);
            }
            else{
                $diffVendor = $delVen;
            }
           
            foreach($diffVendor as $key=>$value){
                $quoteDeleteId = DB::table('quotes')
                                ->where('quotes.vendor_id', '=', $value)
                                ->where('quotes.rfq_id', '=', $id)->select('quote_id')->get();

                if($quoteDeleteId){
                    $delQuoteByVendor = DB::table('quotes')
                                        ->where('quotes.vendor_id', '=', $value)
                                        ->where('quotes.rfq_id', '=', $id)->delete();
                    $delQuoteDetailByVendor = DB::table('quote_details')
                                ->where('quote_id', '=', $quoteDeleteId[0]->quote_id)->delete();
                }
            }

        }
        $quoteId = DB::table('quotes')
                    ->where('quotes.rfq_id', '=', $id)->select('quote_id')->get();
        if(isset($data['deleteRfqDetail']) && ($data['deleteRfqDetail']!=null) && trim($data['deleteRfqDetail'])!=''){
                        // dd($quoteId);
            $delRfq = explode(",",$data['deleteRfqDetail']);
            // dd($delRfq);
            for($s = 0;$s<count($delRfq);$s++){
                $itemDetails = DB::table('rfq_details')
                                ->where('rfq_details.rfqd_id', '=', $delRfq[$s])
                                ->where('rfq_details.rfq_id', '=', $id)->get();
                                // dd($itemDetails);
                $delRfqItem = DB::table('rfq_details')
                                ->where('rfq_details.rfqd_id', '=', $delRfq[$s])
                                ->where('rfq_details.rfq_id', '=', $id)->delete();
                
                for($q=0;$q<count($quoteId);$q++){
                    if($itemDetails && $quoteId){
                        $delQuoteItem = DB::table('quote_details')
                                            ->where('quote_details.quote_id', '=', $quoteId[$q]->quote_id)
                                            ->where('quote_details.item_id', '=', $itemDetails[0]->item_id)->delete();
                    }
                }
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
                $rfqItemIns = DB::table('rfq_details')->insert($rfqItemDetails);
            }
        }

        //quotes and quotes detail
        if(isset($data['vendors']) && ($data['vendors']!=null)){
            for($f=0;$f<count($data['vendors']);$f++){
                $result = DB::table('quotes')
                            ->where('quotes.vendor_id', '=', $data['vendors'][$f])
                            ->where('quotes.rfq_id', '=', $id)->get();
                $quotes = array(
                    'rfq_id' => $id,
                    'vendor_id' => $data['vendors'][$f],
                );
                if(count($result)>0){
                    for($i=0;$i<count($data['item']);$i++){
                        $quoteItemDetails = array(
                            'quote_id' => $result[0]->quote_id,
                            'item_id' => $data['item'][$i],
                            'uom' => $data['unitId'][$i],
                            'quantity' => $data['qty'][$i]
                        );
                        if(isset($data['rdId'][$i]) && $data['rdId'][$i]!=''){
                            $itemDetails = DB::table('rfq_details')
                                            ->where('rfq_details.rfqd_id', '=', $data['rdId'][$i])
                                            ->where('rfq_details.rfq_id', '=', $id)->get();
            
                            if($itemDetails && $result[0]->quote_id){
                                $quoteItemUp = DB::table('quote_details')
                                                ->where('quote_details.quote_id', '=', $result[0]->quote_id)
                                                ->where('quote_details.item_id', '=', $itemDetails[0]->item_id)
                                                ->update($quoteItemDetails);
                            }
                        }else{
                            $quotesItemIns = DB::table('quote_details')->insert($quoteItemDetails);
                        }
                    }
                }
                else{
                    $quotesIns = DB::table('quotes')->insertGetId(
                                    [
                                    'rfq_id' => $id,
                                    'vendor_id' => $data['vendors'][$f],
                                    ]
                                );
                    if ($params->input('item')!=null) {
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
                    $commonservice = new CommonService();
                    $commonservice->eventLog(session('userId'), $id, 'Quotes-update', 'Update Quotes ' . $id, 'Quotes');
                }
                
            }
        }
        if ($rfqUp || $delQuoteItem || $delRfqItem || $quotesDetails || $quotesIns || $quoteItemUp || $quotesItemIns || $rfqItemUp || $rfqItemIns) {
            $response = 1;
        }
        return $response;
    }
}
