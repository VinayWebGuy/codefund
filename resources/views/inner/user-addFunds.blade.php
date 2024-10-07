@extends('inner.layouts.main')
@section('title', 'Add Funds')
@section('user-add-funds', 'active')
@section('user-need-wallet', 'locked')
@section('content')
    <div class="container">
        <h4>Add Funds</h4>
        <form action="{{route('funds.add')}}" method="post">
            @csrf
            <div class="row">
                <div class="group">
                    <label for="ref_id">Reference Id</label>
                    <input type="text" name="ref_id" id="ref_id" value="{{old('ref_id')}}">
                    @error('ref_id') <div class="error">{{$message}}</div> @enderror
                </div>
                <div class="group">
                    <label for="amount">Amount</label>
                    <input type="number" step=".1" name="amount" id="amount" value="{{old('amount')}}">
                    @error('amount') <div class="error">{{$message}}</div> @enderror
                </div>
                <div class="group">
                    <label for="secret_code">Secret Code</label>
                    <input type="password" name="secret_code" id="secret_code">
                    @error('secret_code') <div class="error">{{$message}}</div> @enderror
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