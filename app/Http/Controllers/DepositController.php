<?php

namespace App\Http\Controllers;
use App\Models\Deposit;
use Auth;
use App\Models\User;
use App\Models\Transaction;
use App\Models\WalletAccount;
use App\Models\PaymentLink;
use Str;


use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function addDeposit() {
        return view('inner.admin-addDeposit');
    }
    public function saveDeposit(Request $req) {
        $req->validate([
            'ref_id' => 'required|unique:deposits',
            'amount' => 'required',
        ]);
        if ($req->expiry == 1) {
            $expiry_date = now()->addDays($req->expiry_days);
        } else {
            $expiry_date = null;
        }
        $secret_code = rand(111111,999999);
        $deposit = Deposit::create([
            'ref_id' => $req->ref_id,
            'amount' => $req->amount,
            'expiry' => $expiry_date,
            'open_secret_code' => $secret_code,
            'secret_code' => md5($secret_code),
            'added_by' => Auth::id()
        ]);
        return redirect()->back()->with('success', 'Deposit added successfully! Here is the payment deposit code '.$secret_code.'');
    }

    public function allDeposits() {
        $deposits = Deposit::orderBy('id', 'desc')->paginate(10);
        return view('inner.admin-allDeposits', compact('deposits'));
    }

    public function addFunds(Request $req) {
        $req->validate([
            'ref_id' => 'required',
            'amount' => 'required',
            'secret_code' => 'required'
        ]);
        // Check Deposit
        $deposit = Deposit::where('ref_id', $req->ref_id)->where('amount', $req->amount)->where('secret_code', md5($req->secret_code))->first();
        if($deposit) {
            // Check Expiry
            if($deposit->is_used == 1) {
                return redirect()->back()->with('error', 'This entry has been already used by someone else!')->withInput();
            }
            if($deposit->expiry != "" &&  $deposit->expiry < now()) {
                return redirect()->back()->with('error', 'Oops! This entry has been expired. Kindly contact the admin to renew this.')->withInput();
            }
                $deposit->is_used = 1;
                $deposit->used_by = Auth::id();
                $deposit->save();
                $remarks = 'Added from deposit code '.$deposit->ref_id;
                $txn_id = $this->generateTransactionId();
                $this->makeTransaction(Auth::id(), $txn_id, $deposit->amount, "Deposit", $deposit->id, "Credit", $remarks);
                return redirect()->back()->with('success', 'Fund added successfully!');
        }
        else {
            return redirect()->back()->with('error', 'You are entering invalid details.')->withInput();
        }
    }

    public function fundsTransfer(Request $req) {
        $req->validate([
            'amount' => 'required',
            'account_number' => 'required',
        ]);
        // Validate balance
        $user = User::find(Auth::id());
        if($user->wallet_balance < $req->amount) {
            return redirect()->back()->with('error', "You don't have enough balance to perform this transaction.")->withInput();
        }
        // Validate Acccount Number
        $account = WalletAccount::where('account_number', $req->account_number)->first();
        $myAccount = WalletAccount::where('user_id', Auth::id())->first();
     
        if($req->account_number  == $myAccount->account_number) {
            return redirect()->back()->with('error', "You can't send balance to your own account.")->withInput();
        }
        if(!$account) {
            return redirect()->back()->with('error', "Please enter a valid account number.")->withInput();
        }
        if($account->status == 0) {
            return redirect()->back()->with('error', "This account has been blocked")->withInput();
        }
        $txn_id = $this->generateTransactionId();
        $remarks1 = "Funds transfered successfully to ".$account->account_number;
        $remarks2 = "Funds received by ".$myAccount->account_number;
        $this->makeTransaction(Auth::id(), $txn_id, $req->amount, "Fund Transfer", $account->user_id, "Debit", $remarks1);
        $this->makeTransaction($account->user_id, $txn_id, $req->amount, "Fund Transfer", Auth::id(), "Credit", $remarks2);
        return redirect()->back()->with('success', "Funds transferred successfully.");
    }

    private function makeTransaction($user_id, $txn_id, $amount, $from_where, $from_where_id, $type, $remarks) {
        // Update Balance
        $user = User::find($user_id);
        
        if ($type == 'Credit') {
            $user->wallet_balance = $user->wallet_balance + $amount;
        } else {
            $user->wallet_balance = $user->wallet_balance - $amount;
        }
        
        $user->save();
    
        // Save Transaction
        $transaction = Transaction::create([
            'amount' => $amount,
            'transaction_id' => $txn_id,
            'user_id' => $user_id,
            'type' => $type,
            'closing_balance' => $user->wallet_balance,
            'remarks' => $remarks,
            'from_where' => $from_where,
            'from_where_id' => $from_where_id
        ]);
        return $transaction;
    }

    private function generateTransactionId() {
        do {
            $transaction_id = rand(1000000000,9999999999);
        } while (Transaction::where('transaction_id', $transaction_id)->exists());

        return $transaction_id;
    }

    public function generatePaymentLink(Request $req) {
        $req->validate([
            'amount' => 'required',
            'account_number' => 'required',
        ]);
        $wallet = WalletAccount::where('account_number', $req->account_number)->first();
        $myAccount = WalletAccount::where('user_id', Auth::id())->first();
        if(!$wallet) {
            return redirect()->back()->with('error', "Invalid account number.")->withInput();
        }
        if($req->account_number  == $myAccount->account_number) {
            return redirect()->back()->with('error', "You can't create a link for your own")->withInput();
        }
        $link = $this->createRandomPaymentLink();
        $payment = PaymentLink::create([
            'amount' => $req->amount,
            'link' => $link,
             'wallet_account_id' => $wallet->id,
             'for_user_id' => $wallet->user_id,
             'account_number' => $req->account_number,
             'generatedBy' => Auth::id(),
        ]);
        return redirect()->back()->with('success', 'Link created successfully.');
    }
    private function createRandomPaymentLink() {
        do {
            $randomLink = Str::random(35);
        } while (PaymentLink::where('link', $randomLink)->exists());

        return $randomLink;
    }

    public function payViaLink($link) {
        $link = PaymentLink::where('link', $link)->first();
        $user = User::find(Auth::id());
        if($link->generatedBy == Auth::id()) {
            return redirect('main/user/transactions')->with('error', "You can't send balance to your own account.");
        }
        // Validate Acccount Number
        $account = WalletAccount::where('user_id', $link->generatedBy)->first();
        $myAccount = WalletAccount::where('user_id', Auth::id())->first();
        
        if(!$account) {
            return redirect()->back()->with('error', "Please enter a valid account number.");
        }
        if($link->account_number != $myAccount->account_number) {
            return redirect()->back()->with('error', "This link is not valid or has been expired");
        }
        if($user->wallet_balance < $link->amount) {
            return redirect()->back()->with('error', "You don't have enough balance to perform this transaction.")->withInput();
        }
     
        if($account->status == 0) {
            return redirect()->back()->with('error', "This account has been blocked");
        }
        if($link->status == 1) {
            return redirect()->back()->with('error', "This link has been expired or has been paid");
        }

        $txn_id = $this->generateTransactionId();
        $remarks1 = "Funds transfered successfully to ".$account->account_number . "(via Payment Link)";
        $remarks2 = "Funds received by ".$myAccount->account_number . "(via Payment Link)";
        $this->makeTransaction(Auth::id(), $txn_id, $link->amount, "Payment Link", $account->user_id, "Debit", $remarks1);
        $this->makeTransaction($account->user_id, $txn_id, $link->amount, "Payment Link", Auth::id(), "Credit", $remarks2);
        $link->status = 1;
        $link->payment_on = now();
        $link->save();
        return redirect()->back()->with('success', "Funds transferred successfully.");
    }
}
