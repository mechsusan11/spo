<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reportType = [
            ['success_message' => "Submitted Successfully\nவெற்றிகரமாக சமர்ப்பிக்கப்பட்டது:We are grateful for your invaluable contribution in making our Thanjavur a safer place for the future.\nநமது தஞ்சாவூரை எதிர்காலத்திற்கு பாதுகாப்பான இடமாக மாற்றுவதில் உங்களின் விலைமதிப்பற்ற பங்களிப்பிற்கு நன்றி.", 'app_name' => "public_app"],
            ['success_message' => "Report Updated Successfully", 'app_name' => "police_app"],
        ];
        DB::table('app_config_master')->insert($reportType);
    }
}
