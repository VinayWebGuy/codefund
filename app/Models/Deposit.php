<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        "ref_id",
        "amount",
        "open_secret_code",
        "secret_code",
        "is_used",
        "used_by",
        "expiry",
        "added_by"
    ];
    public function usedBy() {
        return $this->belongsTo(User::class, 'used_by');
    }
    
    public function addedBy() {
        return $this->belongsTo(User::class, 'added_by');
    }
}
