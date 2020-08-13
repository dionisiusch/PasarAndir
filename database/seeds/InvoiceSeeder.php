<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->insert([
            'stall_id' => 1,
            'stall_electricity_id' => 1,
            'stall_water_id' => 1,
            'discount' => 0,
            'minimal_payment' => 100000,
            'fine' => 0,
            'month_bill' => 'Agustus 2020',
            'grace_date' => Carbon::createFromDate(2020, 8, 1, 'Asia/Jakarta')->toDateString(),
            'status' => 'Lunas',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('invoices')->insert([
            'stall_id' => 2,
            'stall_electricity_id' => 2,
            'stall_water_id' => 2,
            'discount' => 0,
            'minimal_payment' => 100000,
            'fine' => 0,
            'month_bill' => 'Agustus 2020',
            'grace_date' => Carbon::createFromDate(2020, 8, 1, 'Asia/Jakarta')->toDateString(),
            'status' => 'Lunas',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
