<?php

use Illuminate\Database\Seeder;

class GlobalConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('global_config')->insert([
            'display_name' => 'Map Zoom Level',
            'global_name' => 'map_zoom_level',
            'global_value' => '3',
        ]);
    }
}
