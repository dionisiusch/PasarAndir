<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employers')->insert([
            'role_id' => 1,
            'username' => 'gmandir',
            'password' => Hash::make('gmandir'),
            'name' => 'General Manager Pasar Andir',
            'email' => 'gmandir@pasarandir.com',
            'phone_number' => '081122334455',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('employers')->insert([
            'role_id' => 2,
            'username' => 'adminandir',
            'password' => Hash::make('adminandir'),
            'name' => 'Admin Pasar Andir',
            'email' => 'admin@pasarandir.com',
            'phone_number' => '081122334466',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('employers')->insert([
            'role_id' => 3,
            'username' => 'collectorandir',
            'password' => Hash::make('collectorandir'),
            'name' => 'Collector Pasar Andir',
            'email' => 'collectorandir@pasarandir.com',
            'phone_number' => '081122334477',
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
