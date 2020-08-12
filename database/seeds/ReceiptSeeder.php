<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receipts')->insert([
            'stall_id' => 1,
            'payment' => 300000,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('receipts')->insert([
            'stall_id' => 2,
            'payment' => 300000,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
