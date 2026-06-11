<x-app-layout>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Pengaturan SPMB' => '#'
            ]" />

            <!-- Flash Alerts -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            <x-card>
                <x-slot name="title">Pengaturan Penerimaan Murid Baru (SPMB)</x-slot>
                <x-slot name="subtitle">Kelola status pembukaan pendaftaran, link formulir eksternal, dan deskripsi prosedur pendaftaran.</x-slot>

                <form 
                    method="POST" 
                    action="{{ route('admin.spmb.update', $unit) }}" 
                    x-data="{ statusSpmb: {{ old('status_spmb', $spmb->status_spmb ? '1' : '0') }} }"
                    class="space-y-6 mt-6"
                >
                    @csrf
                    @method('PUT')

                    <!-- Visual Indicator Card (Glows dynamically) -->
                    <div 
                        :class="statusSpmb == 1 
                            ? 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-900 text-emerald-800 dark:text-emerald-300 ring-2 ring-emerald-500/20' 
                            : 'bg-rose-50 dark:bg-rose-950/10 border-rose-200 dark:border-rose-950 text-rose-800 dark:text-rose-400'"
                        class="p-5 rounded-xl border flex flex-col md:flex-row items-center justify-between gap-4 transition-all duration-300 shadow-sm"
                    >
                        <div class="flex items-center gap-3.5">
                            <span class="relative flex h-3 w-3">
                                <span 
                                    :class="statusSpmb == 1 ? 'bg-emerald-400' : 'bg-rose-450'"
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"
                                ></span>
                                <span 
                                    :class="statusSpmb == 1 ? 'bg-emerald-500' : 'bg-rose-550'"
                                    class="relative inline-flex rounded-full h-3 w-3"
                                ></span>
                            </span>
                            <div>
                                <h3 class="font-bold text-base">
                                    Status SPMB: <span x-text="statusSpmb == 1 ? 'DIBUKA' : 'DITUTUP'"></span>
                                </h3>
                                <p class="text-xs opacity-80 mt-0.5">
                                    <span x-text="statusSpmb == 1 ? 'Sistem penerimaan siswa baru aktif. Pendaftar dapat mengajukan berkas.' : 'Sistem penerimaan siswa baru non-aktif. Pendaftaran sedang ditangguhkan.'"></span>
                                </p>
                            </div>
                        </div>

                        <!-- Toggle Switch Control -->
                        <div class="flex items-center">
                            <input type="hidden" name="status_spmb" :value="statusSpmb">
                            
                            <button 
                                type="button"
                                @click="statusSpmb = (statusSpmb == 1 ? 0 : 1)"
                                :class="statusSpmb == 1 ? 'bg-emerald-600' : 'bg-gray-300 dark:bg-gray-700'"
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-brand-red focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                            >
                                <span 
                                    :class="statusSpmb == 1 ? 'translate-x-5' : 'translate-x-0'"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                ></span>
                            </button>
                        </div>
                    </div>

                    <!-- URL Eksternal Pendaftaran -->
                    <x-form-input 
                        name="url_eksternal_pendaftaran" 
                        label="URL Eksternal Pendaftaran (Opsional)" 
                        type="url" 
                        :value="old('url_eksternal_pendaftaran', $spmb->url_eksternal_pendaftaran)" 
                        placeholder="https://formulir.sekolah.sch.id/daftar" 
                    />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4">Isi jika pendaftaran menggunakan platform eksternal (Google Form, PPDB Online, dll.). Biarkan kosong jika menggunakan halaman prosedur internal.</p>

                    <!-- Informasi Prosedur (Rich Text Editor) -->
                    <x-form-rich-text 
                        name="informasi_prosedur" 
                        label="Panduan / Prosedur Pendaftaran Siswa Baru" 
                        :value="old('informasi_prosedur', $spmb->informasi_prosedur)" 
                    />

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.dashboard', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Pengaturan
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
