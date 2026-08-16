@extends('layouts.admin')

@section('title', 'Skills')

@section('content')
<div class="top-actions">
  <h1 style="margin:0;">Skills</h1>
  <a href="{{ route('admin.skills.create') }}" class="btn">+ Add skill</a>
</div>

@foreach (\App\Models\Skill::CATEGORIES as $value => $label)
  <div class="card">
    <div style="font-family:var(--font-mono); font-size:12px; text-transform:uppercase; letter-spacing:0.08em; color:var(--accent-green); margin-bottom:6px;">{{ $label }}</div>
    @php($group = $skills->get($value, collect()))
    @forelse ($group as $skill)
      <div class="list-row">
        <div>{{ $skill->name }}</div>
        <div class="actions">
          <a href="{{ route('admin.skills.edit', $skill) }}">Edit</a>
          <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this skill?');">
            @csrf @method('DELETE')
            <button type="submit" class="danger">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <p style="color:var(--ink-muted); font-size:13px;">Nothing here yet.</p>
    @endforelse
  </div>
@endforeach
@endsection
