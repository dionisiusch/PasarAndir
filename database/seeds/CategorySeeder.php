<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Kelontong',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('categories')->insert([
            'name' => 'Grosir',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
