<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory;

    protected $fillable = [
        "link",
        "wallet_account_id",
        "for_user_id",
        "account_number",
        "amount",
        "generatedBy",
        "status",
        "payment_on"
    ];
}
