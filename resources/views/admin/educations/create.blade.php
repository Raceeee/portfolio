@extends('layouts.admin')

@section('title', 'Add Education')

@section('content')
<h1>Add Education Entry</h1>
<div class="card">
  <form method="POST" action="{{ route('admin.educations.store') }}">
    @csrf
    @include('admin.educations._form')
  </form>
</div>
@endsection
