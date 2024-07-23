<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfigModel extends Model
{
    use HasFactory;
    protected $table = 'app_config_master';
    protected $primarykey = 'id';
}
