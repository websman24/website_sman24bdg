<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display Extracurriculars List with search and category filter.
     */
    public function extracurriculars(Request $request): View
    {
        $query = Extracurricular::where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mentor_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $extracurriculars = $query->orderBy('name', 'asc')->get();
        $categories = Extracurricular::where('is_active', true)
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('public.student.extracurriculars', compact('extracurriculars', 'categories'));
    }

    /**
     * Display Student Achievements with search, category, and level filters.
     */
    public function achievements(Request $request): View
    {
        $query = Achievement::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('winner_name', 'like', "%{$search}%")
                  ->orWhere('event_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $achievements = $query->orderBy('achievement_year', 'desc')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('public.student.achievements', compact('achievements'));
    }
}
