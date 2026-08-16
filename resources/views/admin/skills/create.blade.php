@extends('layouts.admin')

@section('title', 'Add Skill')

@section('content')
<h1>Add Skill</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.skills.store') }}">
    @csrf
    @include('admin.skills._form')
  </form>
</div>
@endsection
