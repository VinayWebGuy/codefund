<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;


class AuthController extends Controller
{
    public function registerUser(Request $req) {
        $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'same:password',
            'pin_code' => 'required|min:6',
            'identification_type' => 'required',
            'identification_number' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'pin_code' => $req->pin_code,
            'identification_type' => $req->identification_type,
            'identification_number' => $req->identification_number,
            'unique_id' => uniqid(),
        ]);
        return redirect()->back()->with('success', 'Account created successfully. Please wait while someone will approve your account.');
    }


    public function authUser(Request $req) {
        $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            $user = Auth::user();
            if($user->status == 0) {
                Auth::logout();
                return redirect()->back()->with('error', 'Your account is not active.')->withInput();
            }
            if($user->role == 1) {
                return redirect('main/user');
            }
            else {
                return redirect('main/admin');
            }
        }
        else {
            return redirect()->back()->with('error', 'Invalid credentials')->withInput();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }
}
