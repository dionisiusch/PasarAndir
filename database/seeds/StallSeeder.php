<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stalls')->insert([
            'user_id' => 1,
            'area_no_id' => 1,
            'category_id' => 1,
            'name' => 'Toko Kelontong Kevin Hoax',
            'length' => 1,
            'width' => 1,
            'height' => 1,
            'status' => 'Aktif',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('stalls')->insert([
            'user_id' => 2,
            'area_no_id' => 2,
            'category_id' => 2,
            'name' => 'Toko Grosir Kevin Hoax',
            'length' => 1,
            'width' => 1,
            'height' => 1,
            'status' => 'Tidak Aktif',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
