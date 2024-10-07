@extends('inner.layouts.main')
@section('title', 'API Manager')
@section('user-api', 'active')
@section('user-need-wallet', 'locked')
@section('content')

    <div class="table container">
        <h4 class="row">My Api Keys
            <a href="{{url('main/user/api/usage')}}" class="btn primary sm">How to use?</a>
        </h4>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>API Key</th>
                    <th>Total / Left Requests</th>
                    <th>Security Header</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($keys) > 0)
                @php $i = 1; @endphp
                @foreach ($keys as $key)
                <tr>
                    <td>{{$i}}</td>
                    <td class="{{$key->total_requests - $key->request_hit == 0 ? 'danger': ''}}">{{$key->key}}</td>
                    <td>{{$key->api_quota == 'unlimited' ? "Unlimited" : $key->total_requests}} / {{$key->api_quota == 'unlimited' ? "Unlimited" : $key->total_requests - $key->request_hit}}</td>
                    <td class="blur">{{$key->security_header}}</td>
                    <td>
          
                        <a href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->check_balance == 0 ? 'restrict' : ''}} perm">CB</a>
                        <a href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->get_transactions == 0 ? 'restrict' : ''}} perm">GT</a>
                        <a href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->find_user == 0 ? 'restrict' : ''}} perm">FU</a>
                        <a href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->send_funds == 0 ? 'restrict' : ''}} perm">SF</a>
                        <a href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->my_profile == 0 ? 'restrict' : ''}} perm">MP</a>
                        <a href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->find_transaction == 0 ? 'restrict' : ''}} perm">FT</a>
                        <a href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->generate_payment_link == 0 ? 'restrict' : ''}} perm">GPL</a>
                    </td>
                    <td>
                        {{-- <a class="btn primary sm" href="{{url('main/user/api/permission')}}/{{$key->key}}">Permissions</a> --}}
                        <a href="{{url('main/user/api/delete')}}/{{$key->key}}" class="btn danger sm">Delete</a>
                        <a href="{{url('main/user/api/edit')}}/{{$key->key}}" class="btn warning sm">Edit</a>
                        @if($key->status == 1)
                        <a href="{{url('main/user/api/change-status')}}/{{$key->key}}" class="btn primary sm">Active</a>
                        @else
                        <a href="{{url('main/user/api/change-status')}}/{{$key->key}}" class="btn danger sm">Inactive</a>
                        @endif
                    </td>
                </tr>   
                @php $i++ @endphp
                @endforeach
                @else
                    <tr>
                        <td colspan="7"> No key generated yet.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="container">
        <h4>Create New Key</h4>
        <form action="{{route('generate.key')}}" method="post">
            @csrf
            <div class="row form">
                <div class="group">
                    <label for="api_quota">API Quota</label>
                    <select name="api_quota" id="api_quota">
                        <option {{ old('api_quota') === 'limited' ? 'selected' : '' }} value="limited">Limited</option>
                        <option {{ old('api_quota') === 'unlimited' ? 'selected' : '' }} value="unlimited">Unlimited</option>
                    </select>
                    @error('api_quota')
                    <div class="error">{{ $message }}</div>
                @enderror
                </div>
                <div class="group">
                    <label for="total_requests">Total Requests</label>
                   <input type="number" name="total_requests" id="total_requests" value="{{old('total_requests')}}" min="1" max="25000">
                   @error('total_requests')
                   <div class="error">{{ $message }}</div>
               @enderror
                </div>
            </div>
            <div class="row form">
                <div class="group">
                    <label for="extra_secure">Extra Secure</label>
                    <select name="extra_secure" id="extra_secure">
                        <option {{ old('extra_secure') == 0 ? 'selected' : '' }} value="0">No</option>
                        <option {{ old('extra_secure') == 1 ? 'selected' : '' }} value="1">Yes</option>
                    </select>
                    @error('extra_secure')
                    <div class="error">{{ $message }}</div>
                @enderror
                </div>
                <div class="group sec_header">
                    <label for="security_header">Security Header <button type="button" id="generate_security_header" class="btn primary sm">Generate</button></label>
                   <input type="text" name="security_header" id="security_header" value="{{old('security_header')}}" disabled>
                   @error('security_header')
                   <div class="error">{{ $message }}</div>
               @enderror
                </div>
            </div>
            <button class="btn primary">Create</button>
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