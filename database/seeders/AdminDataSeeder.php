<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admindata = [
            [
                "ip_address" => json_encode('127.0.0.1'),
                'name' => "sp",
                "username" => "sp",
                "mobile" => "9466543885",
                "sub_division" => 9,
                "password" => Hash::make('spo@12345'),
                "role" => "sp"
            ],
        ];
        DB::table('police_users')->insert($admindata);
    }
}
