<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periods')->insert([
          ['name'=>'year'],
          ['name'=>'month'],
          ['name'=>'week'],
          ['name'=>'day'],
          ['name'=>'simple']
        ]);
    }
}
