<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'projects'    => Project::count(),
            'skills'      => Skill::count(),
            'experiences' => Experience::count(),
            'educations'  => Education::count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
