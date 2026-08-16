@extends('layouts.admin')

@section('title', 'Education')

@section('content')
<div class="top-actions">
  <h1 style="margin:0;">Education</h1>
  <a href="{{ route('admin.educations.create') }}" class="btn">+ Add entry</a>
</div>

<div class="card">
  @forelse ($educations as $education)
    <div class="list-row">
      <div>
        <div>{{ $education->title }}</div>
        <div class="meta">{{ $education->institution }} @if($education->date_range) — {{ $education->date_range }} @endif</div>
      </div>
      <div class="actions">
        <a href="{{ route('admin.educations.edit', $education) }}">Edit</a>
        <form action="{{ route('admin.educations.destroy', $education) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this entry?');">
          @csrf @method('DELETE')
          <button type="submit" class="danger">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <p style="color:var(--ink-muted);">No education entries yet.</p>
  @endforelse
</div>
@endsection
