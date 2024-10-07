<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists('AppInfo')) {
    function AppInfo($type) {
        if($type == "name") {
            return "TestApp";
        }
        elseif($type == "domain_name") { // fixed typo: "doman_name" to "domain_name"
            return "http://localhost:8000/api";
        }
        elseif($type == "role_route") { 
            return Auth::user()->role == 1 ? 'user' : 'admin';
        }
        else {
            return "Not Exists";
        }
    }
}