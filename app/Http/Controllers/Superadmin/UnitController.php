<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UnitController extends Controller
{
    /**
     * Display a listing of the units.
     */
    public function index(): View
    {
        $units = Unit::withCount('users')->orderBy('nama_sekolah')->get();

        return view('superadmin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new unit.
     */
    public function create(): View
    {
        return view('superadmin.units.create');
    }

    /**
     * Store a newly created unit in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255', 'unique:units'],
            'jenjang'      => ['required', Rule::in(['tk', 'smp', 'smk'])],
            'is_active'    => ['required', 'boolean'],
        ]);

        // Buat Unit
        $unit = Unit::create([
            'nama_sekolah' => $validated['nama_sekolah'],
            'slug'         => Str::slug($validated['nama_sekolah']),
            'jenjang'      => $validated['jenjang'],
            'is_active'    => $validated['is_active'],
        ]);

        // Inisialisasi Profil Sekolah default
        $unit->schoolProfile()->create([
            'email'        => 'info@' . $unit->slug . '.sch.id',
            'media_sosial' => [
                'instagram' => null,
                'facebook'  => null,
                'youtube'   => null,
                'tiktok'    => null,
            ],
        ]);

        // Inisialisasi SPMB Setting default
        $unit->spmbSetting()->create([
            'status_spmb'               => false,
            'url_eksternal_pendaftaran' => null,
        ]);

        return redirect()->route('superadmin.units.index')
            ->with('success', 'Unit sekolah baru berhasil terdaftar dan diinisialisasi.');
    }

    /**
     * Display the specified unit details.
     */
    public function show(Unit $unit): View
    {
        $unit->load(['users' => function($query) {
            $query->where('role', 'admin');
        }]);

        // Hitung statistik konten unit
        $stats = [
            'news'            => $unit->news()->count(),
            'achievements'    => $unit->achievements()->count(),
            'extracurriculars'=> $unit->extracurriculars()->count(),
            'majors'          => $unit->majors()->count(),
        ];

        return view('superadmin.units.show', compact('unit', 'stats'));
    }

    /**
     * Show the form for editing the specified unit.
     */
    public function edit(Unit $unit): View
    {
        return view('superadmin.units.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255', Rule::unique('units')->ignore($unit->id)],
            'jenjang'      => ['required', Rule::in(['tk', 'smp', 'smk'])],
            'is_active'    => ['required', 'boolean'],
        ]);

        $unit->nama_sekolah = $validated['nama_sekolah'];
        $unit->slug         = Str::slug($validated['nama_sekolah']);
        $unit->jenjang      = $validated['jenjang'];
        $unit->is_active    = $validated['is_active'];
        $unit->save();

        return redirect()->route('superadmin.units.index')
            ->with('success', 'Data unit sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified unit from storage.
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        $unit->delete();

        return redirect()->route('superadmin.units.index')
            ->with('success', 'Unit sekolah beserta seluruh data terkait berhasil dihapus.');
    }
}
