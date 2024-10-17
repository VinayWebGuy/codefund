<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;


    protected $fillable = [
        "user_id",
        "name",
        "email",
        "account_number",
        "mobile",
        "friend_user_id",
        "status"
    ];
}
