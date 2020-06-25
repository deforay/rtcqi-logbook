<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class ItemPriceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'itemprice:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Item Price Stock';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $today_date = date('Y-m-d');
        // $today_date = "2020-02-07";
        $yesterday_date = date('Y-m-d',strtotime("-1 days"));
        DB::beginTransaction();
        $items = DB::table('items')
                ->get()
                ;
        for($i=0;$i<count($items);$i++)
        {
            $todayItemPrice =DB::table('item_price_records')
                ->where('purchase_date', '=',$today_date )
                ->where('item_id', '=',$items[$i]->item_id )
                ->get();
            if(count($todayItemPrice) == 0)
            {
                $yesterdayItemPrice =DB::table('item_price_records')
                    ->where('purchase_date', '=',$yesterday_date )
                    ->where('item_id', '=',$items[$i]->item_id )
                    ->get();
                if(count($yesterdayItemPrice)>0)
                {
                    $insertItemPrice = DB::table('item_price_records')->insertGetId(
                        [
                        'item_id' => $items[$i]->item_id,
                        'purchase_date' => $today_date,
                        'unit_price' => $yesterdayItemPrice[0]->unit_price
                        ]
                    );
                    \Log::info('Inserted The item price data with Yesterday value for item id - '.$items[$i]->item_name."  val  - ".$insertItemPrice);
                }
                else{
                    $insertItemPrice = DB::table('item_price_records')->insertGetId(
                        [
                        'item_id' => $items[$i]->item_id,
                        'purchase_date' => $today_date,
                        'unit_price' => 0
                        ]
                    );
                    \Log::info('Inserted The item price data with 0 value for item id - '.$items[$i]->item_name."  val  - ".$insertItemPrice);
                }
            }
            else{
                \Log::info("Price list is already ran for item - ".$items[$i]->item_name);
            }
        }
        DB::commit();
        
    }
}
