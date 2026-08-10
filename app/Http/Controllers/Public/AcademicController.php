<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\Teacher;
use Illuminate\View\View;

class AcademicController extends Controller
{
    /**
     * Display Teachers & Staff Directory.
     */
    public function teachers(): View
    {
        $teachers = Teacher::where('is_active', true)
            ->orderBy('order_position')
            ->orderBy('name')
            ->paginate(12);

        return view('public.academic.teachers', compact('teachers'));
    }

    /**
     * Display Academic Calendar.
     */
    public function calendar(): View
    {
        $calendars = AcademicCalendar::orderBy('start_date', 'asc')->get();
        return view('public.academic.calendar', compact('calendars'));
    }
}
