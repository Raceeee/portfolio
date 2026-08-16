@extends('layouts.admin')

@section('title', 'Edit Education')

@section('content')
<h1>Edit Education Entry</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.educations.update', $education) }}">
    @csrf
    @method('PUT')
    @include('admin.educations._form')
  </form>
</div>
@endsection
