<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StallWaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stall_waters')->insert([
            'stall_id' => 1,
            'meter_before' => 0,
            'meter_after' => 10,
            'price' => 5000,
            'fixed_price' => 0,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('stall_waters')->insert([
            'stall_id' => 2,
            'meter_before' => 0,
            'meter_after' => 10,
            'price' => 5000,
            'fixed_price' => 0,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
