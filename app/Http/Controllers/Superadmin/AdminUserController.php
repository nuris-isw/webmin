<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the admin users.
     */
    public function index(Request $request): View
    {
        $query = User::with('unit');

        if ($request->filled('role')) {
            $query->where('role', $request->query('role'));
        }

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->query('unit_id'));
        }

        $users = $query->orderBy('role', 'desc')->orderBy('name')->get();
        $units = Unit::orderBy('nama_sekolah')->get();

        return view('superadmin.users.index', compact('users', 'units'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create(): View
    {
        $units = Unit::orderBy('nama_sekolah')->get();

        return view('superadmin.users.create', compact('units'));
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'     => ['required', Rule::in(['superadmin', 'admin'])],
            'unit_id'  => ['nullable', 'required_if:role,admin', 'exists:units,id'],
            'password' => ['required', Password::defaults()],
        ], [
            'unit_id.required_if' => 'Unit sekolah wajib dipilih jika peran adalah Admin.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'unit_id'  => $validated['role'] === 'superadmin' ? null : $validated['unit_id'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Akun admin berhasil didaftarkan.');
    }

    /**
     * Show the form for editing the specified admin user.
     */
    public function edit(User $user): View
    {
        $units = Unit::orderBy('nama_sekolah')->get();

        return view('superadmin.users.edit', compact('user', 'units'));
    }

    /**
     * Update the specified admin user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', Rule::in(['superadmin', 'admin'])],
            'unit_id'  => ['nullable', 'required_if:role,admin', 'exists:units,id'],
            'password' => ['nullable', Password::defaults()],
        ], [
            'unit_id.required_if' => 'Unit sekolah wajib dipilih jika peran adalah Admin.',
        ]);

        $data = [
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'role'    => $validated['role'],
            'unit_id' => $validated['role'] === 'superadmin' ? null : $validated['unit_id'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Akun admin berhasil diperbarui.');
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Cegah menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }
}
