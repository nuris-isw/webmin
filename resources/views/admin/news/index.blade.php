<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Berita & Artikel') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Berita' => '#'
            ]" />

            <!-- Flash Alerts -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            <!-- Main Listing Card -->
            <x-card>
                <x-slot name="title">Daftar Berita / Artikel</x-slot>
                <x-slot name="subtitle">Kelola publikasi berita, pengumuman, dan artikel sekolah.</x-slot>

                <div class="flex justify-end mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <!-- Add Button -->
                    <a href="{{ route('admin.news.create', $unit) }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                        + Tulis Berita Baru
                    </a>
                </div>

                <x-data-table :headers="['Gambar', 'Judul Berita', 'Status', 'Tanggal Rilis', 'Aksi']">
                    @forelse ($news as $article)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4">
                                @if ($article->gambar_utama)
                                    <img src="@asset($article->gambar_utama)" alt="Gambar Utama" class="h-12 w-20 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="h-12 w-20 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-[10px] text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                <span class="block truncate max-w-xs md:max-w-md">{{ $article->judul_berita }}</span>
                                <span class="text-xs text-gray-400 block font-normal">Slug: {{ $article->slug }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($article->published_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-emerald-100 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-300">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-gray-100 dark:bg-gray-700 text-gray-850 dark:text-gray-300">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">
                                {{ $article->published_at ? $article->published_at->format('d M Y H:i') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.news.edit', [$unit, $article]) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.news.destroy', [$unit, $article]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-500 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-full text-gray-400 dark:text-gray-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v4M19 20l-4-4m4-4a5 5 0 11-10 0 5 5 0 0110 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Berita</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Publikasikan pengumuman sekolah, kegiatan kesiswaan, atau artikel berita untuk dibagikan kepada publik.</p>
                                    </div>
                                    <a href="{{ route('admin.news.create', $unit) }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Tulis Berita Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($news as $article)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center gap-3">
                                    @if ($article->gambar_utama)
                                        <img src="@asset($article->gambar_utama)" alt="Gambar Utama" class="h-16 w-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                    @else
                                        <div class="h-16 w-24 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                            No Image
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $article->judul_berita }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal: {{ $article->published_at ? $article->published_at->format('d M Y') : '—' }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase mt-1 {{ $article->published_at ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                                            {{ $article->published_at ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.news.edit', [$unit, $article]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.news.destroy', [$unit, $article]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-rose-50 dark:bg-rose-950/20 text-rose-600 hover:bg-rose-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-800 flex flex-col items-center justify-center space-y-3">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v4M19 20l-4-4m4-4a5 5 0 11-10 0 5 5 0 0110 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Berita</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Tulis artikel berita pertama untuk unit ini.</p>
                                </div>
                                <a href="{{ route('admin.news.create', $unit) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Tulis Berita
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($news->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $news->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
