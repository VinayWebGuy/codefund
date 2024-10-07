@extends('layouts.main')
@section('title', 'Reset Password')
@section('content')
    <form action="">
        <div class="group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password">
        </div>
        <button class="btn primary full">Update</button>
        <div class="links single">
            <a href="{{url('login')}}">Back to Login</a>
        </div>
    </form>
@endsection
