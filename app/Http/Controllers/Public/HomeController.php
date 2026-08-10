<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display SMAN 24 Bandung Public Homepage.
     */
    public function index(): View
    {
        $schoolInfo = [
            'name' => 'SMA Negeri 24 Bandung',
            'address' => 'Jl. A.H. Nasution No. 27, Kota Bandung',
            'phone' => '(022) 7800540',
            'email' => 'info@sman24bdg.sch.id',
            'accreditation' => 'A (Unggul)',
            'motto' => 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global',
        ];

        return view('public.home', compact('schoolInfo'));
    }
}
