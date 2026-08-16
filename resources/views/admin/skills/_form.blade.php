@php($skill = $skill ?? null)

<label>Category</label>
<select name="category" required>
  @foreach (\App\Models\Skill::CATEGORIES as $value => $label)
    <option value="{{ $value }}" @selected(old('category', $skill->category ?? '') === $value)>{{ $label }}</option>
  @endforeach
</select>

<label>Skill name</label>
<input type="text" name="name" value="{{ old('name', $skill->name ?? '') }}" required>

<label>Sort order (lower shows first, within its category)</label>
<input type="number" name="sort_order" value="{{ old('sort_order', $skill->sort_order ?? 0) }}">

<button type="submit" class="btn">Save</button>
