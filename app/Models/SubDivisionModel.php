<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDivisionModel extends Model
{
    use HasFactory;
    protected $table = 'sub_division_master';
    protected $primarykey = 'id';

    public function reports()
    {
        return $this->hasMany(ReportModel::class, 'sub_division', 'id');
    }
}
