@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>
<div class="dash-grid">
  <a class="dash-card" href="{{ route('admin.projects.index') }}">
    <div class="num">{{ $counts['projects'] }}</div>
    <div class="label">Projects</div>
  </a>
  <a class="dash-card" href="{{ route('admin.skills.index') }}">
    <div class="num">{{ $counts['skills'] }}</div>
    <div class="label">Skills</div>
  </a>
  <a class="dash-card" href="{{ route('admin.experiences.index') }}">
    <div class="num">{{ $counts['experiences'] }}</div>
    <div class="label">Experience entries</div>
  </a>
  <a class="dash-card" href="{{ route('admin.educations.index') }}">
    <div class="num">{{ $counts['educations'] }}</div>
    <div class="label">Education entries</div>
  </a>
</div>
<p style="margin-top:26px;"><a href="{{ route('admin.profile.edit') }}" class="btn">Edit profile / contact info</a></p>
@endsection
