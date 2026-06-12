# Web Admin — Sistem CMS Multi-Tenant Sekolah Terpusat

> Platform manajemen konten terpusat berbasis web untuk mengelola seluruh unit sekolah (TK, SMP, SMK) dalam satu ekosistem yang terintegrasi.

---

## 📋 Deskripsi Proyek

**Web Admin** adalah aplikasi CMS (*Content Management System*) multi-tenant yang dirancang untuk kebutuhan Badan Penyelenggara / Yayasan pendidikan. Sistem ini memungkinkan satu platform tunggal mengoperasikan dan mengelola konten digital dari seluruh unit sekolah yang berada di bawah naungan yayasan — mulai dari profil sekolah, berita, galeri kegiatan, data kesiswaan, hingga informasi penerimaan peserta didik baru (SPMB/PPDB).

---

## 🎯 Fitur Utama Setelah Pengembangan

### 1. Manajemen Multi-Tenant & Context-Aware UI
- **Isolasi Data Ketat**: Pemisahan data berbasis `unit_id` per sekolah untuk menjaga integritas data masing-masing unit.
- **Superadmin Dashboard**: Dilengkapi akses lintas unit (*cross-tenant*), manajemen pendaftaran unit sekolah baru, kontrol penuh atas penugasan admin sekolah, dan filter data (role/unit) yang andal.
- **Indikator Konteks Aktif**: Menampilkan teks penjelas *"Sedang Mengelola: [Nama Sekolah]"* di sidebar dan header ketika Superadmin sedang mengelola konten unit tertentu secara interaktif (*override mode*).
- **Admin Unit**: Dashboard terisolasi khusus untuk sekolah yang ditugaskan. Mendukung jenjang **TK**, **SMP**, dan **SMK** (jenjang SMK memiliki akses eksklusif ke Manajemen Jurusan).

### 2. Autentikasi & Keamanan Terintegrasi
- **Autentikasi Session**: Berbasis Laravel Breeze untuk panel manajemen administrator.
- **Google OAuth**: Integrasi login sekali klik via Laravel Socialite.
- **Role-Based Access Control (RBAC)**: Pembatasan hak akses yang ketat antara peran `superadmin` dan `admin` di sisi server dan antarmuka.
- **Perlindungan Rute & API**: Menggunakan middleware otorisasi cerdas dengan bypass otomatis untuk Superadmin demi kemudahan pengelolaan.

### 3. Optimalisasi UI/UX Premium
- **Skala Tipografi Global**: Dikonfigurasi ulang untuk kenyamanan visual yang lebih baik. Menggunakan font **Plus Jakarta Sans** dengan ukuran teks minimum `14px` (`text-sm`) untuk teks pendukung/metadata, `16px` (`text-base`) untuk teks standar konten, dan `18px` (`text-lg`) untuk judul kartu/menu.
- **Tombol Aksi Modern & Anti-Clipping**: Semua aksi tabel (Detail, Edit, Hapus) menggunakan komponen `<x-icon-button>` berbasis SVG Heroicons yang dilengkapi dengan native browser tooltips (`title` attribute) untuk mencegah penumpukan atau terpotong (*clipped*) oleh wrapper tabel responsif.
- **Dropdown yang Lebih Longgar**: Padding pada komponen dropdown diperluas (`px-5 py-3` pada link, `py-2` pada kontainer) dengan dukungan warna latar belakang gelap yang kontras (`dark:bg-gray-800`).
- **Penyempurnaan Guest Layout**: Halaman login memiliki kartu logo berwarna putih dengan radius `15px` (`rounded-2xl` equivalents) untuk menonjolkan tipografi logo berwarna merah, serta dilengkapi dengan footer halaman terintegrasi di bagian bawah.

### 4. Rich-Text Editor (Quill v2) Terintegrasi
- Menggunakan komponen kustom `<x-form-rich-text>` bertenaga **Quill v2.0.2**.
- Menangani inisialisasi konten programatik untuk form pengeditan menggunakan `quill.clipboard.dangerouslyPasteHTML` untuk mencegah data kosong.
- Menggunakan input tersembunyi (*hidden inputs*) untuk pertukaran data yang aman dengan Alpine.js guna menghindari konflik siklus update data.
- Dilengkapi dengan panel toolbar kaya fitur (blockquote, link, indent/outdent, header hingga 4 tingkat) serta dukungan mode gelap (*dark mode*) yang disesuaikan.

---

## 🏗️ Arsitektur & Tech Stack

| Komponen | Teknologi |
|---|---|
| **Core Framework** | Laravel 11 (PHP 8.3+) |
| **Auth Scaffolding** | Laravel Breeze |
| **OAuth Provider** | Laravel Socialite (Google) |
| **Styling Engine** | Tailwind CSS v4 (Dengan konfigurasi `@theme` di `resources/css/app.css`) |
| **Typography** | Plus Jakarta Sans |
| **Database** | MySQL / SQLite (development) |
| **Asset Bundler** | Vite |
| **Template Engine** | Blade & Alpine.js |
| **Rich-Text Editor** | Quill Editor v2.0.2 |
| **API Documentation** | Scribe v4 |

### Palet Warna Brand

Aplikasi menggunakan palet warna khusus untuk memberikan identitas visual yang kuat dan premium:
```css
--color-brand-red:       #E4252C   /* Warna utama aplikasi (Brand Red) */
--color-brand-red-light: #EF3F3C   /* Warna hover */
--color-brand-red-dark:  #8F1924   /* Warna active / pressed state */
--color-brand-red-deep:  #6C0C1C   /* Aksen warna merah pekat */
--color-dark:            #010101   /* Warna teks utama & dasar gelap */
--color-gray-dark:       #737272   /* Warna teks sekunder / metadata */
--color-gray-medium:     #BCBCBC   /* Batas luar / borders */
--color-gray-light:      #DCDBDB   /* Background netral muda */
```

---

## 🔐 Model Akses (Hybrid Access Model)

```
[Public] → Landing page & informasi publik (tanpa login)
    │
    ▼
[Google OAuth / Login Form]
    │
    ▼
[Laravel Breeze Session Management]
    │
    ├─► [Superadmin] → Dashboard global, CRUD semua unit & user (Bypass Tenant Middleware)
    │
    └─► [Admin Unit] → Dashboard terbatas pada unit_id yang ditetapkan
              │
              ├─► TK/SMP: Semua fitur kecuali Manajemen Jurusan
              └─► SMK:    Semua fitur termasuk Manajemen Jurusan
```

---

## 📁 Struktur Proyek Utama

```
webmin/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controller per modul & API Controller
│   │   ├── Middleware/      # Auth, role, force JSON, tenant isolation
│   │   ├── Resources/       # JSON Resources (Transformers API)
│   │   └── Requests/        # Form Request Validation
│   ├── Models/              # Eloquent Models (Unit, User, dll.)
│   ├── Policies/            # Authorization policies
│   └── Services/            # Business logic layer
├── database/
│   ├── migrations/          # Schema database
│   └── seeders/             # Data awal, admin default, & mock data testing
├── docs/
│   ├── api/                 # OpenAPI Spec, Postman Collection, & Panduan API
│   │   ├── INTEGRATION_GUIDE.md
│   │   ├── CHANGELOG.md
│   │   ├── openapi.yaml
│   │   └── postman_collection.json
│   └── USER_MANUAL.md       # Panduan operasional sistem
├── resources/
│   ├── views/               # Blade templates
│   │   ├── layouts/         # Layout utama (app, guest)
│   │   ├── components/      # Komponen Blade reusable (rich-text, icon-button, dll.)
│   │   ├── superadmin/      # Panel Superadmin (Manajemen Unit & Admin)
│   │   └── admin/           # Panel Admin unit sekolah
│   └── css/                 # app.css (Pengaturan tema Tailwind v4)
├── routes/
│   ├── web.php              # Route panel web & auth
│   ├── api.php              # Route API v1 (Public endpoints)
│   └── admin.php            # Route dashboard manajemen (Protected)
└── tests/
    └── Feature/             # Automated Feature Tests (termasuk ApiTest.php)
```

---

## 🚀 Instalasi & Setup Lokal

### Prasyarat
- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL atau SQLite

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone <repo-url> webmin
cd webmin

# 2. Install dependensi PHP & Node
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env, lalu jalankan migrasi & seeder
php artisan migrate --seed

# 5. Build aset frontend (Development)
npm run dev

# 6. Jalankan local server laravel
php artisan serve
```

---

## 📄 REST API & Dokumentasi API (Scribe)

Platform menyediakan API publik siap pakai untuk kebutuhan integrasi frontend eksternal (mobile app atau website publik sekolah).

### Cara Mengakses Dokumentasi API
1. **Melalui Rute Web Terintegrasi**:
   - Jalankan server lokal Anda (misal: `http://localhost:8000`).
   - Buka peramban dan akses rute: **`/docs`** (contoh: `http://localhost:8000/docs`).
   - Rute ini akan merender dokumentasi API interaktif yang kaya fitur secara langsung di peramban Anda.
2. **Format Ekspor Tambahan**:
   - **Postman Collection**: Dapat diakses di rute `/docs.postman` (atau langsung mengimpor berkas dari proyek di [`docs/api/postman_collection.json`](./docs/api/postman_collection.json)).
   - **OpenAPI Specification**: Dapat diakses di rute `/docs.openapi` (atau mengimpor berkas di [`docs/api/openapi.yaml`](./docs/api/openapi.yaml) ke aplikasi seperti Insomnia atau Swagger Editor).

### Optimalisasi UI/UX Dokumentasi API Scribe
Dokumentasi Scribe telah disesuaikan agar memiliki tampilan premium yang senada dengan branding aplikasi:
- **Pewarnaan Konsisten**: Menggunakan skema warna Web Admin. Sidebar pencarian dan panel kode menggunakan latar gelap pekat (`#0c0c0c` dan `#121212`), dipadukan dengan aksen Brand Red (`#E4252C`) untuk penanda rute aktif, tombol bahasa, dan detail komponen.
- **Keterbacaan & Ukuran Teks**: Enforcing skala tipografi menggunakan font **Plus Jakarta Sans** dengan ukuran font teks minimum **`14px` (`text-sm` equivalent)**. Aturan ini diterapkan pada deskripsi rute, daftar parameter, tabel tanggapan, aside notice blocks, dan contoh kode pemrograman guna menghindari teks yang terlalu kecil.
- **Fitur Interaktif**: Konsumen API dapat langsung mencoba endpoint melalui tombol **"Try It Out"** yang ada di dokumen.

### Cara Regenerasi Dokumentasi API
Setiap kali ada perubahan pada anotasi docblock di Controller API, Anda harus memperbarui dokumentasi dengan menjalankan perintah:
```bash
php artisan scribe:generate
```

> [!NOTE]
> Jika Anda mengalami masalah penguncian berkas (*file locking* atau `Access is denied`) saat menjalankan perintah ini di lingkungan Windows, silakan hapus folder cache/vendor scribe secara manual di `public/vendor/scribe` sebelum menjalankan ulang perintah di atas.

---

## 🧪 Pengujian (Testing)

Proyek ini dilengkapi dengan unit dan feature testing otomatis untuk menjamin kestabilan kode saat dilakukan pembaruan.

```bash
# Jalankan seluruh test suite otomatis
php artisan test
```

Semua pengujian (termasuk otorisasi unit, rate limiter API, isolasi tenant data, dan validasi data masukan) dipastikan lulus sebelum masuk ke rute rilis.

---

## 🚀 Panduan Tambahan & Deployment Produksi

- **Panduan Pengguna**: Silakan baca [`docs/USER_MANUAL.md`](./docs/USER_MANUAL.md) untuk petunjuk langkah demi langkah pengoperasian aplikasi oleh operator dan Superadmin.
- **Panduan Integrasi API**: Baca [`docs/api/INTEGRATION_GUIDE.md`](./docs/api/INTEGRATION_GUIDE.md) untuk panduan integrasi sistem frontend dengan API.
- **Checklist Deployment**:
  1. Set `APP_ENV=production` dan `APP_DEBUG=false` di berkas `.env`.
  2. Pastikan symbolic link dibuat dengan `php artisan storage:link`.
  3. Compile aset frontend dengan `npm run build`.
  4. Lakukan optimasi cache dengan `php artisan optimize` dan `php artisan view:cache`.
  5. Generate dokumentasi API final sebelum dideploy menggunakan `php artisan scribe:generate`.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan internal. Seluruh hak cipta dilindungi.
