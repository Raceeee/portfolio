<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('category')->orderBy('sort_order')->orderBy('id')->get();
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        Skill::create($this->validated($request));

        return redirect()->route('admin.skills.index')->with('status', 'Skill added.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $skill->update($this->validated($request));

        return redirect()->route('admin.skills.index')->with('status', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('status', 'Skill removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category'   => ['required', 'in:language,core,tool,soft'],
            'name'       => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
