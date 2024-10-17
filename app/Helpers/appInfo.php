<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists('AppInfo')) {
    function AppInfo($type) {
        if($type == "name") {
            return "TestApp";
        }
        elseif($type == "refer_domain_name") { 
            return "http://localhost:8000/refer";
        }
        elseif($type == "api_domain_name") {
            return "http://localhost:8000/api";
        }
        elseif($type == "role_route") { 
            return Auth::user()->role == 1 ? 'user' : 'admin';
        }
        elseif($type == "min_balance") { 
            return 100;
        }
        else {
            return "Not Exists";
        }
    }
}