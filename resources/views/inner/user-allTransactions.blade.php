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
                    <th>Action</th>
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
                    <td>
                        <button data-details="{{$transaction}}" class="btn primary sm viewTransactionCard">Receipt</button>
                    </td>
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
   

    <div class="modal-bg">
        <div class="modal-card">
            <i class="fa fa-times" id="close-modal"></i>
            <i class="fa fa-download" id="download-receipt"></i>
            <div class="txn-details">
                <div class="type txnAmount"></div>

                <div class="txn-amt txn-info">
                    <span>Type</span> <span class="txnType"></span>
                </div>
                <div class="txn-id txn-info">
                    <span>Transaction ID</span> <span class="txnTxnId"></span>
                </div>
                <div class="txn-type txn-info">
                    <span>Date</span> <span class="txnDate"></span>
                </div>
                <div class="txn-source txn-info">
                    <span>Source</span> <span class="txnSource"></span>
                </div>
                <div class="txn-closingBal txn-info">
                    <span>Closing Balance</span> <span class="txnClosing"></span>
                </div>
                {{-- <div class="txn-remarks txn-info">
                    <span>Remarks</span> <span class="txnRemarks"></span>
                </div> --}}
            </div>
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