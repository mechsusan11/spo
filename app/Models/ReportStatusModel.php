<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStatusModel extends Model
{
    use HasFactory;
    protected $table = 'report_status_master';
    protected $primarykey = 'id';
}
