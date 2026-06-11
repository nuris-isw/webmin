<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Unit;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExtracurricularController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the extracurriculars.
     */
    public function index(Unit $unit): View
    {
        $extracurriculars = $unit->extracurriculars()->orderBy('nama_ekskul')->get();

        return view('admin.extracurriculars.index', compact('unit', 'extracurriculars'));
    }

    /**
     * Show the form for creating a new extracurricular.
     */
    public function create(Unit $unit): View
    {
        return view('admin.extracurriculars.create', compact('unit'));
    }

    /**
     * Store a newly created extracurricular in storage.
     */
    public function store(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ekskul'     => ['required', 'string', 'max:255'],
            'pembina_ekskul'  => ['nullable', 'string', 'max:255'],
            'jadwal_kegiatan' => ['nullable', 'string'],
            'logo_ekskul'     => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['logo_ekskul', '_token']);

        if ($request->hasFile('logo_ekskul')) {
            $data['logo_ekskul'] = $this->fileUploadService->uploadImage($request->file('logo_ekskul'), $unit->id, 'extracurriculars');
        }

        $unit->extracurriculars()->create($data);

        return redirect()->route('admin.extracurriculars.index', $unit)
            ->with('success', 'Ekstrakurikuler baru berhasil didaftarkan.');
    }

    /**
     * Show the form for editing the specified extracurricular.
     */
    public function edit(Unit $unit, Extracurricular $extracurricular): View
    {
        if ($extracurricular->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.extracurriculars.edit', compact('unit', 'extracurricular'));
    }

    /**
     * Update the specified extracurricular in storage.
     */
    public function update(Request $request, Unit $unit, Extracurricular $extracurricular): RedirectResponse
    {
        if ($extracurricular->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'nama_ekskul'     => ['required', 'string', 'max:255'],
            'pembina_ekskul'  => ['nullable', 'string', 'max:255'],
            'jadwal_kegiatan' => ['nullable', 'string'],
            'logo_ekskul'     => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['logo_ekskul', '_token', '_method']);

        if ($request->hasFile('logo_ekskul')) {
            $data['logo_ekskul'] = $this->fileUploadService->uploadImage($request->file('logo_ekskul'), $unit->id, 'extracurriculars', $extracurricular->logo_ekskul);
        }

        $extracurricular->update($data);

        return redirect()->route('admin.extracurriculars.index', $unit)
            ->with('success', 'Data ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Remove the specified extracurricular from storage.
     */
    public function destroy(Unit $unit, Extracurricular $extracurricular): RedirectResponse
    {
        if ($extracurricular->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $this->fileUploadService->deleteFile($extracurricular->logo_ekskul);

        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index', $unit)
            ->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
