@extends('inner.layouts.main')
@section('title', 'All Friend')
@section('user-friends', 'active')
@section('user-need-wallet', 'locked')
@section('content')
    <div class="table container">
        <h4 class="row">All Friends
            <a href="{{url('main/user/friends/add')}}" class="btn primary sm">Add Friend</a>
        </h4>

        <table>
          <thead>
              <tr>
                  <th>Account number</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              @if(count($friends) > 0)
              @foreach($friends as $friend)
                  <tr>
                      <td>{{ $friend->account_number }}</td>
                      <td>{{ $friend->name }}</td>
                      <td>{{ $friend->email }}</td>
                      <td>{{ $friend->mobile }}</td>
                     
                     
                      <td>
                        @if($friend->status == 0)
                        <a title="Active" href="{{url('main/user/friends/change-status')}}/{{$friend->id}}" class="btn primary sm"><i class="fa fa-thumbs-up"></i></a>
                        @else
                        <a title="Deactive" href="{{url('main/user/friends/change-status')}}/{{$friend->id}}" class="btn danger sm"><i class="fa fa-thumbs-down"></i></a>
                        @endif
                        @if($friend->status == 1)
                        <a href="{{url('main/user/funds/transfer')}}/{{$friend->account_number}}" title="Pay" class="btn primary sm"><i class="fa fa-credit-card"></i></a>
                        @endif
                      </td>
                  </tr>
              @endforeach
              @else
                  <tr>
                      <td colspan="5" align="center">No data found</td>
                  </tr>
              @endif
          </tbody>
      </table>
      <div class="pagination">
        {{ $friends->links('vendor.pagination.custom') }} 
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