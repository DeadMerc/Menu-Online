<?php

use Illuminate\Database\Seeder;

class StatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stats')->insert([
            'views' => 150
        ]);
    }
}
