<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'key',
        'api_quota',
        'total_requests',
        'extra_secure',
        'security_header',
        'request_hit'
    ];
}
