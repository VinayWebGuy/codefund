@extends('inner.layouts.main')
@section('title', 'Api Permissions')
@section('user-api', 'active')
@section('user-need-wallet', 'locked')
@section('content')
<div class="table container">
    <h4 class="row">Update Api Permission ({{$api->key}})
    </h4>
    <form action="{{route('permission.update')}}" method="post">
        @csrf
        <input type="hidden" name="api_key" value="{{$api->key}}">

    <table>
        <thead>
            <tr>
                <th>Check Balance</th>
                <th>Get Transactions</th>
                <th>Find User</th>
                <th>Send Funds</th>
                <th>My Profile</th>
                <th>Find Transaction</th>
                <th>Generate Payment Link</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td><input type="checkbox" name="check_balance" id="check_balance" {{ $api->check_balance ? 'checked' : '' }}></td>
                <td><input type="checkbox" name="get_transactions" id="get_transactions" {{ $api->get_transactions ? 'checked' : '' }}></td>
                <td><input type="checkbox" name="find_user" id="find_user" {{ $api->find_user ? 'checked' : '' }}></td>
                <td><input type="checkbox" name="send_funds" id="send_funds" {{ $api->send_funds ? 'checked' : '' }}></td>
                <td><input type="checkbox" name="my_profile" id="my_profile" {{ $api->my_profile ? 'checked' : '' }}></td>
                <td><input type="checkbox" name="find_transaction" id="find_transaction" {{ $api->find_transaction ? 'checked' : '' }}></td>
                <td><input type="checkbox" name="generate_payment_link" id="generate_payment_link" {{ $api->generate_payment_link ? 'checked' : '' }}></td>
            </tr>
        </tbody>

    </table>
    <button class="btn primary mt-10">Update</button>
</form>
</div>
@if (session('success'))
<div class="toastr success">
  {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="toastr error">
  {{ session('error') }}
</div>
@endif

@endsection