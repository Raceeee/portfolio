@extends('layouts.admin')

@section('title', 'Experience')

@section('content')
<div class="top-actions">
  <h1 style="margin:0;">Work Experience</h1>
  <a href="{{ route('admin.experiences.create') }}" class="btn">+ Add entry</a>
</div>

<div class="card">
  @forelse ($experiences as $experience)
    <div class="list-row">
      <div>
        <div>{{ $experience->title }}</div>
        <div class="meta">
          @if($experience->organization) {{ $experience->organization }} — @endif
          {{ $experience->date_range }}
          &middot; {{ count($experience->bullets ?? []) }} bullet(s)
        </div>
      </div>
      <div class="actions">
        <a href="{{ route('admin.experiences.edit', $experience) }}">Edit</a>
        <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this entry?');">
          @csrf @method('DELETE')
          <button type="submit" class="danger">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <p style="color:var(--ink-muted);">No experience entries yet.</p>
  @endforelse
</div>
@endsection
