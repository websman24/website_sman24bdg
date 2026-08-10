@extends('layouts.admin.app')

@section('title', 'Manajemen Pengguna & Hak Akses - SMAN 24 Bandung')
@section('breadcrumb', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6" x-data="{ selectedIds: [], selectAll: false }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Pengguna Administrator & Hak Akses</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola akun administrator, tim redaksi, humas, dan pendidik SMAN 24 Bandung.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna Baru
        </a>
    </div>

    <!-- Search & Filter & Bulk Action Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex-1 w-full flex flex-col sm:flex-row gap-3">
            <div class="flex-1 flex gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email pengguna..." class="form-input-custom">
                <x-button type="submit" variant="primary">Cari</x-button>
            </div>
            
            <div class="flex gap-3 items-center">
                <select name="role" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                    <option value="">-- Semua Role --</option>
                    <option value="superadmin" {{ $role === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin CMS</option>
                    <option value="editor" {{ $role === 'editor' ? 'selected' : '' }}>Editor / Humas</option>
                    <option value="guru" {{ $role === 'guru' ? 'selected' : '' }}>Guru / Pengajar</option>
                </select>

                @if($search || $role)
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Bulk Action Form -->
        <form action="{{ route('admin.users.bulk_delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh akun pengguna yang terpilih?')" x-show="selectedIds.length > 0">
            @csrf
            <template x-for="id in selectedIds" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
            <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-1.5">
                <span>🗑️ Hapus Terpilih (<span x-text="selectedIds.length"></span>)</span>
            </button>
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-4 py-4 text-center w-10">
                            <input type="checkbox" @change="
                                selectAll = !selectAll;
                                if (selectAll) {
                                    selectedIds = [{{ $users->pluck('id')->implode(',') }}];
                                } else {
                                    selectedIds = [];
                                }
                            " class="w-4 h-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-700">
                        </th>
                        <th class="px-6 py-4">Avatar & Nama Pengguna</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Role / Hak Akses</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-4 py-4 text-center">
                                @if(auth()->id() !== $user->id)
                                    <input type="checkbox" value="{{ $user->id }}" x-model="selectedIds" class="w-4 h-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-700">
                                @else
                                    <span class="text-slate-300 font-bold" title="Akun Anda Saat Ini">•</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-700/40 shadow-xs">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-emerald-800 text-amber-400 font-black flex items-center justify-center text-sm border-2 border-amber-400/40 shadow-xs">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                            <span>{{ $user->name }}</span>
                                            @if(auth()->id() === $user->id)
                                                <span class="px-2 py-0.5 rounded text-[9px] font-extrabold bg-sky-100 text-sky-800 border border-sky-300">
                                                    (Anda)
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-slate-400 text-[11px]">Terdaftar: {{ $user->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-700 font-mono font-medium">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border
                                    @if($user->role === 'superadmin') bg-rose-100 text-rose-900 border-rose-300
                                    @elseif($user->role === 'admin') bg-amber-100 text-amber-900 border-amber-300
                                    @elseif($user->role === 'editor') bg-sky-100 text-sky-900 border-sky-300
                                    @else bg-emerald-100 text-emerald-900 border-emerald-300 @endif">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $user->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-500 border border-slate-300' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Tidak ada akun pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
