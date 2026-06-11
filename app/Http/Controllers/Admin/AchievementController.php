<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Unit;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AchievementController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the achievements.
     */
    public function index(Request $request, Unit $unit): View
    {
        $query = $unit->achievements();

        if ($request->filled('peraih_prestasi')) {
            $query->where('peraih_prestasi', $request->query('peraih_prestasi'));
        }

        $achievements = $query->orderBy('tahun_prestasi', 'desc')->orderBy('created_at', 'desc')->get();

        return view('admin.achievements.index', compact('unit', 'achievements'));
    }

    /**
     * Show the form for creating a new achievement.
     */
    public function create(Unit $unit): View
    {
        return view('admin.achievements.create', compact('unit'));
    }

    /**
     * Store a newly created achievement in storage.
     */
    public function store(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'judul_prestasi'     => ['required', 'string', 'max:255'],
            'tahun_prestasi'     => ['required', 'string', 'max:4'],
            'peraih_prestasi'    => ['required', Rule::in(['siswa', 'guru', 'tendik', 'sekolah'])],
            'deskripsi_prestasi' => ['nullable', 'string'],
            'foto_penghargaan'   => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['foto_penghargaan', '_token']);

        if ($request->hasFile('foto_penghargaan')) {
            $data['foto_penghargaan'] = $this->fileUploadService->uploadImage($request->file('foto_penghargaan'), $unit->id, 'achievements');
        }

        $unit->achievements()->create($data);

        return redirect()->route('admin.achievements.index', $unit)
            ->with('success', 'Prestasi baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified achievement.
     */
    public function edit(Unit $unit, Achievement $achievement): View
    {
        // Pastikan achievement memang milik unit ini
        if ($achievement->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.achievements.edit', compact('unit', 'achievement'));
    }

    /**
     * Update the specified achievement in storage.
     */
    public function update(Request $request, Unit $unit, Achievement $achievement): RedirectResponse
    {
        if ($achievement->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'judul_prestasi'     => ['required', 'string', 'max:255'],
            'tahun_prestasi'     => ['required', 'string', 'max:4'],
            'peraih_prestasi'    => ['required', Rule::in(['siswa', 'guru', 'tendik', 'sekolah'])],
            'deskripsi_prestasi' => ['nullable', 'string'],
            'foto_penghargaan'   => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['foto_penghargaan', '_token', '_method']);

        if ($request->hasFile('foto_penghargaan')) {
            $data['foto_penghargaan'] = $this->fileUploadService->uploadImage($request->file('foto_penghargaan'), $unit->id, 'achievements', $achievement->foto_penghargaan);
        }

        $achievement->update($data);

        return redirect()->route('admin.achievements.index', $unit)
            ->with('success', 'Data prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified achievement from storage.
     */
    public function destroy(Unit $unit, Achievement $achievement): RedirectResponse
    {
        if ($achievement->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $this->fileUploadService->deleteFile($achievement->foto_penghargaan);

        $achievement->delete();

        return redirect()->route('admin.achievements.index', $unit)
            ->with('success', 'Prestasi berhasil dihapus.');
    }
}
