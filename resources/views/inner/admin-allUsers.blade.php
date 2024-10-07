@extends('inner.layouts.main')
@section('title', 'All Users')
@section('admin-all-users', 'active')
@section('content')
<div class="table container">
    <h4 class="row">All Users
        <a href="{{url('main/admin/deposit')}}" class="btn primary sm">Add new</a>
    </h4>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>For Approval</th>
                <th>Wallet Balance</th>
                <th>Keys Generated</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) > 0)
            @foreach ($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->identification_type}} / {{$user->identification_number}}</td>
                <td>{{format_number($user->wallet_balance)}}</td>
                <td>{{$user->keys_generated}}</td>
                <td>
                    @if($user->status == 1)
                    <a href="{{url('main/admin/users/change-status')}}/{{$user->unique_id}}" class="btn danger sm">Block?</a>
                    @else
                    <a href="{{url('main/admin/users/change-status')}}/{{$user->unique_id}}" class="btn primary sm">Approve?</a>
                    @endif
                </td>
            </tr>   
            @endforeach
            @else
                <tr>
                    <td colspan="5">No User Found</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="pagination">
        {{ $users->links('vendor.pagination.custom') }} 
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