<?php
/*
Author             : Sriram V
Date               : 25 June 2020
Description        : Quotes Table Page
Last Modified Date : 
Last Modified Name : 
*/

namespace App\Model\Quotes;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\QuotesService;
use App\Service\CommonService;

class QuotesTable extends Model
{
    protected $table = 'quotes';

    // Fetch All Quotes List
    public function fetchAllQuotes()
    {
        $data = DB::table('quotes')
            ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            // ->join('units_of_measure', 'units_of_measure.uom_id', '=', 'items.base_unit')
            ->get();
        return $data;
    }

    // fetch particular Quotes  details
    public function fetchQuotesById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('quotes')
            ->join('rfq', 'rfq.rfq_id', '=', 'quotes.rfq_id')
            ->join('vendors', 'vendors.vendor_id', '=', 'quotes.vendor_id')
            ->where('quote_id', '=', $id)->get();
        $data['quotesdetails'] =  DB::table('quote_details')
            ->join('quotes', 'quotes.quote_id', '=', 'quote_details.quote_id')
            ->join('items', 'items.item_id', '=', 'quote_details.item_id')
            ->where('quote_details.quote_id', '=', $id)->get();
        return $data;
    }

    // Update particular Quotes  details
    public function updateQuotes($params, $id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('quoteNumber') != null && trim($params->input('quoteNumber')) != '') {

            for($i=0;$i<count($data['quoteQty']);$i++){
                $quoteDetailsData = array(
                    'quantity'=>$data['quoteQty'][$i],
                    'unit_price'=>$data['unitPrice'][$i],
                    'updated_on' => $commonservice->getDateTime(),
                    );
    
                    $ordUp = DB::table('quote_details') ->where('qd_id','=', $data['qdId'][$i])
                            ->update($quoteDetailsData);
            }

            $response = DB::table('quotes')
                ->where('quote_id', '=', base64_decode($id))
                ->update(
                    [
                        'quote_number' => $data['quoteNumber'],
                        'quotes_status' => 'responded',
                        'responded_on' => $commonservice->getDateTime(),
                    ]
                );

            $commonservice = new CommonService();
            $commonservice->eventLog(session('userId'), base64_decode($id), 'Quote-update', 'Update Quaote ' . $data['quoteNumber'], 'Item');
        }
        return $response;
    }
}
