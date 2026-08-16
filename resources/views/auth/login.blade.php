@extends('layouts.admin')

@section('title', 'Log in')

@section('content')
<div style="max-width:360px; margin:60px auto;">
  <h1 style="text-align:center;">Admin Access</h1>
  <div class="card" style="text-align:center;">
    <p style="color:var(--ink-muted); font-size:14px; margin:0 0 20px;">
      This admin panel is restricted to a single authorized Google account.
    </p>

    <a href="{{ route('login.google') }}"
       style="display:flex; align-items:center; justify-content:center; gap:10px;
              width:100%; padding:12px 18px; border-radius:6px; border:1px solid var(--rule);
              background:#14181a; color:var(--ink); font-family:var(--font-sans); font-size:14px;
              text-decoration:none; transition:border-color .15s;">
      <svg width="18" height="18" viewBox="0 0 48 48" aria-hidden="true">
        <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.6 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z"/>
        <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 15.9 18.9 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 16.3 4 9.6 8.3 6.3 14.7z"/>
        <path fill="#4CAF50" d="M24 44c5.5 0 10.4-1.9 14.3-5.1l-6.6-5.6C29.6 35 26.9 36 24 36c-5.3 0-9.7-3.4-11.3-8l-6.6 5.1C9.5 39.6 16.2 44 24 44z"/>
        <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.3-4.2 5.7l6.6 5.6C40.5 36.8 44 31 44 24c0-1.3-.1-2.7-.4-3.5z"/>
      </svg>
      Sign in with Google
    </a>

    @error('google')
      <p style="color:#e79a95; font-size:13px; margin:16px 0 0;">{{ $message }}</p>
    @enderror
  </div>
</div>
@endsection
