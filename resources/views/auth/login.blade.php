@extends('layouts.admin')

@section('title', 'Log in')

@section('content')
<div style="max-width:360px; margin:60px auto;">
  <h1 style="text-align:center;">Admin Access</h1>
  <div class="card">
    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <label style="display:flex;align-items:center;gap:8px;font-family:var(--font-sans);text-transform:none;letter-spacing:normal;color:var(--ink-muted);margin-top:14px;">
        <input type="checkbox" name="remember" style="width:auto;"> Remember me
      </label>

      <button type="submit" class="btn" style="width:100%;text-align:center;">Log in</button>
    </form>
  </div>
</div>
@endsection
