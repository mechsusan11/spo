<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class PoliceUser extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $guard = 'police_users';
    protected $table = 'police_users';
    protected $fillable = [
        'name',
        'username',
        'mobile',
        'sub_division',
        'ip_address',
        'password'
    ];
}
