# Task 2 — WebMin Dashboard Audit, UI/UX Optimization & Rich-Text Completion

## Objective
1. Pastikan semua fungsi dashboard superadmin berfungsi dengan benar.
2. Optimalisasi UI/UX — utamanya padding, margin, dan konsistensi komponen.
3. Lengkapi fitur form rich-text (Quill editor) agar nilai terpopulasi dengan benar saat edit.

---

## Fase A — Audit & Perbaikan Fungsionalitas Dashboard Superadmin

### A1 — Layout: Hapus double-padding pada semua halaman view ✅ SELESAI
- `[x]` Hapus `py-12` outer wrapper dari 28 file view (batch script + manual cleanup)
- `[x]` Hapus dangling `</div>` closing wrapper dari 24 file view
- `[x]` Hapus nested `space-y-*` wrapper yang redundan di superadmin/dashboard dan admin/dashboard

### A2 — Layout: Hapus slot `header` yang tidak dirender ✅ SELESAI
- `[x]` Hapus blok `<x-slot name="header">...</x-slot>` dari 28 file view (semua view Blade yang menggunakannya)

### A3 — Breadcrumb: Perbaiki breadcrumb di `units/show.blade.php` ✅ SELESAI
- `[x]` Tambahkan `'Dashboard' => route('superadmin.dashboard')` sebagai item pertama di breadcrumb `units/show.blade.php`

### A4 — Superadmin Dashboard: Tambahkan breadcrumb / page-heading yang konsisten ✅ SELESAI
- `[x]` `superadmin/dashboard.blade.php` — sudah menggunakan `x-page-heading` ✓
- `[x]` `superadmin/units/index.blade.php` — ditambahkan `x-page-heading`
- `[x]` `superadmin/users/index.blade.php` — ditambahkan `x-page-heading`
- `[x]` `superadmin/units/create.blade.php` — ditambahkan Dashboard ke breadcrumb
- `[x]` `superadmin/units/edit.blade.php` — ditambahkan Dashboard ke breadcrumb
- `[x]` `superadmin/users/create.blade.php` — ditambahkan Dashboard ke breadcrumb
- `[x]` `superadmin/users/edit.blade.php` — ditambahkan Dashboard ke breadcrumb

### A5 — Flash Alert & Error Display ✅ SUDAH ADA
- `[x]` `superadmin/users/index.blade.php` — sudah memiliki `session('success')` dan `session('error')` alert

### A6 — Verifikasi alur CRUD Unit Sekolah
- `[ ]` Unit Create → Store → Redirect ke index (dengan success flash) — *perlu tes manual*
- `[ ]` Unit Edit → Update → Redirect ke index (dengan success flash) — *perlu tes manual*
- `[ ]` Unit Destroy → Redirect ke index — *perlu tes manual*
- `[ ]` Unit Show → Content override links menuju ke URL unit yang benar — *perlu tes manual*

### A7 — Verifikasi alur CRUD Admin User (Superadmin)
- `[ ]` Admin User Create → Store → Redirect ke index — *perlu tes manual*
- `[ ]` Admin User Edit → Update → Redirect ke index — *perlu tes manual*
- `[ ]` Admin User Destroy → perlu konfirmasi tidak bisa hapus diri sendiri — *perlu tes manual*
- `[ ]` Filter role/unit pada halaman index — *perlu tes manual*

---

## Fase B — Optimalisasi UI/UX

### B1 — Konsistensi Spacing pada Komponen Card ✅ SUDAH BAIK
- `[x]` `card.blade.php` — padding body `p-6` sudah konsisten
- `[x]` Semua form di dalam card menggunakan `class="space-y-6"` secara konsisten

### B2 — Konsistensi Heading Halaman ✅ SELESAI
- `[x]` Semua halaman index superadmin sudah memiliki `x-page-heading`
- `[x]` Semua halaman create/edit sudah memiliki `x-breadcrumb` dengan Dashboard di root

### B3 — Konsistensi tombol Aksi ✅ SUDAH BAIK
- `[x]` Tombol primer menggunakan `x-button` (brand-red style)
- `[x]` Tombol sekunder/batal menggunakan style `border + gray`
- `[x]` Tombol hapus di tabel menggunakan warna `rose-600` dengan konfirmasi `onsubmit`

### B4 — Tambahkan Page Title yang dinamis
- `[ ]` `app.blade.php` — update agar mendukung `$title` slot dinamis per halaman

### B5 — Perbaiki tampilan mobile/responsive ✅ SUDAH ADA
- `[x]` Mobile slot pada `x-data-table` sudah ada di semua halaman index yang relevan

---

## Fase C — Perbaikan Rich-Text Editor (Quill) ✅ SELESAI

### C1 — Bug Kritis: Editor tidak memuat konten saat edit ✅ SELESAI
- `[x]` Diganti dengan `quill.clipboard.dangerouslyPasteHTML(initialContent)` setelah inisialisasi
- `[x]` Konten awal diambil dari `data-initial-value` attribute yang di-encode dengan `htmlspecialchars`

### C2 — Bug: Escaping HTML di Alpine.js x-data ✅ SELESAI
- `[x]` Alpine.js `x-data` binding dihapus sepenuhnya
- `[x]` Diganti dengan `<input type="hidden">` yang diisi oleh listener `quill.on('text-change')`

### C3 — Toolbar Quill ✅ SELESAI
- `[x]` Ditambahkan: `blockquote`, `code-block`, `link`, `indent/outdent`, `header` (4 level)

### C4 — Dark mode Quill ✅ SELESAI
- `[x]` Dark mode styling diperbaiki: toolbar icon stroke/fill, picker dropdown, placeholder

### C5 — Validasi rich-text ✅ SUDAH TERTANGANI
- `[x]` Hidden input bernilai `""` jika editor kosong — backend validation `required` tetap berfungsi

### C6 — Integrasi form rich-text ✅ SELESAI (perlu tes manual)
- `[x]` `admin/news/create.blade.php` — menggunakan `x-form-rich-text`
- `[x]` `admin/news/edit.blade.php` — menggunakan `x-form-rich-text` dengan pre-populate via `data-initial-value`
- `[x]` `admin/profile/edit.blade.php` — 5 field rich-text (sambutan, sejarah, visi, misi, kurikulum)
- `[ ]` Tes manual pre-populate dan save cycle — *perlu tes manual*

---

## Fase D — Polish & Verifikasi Akhir

### D1 — Tes automated ✅ PASSED
- `[x]` 73 tests, 380 assertions — semua passed setelah perubahan ini

### D2 — Tes manual alur superadmin end-to-end
- `[ ]` Login sebagai superadmin
- `[ ]` Buat unit baru → verifikasi SchoolProfile & SpmbSetting dibuat otomatis
- `[ ]` Edit unit → verifikasi perubahan tersimpan
- `[ ]` Lihat detail unit → verifikasi link override konten ke unit yang benar
- `[ ]` Buat admin user baru → assign ke unit → verifikasi login
- `[ ]` Edit admin user → ubah password → verifikasi login dengan password baru
- `[ ]` Hapus admin user (bukan diri sendiri) → verifikasi tidak bisa hapus diri sendiri

### D3 — Tes manual alur admin unit end-to-end (Rich Text)
- `[ ]` Login sebagai admin unit
- `[ ]` Buat berita baru → isi dengan rich text → simpan → verifikasi tersimpan
- `[ ]` Edit berita yang ada → verifikasi konten terpopulasi di editor → edit → simpan
- `[ ]` Edit profil sekolah Tab B → isi sambutan & sejarah → simpan → edit lagi → verifikasi pre-populate

---

## Catatan Teknis

- Stack: Laravel 11, Blade, Alpine.js v3, Tailwind CSS v4, Quill v2.0.2
- `app.blade.php` main content: `p-4 sm:p-6 lg:p-8` (tidak perlu tambah padding di halaman)
- Quill v2: gunakan `quill.clipboard.dangerouslyPasteHTML()` untuk set konten programatik
- Untuk HTML yang aman di atribut: gunakan `htmlspecialchars()` bukan `{{ }}`
- All 73 automated tests: ✅ PASSED (380 assertions, ~23s)
