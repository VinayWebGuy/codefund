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
                    <th>Name</th>
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
                    <td>{{$key->name}}</td>
                    <td class="{{($key->total_requests - $key->request_hit == 0 && $key->api_quota != 'unlimited') ? 'danger': ''}}">{{$key->key}}</td>
                    <td><span title="Total">{{$key->api_quota == 'unlimited' ? "Unlimited" : $key->total_requests}}</span> / <span title="Remaining">{{$key->api_quota == 'unlimited' ? "Unlimited" : $key->total_requests - $key->request_hit}}</span></td>
                    <td class="blur" title="Shh.....">{{$key->security_header}}</td>
                    <td>
          
                        <a title="Check Balance" href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->check_balance == 0 ? 'restrict' : ''}} perm">CB</a>
                        <a title="Get Transactions" href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->get_transactions == 0 ? 'restrict' : ''}} perm">GT</a>
                        <a title="Find User" href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->find_user == 0 ? 'restrict' : ''}} perm">FU</a>
                        <a title="Send Funds" href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->send_funds == 0 ? 'restrict' : ''}} perm">SF</a>
                        <a title="My Profile" href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->my_profile == 0 ? 'restrict' : ''}} perm">MP</a>
                        <a title="Find Transaction" href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->find_transaction == 0 ? 'restrict' : ''}} perm">FT</a>
                        <a title="Generate Payment Link" href="{{url('main/user/api/permission')}}/{{$key->key}}" class="{{$key->generate_payment_link == 0 ? 'restrict' : ''}} perm">GPL</a>
                    </td>
                    <td>
                        {{-- <a class="btn primary sm" href="{{url('main/user/api/permission')}}/{{$key->key}}">Permissions</a> --}}
                        <a title="Delete" href="{{url('main/user/api/delete')}}/{{$key->key}}" class="btn danger sm"><i class="fa fa-trash"></i></a>
                        <a title="Edit" href="{{url('main/user/api/edit')}}/{{$key->key}}" class="btn warning sm"><i class="fa fa-edit"></i></a>
                        @if($key->status == 1)
                        <a title="Active" href="{{url('main/user/api/change-status')}}/{{$key->key}}" class="btn primary sm"><i class="fa fa-thumbs-up"></i></a>
                        @else
                        <a title="Deactive" href="{{url('main/user/api/change-status')}}/{{$key->key}}" class="btn danger sm"><i class="fa fa-thumbs-down"></i></a>
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
                    <label for="name">Name</label>
                   <input type="text" name="name" id="name" value="{{old('name')}}">
                   @error('name')
                   <div class="error">{{ $message }}</div>
               @enderror
                </div>
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