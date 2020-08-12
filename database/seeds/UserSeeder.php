<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'userandir1',
            'password' => Hash::make('userandir1'),
            'pic_name' => 'User Pasar Andir 1',
            'pic_phone_number' => '081122223333',
            'joined_date' => Carbon::now('Asia/Jakarta')->toDateString(),
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'username' => 'userandir2',
            'password' => Hash::make('userandir2'),
            'pic_name' => 'User Pasar Andir 2',
            'pic_phone_number' => '081122224444',
            'joined_date' => Carbon::now('Asia/Jakarta')->toDateString(),
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
