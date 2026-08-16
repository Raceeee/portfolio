@extends('layouts.admin')

@section('title', 'Edit Skill')

@section('content')
<h1>Edit Skill</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
    @csrf
    @method('PUT')
    @include('admin.skills._form')
  </form>
</div>
@endsection
