<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\View\View;

class SpmbController extends Controller
{
    /**
     * Display SPMB Pendaftar page.
     */
    public function pendaftar(): View
    {
        $spmbDocuments = Document::where('category', 'SPMB')->get();
        return view('public.spmb.pendaftar', compact('spmbDocuments'));
    }

    /**
     * Display SPMB Daftar Ulang page.
     */
    public function daftarUlang(): View
    {
        return view('public.spmb.daftar_ulang');
    }
}
