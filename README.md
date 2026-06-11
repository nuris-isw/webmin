# WebMin — Sistem CMS Multi-Tenant Sekolah Terpusat

> Platform manajemen konten terpusat berbasis web untuk mengelola seluruh unit sekolah (TK, SMP, SMK) dalam satu ekosistem yang terintegrasi.

---

## 📋 Deskripsi Proyek

**WebMin** adalah aplikasi CMS (*Content Management System*) multi-tenant yang dirancang untuk kebutuhan Badan Penyelenggara / Yayasan pendidikan. Sistem ini memungkinkan satu platform tunggal mengoperasikan dan mengelola konten digital dari seluruh unit sekolah yang berada di bawah naungan yayasan — mulai dari profil sekolah, berita, galeri kegiatan, data kesiswaan, hingga informasi penerimaan peserta didik baru (SPMB/PPDB).

---

## 🎯 Fitur Utama

### Manajemen Multi-Tenant
- Isolasi data ketat berbasis `unit_id` per sekolah
- Superadmin dengan akses lintas seluruh unit (*cross-tenant*)
- Admin unit dengan hak akses terbatas pada unit yang ditetapkan
- Dukungan jenjang: **TK**, **SMP**, dan **SMK** dengan fitur kondisional

### Autentikasi & Keamanan
- Login berbasis session (Laravel Breeze)
- Integrasi OAuth via Google (Laravel Socialite)
- Role-Based Access Control (RBAC): `superadmin` & `admin`
- Middleware proteksi API per jenjang (khususnya SMK)

### Modul Konten (Per Unit)
| Modul | Keterangan |
|---|---|
| **Profil Sekolah** | Kontak & Lokasi, Profil & Sejarah, Data Akademik |
| **Kesiswaan** | Data Prestasi (siswa/guru/tendik/sekolah), Ekstrakurikuler |
| **Publikasi** | Berita/Artikel, Galeri Kegiatan (multi-display), Info SPMB |
| **Manajemen Jurusan** | Khusus unit SMK — CRUD data program/konsentrasi keahlian |

### Galeri dengan Display Placement Routing
Sistem pengelompokan aset foto yang cerdas:
- `hero_section` → Slider/banner utama halaman depan
- `gambar_pembuka` → Visual intro halaman tertentu
- `galeri_dokumentasi` → Album dokumentasi umum
- `galeri_program` → Foto kegiatan unggulan (TK/SMP) atau halaman jurusan (SMK)

---

## 🏗️ Arsitektur & Tech Stack

| Komponen | Teknologi |
|---|---|
| **Core Framework** | Laravel 12 (PHP 8.3+) |
| **Auth Scaffolding** | Laravel Breeze |
| **OAuth Provider** | Laravel Socialite (Google) |
| **Styling Engine** | Tailwind CSS v4 (`@import "tailwindcss"`) |
| **Typography** | Plus Jakarta Sans |
| **Database** | MySQL / SQLite (development) |
| **Asset Bundler** | Vite |
| **Template Engine** | Blade |

### Palet Warna Brand

```css
--color-brand-red:       #E4252C   /* Aksen utama */
--color-brand-red-light: #EF3F3C   /* Hover state */
--color-brand-red-dark:  #8F1924   /* Active/pressed */
--color-brand-red-deep:  #6C0C1C   /* Deep accent */
--color-dark:            #010101   /* Base dark */
--color-gray-dark:       #737272   /* Teks sekunder */
--color-gray-medium:     #BCBCBC   /* Border/divider */
--color-gray-light:      #DCDBDB   /* Background subtle */
```

### Prinsip Desain
- **Minimalis Profesional** — Hierarki tipografi yang jelas, efisiensi ruang
- **Mobile-First** — Responsif penuh dengan breakpoint `sm:` → `md:` → `lg:`
- **Dark Mode Ready** — Integrasi kelas `.dark` via Tailwind CSS
- **Anti-Truncation** — Konten tidak dipotong demi layout; layout yang adaptif
- **Anti-Grayscale** — Integritas warna gambar dijaga di semua mode tampilan

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
    ├─► [Superadmin] → Dashboard global, CRUD semua unit & user
    │
    └─► [Admin Unit] → Dashboard terbatas pada unit_id yang ditetapkan
              │
              ├─► TK/SMP: Semua fitur kecuali Manajemen Jurusan
              └─► SMK:    Semua fitur termasuk Manajemen Jurusan
```

---

## 📁 Struktur Proyek

```
webmin/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controller per modul
│   │   ├── Middleware/      # Auth, role, tenant isolation
│   │   └── Requests/        # Form Request Validation
│   ├── Models/              # Eloquent Models (Unit, User, dll.)
│   ├── Policies/            # Authorization policies
│   └── Services/            # Business logic layer
├── database/
│   ├── migrations/          # Schema database bertahap
│   └── seeders/             # Data awal & testing
├── resources/
│   ├── views/               # Blade templates
│   │   ├── layouts/         # Layout utama (app, guest)
│   │   ├── components/      # Komponen Blade reusable
│   │   ├── superadmin/      # View Superadmin
│   │   └── admin/           # View Admin unit
│   └── css/                 # app.css (Tailwind config)
├── routes/
│   ├── web.php              # Route publik & auth
│   └── admin.php            # Route dashboard (protected)
├── webmin-requirement.md    # Functional Requirements Spec (FRS)
└── design-v2.md             # Software Design Documentation (SDD)
```

---

## 🚀 Instalasi & Setup

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

# 4. Konfigurasi database di .env, lalu jalankan migrasi
php artisan migrate --seed

# 5. Jalankan server development
composer run dev
```

### Konfigurasi Google OAuth

Tambahkan pada berkas `.env`:
```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## 🧪 Testing

```bash
# Jalankan seluruh test suite
composer run test

# Atau dengan PHPUnit langsung
php artisan test
```

---

## 📜 Dokumentasi Teknis

| Berkas | Keterangan |
|---|---|
| [`webmin-requirement.md`](./webmin-requirement.md) | Functional Requirements Specification (FRS) lengkap |
| [`design-v2.md`](./design-v2.md) | Software Design Documentation (SDD) & Design System |
| [`task.md`](./task.md) | Rencana & progres tugas pengembangan per fase |

---

## 👥 Peran & Hak Akses

| Peran | Hak Akses |
|---|---|
| **Superadmin** | CRUD semua unit, CRUD semua user, override konten seluruh unit |
| **Admin (TK/SMP)** | CRUD konten unit sendiri (Profil, Kesiswaan, Publikasi) |
| **Admin SMK** | Semua hak Admin + CRUD Manajemen Jurusan |

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan internal. Seluruh hak cipta dilindungi.
