<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\WalletAccount;
use Auth;

class FriendsController extends Controller
{
    public function allFriends() {
        $friends = Friend::where('user_id', Auth::id())->paginate(10);
        return view('inner.user-allFriends', compact('friends'));
    }
    public function addFriend() {
        return view('inner.user-addFriend');
    }

    public function saveFriend(Request $req) {
        $req->validate([
            'account_number' => 'required|exists:wallet_accounts',
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
        ]);
        $checkAC = Friend::where('user_id', Auth::id())->where('account_number', $req->account_number)->first();
        if($checkAC) {
            return redirect()->back()->with('error', "Account number already exists")->withInput();
        }
        $friend = new Friend();
        $wc = WalletAccount::where('account_number', $req->account_number)->first();
        if($wc->user_id == Auth::id()) {
            return redirect()->back()->with('error', "You can not add your own account number")->withInput();
        }
        // Check Account number exists or not for this user
        $friend->user_id = Auth::id();
        $friend->name = $req->name;
        $friend->account_number = $req->account_number;
        $friend->email = $req->email;
        $friend->mobile = $req->mobile;
        $friend->friend_user_id = $wc->user_id;
        $friend->save();
        return redirect('main/user/friends/all')->with('success', 'Friend added successfully.');
    }

    public function changeStatus($id) {
        $friend = Friend::where('user_id', Auth::id())->where('id', $id)->first();

        if($friend) {
            $friend->status = $friend->status == 1 ? 0 : 1;
            $friend->save();
            return redirect()->back()->with('success', 'Friend status updated successfully!');
        }
        else {
            return redirect()->back()->with('error', 'Invalid action!');
        }
    }
}
