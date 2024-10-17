@extends('inner.layouts.main')
@section('title', 'Refer')
@section('user-refer', 'active')
@section('content')

    <div class="container">
        <h4>Refer</h4>

        <div class="refer-box">
            <div class="refer-link">
                {{AppInfo('refer_domain_name')}}/my-code/{{$user->unique_id}}-{{md5($user->email)}}
            </div>
            <i class="copyBtn fa fa-clipboard"></i>
        </div>
        <p class="referNote">👉 Earn Rs. 200 joining bonus on every refer.</p>

      
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