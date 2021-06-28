<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class ODKDataCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odkdata:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Odk Data save';

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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://odk-central.labsinformatics.com/v1/sessions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"email\": \"support@deforay.com\",
        \"password\": \"mko)(*&^\"
        }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $email = 'support@deforay.com';
        $password = 'mko)(*&^';
        $token = base64_encode($email . ':' . $password);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://odk-central.labsinformatics.com/v1/projects/5/forms/Monthly_Report/submissions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic $token",
        ));
        $response1 = curl_exec($ch);
        $submission = json_decode($response1,TRUE);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://odk-central.labsinformatics.com/v1/projects/5/forms/Monthly_Report/submissions/".$submission[0]['instanceId'].".xml");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic $token",
            "Content-Type: application/xml"    
        ));
        $response2 = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($response2);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        // DB::beginTransaction();
        //         \Log::info("Test cron");
        // DB::commit();
        
    }
}
