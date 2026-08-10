<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\News;
use App\Models\SchoolProfile;
use App\Models\Slider;
use App\Models\Teacher;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display SMAN 24 Bandung Public Homepage with real dynamic MySQL data.
     */
    public function index(): View
    {
        $schoolInfo = [
            'name' => \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung'),
            'address' => \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung'),
            'phone' => \App\Models\Setting::getValue('school_phone', '(022) 7800540'),
            'email' => \App\Models\Setting::getValue('school_email', 'info@sman24bdg.sch.id'),
            'accreditation' => \App\Models\Setting::getValue('school_accreditation', 'A (Unggul)'),
            'motto' => \App\Models\Setting::getValue('school_motto', 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global'),
            'principal_name' => \App\Models\Setting::getValue('principal_name', 'Drs. H. Solihin, M.Pd.'),
            'principal_title' => \App\Models\Setting::getValue('principal_title', 'Kepala SMA Negeri 24 Bandung'),
            'principal_photo' => \App\Models\Setting::getValue('principal_photo'),
        ];

        $sliders = Slider::where('is_active', true)
            ->orderBy('order_position', 'asc')
            ->get();

        $latestNews = News::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $pinnedAnnouncements = Announcement::where('status', 'published')
            ->orderBy('is_pinned', 'desc')
            ->latest('published_at')
            ->take(4)
            ->get();

        $upcomingEvents = Event::where('status', 'upcoming')
            ->latest('start_date')
            ->take(3)
            ->get();

        $teachers = Teacher::where('is_active', true)
            ->orderBy('order_position')
            ->take(4)
            ->get();

        $extracurriculars = Extracurricular::where('is_active', true)
            ->take(4)
            ->get();

        $spmbDocuments = Document::where('category', 'SPMB')
            ->latest()
            ->get();

        $profiles = SchoolProfile::where('is_published', true)
            ->get()
            ->keyBy('key');

        return view('public.home', compact(
            'schoolInfo',
            'sliders',
            'latestNews',
            'pinnedAnnouncements',
            'upcomingEvents',
            'teachers',
            'extracurriculars',
            'spmbDocuments',
            'profiles'
        ));
    }
}
