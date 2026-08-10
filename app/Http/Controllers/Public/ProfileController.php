<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display School Profile Page.
     */
    public function index(): View
    {
        $profiles = SchoolProfile::where('is_published', true)
            ->get()
            ->keyBy('key');

        return view('public.profile.index', compact('profiles'));
    }
}
