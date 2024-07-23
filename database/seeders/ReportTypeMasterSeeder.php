<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportTypeMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reportType = [
            ['icon_path' => 'assets/icons/drugs.svg', 'report_type' => 'போதைப்பொருள் | Drugs'],
            ['icon_path' => 'assets/icons/gambling.svg', 'report_type' => 'சூதாட்டம் & குலுக்குச்சீட்டு | Gambling & Lottery'],
            [
                'icon_path' => 'assets/icons/liquor.svg', 'report_type' => 'கள்ள சாராயம், பொது இடத்தில் மது அருந்துதல், சட்டவிரோத மது விற்பனை |
Spurious liquor, Open place drinking , Illegal liquor sale'
            ],
            ['icon_path' => 'assets/icons/sand_robbery.svg', 'report_type' => 'மணல் கொள்ளை | Sand Theft']
        ];
        DB::table('report_type_master')->insert($reportType);
    }
}
