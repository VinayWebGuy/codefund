<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        	'amount',
        	'user_id',
			'transaction_id',
        	'type',
        	'closing_balance',
        	'remarks',
        	'narration',
            'from_where',
        	'from_where_id'
    ]; 

}
