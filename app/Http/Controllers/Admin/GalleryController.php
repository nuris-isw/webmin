<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Major;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     */
    public function index(Unit $unit): View
    {
        $galleries = $unit->galleries()->withCount('photos')->orderBy('created_at', 'desc')->get();

        return view('admin.galleries.index', compact('unit', 'galleries'));
    }

    /**
     * Show the form for creating a new gallery.
     */
    public function create(Unit $unit): View
    {
        $majors = [];
        if ($unit->isSmk()) {
            $majors = $unit->majors()->orderBy('nama_jurusan')->get();
        }

        return view('admin.galleries.create', compact('unit', 'majors'));
    }

    /**
     * Store a newly created gallery in storage.
     */
    public function store(Request $request, Unit $unit): RedirectResponse
    {
        $rules = [
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'opsi_tampilan' => ['required', Rule::in(['hero_section', 'gambar_pembuka', 'galeri_dokumentasi', 'galeri_program'])],
            'major_id'      => ['nullable'],
            'photos'        => ['required', 'array', 'min:1'],
            'photos.*'      => ['image', 'max:2048'],
        ];

        if ($unit->isSmk() && $request->input('opsi_tampilan') === 'galeri_program') {
            $rules['major_id'] = ['required', 'exists:majors,id'];
        }

        $validated = $request->validate($rules);

        $data = [
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'opsi_tampilan' => $validated['opsi_tampilan'],
            'major_id'      => ($unit->isSmk() && $validated['opsi_tampilan'] === 'galeri_program') ? $validated['major_id'] : null,
        ];

        $gallery = $unit->galleries()->create($data);

        if ($request->hasFile('photos')) {
            $counter = 0;
            foreach ($request->file('photos') as $file) {
                $path = $file->store("{$unit->id}/galleries", 'public');
                $gallery->photos()->create([
                    'file_foto' => $path,
                    'urutan'    => $counter++,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index', $unit)
            ->with('success', 'Galeri kegiatan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified gallery.
     */
    public function edit(Unit $unit, Gallery $gallery): View
    {
        if ($gallery->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $majors = [];
        if ($unit->isSmk()) {
            $majors = $unit->majors()->orderBy('nama_jurusan')->get();
        }

        $gallery->load('photos');

        return view('admin.galleries.edit', compact('unit', 'gallery', 'majors'));
    }

    /**
     * Update the specified gallery in storage.
     */
    public function update(Request $request, Unit $unit, Gallery $gallery): RedirectResponse
    {
        if ($gallery->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $rules = [
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'opsi_tampilan' => ['required', Rule::in(['hero_section', 'gambar_pembuka', 'galeri_dokumentasi', 'galeri_program'])],
            'major_id'      => ['nullable'],
            'photos'        => ['nullable', 'array'],
            'photos.*'      => ['image', 'max:2048'],
        ];

        if ($unit->isSmk() && $request->input('opsi_tampilan') === 'galeri_program') {
            $rules['major_id'] = ['required', 'exists:majors,id'];
        }

        $validated = $request->validate($rules);

        $data = [
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'opsi_tampilan' => $validated['opsi_tampilan'],
            'major_id'      => ($unit->isSmk() && $validated['opsi_tampilan'] === 'galeri_program') ? $validated['major_id'] : null,
        ];

        $gallery->update($data);

        // 1. Delete requested photos
        if ($request->filled('deleted_photos')) {
            $deletedIds = $request->input('deleted_photos');
            $photosToDelete = $gallery->photos()->whereIn('id', $deletedIds)->get();
            foreach ($photosToDelete as $photo) {
                Storage::disk('public')->delete($photo->file_foto);
                $photo->delete();
            }
        }

        // 2. Reorder remaining photos
        if ($request->filled('existing_photos_order')) {
            $order = $request->input('existing_photos_order');
            foreach ($order as $index => $photoId) {
                $gallery->photos()->where('id', $photoId)->update(['urutan' => $index]);
            }
        }

        // 3. Store new uploaded photos
        if ($request->hasFile('photos')) {
            $maxOrder = $gallery->photos()->max('urutan') ?? -1;
            $counter = $maxOrder + 1;
            foreach ($request->file('photos') as $file) {
                $path = $file->store("{$unit->id}/galleries", 'public');
                $gallery->photos()->create([
                    'file_foto' => $path,
                    'urutan'    => $counter++,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index', $unit)
            ->with('success', 'Galeri kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified gallery from storage.
     */
    public function destroy(Unit $unit, Gallery $gallery): RedirectResponse
    {
        if ($gallery->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        foreach ($gallery->photos as $photo) {
            Storage::disk('public')->delete($photo->file_foto);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index', $unit)
            ->with('success', 'Galeri kegiatan berhasil dihapus.');
    }
}
