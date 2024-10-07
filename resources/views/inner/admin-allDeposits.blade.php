@extends('inner.layouts.main')
@section('title', 'All Deposits')
@section('admin-deposit', 'active')
@section('content')

    <div class="table container">
        <h4 class="row">All Deposits
            <a href="{{url('main/admin/deposit')}}" class="btn primary sm">Add new</a>
        </h4>
        <table>
            <thead>
                <tr>
                    <th>Ref Id</th>
                    <th>Amount</th>
                    <th>Open SC</th>
                    <th>Expiry</th>
                    <th>Used By</th>
                </tr>
            </thead>
            <tbody>
                @if(count($deposits) > 0)
                @foreach ($deposits as $deposit)
                <tr>
                    <td>{{$deposit->ref_id}}</td>
                    <td>{{$deposit->amount}}</td>
                    <td>{{$deposit->open_secret_code}}</td>
                    <td>{{$deposit->expiry != "" ? $deposit->expiry: "-"}}</td>
                    <td>{{$deposit->used_by != "" ? $deposit->usedBy->name: "-"}}</td>
                </tr>   
                @endforeach
                @else
                    <tr>
                        <td colspan="4"> No deposit added.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="pagination">
            {{ $deposits->links('vendor.pagination.custom') }} 
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