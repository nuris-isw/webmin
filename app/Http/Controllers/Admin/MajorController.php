<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Unit;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MajorController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the majors.
     */
    public function index(Unit $unit): View
    {
        $majors = $unit->majors()->orderBy('nama_jurusan')->get();

        return view('admin.majors.index', compact('unit', 'majors'));
    }

    /**
     * Show the form for creating a new major.
     */
    public function create(Unit $unit): View
    {
        return view('admin.majors.create', compact('unit'));
    }

    /**
     * Store a newly created major in storage.
     */
    public function store(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jurusan'        => ['required', 'string', 'max:255'],
            'nomenklatur_istilah' => ['required', 'string', 'max:255'],
            'shortname'           => ['required', 'string', 'max:50'],
            'nama_kaprog'         => ['nullable', 'string', 'max:255'],
            'foto_kaprog'         => ['nullable', 'image', 'max:2048'],
            'deskripsi_jurusan'   => ['nullable', 'string'],
        ]);

        $data = $request->except(['foto_kaprog', '_token']);

        if ($request->hasFile('foto_kaprog')) {
            $data['foto_kaprog'] = $this->fileUploadService->uploadImage($request->file('foto_kaprog'), $unit->id, 'majors');
        }

        $unit->majors()->create($data);

        return redirect()->route('admin.majors.index', $unit)
            ->with('success', 'Jurusan baru berhasil didaftarkan.');
    }

    /**
     * Show the form for editing the specified major.
     */
    public function edit(Unit $unit, Major $major): View
    {
        if ($major->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.majors.edit', compact('unit', 'major'));
    }

    /**
     * Update the specified major in storage.
     */
    public function update(Request $request, Unit $unit, Major $major): RedirectResponse
    {
        if ($major->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'nama_jurusan'        => ['required', 'string', 'max:255'],
            'nomenklatur_istilah' => ['required', 'string', 'max:255'],
            'shortname'           => ['required', 'string', 'max:50'],
            'nama_kaprog'         => ['nullable', 'string', 'max:255'],
            'foto_kaprog'         => ['nullable', 'image', 'max:2048'],
            'deskripsi_jurusan'   => ['nullable', 'string'],
        ]);

        $data = $request->except(['foto_kaprog', '_token', '_method']);

        if ($request->hasFile('foto_kaprog')) {
            $data['foto_kaprog'] = $this->fileUploadService->uploadImage($request->file('foto_kaprog'), $unit->id, 'majors', $major->foto_kaprog);
        }

        $major->update($data);

        return redirect()->route('admin.majors.index', $unit)
            ->with('success', 'Data jurusan berhasil diperbarui.');
    }

    /**
     * Remove the specified major from storage.
     */
    public function destroy(Unit $unit, Major $major): RedirectResponse
    {
        if ($major->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Delete Kaprog photo if exists
        $this->fileUploadService->deleteFile($major->foto_kaprog);

        $major->delete();

        return redirect()->route('admin.majors.index', $unit)
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
