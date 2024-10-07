@extends('layouts.main')
@section('title', 'Login')
@section('content')
    <form action="{{route('user.auth')}}" method="post">
        @csrf
        <div class="group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{old('email')}}">
            @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
        </div>
        <div class="group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
        </div>
        <button class="btn primary full">Login</button>
        <div class="links">
            <a href="{{url('register')}}">Create Account</a>
            <a href="{{url('forget-password')}}">Forget Password?</a>
        </div>
    </form>
  
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
