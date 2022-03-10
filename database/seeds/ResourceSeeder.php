<?php

use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resources')->insert([
            'resource_id' => 'App\\Http\\Controllers\\AuditTrail\\AuditTrailController',
            'display_name' => 'AuditTrail',
            'status' => 'active',
        ]);
    }
}
