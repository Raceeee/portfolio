@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<h1>Edit Project</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.projects.update', $project) }}">
    @csrf
    @method('PUT')
    @include('admin.projects._form')
  </form>
</div>
@endsection
