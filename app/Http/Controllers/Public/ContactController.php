<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display Contact Us Page.
     */
    public function index(): View
    {
        $contact = [
            'name' => Setting::getValue('school_name', 'SMA Negeri 24 Bandung'),
            'address' => Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614'),
            'phone' => Setting::getValue('school_phone', '(022) 7800540'),
            'email' => 'info@sman24bdg.sch.id',
        ];

        return view('public.contact.index', compact('contact'));
    }
}
