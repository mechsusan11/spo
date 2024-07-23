<?php

namespace App\Http\Controllers;

use App\Models\ReportStatusModel;
use Illuminate\Http\Request;

class ReportStatusController extends Controller
{
    public function getReportStatus()
    {
        $report_status = ReportStatusModel::all();
        return view('pages.reportStatus',compact('report_status'));
    }
}
