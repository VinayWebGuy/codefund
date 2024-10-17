@extends('inner.layouts.main')
@section('title', 'Add Friend')
@section('user-friends', 'active')
@section('user-need-wallet', 'locked')
@section('content')
    <div class="container">
        <h4 class="row">Add Friend
            <a href="{{url('main/user/friends/all')}}" class="btn primary sm">All Friends</a>
        </h4>
        <form action="{{route('friend.add')}}" method="post">
            @csrf
            <div class="row">
                <div class="group">
                    <label for="account_number">Account number</label>
                    <input type="number" name="account_number" id="account_number" value="{{old('account_number')}}">
                    @error('account_number') <div class="error">{{$message}}</div> @enderror
                </div>
                <div class="group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{old('name')}}">
                    @error('name') <div class="error">{{$message}}</div> @enderror
                </div>
            </div>
            <div class="row">
                <div class="group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{old('email')}}">
                    @error('email') <div class="error">{{$message}}</div> @enderror
                </div> 
              
          
                <div class="group">
                    <label for="mobile">Mobile</label>
                    <input type="number" name="mobile" id="mobile" value="{{old('mobile')}}">
                    @error('mobile') <div class="error">{{$message}}</div> @enderror
                </div>
            </div>
            <button class="btn primary">Add</button>
            <button type="reset" class="btn danger">Reset</button>
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