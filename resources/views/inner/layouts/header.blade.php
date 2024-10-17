<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/themes/prism.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <title>@yield('title')</title>
</head>
<body>
    @php
        $checkAccount = DB::table('wallet_accounts')->where('user_id', Auth::id())->first();
    @endphp
    <div class="inner">
        <nav class="navbar">
            <div class="logo">
                <a href="{{url('main')}}/{{AppInfo('role_route')}}">{{AppInfo('name')}}</a>
            </div>
            @if(Auth::user()->role == 1)
            <div class="menu">
                <li class="@yield('user-add-funds')"><a href="{{url('main/user/funds/add')}}">Add Funds</a></li>
                <li class="@yield('user-funds-transfer')"><a href="{{url('main/user/funds/transfer')}}">Funds Transfer</a></li>
                <li class="@yield('user-friends')"><a href="{{url('main/user/friends/all')}}">Friends</a></li>
                <li class="@yield('user-payment-link')"><a href="{{url('main/user/funds/payment-link')}}">Payment Link</a></li>
                <li class="@yield('user-transactions')"><a href="{{url('main/user/transactions')}}">Transactions</a></li>
                <li class="@yield('user-api')"><a href="{{url('main/user/api')}}">API</a></li>
                <li class="@yield('user-profile')"><a href="{{url('main/user/profile')}}">Profile</a></li>
                {{-- <li class="@yield('user-refer')"><a href="{{url('main/user/refer')}}">Refer</a></li> --}}
                <li><a href="{{route('user.logout')}}">Logout</a></li>
                <li class="balance">Wallet : {{format_number(Auth::user()->wallet_balance)}}</li>
            </div>
            @else 
          <div class="menu">
            <li class="@yield('admin-all-users')"><a href="{{url('main/admin/users')}}">All Users</a></li>
            <li class="@yield('admin-deposit')"><a href="{{url('main/admin/deposit')}}">Deposit</a></li>
            <li class="@yield('user-profile')"><a href="{{url('main/admin/profile')}}">Profile</a></li>
            <li><a href="{{route('user.logout')}}">Logout</a></li>
          </div>

            @endif
        </nav>
        <div class="content @if(!$checkAccount )@yield('user-need-wallet') @endif">