@extends('layouts.app')

@section('content')
<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:60vh;text-align:center;padding:40px;">
    
    <div style="width:80px;height:80px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:24px;">
        <i class="bi bi-person-slash" style="font-size:36px;color:#ef4444;"></i>
    </div>

    <h2 style="font-size:22px;font-weight:700;color:var(--text-primary);margin:0 0 8px;">
        Account Deactivated
    </h2>

    <p style="font-size:14px;color:var(--text-muted);max-width:400px;margin:0 0 32px;">
        Your account has been deactivated or terminated. 
        Please contact HR or your administrator for assistance.
    </p>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       style="display:inline-flex;align-items:center;gap:6px;padding:10px 24px;background:#ef4444;color:#fff;border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

</div>
@endsection