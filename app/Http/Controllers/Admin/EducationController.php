<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.educations.index', compact('educations'));
    }

    public function create()
    {
        return view('admin.educations.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Education::create($data);

        return redirect()->route('admin.educations.index')->with('status', 'Education entry added.');
    }

    public function edit(Education $education)
    {
        return view('admin.educations.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $education->update($this->validated($request));

        return redirect()->route('admin.educations.index')->with('status', 'Education entry updated.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.educations.index')->with('status', 'Education entry removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'date_range'  => ['nullable', 'string', 'max:100'],
            'sort_order'  => ['nullable', 'integer'],
        ]);
    }
}
