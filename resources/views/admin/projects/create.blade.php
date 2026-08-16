@extends('layouts.admin')

@section('title', 'Add Project')

@section('content')
<h1>Add Project</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.projects.store') }}">
    @csrf
    @include('admin.projects._form')
  </form>
</div>
@endsection
