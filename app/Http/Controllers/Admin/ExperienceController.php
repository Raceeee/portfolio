<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        Experience::create($this->validated($request));

        return redirect()->route('admin.experiences.index')->with('status', 'Experience added.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $experience->update($this->validated($request));

        return redirect()->route('admin.experiences.index')->with('status', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('status', 'Experience removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'date_range'   => ['nullable', 'string', 'max:100'],
            'bullets_text' => ['nullable', 'string'],
            'sort_order'   => ['nullable', 'integer'],
        ]);

        // One bullet point per line in the textarea -> JSON array in the DB
        $lines = collect(explode("\n", $data['bullets_text'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        unset($data['bullets_text']);
        $data['bullets'] = $lines;

        return $data;
    }
}
