@extends('layouts.admin.app')

@section('title', 'Manajemen Profil Sekolah - SMAN 24 Bandung')
@section('breadcrumb', 'Profil Sekolah')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Manajemen Profil Sekolah</h2>
        <p class="text-xs text-slate-500 mt-1">Kelola konten Sejarah, Visi Misi, dan Sambutan Kepala Sekolah.</p>
    </div>

    <div class="space-y-6">
        @foreach($profiles as $profile)
            <form action="{{ route('admin.profiles.update', $profile) }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                @csrf
                @method('PUT')

                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <span class="text-xs font-bold text-emerald-800 uppercase font-mono">KEY: {{ $profile->key }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Published</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Profil</label>
                    <input type="text" name="title" value="{{ old('title', $profile->title) }}" required class="form-input-custom">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Isi Konten</label>
                    <input id="content_{{ $profile->id }}" type="hidden" name="content" value="{{ old('content', $profile->content) }}">
                    <trix-editor input="content_{{ $profile->id }}" class="trix-content form-input-custom min-h-[150px] bg-white"></trix-editor>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" variant="primary">
                        Perbarui {{ $profile->title }}
                    </x-button>
                </div>
            </form>
        @endforeach
    </div>
</div>
@endsection
