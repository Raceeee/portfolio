@extends('layouts.admin')

@section('title', 'Add Experience')

@section('content')
<h1>Add Experience Entry</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.experiences.store') }}">
    @csrf
    @include('admin.experiences._form')
  </form>
</div>
@endsection
