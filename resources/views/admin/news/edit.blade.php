<x-app-layout>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Berita' => route('admin.news.index', $unit),
                'Edit Berita' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Edit Berita / Pengumuman</x-slot>
                <x-slot name="subtitle">Perbarui informasi dan isi berita sekolah.</x-slot>

                <form method="POST" action="{{ route('admin.news.update', [$unit, $news]) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf
                    @method('PUT')

                    <!-- Judul Berita -->
                    <x-form-input name="judul_berita" label="Judul Berita / Pengumuman" :value="old('judul_berita', $news->judul_berita)" required autofocus />

                    <!-- Gambar Utama / Cover -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center border-t border-gray-100 dark:border-gray-800 pt-6">
                        <div class="md:col-span-1 flex justify-center">
                            @if ($news->gambar_utama)
                                <img src="@asset($news->gambar_utama)" alt="Gambar Utama" class="h-20 w-32 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                            @else
                                <div class="h-20 w-32 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="md:col-span-3">
                            <x-form-file name="gambar_utama" label="Ganti Gambar Utama / Cover Berita" accept="image/png, image/jpeg, image/webp" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, WEBP. Maksimal 2MB. Biarkan kosong jika tidak ingin mengganti.</p>
                        </div>
                    </div>

                    <!-- Konten Berita (Rich Text Editor) -->
                    <x-form-rich-text name="konten_berita" label="Konten Berita" :value="old('konten_berita', $news->konten_berita)" />

                    <!-- Status Publikasi -->
                    <div class="border-t border-gray-100 dark:border-gray-800 pt-6">
                        <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status Publikasi</span>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="draft" class="text-brand-red focus:ring-brand-red dark:bg-gray-800 dark:border-gray-700" @checked(old('status', $news->published_at ? 'publish' : 'draft') === 'draft')>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Simpan Sebagai Draft (Belum rilis ke publik)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="publish" class="text-brand-red focus:ring-brand-red dark:bg-gray-800 dark:border-gray-700" @checked(old('status', $news->published_at ? 'publish' : 'draft') === 'publish')>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Publikasikan Sekarang</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-sm text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.news.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Perbarui Berita
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
