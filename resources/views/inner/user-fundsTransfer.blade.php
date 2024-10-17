@extends('inner.layouts.main')
@section('title', 'Funds Transfer')
@section('user-funds-transfer', 'active')
@section('user-need-wallet', 'locked')
@section('content')
    <div class="container">
        <h4>Funds Transfer</h4>
        <form action="{{route('funds.transfer')}}" method="post">
            @csrf
            <div class="row">
                <div class="group">
                    <label for="amount">Amount</label>
                    <input type="number" step=".1" name="amount" id="amount" value="{{old('amount')}}">
                    @error('amount')
                        <div class="error">{{$message}}</div>
                    @enderror
                </div>
                <div class="group">
                    <label for="account_number">Account number</label>
                    <input type="text"  name="account_number" id="account_number" value="{{old('account_number', $account_number)}}">
                    @error('account_number')
                    <div class="error">{{$message}}</div>
                @enderror
                </div>
            </div>
            <button class="btn primary">Send</button>
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