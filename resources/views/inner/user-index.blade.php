@extends('inner.layouts.main')
@section('title', 'Home')
@section('content')
    <div class="blocks">
        <div class="block">
            <span>{{ format_number(Auth::user()->wallet_balance) }}</span>
            <span>Wallet Balance</span>
        </div>
        <div class="block">
            <span>{{ format_number(Auth::user()->keys_generated) }}</span>
            <span>API Created</span>
        </div>
        <div class="block">
            <span>{{ format_number($transactionsCount) }}</span>
            <span>Completed Transactions</span>
        </div>
        <div class="block">
            <span>{{ format_number($transactionsSum) }}</span>
            <span>Total Transactions Amount</span>
        </div>
    </div>
    <div class="table">
        <h4>Recent Transactions</h4>
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
                @if(count($recentTransactions) > 0)
                @foreach ($recentTransactions as $transaction)
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
                        <td colspan="7"> No transaction added.</td>
                    </tr>
                @endif
            </tbody>
        </table>
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
