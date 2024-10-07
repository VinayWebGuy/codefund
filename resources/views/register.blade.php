@extends('layouts.main')
@section('title', 'Register')
@section('content')
    <form action="{{ route('user.register') }}" method="post">
        @csrf
        <div class="group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
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
        <div class="group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password">
            @error('confirm_password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="group">
            <label for="pin_code">Pin code</label>
            <input value="{{ old('pin_code') }}" type="number" name="pin_code" id="pin_code">
            @error('pin_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="group">
            <label for="identification_type">Identifcation Type</label>
            <select name="identification_type" id="identification_type">
                <option value="" hidden>Choose</option>
                <option {{ old('identification_type') === 'pan_card' ? 'selected' : '' }} value="pan_card">Pan Card</option>
                <option {{ old('identification_type') === 'passport' ? 'selected' : '' }} value="passport">Passport
                </option>
                <option {{ old('identification_type') === 'driving_license' ? 'selected' : '' }} value="driving_license">
                    Driving License</option>
            </select>
            @error('identification_type')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="group">
            <label for="identification_number">Identification Number</label>
            <input value="{{ old('identification_number') }}" type="text" name="identification_number"
                id="identification_number">
            @error('identification_number')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn primary full">Register</button>
        <div class="links single">
            <a href="{{ url('login') }}">Already have an account?</a>
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
