<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Unit;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the news.
     */
    public function index(Unit $unit): View
    {
        $news = $unit->news()->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.news.index', compact('unit', 'news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create(Unit $unit): View
    {
        return view('admin.news.create', compact('unit'));
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'judul_berita'  => ['required', 'string', 'max:255'],
            'konten_berita' => ['nullable', 'string'],
            'gambar_utama'  => ['nullable', 'image', 'max:2048'],
            'status'        => ['required', 'in:draft,publish'],
        ]);

        $data = [
            'judul_berita'  => $validated['judul_berita'],
            'konten_berita' => $validated['konten_berita'],
            'published_at'  => $validated['status'] === 'publish' ? now() : null,
        ];

        if ($request->hasFile('gambar_utama')) {
            $data['gambar_utama'] = $this->fileUploadService->uploadImage($request->file('gambar_utama'), $unit->id, 'news');
        }

        $unit->news()->create($data);

        return redirect()->route('admin.news.index', $unit)
            ->with('success', 'Berita baru berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(Unit $unit, News $news): View
    {
        if ($news->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.news.edit', compact('unit', 'news'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(Request $request, Unit $unit, News $news): RedirectResponse
    {
        if ($news->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'judul_berita'  => ['required', 'string', 'max:255'],
            'konten_berita' => ['nullable', 'string'],
            'gambar_utama'  => ['nullable', 'image', 'max:2048'],
            'status'        => ['required', 'in:draft,publish'],
        ]);

        $data = [
            'judul_berita'  => $validated['judul_berita'],
            'konten_berita' => $validated['konten_berita'],
            'published_at'  => $validated['status'] === 'publish' ? ($news->published_at ?? now()) : null,
        ];

        if ($request->hasFile('gambar_utama')) {
            $data['gambar_utama'] = $this->fileUploadService->uploadImage($request->file('gambar_utama'), $unit->id, 'news', $news->gambar_utama);
        }

        $news->update($data);

        return redirect()->route('admin.news.index', $unit)
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy(Unit $unit, News $news): RedirectResponse
    {
        if ($news->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $this->fileUploadService->deleteFile($news->gambar_utama);

        $news->delete();

        return redirect()->route('admin.news.index', $unit)
            ->with('success', 'Berita berhasil dihapus.');
    }
}
