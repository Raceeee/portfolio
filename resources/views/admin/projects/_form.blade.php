@php($project = $project ?? null)

<label>Tag (e.g. Cybersecurity, Mobile App)</label>
<input type="text" name="tag" value="{{ old('tag', $project->tag ?? '') }}">

<label>Project title</label>
<input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required>

<label>Subtitle</label>
<input type="text" name="subtitle" value="{{ old('subtitle', $project->subtitle ?? '') }}">

<label>Description</label>
<textarea name="description">{{ old('description', $project->description ?? '') }}</textarea>

<label>Sort order (lower shows first)</label>
<input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}">

<button type="submit" class="btn">Save</button>
