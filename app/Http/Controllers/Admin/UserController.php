<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Display a listing of admin users with search and role filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $role = $request->query('role');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    /**
     * Show form to create new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store new user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:superadmin,admin,editor,guru'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Role pengguna wajib dipilih.',
        ]);

        // Security check: Only superadmin can create superadmin
        if ($validated['role'] === 'superadmin' && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak: Hanya Superadmin yang dapat membuat akun Superadmin baru.');
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('avatar_file')) {
            $data['avatar'] = $this->fileStorageService->uploadImage($request->file('avatar_file'), 'avatars');
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna administrator baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit user.
     */
    public function edit(User $user): View
    {
        // Security check: Only superadmin can edit another superadmin
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak: Hanya Superadmin yang dapat mengedit akun Superadmin.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:superadmin,admin,editor,guru'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Security check: Only superadmin can manage superadmin role or accounts
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak: Anda tidak dapat memodifikasi akun Superadmin.');
        }
        if ($validated['role'] === 'superadmin' && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak: Anda tidak memiliki izin untuk memberikan role Superadmin.');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->is_active = $request->has('is_active') ? $request->boolean('is_active') : $user->is_active;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar_file')) {
            if ($user->avatar) {
                $this->fileStorageService->deleteFile($user->avatar);
            }
            $user->avatar = $this->fileStorageService->uploadImage($request->file('avatar_file'), 'avatars');
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Informasi akun pengguna berhasil diperbarui.');
    }

    /**
     * Destroy user (prevent self deletion).
     */
    public function destroy(User $user): RedirectResponse
    {
        // Security check: Only superadmin can delete another superadmin
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak: Hanya Superadmin yang dapat menghapus akun Superadmin.');
        }

        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan saat ini.');
        }

        if ($user->avatar) {
            $this->fileStorageService->deleteFile($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }

    /**
     * Bulk delete selected users.
     *
     * Security: validates ids as integers, prevents self-deletion,
     * prevents deletion of last superadmin account.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'min:1'],
        ]);

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak ada data pengguna yang dipilih.');
        }

        // Exclude current logged-in user from deletion
        $filteredIds = array_filter($ids, fn ($id) => (int) $id !== auth()->id());

        // Security check: Admin cannot delete superadmin accounts via bulk delete
        $isSuperAdmin = auth()->user()->isSuperAdmin();

        $superadminIds = User::whereIn('id', $filteredIds)->where('role', 'superadmin')->pluck('id')->toArray();
        if (! empty($superadminIds)) {
            if (! $isSuperAdmin) {
                // If not superadmin, remove superadmin IDs silently
                $filteredIds = array_filter($filteredIds, fn ($id) => ! in_array((int) $id, $superadminIds));
            } else {
                // Even for superadmin, superadmin accounts are only deletable one by one to prevent accidental mass lockout
                $filteredIds = array_filter($filteredIds, fn ($id) => ! in_array((int) $id, $superadminIds));
            }
        }

        $users = User::whereIn('id', $filteredIds)->get();
        foreach ($users as $user) {
            if ($user->avatar) {
                $this->fileStorageService->deleteFile($user->avatar);
            }
            $user->delete();
        }

        $deletedCount = count($users);
        $skippedCount = count($superadminIds);
        $message = "{$deletedCount} akun pengguna berhasil dihapus secara massal.";

        if ($skippedCount > 0) {
            $message .= " {$skippedCount} akun superadmin dilewati (hapus manual satu per satu).";
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }
}
