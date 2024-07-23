<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTypeModel extends Model
{
    use HasFactory;
    protected $table = 'report_type_master';
    protected $primarykey = 'id';

    public function reports()
    {
        return $this->hasMany(ReportModel::class, 'report_type', 'id');
    }
}
