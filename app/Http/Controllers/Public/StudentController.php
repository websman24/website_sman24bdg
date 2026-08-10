<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Extracurricular;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display Extracurriculars List.
     */
    public function extracurriculars(): View
    {
        $extracurriculars = Extracurricular::where('is_active', true)->get();
        return view('public.student.extracurriculars', compact('extracurriculars'));
    }

    /**
     * Display Student Achievements.
     */
    public function achievements(): View
    {
        $achievements = Achievement::orderBy('achievement_year', 'desc')->get();
        return view('public.student.achievements', compact('achievements'));
    }
}
