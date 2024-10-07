@extends('layouts.main')
@section('title', 'Forget Password')
@section('content')
    <form action="">
        <div class="group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <button class="btn primary full">Reset</button>
        <div class="links single">
            <a href="{{url('login')}}">Back to Login</a>
        </div>
    </form>
@endsection
