<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        // return view('index');
        return redirect('login');
    }
    public function login() {
        return view('login');
    }
    public function register() {
        return view('register');
    }
    public function forgetPassword() {
        return view('forget-password');
    }
    public function resetPassword() {
        return view('reset-password');
    }
    public function otp() {
        return view('otp');
    }
}
