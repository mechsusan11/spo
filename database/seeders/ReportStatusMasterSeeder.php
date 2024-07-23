<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportStatusMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reportstatus = [
            ['report_status' => 'FIR Register'],
            ['report_status' => 'CSR Register'],
            ['report_status' => 'False Complaint'],
            ['report_status' => 'Accused Escaped'],
        ];
        DB::table('report_status_master')->insert($reportstatus);
    }
}
