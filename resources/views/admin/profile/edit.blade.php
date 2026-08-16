@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
<h1>Profile &amp; Contact</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.profile.update') }}">
    @csrf
    @method('PUT')

    <label>Full name</label>
    <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required>

    <label>Role / title</label>
    <input type="text" name="role_title" value="{{ old('role_title', $profile->role_title) }}">

    <label>About me (separate paragraphs with a blank line — the last paragraph is highlighted on the site)</label>
    <textarea name="objective" rows="8">{{ old('objective', $profile->objective) }}</textarea>

    <label>Location</label>
    <input type="text" name="location" value="{{ old('location', $profile->location) }}">

    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}">

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $profile->email) }}">

    <label>Case number (shown in header, e.g. 2026-CS-ESC)</label>
    <input type="text" name="case_number" value="{{ old('case_number', $profile->case_number) }}">

    <label>Status (e.g. ACTIVE)</label>
    <input type="text" name="status" value="{{ old('status', $profile->status) }}">

    <label>GitHub URL</label>
    <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}" placeholder="https://github.com/yourname">

    <label>LinkedIn URL</label>
    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" placeholder="https://linkedin.com/in/yourname">

    <button type="submit" class="btn">Save changes</button>
  </form>
</div>

<h1>Change Password</h1>
<div class="card">
  @if ($errors->has('current_password') || $errors->has('password'))
    <ul>
      @foreach ($errors->only(['current_password', 'password']) as $fieldErrors)
        @foreach ((array) $fieldErrors as $error)
          <li style="color:#c00">{{ $error }}</li>
        @endforeach
      @endforeach
    </ul>
  @endif

  <form method="POST" action="{{ route('admin.profile.password.update') }}">
    @csrf
    @method('PUT')

    <label>Current password</label>
    <input type="password" name="current_password" required>

    <label>New password</label>
    <input type="password" name="password" required minlength="8">

    <label>Confirm new password</label>
    <input type="password" name="password_confirmation" required minlength="8">

    <button type="submit" class="btn">Update password</button>
  </form>
</div>
@endsection