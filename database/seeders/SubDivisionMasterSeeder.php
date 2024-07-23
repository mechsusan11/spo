<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubDivisionMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subdivisions = [
            ['name' => 'நகரம் | Town', 'order' => 1],
            ['name' => 'வல்லம் | Vallam', 'order' => 2],
            ['name' => 'ஓரத்தநாடு | Orthanadu', 'order' => 3],
            ['name' => 'பட்டுக்கோட்டை | Pattukotai', 'order' => 4],
            ['name' => 'திருவையாறு | Thiruvaiyaru', 'order' => 5],
            ['name' => 'நகர்ப்புறம்  | Rural', 'order' => 6],
            ['name' => 'கும்பகோணம் | Kumbakonam', 'order' => 7],
            ['name' => 'திருவிடைமருதூர் | Thiruvidaimarudhur', 'order' => 8],
            ['name' => 'உறுதியாக தெரியவில்லை | Not Sure', 'order' => 9]
        ];
        DB::table('sub_division_master')->insert($subdivisions);
    }
}
