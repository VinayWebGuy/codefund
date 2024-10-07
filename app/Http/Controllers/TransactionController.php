<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Auth;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function allTransactions() {
        $transactions = Transaction::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('inner.user-allTransactions', compact('transactions'));
    }
}
