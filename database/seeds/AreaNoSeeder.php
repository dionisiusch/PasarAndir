<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AreaNoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('area_nos')->insert([
            'area_id' => 1,
            'no_id' => 1,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('area_nos')->insert([
            'area_id' => 2,
            'no_id' => 1,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
