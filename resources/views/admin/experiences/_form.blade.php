@php($experience = $experience ?? null)
@php($bulletsText = old('bullets_text', $experience ? implode("\n", $experience->bullets ?? []) : ''))

<label>Title / role</label>
<input type="text" name="title" value="{{ old('title', $experience->title ?? '') }}" required>

<label>Organization (leave blank if none)</label>
<input type="text" name="organization" value="{{ old('organization', $experience->organization ?? '') }}">

<label>Date range (e.g. Jan 2026 – Mar 2026)</label>
<input type="text" name="date_range" value="{{ old('date_range', $experience->date_range ?? '') }}">

<label>Bullet points — one per line</label>
<textarea name="bullets_text" style="min-height:140px;">{{ $bulletsText }}</textarea>

<label>Sort order (lower shows first)</label>
<input type="number" name="sort_order" value="{{ old('sort_order', $experience->sort_order ?? 0) }}">

<button type="submit" class="btn">Save</button>
