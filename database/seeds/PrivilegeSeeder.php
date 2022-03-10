<?php

use Illuminate\Database\Seeder;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privileges')->insert([
            'resource_id' => 'App\\Http\\Controllers\\AuditTrail\\AuditTrailController',
            'privilege_name' => 'index',
            'display_name' => 'Access',
        ]);
    }
}
