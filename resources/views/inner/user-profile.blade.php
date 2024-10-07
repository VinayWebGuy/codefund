@extends('inner.layouts.main')
@section('title', 'Profile')
@section('user-profile', 'active')
@section('content')

    <div class="container">
        <h4>Profile</h4>
        @if(Auth::user()->role == 1)
        <div class="profile-details">
            <p>Account number</p>
            <p>

                @if(!$wallet_account)<a href="{{ url('main/'.AppInfo('role_route').'/create-account') }}" class="btn warning sm">Create Account</a> @else {{$wallet_account->account_number}} @endif
            </p>
          </div>
          @endif
        
        <div class="profile-details">
            <p>Name</p>
            <p>{{Auth::user()->name}}</p>
        </div>
        <div class="profile-details">
            <p>Email</p>
            <p>{{Auth::user()->email}}</p>
        </div>
        <div class="profile-details">
            <p>Identification Type</p>
            <p>{{ucfirst(Auth::user()->identification_type)}}</p>
        </div>
        <div class="profile-details">
            <p>Identification Number</p>
            <p>{{Auth::user()->identification_number}}</p>
        </div>
      
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