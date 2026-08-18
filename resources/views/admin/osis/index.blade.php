@extends('layouts.admin.app')

@section('title', 'Manajemen OSIS SMAN 24 Bandung')
@section('breadcrumb', 'OSIS & MPK')

@section('content')
<div class="space-y-6" x-data="{ 
    currentTab: '{{ $activeTab }}',
    selectedIds: [],
    selectAll: false,
    toggleAll() {
        if (this.selectAll) {
            this.selectedIds = Array.from(document.querySelectorAll('.member-checkbox')).map(el => el.value);
        } else {
            this.selectedIds = [];
        }
    }
}">
    <!-- Header & Action Hub -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase bg-indigo-100 text-indigo-800 border border-indigo-200">Kesiswaan</span>
                <span class="text-xs text-slate-400 font-medium">Periode {{ $profile->period ?? '2025/2026' }}</span>
            </div>
            <h2 class="text-xl font-bold text-slate-900 mt-1">Manajemen OSIS & MPK SMAN 24</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola identitas kabinet, visi-misi, serta susunan pengurus BPH dan Seksi Bidang.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.osis.members.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-700 hover:bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-900/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengurus Baru
            </a>
        </div>
    </div>

    <!-- Stats Quick Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Pengurus</span>
                <span class="text-2xl font-black text-slate-900">{{ $stats['total_members'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg font-bold">
                👥
            </div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Pengurus BPH</span>
                <span class="text-2xl font-black text-indigo-700">{{ $stats['total_bph'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg font-bold">
                🏛️
            </div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Seksi Bidang (1-10)</span>
                <span class="text-2xl font-black text-emerald-700">{{ $stats['total_sekbid'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg font-bold">
                🎯
            </div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Perwakilan MPK</span>
                <span class="text-2xl font-black text-amber-700">{{ $stats['total_mpk'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg font-bold">
                ⚖️
            </div>
        </div>
    </div>

    <!-- Navigation Tab Buttons -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
        <button type="button" 
                @click="currentTab = 'profile'"
                :class="currentTab === 'profile' ? 'bg-indigo-700 text-white shadow-sm font-bold' : 'bg-white text-slate-600 hover:bg-slate-100 font-semibold border border-slate-200'"
                class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
            <span>🏷️</span>
            <span>Profil & Kabinet OSIS</span>
        </button>
        <button type="button" 
                @click="currentTab = 'members'"
                :class="currentTab === 'members' ? 'bg-indigo-700 text-white shadow-sm font-bold' : 'bg-white text-slate-600 hover:bg-slate-100 font-semibold border border-slate-200'"
                class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
            <span>👥</span>
            <span>Struktur Pengurus & BPH/Sekbid</span>
            <span class="px-2 py-0.5 rounded-full text-[10px]" :class="currentTab === 'members' ? 'bg-indigo-900/60 text-white' : 'bg-slate-200 text-slate-700'">{{ $stats['total_members'] }}</span>
        </button>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: PROFIL & KABINET OSIS              -->
    <!-- ========================================== -->
    <div x-show="currentTab === 'profile'" x-cloak class="space-y-6">
        <form action="{{ route('admin.osis.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-8">
            @csrf

            <!-- Informasi Pokok Kabinet -->
            <div>
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>👑</span> Identitas & Periode Kabinet
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-4">
                    <div>
                        <label for="cabinet_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Kabinet</label>
                        <input type="text" id="cabinet_name" name="cabinet_name" value="{{ old('cabinet_name', $profile->cabinet_name) }}" required placeholder="e.g. Kabinet Cakra Baskara" class="form-input-custom">
                        @error('cabinet_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="period" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Periode Kepengurusan</label>
                        <input type="text" id="period" name="period" value="{{ old('period', $profile->period) }}" required placeholder="e.g. 2025/2026" class="form-input-custom">
                        @error('period') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="tagline" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Semboyan / Motto Kabinet</label>
                        <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $profile->tagline) }}" placeholder="e.g. Bersinergi, Berkarakter, Menginspirasi" class="form-input-custom">
                    </div>
                </div>
            </div>

            <!-- Visi & Misi OSIS -->
            <div>
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>🎯</span> Visi & Misi OSIS SMAN 24
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="vision" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Visi OSIS</label>
                        <textarea id="vision" name="vision" rows="5" placeholder="Tuliskan visi kepengurusan OSIS..." class="form-input-custom">{{ old('vision', $profile->vision) }}</textarea>
                    </div>
                    <div>
                        <label for="mission" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Misi OSIS (Poin per Baris)</label>
                        <textarea id="mission" name="mission" rows="5" placeholder="1. Misi pertama&#10;2. Misi kedua..." class="form-input-custom">{{ old('mission', $profile->mission) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Sambutan & Profil Ketua OSIS -->
            <div>
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>🎙️</span> Sambutan & Profil Ketua OSIS
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                    <div class="md:col-span-1 space-y-4">
                        <div>
                            <label for="leader_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap Ketua OSIS</label>
                            <input type="text" id="leader_name" name="leader_name" value="{{ old('leader_name', $profile->leader_name) }}" placeholder="Nama Ketua OSIS..." class="form-input-custom">
                        </div>
                        <div>
                            <label for="leader_photo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Ketua OSIS</label>
                            @if($profile->leader_photo)
                                <div class="mb-2 flex items-center gap-3 p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                                    <img src="{{ asset($profile->leader_photo) }}" alt="{{ $profile->leader_name }}" class="w-12 h-12 object-cover rounded-xl border border-slate-300">
                                    <span class="text-[11px] text-slate-500 font-mono">Foto aktif</span>
                                </div>
                            @endif
                            <input type="file" id="leader_photo" name="leader_photo" accept="image/*" class="form-input-custom bg-white">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="leader_welcome" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pesan & Sambutan Ketua OSIS</label>
                        <textarea id="leader_welcome" name="leader_welcome" rows="6" placeholder="Kutipan sambutan ketua OSIS untuk siswa dan pengunjung..." class="form-input-custom">{{ old('leader_welcome', $profile->leader_welcome) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Media Visual & Media Sosial -->
            <div>
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>📸</span> Media Visual & Saluran Resmi
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="cabinet_photo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Bersama Kabinet / Banner</label>
                        @if($profile->cabinet_photo)
                            <div class="mb-2 p-2 bg-slate-50 rounded-xl border border-slate-200">
                                <img src="{{ asset($profile->cabinet_photo) }}" alt="Foto Kabinet" class="w-full h-24 object-cover rounded-lg border border-slate-300">
                            </div>
                        @endif
                        <input type="file" id="cabinet_photo" name="cabinet_photo" accept="image/*" class="form-input-custom bg-white">
                    </div>
                    <div>
                        <label for="cabinet_logo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Logo Kabinet OSIS (PNG/Transparent)</label>
                        @if($profile->cabinet_logo)
                            <div class="mb-2 flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-200">
                                <img src="{{ asset($profile->cabinet_logo) }}" alt="Logo Kabinet" class="w-12 h-12 object-contain rounded-lg">
                                <span class="text-[11px] text-slate-500 font-mono">Logo aktif</span>
                            </div>
                        @endif
                        <input type="file" id="cabinet_logo" name="cabinet_logo" accept="image/*" class="form-input-custom bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-4">
                    <div>
                        <label for="instagram_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Instagram OSIS</label>
                        <input type="text" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" placeholder="https://instagram.com/osis24bdg" class="form-input-custom">
                    </div>
                    <div>
                        <label for="tiktok_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">TikTok OSIS</label>
                        <input type="text" id="tiktok_url" name="tiktok_url" value="{{ old('tiktok_url', $profile->tiktok_url) }}" placeholder="https://tiktok.com/@osis24bdg" class="form-input-custom">
                    </div>
                    <div>
                        <label for="youtube_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">YouTube OSIS</label>
                        <input type="text" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $profile->youtube_url) }}" placeholder="https://youtube.com/@osis24bdg" class="form-input-custom">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-700 hover:bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-900/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan Profil Kabinet
                </button>
            </div>
        </form>
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: STRUKTUR PENGURUS BPH & SEKBID      -->
    <!-- ========================================== -->
    <div x-show="currentTab === 'members'" x-cloak class="space-y-6">
        <!-- Search & Filter Bar -->
        <form action="{{ route('admin.osis.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
            <input type="hidden" name="tab" value="members">
            <div class="flex-1 w-full flex gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama pengurus, jabatan, atau kelas..." class="form-input-custom">
                <x-button type="submit" variant="primary">Cari</x-button>
            </div>
            
            <div class="flex flex-wrap md:flex-nowrap gap-3 items-center w-full md:w-auto">
                <select name="department" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                    <option value="">-- Semua Divisi / Sekbid --</option>
                    @foreach($departments as $key => $label)
                        <option value="{{ $key }}" {{ $department === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                    <option value="">-- Status --</option>
                    <option value="1" {{ $status === '1' || $status === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $status === '0' || $status === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                </select>

                @if($search || $department || $status !== null && $status !== '')
                    <a href="{{ route('admin.osis.index', ['tab' => 'members']) }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Bulk Action Form (Delete) -->
        <form action="{{ route('admin.osis.members.bulk_delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh pengurus yang dipilih?')" x-show="selectedIds.length > 0" class="flex items-center justify-between p-3.5 bg-rose-50 border border-rose-200 rounded-2xl">
            @csrf
            <template x-for="id in selectedIds" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
            <div class="text-xs font-bold text-rose-900">
                <span x-text="selectedIds.length"></span> pengurus terpilih
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition-all">
                Hapus Massal
            </button>
        </form>

        <!-- Members Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-4 py-4 w-10 text-center">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            </th>
                            <th class="px-6 py-4">Foto & Pengurus</th>
                            <th class="px-6 py-4">Jabatan & Divisi</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4">Instagram / Motto</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($members as $member)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" :value="{{ $member->id }}" x-model="selectedIds" class="member-checkbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3.5">
                                        @if($member->photo)
                                            <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="w-11 h-11 rounded-xl object-cover border border-slate-200 shadow-xs">
                                        @else
                                            <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-800 font-extrabold flex items-center justify-center text-sm border border-indigo-200">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm">{{ $member->name }}</div>
                                            <div class="text-slate-400 text-[10px]">Urutan ke-{{ $member->order_position }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 space-y-1">
                                    <div class="font-extrabold text-slate-800">{{ $member->position }}</div>
                                    <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold {{ $member->department === 'bph' ? 'bg-indigo-100 text-indigo-800 border border-indigo-200' : ($member->department === 'mpk' ? 'bg-amber-100 text-amber-900 border border-amber-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200') }}">
                                        {{ $member->department_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-slate-700">
                                    {{ $member->class_grade ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 space-y-0.5">
                                    @if($member->instagram)
                                        <div class="text-[11px] text-indigo-600 font-semibold flex items-center gap-1">
                                            <span>📸</span> {{ $member->instagram }}
                                        </div>
                                    @endif
                                    @if($member->motto)
                                        <div class="text-[10px] text-slate-400 italic">"{{ Str::limit($member->motto, 35) }}"</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $member->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-500 border border-slate-300' }}">
                                        {{ $member->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.osis.members.edit', $member) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.osis.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengurus ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada data pengurus OSIS. Klik "Tambah Pengurus Baru" untuk menambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($members->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    {{ $members->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
