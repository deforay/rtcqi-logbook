<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\GlobalConfigService;
use App\Service\CommonService;
use DB;

class UserLoginExpireCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UserLoginExpire:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'alert user login expire';

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
     * @return int
     */
    public function handle()
    {
        $globalConfigService = new GlobalConfigService();
        $commonservice = new CommonService();
        $disableInactiveUser = $globalConfigService->getGlobalConfigValue('disable_inactive_user');
        
        if($disableInactiveUser=='yes'){
            //Get host name
            $host = request()->getHttpHost();
            $noOfMonths = $globalConfigService->getGlobalConfigValue('disable_user_no_of_months');
            $currentDate=Date("d-M-Y");
            if(trim($noOfMonths)==""){
                $noOfMonths=5;
            }else{
                $noOfMonths=$noOfMonths-1;
            }
            $userData = DB::table('users')
                ->select('user_id','first_name','last_name','email','phone','last_login_datetime')
                ->where('user_status', '=', 'active')
                ->get();
            $subject="[Important] Your ".$host." login will expire soon";
            $expiryDate = date('01-M-Y', strtotime('+1 month'));
            foreach($userData as $val){
                if(isset($val->last_login_datetime) && trim($val->last_login_datetime)!=""){
                    $lastLoginDatetime=$val->last_login_datetime;

                    //Calculate number of month
                    $diff = abs(strtotime($currentDate)-strtotime($lastLoginDatetime));
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    
                    if($months>=$noOfMonths){
                        $fromName=$val->first_name;
                        $to=$val->email;
                        $msg="Dear ".$val->first_name.' '.$val->last_name.',<br/><br/>';
                        $msg.="Your ".$host." login will expire on ".$expiryDate." Please click on <a href='".$host."'  target='_blank'>".$host."</a> to login and ensure it does not expire.<br/><br/><br/>";
                        $msg.="Thanks <br/><small>Please note this is a system generated email</small>";
                        $fromMail="";
                        $commonservice->insertTempMail($to,$subject,$msg,$fromMail,$fromName);
                    }
                }
            }
        }
    }
}
