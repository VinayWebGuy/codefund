@extends('layouts.main')
@section('title', 'OTP')
@section('content')
    <form action="">
      <div class="otp-group">
        <input type="number" class="otp-input" name="otp[]">
        <input type="number" class="otp-input" name="otp[]">
        <input type="number" class="otp-input" name="otp[]">
        <input type="number" class="otp-input" name="otp[]">
        <input type="number" class="otp-input" name="otp[]">
        <input type="number" class="otp-input" name="otp[]">
      </div>
        <button class="btn primary full">Proceed</button>
        <div class="links single">
            <a href="{{url('login')}}">Logout?</a>
        </div>
    </form>
@endsection
