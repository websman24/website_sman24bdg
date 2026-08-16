<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpmbQuote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpmbQuoteController extends Controller
{
    /**
     * Display a listing of SPMB running text quotes.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = SpmbQuote::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('quote_text', 'like', "%{$search}%")
                    ->orWhere('author_source', 'like', "%{$search}%");
            });
        }

        $quotes = $query->orderBy('order_position', 'asc')->latest()->paginate(10)->withQueryString();

        return view('admin.spmb_quotes.index', compact('quotes', 'search'));
    }

    /**
     * Show form to create new quote.
     */
    public function create(): View
    {
        return view('admin.spmb_quotes.create');
    }

    /**
     * Store new quote.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'quote_text' => ['required', 'string', 'max:1000'],
            'author_source' => ['nullable', 'string', 'max:255'],
            'order_position' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'quote_text.required' => 'Teks kata bijak wajib diisi.',
            'order_position.required' => 'Urutan tampil wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        SpmbQuote::create($validated);

        return redirect()->route('admin.spmb-quotes.index')
            ->with('success', 'Kata-kata bijak SPMB berhasil ditambahkan.');
    }

    /**
     * Show form to edit quote.
     */
    public function edit(SpmbQuote $spmbQuote): View
    {
        return view('admin.spmb_quotes.edit', ['quote' => $spmbQuote]);
    }

    /**
     * Update quote.
     */
    public function update(Request $request, SpmbQuote $spmbQuote): RedirectResponse
    {
        $validated = $request->validate([
            'quote_text' => ['required', 'string', 'max:1000'],
            'author_source' => ['nullable', 'string', 'max:255'],
            'order_position' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'quote_text.required' => 'Teks kata bijak wajib diisi.',
            'order_position.required' => 'Urutan tampil wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $spmbQuote->update($validated);

        return redirect()->route('admin.spmb-quotes.index')
            ->with('success', 'Kata-kata bijak SPMB berhasil diperbarui.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(SpmbQuote $spmbQuote): RedirectResponse
    {
        $spmbQuote->update([
            'is_active' => ! $spmbQuote->is_active,
        ]);

        return back()->with('success', 'Status aktif running text berhasil diubah.');
    }

    /**
     * Delete quote.
     */
    public function destroy(SpmbQuote $spmbQuote): RedirectResponse
    {
        $spmbQuote->delete();

        return redirect()->route('admin.spmb-quotes.index')
            ->with('success', 'Kata-kata bijak SPMB berhasil dihapus.');
    }
}
