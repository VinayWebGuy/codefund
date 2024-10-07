<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Api;
use App\Models\WalletAccount;
use App\Models\Transaction;
use App\Models\PaymentLink;
use Auth;
use DB;

use Illuminate\Http\Request;

class InnerController extends Controller
{
    public function adminIndex() {
        $users = User::where('role', 2)->get();
        $activeUsers = User::where('status', 1)->where('role', 2)->get();
        $transactionsCount = Transaction::distinct('transaction_id')->count();
        $transactionsSum = Transaction::groupBy('transaction_id')
                                      ->selectRaw('transaction_id, MAX(amount) as max_amount')
                                      ->pluck('max_amount')
                                      ->sum();
        $recentTransactions =  Transaction::join('users', 'transactions.user_id', '=', 'users.id')
                                          ->select('transactions.*', 'users.name as username')
                                          ->orderBy('transactions.created_at', 'desc')
                                          ->limit(5)
                                          ->get();
        return view('inner.admin-index', compact('users', 'activeUsers', 'transactionsCount', 'transactionsSum', 'recentTransactions'));
    }
    public function userIndex() {
        $transactionsCount = Transaction::where('user_id', Auth::id())->count();
        $recentTransactions =  Transaction::where('user_id', Auth::id())->orderBy('created_at', 'desc')->limit(5)->get();
        $transactionsSum = Transaction::where('user_id', Auth::id())->sum('amount');
        return view('inner.user-index', compact('transactionsCount', 'transactionsSum', 'recentTransactions'));
    }

    public function apiManager() {
        $keys = Api::where('user_id', Auth::id())->get();
        return view('inner.user-apiManager', compact('keys'));
    }
    public function apiUsage() {
        return view('inner.user-apiUsage');
    }
    public function addFunds() {
        return view('inner.user-addFunds');
    }
    public function fundsTransfer() {
        return view('inner.user-fundsTransfer');
    }
    public function profile() {
        $wallet_account = WalletAccount::where('user_id', Auth::id())->first();
        return view('inner.user-profile', compact('wallet_account'));
    }

    public function createAccount() {
        // Check account is created or not
        $account = WalletAccount::where('user_id',  Auth::id())->first();
        if(!$account) {
            do {
                $account_number = rand(1111111111111, 99999999999999);
            } while (WalletAccount::where('account_number', $account_number)->exists());
            $ac = WalletAccount::create([
                'user_id' => Auth::id(),
                'account_number' => $account_number
            ]);
            return redirect()->back()->with('success', 'Wallet account generated successfully!');
        }
        else {
            return redirect('main/user/profile')->with('error', 'Wallet Account already created');
        }
    }


    public function mainIndex() {
        if(Auth::user()->role == 1) {
            return redirect('main/user');
        }
        else {
            return redirect('main/admin');
        }
    }

    public function allUsers() {
        $users = User::where('role', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('inner.admin-allUsers', compact('users'));
    }
    public function changeUserStatus($uid) {
        $user = User::where('unique_id', $uid)->first();
        if($user) {
            $user->status = $user->status == 1 ? 0 : 1;
            $user->save();
            return redirect()->back()->with('success', 'User status updated successfully!');
        }
        else {
            return redirect()->back()->with('error', 'Invalid action!');
        }
    }

    public function paymentLink() {
        return view('inner.user-paymentLink');
    }
    public function allPaymentLinks() {
        $links = DB::table('payment_links')
            ->join('users', 'payment_links.for_user_id', '=', 'users.id')
            ->where('payment_links.generatedBy', Auth::id())
            ->select('payment_links.*', 'users.email as email')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $forMeLinks = DB::table('payment_links')
            ->join('users', 'payment_links.generatedBy', '=', 'users.id')
            ->where('payment_links.for_user_id', Auth::id())
            ->select('payment_links.*', 'users.email as email')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('inner.user-allPaymentLinks', compact('links', 'forMeLinks'));
    }
}
