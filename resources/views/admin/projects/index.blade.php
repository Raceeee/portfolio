@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<div class="top-actions">
  <h1 style="margin:0;">Projects</h1>
  <a href="{{ route('admin.projects.create') }}" class="btn">+ Add project</a>
</div>

<div class="card">
  @forelse ($projects as $project)
    <div class="list-row">
      <div>
        <div>{{ $project->title }}</div>
        <div class="meta">@if($project->tag){{ $project->tag }} — @endif{{ $project->subtitle }}</div>
      </div>
      <div class="actions">
        <a href="{{ route('admin.projects.edit', $project) }}">Edit</a>
        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this project?');">
          @csrf @method('DELETE')
          <button type="submit" class="danger">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <p style="color:var(--ink-muted);">No projects yet.</p>
  @endforelse
</div>
@endsection
