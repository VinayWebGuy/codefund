<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Api;
use App\Models\User;
use App\Models\Transaction;
use App\Models\WalletAccount;
use App\Models\PaymentLink;
use Str;
use Validator;
use Hash;
use Auth;


class ApiController extends Controller
{

    public function updateApiPermissions($key) {
        $api = Api::where('user_id', Auth::id())->where('key', $key)->first();
        return view('inner.user-updatePermissions', compact('api'));
    }
    public function savePermissions(Request $req) {
        $api = Api::where('key', $req->input('api_key'))->first();
        $api->check_balance = $req->input('check_balance') ? 1 : 0;
        $api->get_transactions = $req->input('get_transactions') ? 1 : 0;
        $api->find_user = $req->input('find_user') ? 1 : 0;
        $api->send_funds = $req->input('send_funds') ? 1 : 0;
        $api->my_profile = $req->input('my_profile') ? 1 : 0;
        $api->find_transaction = $req->input('find_transaction') ? 1 : 0;
        $api->generate_payment_link = $req->input('generate_payment_link') ? 1 : 0;
        $api->save();
        return redirect('main/user/api')->with('success', 'Permissions updated successfully!');
    }
    public function generateApi(Request $req) {
        $req->validate([
            'name' => 'required',
            'api_quota' => 'required',
            'extra_secure' => 'required|in:0,1',
            'total_requests' => 'required_if:api_quota,limited|numeric|max:25000',
            'security_header' => 'required_if:extra_secure,1|alpha_num',
        ]);
        do {
            $key = Str::random(40);
        } while (Api::where('key', $key)->exists());
        $api = Api::create([
           'user_id' => Auth::id(),
           'key' => $key,// 
           'name' => $req->name,
           'api_quota' => $req->api_quota,
           'total_requests' => $req->total_requests,
           'extra_secure' => $req->extra_secure,
           'security_header' => $req->security_header,
        ]);
        $user = User::find(Auth::id());
        $user->keys_generated = $user->keys_generated + 1;
        $user->save();
        return redirect()->back()->with('success', 'API key generated successfully!');
    }
    public function deleteApi($key) {
        $api = Api::where('user_id', Auth::id())->where('key', $key)->first();
        if($api) {
            $api->delete();
            return redirect()->back()->with('success', 'API key deleted successfully!');
        }
        else {
            return redirect()->back()->with('error', 'Invalid action!');
        }
    }
    public function editApi($key) {
        $api = Api::where('user_id', Auth::id())->where('key', $key)->first();
        if($api) {
            return view('inner.user-editApi', compact('api'));
        }
        else {
            return redirect()->back()->with('error', 'Invalid action!');
        }
    }
    public function updateApi(Request $req) {
        $req->validate([
            'name' => 'required',
            'api_quota' => 'required',
            'extra_secure' => 'required|in:0,1',
            'total_requests' => 'required_if:api_quota,limited|numeric|max:20000',
            'security_header' => 'required_if:extra_secure,1|alpha_num',
        ]);
        $api = Api::where('key', $req->key)->where('user_id', Auth::id())->update([
           'name' => $req->name,
           'api_quota' => $req->api_quota,
           'total_requests' => $req->total_requests,
           'extra_secure' => $req->extra_secure,
           'security_header' => $req->security_header,
        ]);
        return redirect('main/user/api')->with('success', 'API key updated successfully!');
    }
    public function changeApiStatus($key) {
        $api = Api::where('user_id', Auth::id())->where('key', $key)->first();
        if($api) {
            $api->status = $api->status == 1 ? 0 : 1;
            $api->save();
            return redirect()->back()->with('success', 'API key updated successfully!');
        }
        else {
            return redirect()->back()->with('error', 'Invalid action!');
        }
    }
    public function authUser(Request $req) {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $errors = implode(", ", $validator->errors()->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 202, 'message' =>$errors]);
        }
        $user = User::where('email', $req->email)->where('role', 1)->first();
    
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json(['success' => false, 'code' => 401, 'message' => 'Invalid credentials!']);
        }
        if ($user->status == 0) {
            return response()->json(['success' => false, 'code' => 403, 'message' => 'Your account is not active!']);
        }
    
        $auth_key = Str::random(20);
    
        $auth_key_expiry = now()->addMinutes(30);
    
        $user->auth_key = $auth_key;
        $user->auth_key_expiry = $auth_key_expiry;
        $user->save();
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Authentication successful!',
            'auth_key' => $auth_key,
            'expires_in' => 30 
        ]);
    }
    
    private function authenticateUser($req, $permission) {
        $token_key = $req->header('token_key');
        $auth_key = $req->header('auth_key');
        $api = Api::where('key', $token_key)->first();
        if(!$api) {
            return response()->json(['success' => false, 'code' => 401, 'message' => 'Invalid api!']);
        }
        $user = User::find($api->user_id);
      
          // Check user auth_key and auth_key_expiry
        if (!$user) {
            return response()->json(['success' => false, 'code' => 401, 'message' => 'User  not found!']);
        }
        if ($user->auth_key != $auth_key) {
            return response()->json(['success' => false, 'code' => 403, 'message' => 'User is not authenticated!']);
        }

      
        if ($user->auth_key_expiry <= now()) {
            return response()->json(['success' => false, 'code' => 403, 'message' => 'User is not authenticated!']);
        }
        if (!$api) {
            return response()->json(['success' => false, 'code' => 401, 'message' => 'API key not found!']);
        }
        if ($api->status == 0) {
            return response()->json(['success' => false, 'code' => 403, 'message' => 'API key is disabled!']);
        }
        $req_left = $api->total_requests - $api->request_hit;
        if ($api->api_quota == "limited" && $req_left <= 0) {
            return response()->json(['success' => false, 'code' => 402, 'message' => 'API quota exceeded!']);
        }
        if ($api->extra_secure == 1 && $req->header('security_header') == "") {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Security header is missing!']);
        }
        if ($api->extra_secure == 1 && $req->header('security_header') != "") {
            $header = $req->header('security_header');
            if ($api->security_header != $header) {
                return response()->json(['success' => false, 'code' => 405, 'message' => 'Invalid security header!']);
            }
        }
        if($api->$permission == 0) {
            return response()->json(['success' => false, 'code' => 402, 'message' => "You don't have permission to access this page!"]);
        }
        return true;
    }
    private function updateApiHit($token_key) {
        $api = Api::where('key', $token_key)->first();
        $api->request_hit = $api->request_hit + 1;
        $api->save();
    }
    public function checkBalance(Request $req) {
   $authResponse = $this->authenticateUser($req, 'check_balance');
    if ($authResponse !== true) {
        return $authResponse;
    }
        $token_key = $req->header('token_key');
        $api = Api::where('key', $token_key)->first();
        $user_id = $api->user_id;
        $balance = User::find($user_id);
        $this->updateApiHit($token_key);
        return response()->json(['success' => true, 'code' => 200, 'message' => 'Data fetched successfully!', 'result' => $balance->wallet_balance]);
    }
    public function getTransactions(Request $req) {
    $authResponse = $this->authenticateUser($req, 'get_transactions');
        if ($authResponse !== true) {
            return $authResponse;
        }
        $token_key = $req->header('token_key');
        $api = Api::where('key', $token_key)->first();
        $user_id = $api->user_id;
        $search_by = $req->search_by;
        $search_value = $req->search_value;
        $orderby = $req->orderby ?? 'desc';
        $select = ['transaction_id', 'amount', 'type', 'closing_balance', 'remarks', 'from_where'];
        $transactions = Transaction::where('user_id', $user_id);
        if ($search_by && $search_value) {
            $transactions->where($search_by, $req->search_value);
        }
        $transactions = $transactions->orderBy('created_at', $orderby)->select($select)->get();
        $this->updateApiHit($token_key);
        return response()->json(['success' => true, 'code' => 200, 'message' => 'Data fetched successfully!', 'count' => count($transactions), 'result' => $transactions]);
    }
    public function findUser(Request $req) {
   $authResponse = $this->authenticateUser($req, 'find_user');
    if ($authResponse !== true) {
        return $authResponse;
    }
        $validator = Validator::make($req->all(), [
            'search_by' => 'required|in:name,email,account_number',
            'search_value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 202, 'message' => 'Invalid search parameters!']);
        }
        $token_key = $req->header('token_key');
        $api = Api::where('key', $token_key)->first();
        $user_id = $api->user_id;
        $search_by = $req->search_by;
        $search_value = $req->search_value;
        if ($search_by == 'account_number') {
            $accounts = WalletAccount::where('account_number', $search_value)->first();
            $users = User::where('id', $accounts->user_id)->select('name', 'email')->get();
        } else {
            $users = User::join('wallet_accounts', 'users.id', '=', 'wallet_accounts.user_id')
            ->where($search_by, $search_value)
            ->select('users.name', 'users.email', 'wallet_accounts.account_number as account_number')
            ->get();
        }
        $this->updateApiHit($token_key);
        return response()->json(['success' => true, 'code' => 200, 'message' => 'Data fetched successfully!', 'count' => count($users), 'result' => $users]);
    }
    private function generateTransactionId() {
        do {
            $transaction_id = rand(1000000000,9999999999);
        } while (Transaction::where('transaction_id', $transaction_id)->exists());
        return $transaction_id;
    }
    private function makeTransaction($user_id, $txn_id, $amount, $from_where, $from_where_id, $type, $remarks) {
        $user = User::find($user_id);
        if ($type == 'Credit') {
            $user->wallet_balance = $user->wallet_balance + $amount;
        } else {
            $user->wallet_balance = $user->wallet_balance - $amount;
        }
        $user->save();
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
    public function sendFunds(Request $req) {
        $authResponse = $this->authenticateUser($req, 'send_funds');
        if ($authResponse !== true) {
            return $authResponse;
        }
        $validator = Validator::make($req->all(), [
            'amount' => 'required|numeric',
            'account_number' => 'required',
        ]);
        $errors = implode(", ", $validator->errors()->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 202, 'message' =>$errors]);
        }
        $token_key = $req->header('token_key');
        $api = Api::where('key', $token_key)->first();
        $user_id = $api->user_id;
        $user = User::find($user_id);
        if($user->wallet_balance < $req->amount) {
            return response()->json(['success' => false, 'code' => 202, 'message' => 'Insufficient balance!']);
        }
        // Validate Account Number
        $account = WalletAccount::where('account_number', $req->account_number)->first();
        $myAccount = WalletAccount::where('user_id', $user_id)->first();
        if($req->account_number  == $myAccount->account_number) {
            return response()->json(['success' => false, 'code' => 202, 'message' => 'You cannot send balance to your own account!']);
        }
        if(!$account) {
            return response()->json(['success' => false, 'code' => 202, 'message' => 'Invalid account number!']);
        }
        if($account->status == 0) {
            return response()->json(['success' => false, 'code' => 202, 'message' => 'This account has been blocked!']);
        }
        $txn_id = $this->generateTransactionId();
        $remarks1 = "Funds transferred successfully to ".$account->account_number;
        $remarks2 = "Funds received by ".$myAccount->account_number;
        $t1 = $this->makeTransaction($user_id, $txn_id, $req->amount, "Fund Transfer", $account->user_id, "Debit", $remarks1);
        $t2 = $this->makeTransaction($account->user_id, $txn_id, $req->amount, "Fund Transfer", $user_id, "Credit", $remarks2);
        $this->updateApiHit($token_key);
        return response()->json(['success' => true, 'code' => 200, 'message' => 'Funds transferred successfully!', 'transaction_id' => $t1->transaction_id]);
    }

    public function findTransaction(Request $req) {
        $authResponse = $this->authenticateUser  ($req, 'find_transaction');
        if ($authResponse !== true) {
            return $authResponse;
        }
        $validator = Validator::make($req->all(), [
            "transaction_id" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 202, 'message' => 'Transaction id can not be blank!']);
        }
        $token_key = $req->header('token_key');
        $api = Api::where('key', $token_key)->first();
        $user_id = $api->user_id;
        $transactions = Transaction::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                  ->orWhere('from_where_id', $user_id);
        })->where('transaction_id', $req->transaction_id)->get();
    
        if($transactions->isEmpty()) {
            return response()->json(['success' => false, 'code' => 202, 'message' => 'Invalid transaction id!']);
        }
        $result = [];
        foreach ($transactions as $transaction) {
            $user = User::find($transaction->user_id);
            $wallet_account = WalletAccount::where('user_id', $transaction->user_id)->first();
            if($transaction->from_where == "Deposit" && $transaction->user_id != $user_id) {
                return response()->json(['success' => false, 'code' => 202, 'message' => 'Invalid transaction id!']);
                return;
            }
            $data = [
                "account_number" => $wallet_account->account_number,
                "name" => $user->name,
                "email" => $user->email,
                "amount" => $transaction->amount,
                "remarks" => $transaction->remarks,
                "from" => $transaction->from_where,
                "type" => $transaction->type,
                "my_user_id" => $user_id,
                "another_user_id" => $transaction->user_id
            ];
            $result[] = $data;
        }
        $this->updateApiHit($token_key);
        return response()->json(['success' => true, 'code' => 200, 'message' => 'Data fetched successfully!', 'result' => $result]);
    }

    public function myProfile(Request $req) {
        $authResponse = $this->authenticateUser($req, 'my_profile');
        if ($authResponse !== true) {
            return $authResponse;
        }
            $token_key = $req->header('token_key');
            $api = Api::where('key', $token_key)->first();
            $user_id = $api->user_id;
            $user = User::find($user_id);
            $walletAccount = WalletAccount::where('user_id', $user_id)->first();
            $profile = [
                'name' => $user->name,
                'email' => $user->email,
                'account_number' => $walletAccount->account_number,
                'wallet_balance' => $user->wallet_balance,
            ];
            $this->updateApiHit($token_key);
            return response()->json(['success' => true, 'code' => 200, 'message' => 'Data fetched successfully!', 'result' => $profile]);
        }
        private function createRandomPaymentLink() {
            do {
                $randomLink = Str::random(35);
            } while (PaymentLink::where('link', $randomLink)->exists());
    
            return $randomLink;
        }


        public function generatePaymentLink(Request $req) {
            $authResponse = $this->authenticateUser($req, 'generate_payment_link');
            if ($authResponse !== true) {
                return $authResponse;
            }
            
            $validator = Validator::make($req->all(), [
                'amount' => 'required|numeric',
                'account_number' => 'required'
            ]);
            $errors = implode(", ", $validator->errors()->all());
            if ($validator->fails()) {
                return response()->json(['success' => false, 'code' => 202, 'message' =>$errors]);
            }
            
            $token_key = $req->header('token_key');
            $api = Api::where('key', $token_key)->first();
            $user_id = $api->user_id;
            
            $wallet = WalletAccount::where('account_number', $req->account_number)->first();
            $myAccount = WalletAccount::where('user_id', $user_id)->first();
            
            if (!$wallet) {
                return response()->json(['success' => false, 'code' => 202, 'message' => 'Invalid account number!']);
            }
            
            if ($req->account_number == $myAccount->account_number) {
                return response()->json(['success' => false, 'code' => 202, 'message' => "You can't create a link for your own account!"]);
            }
            
            $link = $this->createRandomPaymentLink();
            $linkToSend = env('PAY_FUND_URL')."/".$link;
            // Create a payment link record
            $payment = PaymentLink::create([
                'amount' => $req->amount,
                'link' => $link,
                'wallet_account_id' => $wallet->id,
                'for_user_id' => $wallet->user_id,
                'account_number' => $req->account_number,
                'generatedBy' => $user_id,
            ]);
            
            $this->updateApiHit($token_key);
            
            return response()->json(['success' => true, 'code' => 200, 'message' => 'Payment link created successfully!', 'link' => $linkToSend]);
        }
        
    }

