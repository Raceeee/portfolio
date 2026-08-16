@extends('layouts.admin')

@section('title', 'Edit Experience')

@section('content')
<h1>Edit Experience Entry</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.experiences.update', $experience) }}">
    @csrf
    @method('PUT')
    @include('admin.experiences._form')
  </form>
</div>
@endsection
