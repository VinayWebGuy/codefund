@extends('inner.layouts.main')
@section('title', 'All Transactions')
@section('user-transactions', 'active')
@section('user-need-wallet', 'locked')
@section('content')

    <div class="table container">
        <h4>All Transactions</h4>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Txn Id</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Remarks</th>
                    <th>Closing Balance</th>
                    <th>From</th>
                </tr>
            </thead>
            <tbody>
                @if(count($transactions) > 0)
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{$transaction->created_at}}</td>
                    <td>{{$transaction->transaction_id}}</td>
                    <td>{{$transaction->type == "Credit" ?  format_number($transaction->amount) : ""}}</td>
                    <td>{{$transaction->type == "Debit" ?  format_number($transaction->amount) : ""}}</td>
                    <td>{{$transaction->remarks}}</td>
                    <td>{{format_number($transaction->closing_balance)}}</td>
                    <td>{{$transaction->from_where}}</td>

                </tr>   
                @endforeach
                @else
                    <tr>
                        <td colspan="6"> No transaction added.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="pagination">
            {{ $transactions->links('vendor.pagination.custom') }} 
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