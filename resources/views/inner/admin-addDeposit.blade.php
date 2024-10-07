@extends('inner.layouts.main')
@section('title', 'Add Deposit')
@section('admin-deposit', 'active')
@section('content')
    <div class="container">
        <h4 class="row">Add Deposit
            <a href="{{url('main/admin/deposit/all')}}" class="btn  primary sm">All deposits</a>
        </h4>
        <form action="{{route('deposit.save')}}" method="post">
            @csrf
            <div class="row">
                <div class="group">
                    <label for="ref_id">Reference Id <button type="button" class="btn sm warning" id="generateRefId">Generate</button></label>
                    <input type="text" name="ref_id" id="ref_id" value="{{old('ref_id')}}">
                    @error('ref_id') <div class="error">{{$message}}</div> @enderror
                </div>
                <div class="group">
                    <label for="amount">Amount</label>
                    <input type="number" step=".1" name="amount" id="amount">
                    @error('amount') <div class="error">{{$message}}</div> @enderror
                </div>
            </div>
            <div class="row">
                <div class="group">
                    <label for="expiry">Expiry</label>
                <select name="expiry" id="expiry">
                    <option {{ old('expiry') === 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ old('expiry') === 1 ? 'selected' : '' }} value="1">Yes</option>
                </select>
                @error('expiry') <div class="error">{{$message}}</div> @enderror
            </div>
            <div class="group">
                <label for="expiry_days">Expiry Days</label>
                <select disabled name="expiry_days" id="expiry_days">
                    <option {{ old('expiry_days') === 1 ? 'selected' : '' }} value="1">1</option>
                    <option {{ old('expiry_days') === 2 ? 'selected' : '' }} value="2">2</option>
                    <option {{ old('expiry_days') === 3 ? 'selected' : '' }} value="3">3</option>
                    <option {{ old('expiry_days') === 4 ? 'selected' : '' }} value="4">4</option>
                    <option {{ old('expiry_days') === 5 ? 'selected' : '' }} value="5">5</option>
                    <option {{ old('expiry_days') === 6 ? 'selected' : '' }} value="6">6</option>
                    <option {{ old('expiry_days') === 7 ? 'selected' : '' }} value="7">7</option>
                    <option {{ old('expiry_days') === 8 ? 'selected' : '' }} value="8">8</option>
                    <option {{ old('expiry_days') === 9 ? 'selected' : '' }} value="9">9</option>
                    <option {{ old('expiry_days') === 10 ? 'selected' : '' }} value="10">10</option>
                    <option {{ old('expiry_days') === 11 ? 'selected' : '' }} value="11">11</option>
                    <option {{ old('expiry_days') === 12 ? 'selected' : '' }} value="12">12</option>
                </select>
                @error('expiry_days') <div class="error">{{$message}}</div> @enderror
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