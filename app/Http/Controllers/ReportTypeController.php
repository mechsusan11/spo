<?php

namespace App\Http\Controllers;

use App\Models\ReportTypeModel;

class ReportTypeController extends Controller
{
    public function getReportTypes()
    {
        $report_types = ReportTypeModel::all();
        return view('pages.reportType', compact('report_types'));
    }

    public function report_type()
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['public', 'sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $report_type = ReportTypeModel::all();
        if (auth('sanctum')->user()) {
            return  response()->json([
                "status" => "true",
                "message" => "Successfully retrieved report types",
                "data" =>  $report_type
            ]);
        }
        return response()->json([
            "status" => "false",
            "message" => "Retrieval failed",
            "data" =>  []
        ]);
    }
}
