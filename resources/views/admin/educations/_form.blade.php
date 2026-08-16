@php($education = $education ?? null)

<label>Title (degree / program)</label>
<input type="text" name="title" value="{{ old('title', $education->title ?? '') }}" required>

<label>Institution</label>
<input type="text" name="institution" value="{{ old('institution', $education->institution ?? '') }}">

<label>Date range (e.g. 2022 – 2026)</label>
<input type="text" name="date_range" value="{{ old('date_range', $education->date_range ?? '') }}">

<label>Sort order (lower shows first)</label>
<input type="number" name="sort_order" value="{{ old('sort_order', $education->sort_order ?? 0) }}">

<button type="submit" class="btn">Save</button>
