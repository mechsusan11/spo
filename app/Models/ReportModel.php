<?php

namespace App\Models;

use App\Http\Controllers\ReportTypeController;
use App\Http\Controllers\SubDivisionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    use HasFactory;

    protected $table = 'report'; // Table name
    protected $primaryKey = 'id'; // Primary key

    public function reportType()
    {
        return $this->belongsTo(ReportTypeModel::class, 'report_type', 'id');
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivisionModel::class, 'sub_division', 'id');
    }
}
