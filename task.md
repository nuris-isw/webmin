# WebMin — Task Pengembangan

> Rencana pengembangan aplikasi CMS Multi-Tenant Sekolah Terpusat  
> Berdasarkan: `webmin-requirement.md` & `design-v2.md`

---

## Status Legenda

- `[ ]` Belum dikerjakan
- `[/]` Sedang dikerjakan
- `[x]` Selesai

---

## FASE 0 — Fondasi & Konfigurasi Proyek

> **Tujuan:** Memastikan seluruh dependensi, konfigurasi lingkungan, dan tooling terpasang dengan benar sebelum pengembangan fitur dimulai.

- [x] **F0-01** Pasang Laravel Breeze (`php artisan breeze:install blade --dark`)
- [x] **F0-02** Pasang Laravel Socialite (`composer require laravel/socialite`)
- [x] **F0-03** Konfigurasi Tailwind CSS v4 via `@tailwindcss/vite` plugin pada `vite.config.js` & `app.css`
- [x] **F0-04** Definisikan Design System di `app.css` menggunakan `@theme {}`:
  - [x] Font: `Plus Jakarta Sans` (dari Google Fonts — via `<link>` di layouts)
  - [x] Brand colors: `--color-brand-red`, `--color-brand-red-light`, `--color-brand-red-dark`, `--color-brand-red-deep`
  - [x] Neutral colors: `--color-dark`, `--color-gray-dark`, `--color-gray-medium`, `--color-gray-light`
  - [x] Social colors: `--color-facebook`, `--color-instagram`, `--color-youtube`, `--color-tiktok`
- [x] **F0-05** Konfigurasi dark mode class-based (`.dark` pada `<html>`) — inline script di layouts + `app.js`
- [x] **F0-06** Konfigurasi Google OAuth di `.env`, `.env.example`, dan `config/services.php`
- [x] **F0-07** Setup penyimpanan file lokal / disk `public` (`php artisan storage:link`)
- [x] **F0-08** Verifikasi setup: `npm run build` berhasil menghasilkan aset produksi

---

## FASE 1 — Database Schema & Models

> **Tujuan:** Merancang dan membuat seluruh tabel database serta Eloquent Model yang dibutuhkan sistem.

### 1.1 Migrasi Tabel Inti

- [x] **F1-01** Buat migrasi tabel `units` (data unit sekolah)
  - Kolom: `id`, `nama_sekolah`, `slug`, `jenjang` (enum: `tk`, `smp`, `smk`), `is_active`, `timestamps`
- [x] **F1-02** Modifikasi tabel `users` (tambahkan kolom tenant)
  - Kolom tambahan: `unit_id` (FK nullable), `role` (enum: `superadmin`, `admin`), `google_id` (nullable)
- [x] **F1-03** Buat migrasi tabel `school_profiles` (profil sekolah per unit)
  - Tab A — Kontak & Lokasi: `logo_sekolah`, `email`, `telepon`, `alamat`, `google_map_embed_url`, `media_sosial` (JSON)
  - Tab B — Profil & Sejarah: `nama_kepala_sekolah`, `foto_kepala_sekolah`, `sambutan_kepala_sekolah`, `sejarah_singkat_sekolah`
  - Tab C — Akademik: `visi`, `misi`, `deskripsi_kurikulum`, `pdf_kalender_akademik`

### 1.2 Migrasi Tabel Kesiswaan

- [x] **F1-04** Buat migrasi tabel `achievements` (data prestasi)
  - Kolom: `id`, `unit_id` (FK), `judul_prestasi`, `tahun_prestasi`, `peraih_prestasi` (enum: `siswa`, `guru`, `tendik`, `sekolah`), `deskripsi_prestasi`, `foto_penghargaan`, `timestamps`
- [x] **F1-05** Buat migrasi tabel `extracurriculars` (data ekstrakurikuler)
  - Kolom: `id`, `unit_id` (FK), `logo_ekskul`, `nama_ekskul`, `pembina_ekskul`, `jadwal_kegiatan`, `timestamps`

### 1.3 Migrasi Tabel Publikasi

- [x] **F1-06** Buat migrasi tabel `news` (berita/artikel)
  - Kolom: `id`, `unit_id` (FK), `judul_berita`, `slug` (unique per unit), `konten_berita`, `gambar_utama`, `published_at`, `timestamps`
- [x] **F1-07** Buat migrasi tabel `galleries` (galeri kegiatan)
  - Kolom: `id`, `unit_id` (FK), `nama_kegiatan`, `opsi_tampilan` (enum: `hero_section`, `gambar_pembuka`, `galeri_dokumentasi`, `galeri_program`), `major_id` (FK nullable), `timestamps`
- [x] **F1-08** Buat migrasi tabel `gallery_photos` (foto per kegiatan, multi-upload)
  - Kolom: `id`, `gallery_id` (FK), `file_foto`, `urutan`, `timestamps`
- [x] **F1-09** Buat migrasi tabel `spmb_settings` (pengaturan SPMB per unit)
  - Kolom: `id`, `unit_id` (FK), `status_spmb` (boolean), `informasi_prosedur`, `url_eksternal_pendaftaran`, `timestamps`

### 1.4 Migrasi Tabel SMK

- [x] **F1-10** Buat migrasi tabel `majors` (jurusan/program keahlian SMK)
  - Kolom: `id`, `unit_id` (FK), `nama_jurusan`, `nomenklatur_istilah`, `shortname`, `nama_kaprog`, `foto_kaprog`, `deskripsi_jurusan`, `timestamps`

### 1.5 Eloquent Models

- [x] **F1-11** Buat model `Unit` dengan relasi `hasOne(SchoolProfile)`, `hasMany(User)`, `hasMany(Achievement)`, `hasMany(Extracurricular)`, `hasMany(News)`, `hasMany(Gallery)`, `hasMany(SpmbSetting)`, `hasMany(Major)`
- [x] **F1-12** Update model `User` dengan relasi `belongsTo(Unit)` dan scope per role
- [x] **F1-13** Buat model `SchoolProfile` dengan relasi `belongsTo(Unit)`
- [x] **F1-14** Buat model `Achievement` dengan relasi `belongsTo(Unit)`
- [x] **F1-15** Buat model `Extracurricular` dengan relasi `belongsTo(Unit)`
- [x] **F1-16** Buat model `News` dengan auto-slug dan relasi `belongsTo(Unit)`
- [x] **F1-17** Buat model `Gallery` dengan relasi `belongsTo(Unit)`, `hasMany(GalleryPhoto)`, `belongsTo(Major)`
- [x] **F1-18** Buat model `GalleryPhoto` dengan relasi `belongsTo(Gallery)`
- [x] **F1-19** Buat model `SpmbSetting` dengan relasi `belongsTo(Unit)`
- [x] **F1-20** Buat model `Major` dengan relasi `belongsTo(Unit)`, `hasMany(Gallery)`
- [x] **F1-21** Buat Factory & Seeder untuk data dummy (unit, user superadmin, user admin tiap jenjang)

---

## FASE 2 — Autentikasi & RBAC

> **Tujuan:** Membangun sistem autentikasi lengkap dengan dukungan Google OAuth dan kontrol akses berbasis role.

### 2.1 Autentikasi Dasar (Breeze)

- [x] **F2-01** Kustomisasi halaman Login Breeze sesuai desain SDD (minimalis, split-layout desktop)
  - [x] Layout: 1 kolom (mobile) / split screen (desktop `md:`)
  - [x] Input border berubah ke `--color-brand-red` saat `:focus`
  - [x] Support dark mode
- [x] **F2-02** Sembunyikan halaman Register publik (registrasi hanya oleh Superadmin)
- [x] **F2-03** Tambahkan tombol "Masuk dengan Google" pada halaman login (warna netral/kontras tinggi)

### 2.2 Google OAuth (Socialite)

- [x] **F2-04** Buat `SocialiteController` dengan method `redirect` dan `callback`
- [x] **F2-05** Implementasi logic: cek apakah email Google terdaftar di sistem → jika ya, login; jika tidak, tolak dengan pesan error
- [x] **F2-06** Simpan `google_id` pada tabel `users` saat login OAuth berhasil
- [x] **F2-07** Daftarkan route OAuth: `GET /auth/google` dan `GET /auth/google/callback`

### 2.3 Middleware & Authorization

- [x] **F2-08** Buat middleware `EnsureSuperadmin` — redirect jika bukan superadmin
- [x] **F2-09** Buat middleware `EnsureAdminOfUnit` — validasi `unit_id` user dengan resource yang diakses
- [x] **F2-10** Buat middleware `EnsureSmkUnit` — proteksi route Manajemen Jurusan, hanya lolos jika `unit.jenjang === 'smk'`
- [x] **F2-11** Daftarkan seluruh middleware di `bootstrap/app.php`
- [x] **F2-12** Buat Policy untuk setiap Model utama (`UnitPolicy`, `NewsPolicy`, `GalleryPolicy`, dll.)

### 2.4 Manajemen User oleh Superadmin

- [x] **F2-13** Buat form registrasi user admin (hanya dapat diakses Superadmin dari dashboard)
- [x] **F2-14** Implementasi assign `unit_id` saat membuat/mengedit akun admin

---

## FASE 3 — Layout & Komponen UI Dasar

> **Tujuan:** Membangun komponen Blade yang reusable dan layout utama dashboard sesuai Design System.

### 3.1 Layout Utama

- [x] **F3-01** Buat `layouts/app.blade.php` (layout dashboard terautentikasi)
  - [x] Sidebar kiri permanen (desktop `w-64`) dengan navigasi menu
  - [x] Top header: judul halaman, toggle dark mode, info profil user
  - [x] Konten utama dengan padding responsif (`16px` mobile → `32px` desktop)
- [x] **F3-02** Buat `layouts/guest.blade.php` (layout halaman publik/login)
- [x] **F3-03** Implementasi sidebar sebagai *off-canvas hamburger menu* pada mobile

### 3.2 Komponen Navigasi

- [x] **F3-04** Buat komponen `<x-nav-link>` dengan indikator aktif (border kiri `4px brand-red` desktop, border bawah mobile)
- [x] **F3-05** Buat komponen `<x-nav-sidebar>` dengan menu dinamis (tampilkan "Manajemen Jurusan" hanya jika jenjang SMK)
- [x] **F3-06** Buat komponen toggle dark mode (`<x-dark-mode-toggle>`) yang mengubah kelas `.dark` pada `<html>`

### 3.3 Komponen UI Reusable

- [x] **F3-07** Buat komponen `<x-card>` (kartu konten/panel dengan dukungan light/dark mode)
- [x] **F3-08** Buat komponen `<x-stat-card>` (kartu metrik ringkasan untuk dashboard)
- [x] **F3-09** Buat komponen `<x-data-table>` (tabel dengan zebra striping, dukungan dark mode)
  - [x] Desktop: tampilan tabel standar
  - [x] Mobile (`max-w-md`): transformasi menjadi stack card view
- [x] **F3-10** Buat komponen `<x-form-input>`, `<x-form-textarea>`, `<x-form-select>`, `<x-form-file>` dengan styling konsisten
- [x] **F3-11** Buat komponen `<x-button>` (primary dengan `brand-red`, secondary/neutral)
- [x] **F3-12** Buat komponen `<x-alert>` (success, error, warning, info)
- [x] **F3-13** Buat komponen `<x-breadcrumb>` untuk navigasi hierarki halaman
- [x] **F3-14** Buat komponen `<x-page-heading>` dengan aksen garis vertikal merah (`h2` style dari SDD)

### 3.4 Tipografi & Utilitas Global

- [x] **F3-15** Import font `Plus Jakarta Sans` dari Google Fonts di `app.css` (dimuat via `<link>` pada layout html)
- [x] **F3-16** Definisikan skala tipografi: `h1` (bold, adaptif), `h2` (border-left accent), body (no-truncation)
- [x] **F3-17** Pastikan tidak ada kelas `grayscale` atau `truncate` pada komponen konten utama

---

## FASE 4 — Dashboard Superadmin

> **Tujuan:** Membangun antarmuka panel Superadmin untuk manajemen global platform.

### 4.1 Halaman Dashboard Superadmin

- [x] **F4-01** Buat `SuperadminController` dengan method `index` (dashboard overview)
- [x] **F4-02** Tampilkan 4 kartu metrik ringkasan:
  - Total Sekolah (jumlah seluruh unit)
  - Total User Admin (jumlah akun operasional)
  - Total Konten Berita (akumulasi dari seluruh unit)
  - Total Prestasi (akumulasi dari seluruh unit)
- [x] **F4-03** Tampilkan tabel daftar unit sekolah (nama, jenjang, status aktif, jumlah admin, aksi)

### 4.2 Manajemen Unit Sekolah

- [x] **F4-04** Buat `UnitController` (CRUD) dengan method: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`
- [x] **F4-05** Buat form pendaftaran unit baru:
  - Field: nama sekolah, jenjang (dropdown: TK / SMP / SMK), status aktif
  - Validasi: nama unik, jenjang wajib dipilih
- [x] **F4-06** Implementasi halaman detail unit (daftar admin terkait, statistik konten)
- [x] **F4-07** Implementasi fitur override konten unit (navigasi ke dashboard unit mana pun)

### 4.3 Manajemen User Admin

- [x] **F4-08** Buat `UserController` (CRUD) dengan method: `index`, `create`, `store`, `edit`, `update`, `destroy`
- [x] **F4-09** Buat form pendaftaran admin baru (nama, email, password, assign ke unit)
- [x] **F4-10** Tampilkan tabel daftar user dengan filter per unit dan per role
- [x] **F4-11** Implementasi reset password oleh Superadmin

---

## FASE 5 — Dashboard Admin Unit

> **Tujuan:** Membangun antarmuka panel Admin untuk manajemen konten unit masing-masing.

### 5.1 Halaman Dashboard Admin

- [x] **F5-01** Buat `AdminDashboardController` dengan method `index`
- [x] **F5-02** Tampilkan ringkasan statistik konten unit (total berita, prestasi, ekskul, foto galeri)
- [x] **F5-03** Tampilkan informasi unit yang dikelola (nama, jenjang, status SPMB)

### 5.2 Modul Profil Sekolah

- [x] **F5-04** Buat `SchoolProfileController` dengan method `edit` dan `update`
- [x] **F5-05** Implementasi form **Tab A — Kontak & Lokasi**:
  - Upload logo sekolah (image preview)
  - Input email, telepon, alamat
  - Input embed URL Google Maps
  - Input link media sosial (Instagram, Facebook, YouTube, TikTok)
- [x] **F5-06** Implementasi form **Tab B — Profil & Sejarah**:
  - Input nama kepala sekolah
  - Upload foto kepala sekolah
  - Rich text editor untuk sambutan kepala sekolah
  - Rich text editor untuk sejarah singkat sekolah
- [x] **F5-07** Implementasi form **Tab C — Akademik**:
  - Rich text editor untuk visi
  - Rich text editor untuk misi
  - Rich text editor untuk deskripsi kurikulum
  - Upload PDF kalender akademik
- [x] **F5-08** Implementasi navigasi tab (Tab A / B / C) menggunakan JavaScript ringan atau Alpine.js
- [x] **F5-09** Integrasi rich text editor (misal: Quill.js, TipTap, atau Markdown editor) untuk field teks panjang

### 5.3 Modul Kesiswaan — Data Prestasi

- [x] **F5-10** Buat `AchievementController` dengan CRUD lengkap
- [x] **F5-11** Tampilkan tabel daftar prestasi dengan filter `peraih_prestasi` (siswa/guru/tendik/sekolah)
- [x] **F5-12** Buat form tambah/edit prestasi:
  - Input judul, tahun prestasi, dropdown peraih, deskripsi
  - Upload foto penghargaan dengan preview

### 5.4 Modul Kesiswaan — Ekstrakurikuler

- [x] **F5-13** Buat `ExtracurricularController` dengan CRUD lengkap
- [x] **F5-14** Tampilkan tabel daftar ekstrakurikuler (logo, nama, pembina, jadwal)
- [x] **F5-15** Buat form tambah/edit ekstrakurikuler:
  - Upload logo ekskul dengan preview
  - Input nama, pembina, jadwal kegiatan

### 5.5 Modul Publikasi — Berita/Artikel

- [x] **F5-16** Buat `NewsController` dengan CRUD lengkap
- [x] **F5-17** Implementasi auto-generate slug dari judul berita (unique per unit)
- [x] **F5-18** Tampilkan tabel daftar berita (judul, slug, tanggal publish, aksi)
- [x] **F5-19** Buat form tambah/edit berita:
  - Input judul berita
  - Upload gambar utama dengan preview
  - Rich text editor untuk konten berita
- [x] **F5-20** Implementasi soft-draft: berita tersimpan sebagai draft sebelum dipublikasikan

### 5.6 Modul Publikasi — Galeri Kegiatan

- [x] **F5-21** Buat `GalleryController` dengan CRUD lengkap
- [x] **F5-22** Tampilkan grid daftar galeri kegiatan dengan thumbnail
- [x] **F5-23** Buat form tambah/edit galeri:
  - Input nama kegiatan
  - Multi-upload foto (drag & drop)
  - Dropdown opsi tampilan: `hero_section`, `gambar_pembuka`, `galeri_dokumentasi`, `galeri_program`
  - Field `major_id` (dropdown jurusan) — tampil dan **required** hanya jika unit SMK + opsi `galeri_program`
- [x] **F5-24** Implementasi validasi server-side: `major_id` wajib jika unit SMK + `galeri_program`, null jika TK/SMP
- [x] **F5-25** Implementasi reorder foto dalam galeri (drag & drop atau tombol naik/turun)

### 5.7 Modul Publikasi — SPMB

- [x] **F5-26** Buat `SpmbController` dengan method `edit` dan `update`
- [x] **F5-27** Buat form pengaturan SPMB:
  - Toggle buka/tutup status SPMB (visual indicator menonjol)
  - Rich text editor untuk informasi prosedur
  - Input URL eksternal pendaftaran

---

## FASE 6 — Modul Manajemen Jurusan (Khusus SMK)

> **Tujuan:** Membangun modul yang terlindungi middleware SMK untuk manajemen data program keahlian.

- [x] **F6-01** Buat `MajorController` dengan CRUD lengkap
- [x] **F6-02** Pasang middleware `EnsureSmkUnit` pada seluruh route Manajemen Jurusan
- [x] **F6-03** Tampilkan tabel daftar jurusan (nama, nomenklatur, shortname, kaprog, aksi)
- [x] **F6-04** Buat form tambah/edit jurusan:
  - Input nama jurusan (contoh: Teknik Komputer dan Jaringan)
  - Input/dropdown nomenklatur istilah (Program Keahlian / Konsentrasi Keahlian / Program Studi)
  - Input shortname (contoh: TKJ, RPL)
  - Input nama kepala program (kaprog)
  - Upload foto kaprog dengan preview
  - Rich text editor untuk deskripsi jurusan (kompetensi, prospek kerja)
- [x] **F6-05** Verifikasi: halaman ini tidak dapat diakses oleh admin unit TK/SMP (redirect dengan pesan error)
- [x] **F6-06** Penyesuaian padding pada setiap form input agar memiliki padding yang sesuai
- [x] **F6-07** Arahkan route `/` ke halaman login (`/login`) sebagai halaman pertama yang diakses user

---

## FASE 7 — Penanganan File & Media

> **Tujuan:** Memastikan upload, penyimpanan, dan penayangan file berjalan dengan aman dan efisien.

- [x] **F7-01** Konfigurasi disk storage (`public`) dan path per unit (`storage/app/public/{unit_id}/`)
- [x] **F7-02** Buat `FileUploadService` untuk handle validasi, resize, dan penyimpanan gambar
- [x] **F7-03** Implementasi validasi tipe file (image: jpg/png/webp; dokumen: pdf)
- [x] **F7-04** Implementasi batas ukuran file (gambar max 2MB, PDF max 10MB)
- [x] **F7-05** Implementasi hapus file lama saat file baru di-upload (mencegah orphan files)
- [x] **F7-06** Buat helper Blade `@asset()` / route helper untuk URL file yang konsisten
- [x] **F7-07** Implementasi multi-upload foto galeri dengan progress bar

---

## FASE 8 — Polish, UX & Aksesibilitas

> **Tujuan:** Memastikan antarmuka memenuhi standar desain SDD dan optimal digunakan oleh admin non-teknis.

- [ ] **F8-01** Audit seluruh halaman: pastikan tidak ada kelas `grayscale` atau `truncate` pada konten utama
- [ ] **F8-02** Verifikasi dark mode berfungsi pada seluruh halaman (sidebar, kartu, tabel, form)
- [ ] **F8-03** Verifikasi tampilan mobile (stack card view pada tabel, hamburger menu, action button min 44x44px)
- [ ] **F8-04** Tambahkan feedback visual: loading state, success toast notification, error message inline
- [ ] **F8-05** Tambahkan konfirmasi dialog sebelum aksi delete (native `confirm()` atau modal)
- [ ] **F8-06** Implementasi empty state yang informatif (saat tabel kosong, tampilkan ilustrasi + CTA)
- [ ] **F8-07** Pastikan semua form memiliki label yang jelas dan pesan error yang mudah dipahami
- [ ] **F8-08** Review keseluruhan tipografi: `h1` adaptif, `h2` dengan border-left accent merah
- [ ] **F8-09** Tambahkan pagination pada semua tabel yang berpotensi memiliki banyak data

---

## FASE 9 — Testing & Quality Assurance

> **Tujuan:** Memvalidasi fungsionalitas sistem melalui pengujian otomatis dan manual.

### 9.1 Unit & Feature Tests

- [ ] **F9-01** Tulis Feature Test untuk autentikasi (login, logout, Google OAuth mock)
- [ ] **F9-02** Tulis Feature Test untuk RBAC: superadmin dapat akses semua, admin hanya unit sendiri
- [ ] **F9-03** Tulis Feature Test untuk middleware SMK: admin non-SMK tidak bisa akses `/majors`
- [ ] **F9-04** Tulis Feature Test untuk validasi galeri: `major_id` required jika SMK + `galeri_program`
- [ ] **F9-05** Tulis Feature Test untuk CRUD setiap modul (News, Achievement, dll.)
- [ ] **F9-06** Tulis Unit Test untuk `FileUploadService`

### 9.2 Manual Testing Checklist

- [ ] **F9-07** Test login dengan email/password dan Google OAuth
- [ ] **F9-08** Test tenant isolation: admin unit A tidak bisa edit konten unit B
- [ ] **F9-09** Test upload gambar (jpg, png, webp) dan PDF
- [ ] **F9-10** Test multi-upload foto galeri
- [ ] **F9-11** Test dark mode di semua halaman utama
- [ ] **F9-12** Test tampilan mobile pada smartphone (375px) dan tablet (768px)
- [ ] **F9-13** Test seluruh alur admin SMK (termasuk Manajemen Jurusan)
- [ ] **F9-14** Test override Superadmin pada konten unit manapun

---

## FASE 10 — Deployment & Dokumentasi Akhir

> **Tujuan:** Mempersiapkan aplikasi untuk production dan melengkapi dokumentasi.

- [ ] **F10-01** Konfigurasi `.env.production` (database, app key, storage, OAuth credentials)
- [ ] **F10-02** Jalankan optimisasi production (`php artisan optimize`, `npm run build`)
- [ ] **F10-03** Verifikasi `php artisan storage:link` di server production
- [ ] **F10-04** Buat seeder untuk data awal: 1 akun Superadmin default
- [ ] **F10-05** Dokumentasikan panduan penggunaan dasar untuk Admin dan Superadmin
- [ ] **F10-06** Update `README.md` dengan URL production dan catatan deployment

---

## FASE 11 — REST API Layer

> **Tujuan:** Mengekspos seluruh data publik dan terautentikasi melalui endpoint REST API sehingga dapat dikonsumsi oleh aplikasi frontend (Next.js, Nuxt, React Native, dll.).

### 11.1 Setup & Konfigurasi API

- [ ] **F11-01** Aktifkan API routing bawaan Laravel: jalankan `php artisan install:api` (tanpa Sanctum auth — cukup untuk route `api.php`)
- [ ] **F11-02** Buat prefix routing `api/v1/` untuk seluruh endpoint GET di `routes/api.php`
- [ ] **F11-03** Buat middleware `ForceJsonResponse` — memastikan seluruh response API selalu `Content-Type: application/json`
- [ ] **F11-04** Buat response helper / trait `ApiResponse` dengan format standar:
  ```json
  { "success": true, "message": "...", "data": {}, "meta": {} }
  ```
- [ ] **F11-05** Konfigurasi global `Handler.php` untuk mengembalikan error 404 dan 500 dalam format JSON yang konsisten

### 11.2 API Resource & Transformer

- [ ] **F11-06** Buat `JsonResource` untuk setiap model agar output API konsisten dan terpisah dari struktur database:
  - `UnitResource` — data unit termasuk jenjang & URL logo
  - `SchoolProfileResource` — data profil lengkap per unit
  - `NewsResource` & `NewsCollection` — artikel dengan pagination
  - `AchievementResource` — data prestasi
  - `ExtracurricularResource` — data ekstrakurikuler
  - `GalleryResource` — galeri dengan nested `GalleryPhotoResource`
  - `SpmbResource` — status dan info SPMB
  - `MajorResource` — data jurusan SMK
- [ ] **F11-07** Pastikan seluruh URL file (gambar, PDF) di dalam Resource menggunakan URL absolut (`Storage::url()`), bukan path relatif

### 11.3 Endpoint API Publik (Read-Only GET)

> Seluruh endpoint bersifat publik tanpa autentikasi. Manajemen konten **hanya** dilakukan melalui dashboard Laravel.

- [ ] **F11-08** Buat `Api\UnitController`:
  - `GET /api/v1/units` — daftar semua unit aktif
  - `GET /api/v1/units/{slug}` — detail unit beserta profil lengkap
- [ ] **F11-09** Buat `Api\NewsController`:
  - `GET /api/v1/units/{slug}/news` — daftar berita unit (paginated, query: `?page=`, `?per_page=`)
  - `GET /api/v1/units/{slug}/news/{newsSlug}` — detail artikel
- [ ] **F11-10** Buat `Api\AchievementController`:
  - `GET /api/v1/units/{slug}/achievements` — daftar prestasi (query: `?peraih=siswa|guru|tendik|sekolah`)
- [ ] **F11-11** Buat `Api\ExtracurricularController`:
  - `GET /api/v1/units/{slug}/extracurriculars` — daftar ekstrakurikuler
- [ ] **F11-12** Buat `Api\GalleryController`:
  - `GET /api/v1/units/{slug}/galleries` — daftar galeri (query: `?opsi_tampilan=hero_section|gambar_pembuka|galeri_dokumentasi|galeri_program`)
  - `GET /api/v1/units/{slug}/galleries/{id}` — detail galeri beserta semua foto
- [ ] **F11-13** Buat `Api\SpmbController`:
  - `GET /api/v1/units/{slug}/spmb` — info & status SPMB aktif
- [ ] **F11-14** Buat `Api\MajorController` (hanya merespons untuk unit SMK, kembalikan 404 jika bukan SMK):
  - `GET /api/v1/units/{slug}/majors` — daftar jurusan
  - `GET /api/v1/units/{slug}/majors/{id}` — detail jurusan beserta galeri `galeri_program` terkait

### 11.4 Optimasi & Keamanan API

- [ ] **F11-15** Implementasi **Rate Limiting** per IP pada seluruh endpoint (`throttle:60,1`) untuk mencegah penyalahgunaan
- [ ] **F11-16** Konfigurasi CORS (`config/cors.php`) — izinkan origin domain frontend yang telah didaftarkan
- [ ] **F11-17** Implementasi **API Versioning** — seluruh route berada di prefix `/api/v1/` agar migrasi ke versi berikutnya tidak breaking
- [ ] **F11-18** Tambahkan HTTP Cache headers (`Cache-Control: public, max-age=300`) pada endpoint yang jarang berubah (profil sekolah, daftar unit, daftar jurusan)
- [ ] **F11-19** Tulis Feature Test API: setiap endpoint GET mengembalikan status `200` dan struktur JSON sesuai `ApiResponse` yang didefinisikan
- [ ] **F11-20** Tulis Feature Test API: endpoint unit non-SMK yang mengakses `/majors` mengembalikan `404`

---

## FASE 12 — Dokumentasi Endpoint API

> **Tujuan:** Menyediakan dokumentasi API yang lengkap, akurat, dan siap pakai oleh tim frontend atau pihak ketiga.

### 12.1 Setup Generator Dokumentasi

- [ ] **F12-01** Evaluasi dan pilih tool dokumentasi API:
  - **Opsi A:** [Scribe](https://scribe.knuckles.wtf/) (`composer require --dev knuckleswtf/scribe`) — generate dari kode PHP secara otomatis
  - **Opsi B:** [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) — OpenAPI 3.0 / Swagger UI
  - *(Rekomendasi: Scribe untuk proyek Laravel karena integrasi paling mulus)*
- [ ] **F12-02** Pasang dan konfigurasi tool yang dipilih (`php artisan scribe:generate` / `php artisan l5-swagger:generate`)
- [ ] **F12-03** Amankan halaman dokumentasi: hanya dapat diakses di environment `local` / `staging`, atau dengan basic auth di production

### 12.2 Anotasi & Metadata Endpoint

- [ ] **F12-04** Tambahkan docblock/anotasi pada seluruh API Controller dengan informasi:
  - Deskripsi endpoint
  - Parameter path (`{slug}`, `{id}`)
  - Query parameter (filter, pagination: `page`, `per_page`)
  - Request body (field, tipe data, apakah required)
  - Response body (contoh JSON sukses dan error)
- [ ] **F12-05** Definisikan kelompok (group/tag) endpoint sesuai resource:
  - `Units` — daftar & detail unit sekolah
  - `News` — daftar & detail berita per unit
  - `Achievements` — data prestasi per unit
  - `Extracurriculars` — data ekstrakurikuler per unit
  - `Galleries` — galeri kegiatan & foto per unit
  - `SPMB` — status & info penerimaan siswa per unit
  - `Majors` — data jurusan SMK per unit
- [ ] **F12-06** Buat contoh response (`example`) yang realistis untuk setiap endpoint (bukan placeholder lorem ipsum)
- [ ] **F12-07** Dokumentasikan kode status HTTP yang digunakan:
  - `200 OK`, `201 Created`, `204 No Content`
  - `400 Bad Request`, `401 Unauthorized`, `403 Forbidden`, `404 Not Found`
  - `422 Unprocessable Entity` (validasi gagal dengan detail field error)
  - `429 Too Many Requests` (rate limit)
  - `500 Internal Server Error`

### 12.3 Ekspor Koleksi API Client

- [ ] **F12-08** Generate dan ekspor koleksi **Postman** (`postman_collection.json`) dari dokumentasi yang dihasilkan
- [ ] **F12-09** Generate dan ekspor koleksi **Insomnia** (`insomnia_collection.json`) sebagai alternatif
- [ ] **F12-10** Simpan kedua file koleksi di direktori `docs/api/` dalam repositori dan perbarui setiap ada perubahan endpoint
- [ ] **F12-11** Sertakan **environment variables** dalam koleksi: `base_url`, `api_token` (variabel kosong, diisi oleh pengguna)

### 12.4 Panduan Integrasi Frontend

- [ ] **F12-12** Buat berkas `docs/api/INTEGRATION_GUIDE.md` yang menjelaskan:
  - Base URL API dan versi aktif
  - Cara mendapatkan token (flow login)
  - Cara menyertakan token pada setiap request (`Authorization: Bearer <token>`)
  - Cara menangani pagination (`data`, `links`, `meta` dari Laravel Resource)
  - Contoh penggunaan endpoint paling umum (fetch daftar berita, upload gambar)
  - Penjelasan `Display Placement Routing` galeri (bagaimana frontend harus menangani `opsi_tampilan`)
  - Penjelasan conditional field `major_id` untuk galeri unit SMK
- [ ] **F12-13** Buat berkas `docs/api/CHANGELOG.md` untuk mencatat perubahan API setiap versi
- [ ] **F12-14** Verifikasi akhir: akses halaman dokumentasi yang di-generate, pastikan seluruh endpoint terdaftar dan contoh response valid

---

## Ringkasan Fase

| Fase | Nama | Estimasi Kompleksitas |
|------|------|-----------------------|
| **0** | Fondasi & Konfigurasi | Rendah |
| **1** | Database Schema & Models | Sedang |
| **2** | Autentikasi & RBAC | Sedang-Tinggi |
| **3** | Layout & Komponen UI | Sedang |
| **4** | Dashboard Superadmin | Sedang |
| **5** | Dashboard Admin Unit | Tinggi |
| **6** | Manajemen Jurusan (SMK) | Rendah-Sedang |
| **7** | Penanganan File & Media | Sedang |
| **8** | Polish & UX | Sedang |
| **9** | Testing & QA | Sedang |
| **10** | Deployment & Dokumentasi | Rendah |
| **11** | REST API Layer | Tinggi |
| **12** | Dokumentasi Endpoint API | Sedang |
