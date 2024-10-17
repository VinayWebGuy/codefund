@extends('inner.layouts.main')
@section('title', 'API Manager')
@section('user-api', 'active')
@section('user-need-wallet', 'locked')
@section('content')

    <div class="container">
        <h4>Update API Key</h4>
        <form action="{{route('update.key')}}" method="post">
            @csrf
            <input type="hidden" name="key" value="{{$api->key}}">
            <div class="row form">
                <div class="group">
                    <label for="name">Name</label>
                   <input type="text" name="name" id="name" value="{{$api->name}}">
                   @error('name')
                   <div class="error">{{ $message }}</div>
               @enderror
                </div>
                 <div class="group">
                    <label for="total_requests">Total Requests</label>
                   <input type="number" name="total_requests" id="total_requests" value="{{$api->total_requests}}" {{$api->api_quota == 'unlimited' ? "disabled": ""}} min="1" max="25000">
                   @error('total_requests')
                   <div class="error">{{ $message }}</div>
               @enderror
                </div>
                <div class="group">
                    <label for="api_quota">API Quota</label>
                    <select name="api_quota" id="api_quota">
                        <option {{ $api->api_quota === 'limited' ? 'selected' : '' }} value="limited">Limited</option>
                        <option {{ $api->api_quota === 'unlimited' ? 'selected' : '' }} value="unlimited">Unlimited</option>
                    </select>
                    @error('api_quota')
                    <div class="error">{{ $message }}</div>
                @enderror
                </div>
              
            </div>
            <div class="row form">
                <div class="group">
                    <label for="extra_secure">Extra Secure</label>
                    <select name="extra_secure" id="extra_secure">
                        <option {{ $api->extra_secure == 0 ? 'selected' : '' }} value="0">No</option>
                        <option {{ $api->extra_secure == 1 ? 'selected' : '' }} value="1">Yes</option>
                    </select>
                    @error('extra_secure')
                    <div class="error">{{ $message }}</div>
                @enderror
                </div>
                <div class="group sec_header">
                    <label for="security_header">Security Header <button type="button" id="generate_security_header" class="btn primary sm">Generate</button></label>
                   <input type="text" name="security_header" id="security_header" value="{{$api->security_header}}" {{$api->security_header == 0 ? "disabled": ""}}>
                   @error('security_header')
                   <div class="error">{{ $message }}</div>
               @enderror
                </div>
            </div>
            <button class="btn primary">Update</button>
            <button type="reset" class="btn danger">Cancel</button>

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