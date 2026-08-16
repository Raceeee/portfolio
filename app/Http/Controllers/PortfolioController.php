<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $educations = Education::orderBy('sort_order')->orderBy('id')->get();
        $skills = Skill::orderBy('sort_order')->orderBy('id')->get()->groupBy('category');
        $experiences = Experience::orderBy('sort_order')->orderBy('id')->get();
        $projects = Project::orderBy('sort_order')->orderBy('id')->get();

        return view('portfolio.index', compact(
            'profile', 'educations', 'skills', 'experiences', 'projects'
        ));
    }
}
