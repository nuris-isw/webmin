# Software Design Documentation (SDD)
## Project Architecture & Design System Spec

---

### 1. Executive Summary & Design Philosophy
Dokumen ini merancang arsitektur teknis dan panduan visual sistem dengan prinsip **Minimalis Profesional**. Desain mengutamakan efisiensi ruang, kejelasan hierarki tipografi, responsivitas penuh, serta kesiapan mode gelap (*dark mode*) tanpa mengorbankan fungsionalitas elemen.

**Prinsip Desain Utama:**
* **Keutuhan Konten:** Kata dan kalimat dalam artikel/konten tidak boleh dikurangi atau dipotong demi kebutuhan tata letak (*layout*). Desain harus adaptif dan fleksibel terhadap panjang teks asli, baik di layar desktop maupun mobile.
* **Fidelitas Gambar & Aset:** Tidak menggunakan filter *grayscale* pada logo mitra, gambar berita, atau foto dokumentasi untuk menjaga integritas visual dan standar profesional di semua mode tampilan (light/dark).
* **Aksesibilitas Tinggi:** Kontras warna yang kuat dan navigasi intuitif yang mudah digunakan oleh pengguna non-teknis (*non-IT admin*) di berbagai perangkat.

---

### 2. Tech Stack & Integration Architecture

Aplikasi ini dibangun di atas ekosistem modern dengan pembagian peran komponen sebagai berikut:

* **Core Framework:** Laravel 12 (standar kestabilan dan fitur terbaru).
* **Dashboard & Auth Scaffolding:** Laravel Breeze (fondasi autentikasi ringan dan minimalis yang mendukung dark mode bawaan).
* **Social Auth Integration:** Laravel Socialite (integrasi OAuth untuk login eksternal menggunakan Google).
* **Styling Engine:** Tailwind CSS v4 via `@import "tailwindcss";` dengan kustomisasi tema global dan sistem utilitas varian responsif (`sm:`, `md:`, `lg:`) serta varian dark mode (`dark:`).

#### Alur Autentikasi & Akses (Hybrid Access Model)
1.  **Public Access:** Landing page dan informasi publik dapat diakses tanpa autentikasi.
2.  **Socialite Authentication:** Pengguna melakukan login menggunakan penyedia eksternal (Google OAuth).
3.  **Breeze Session Management:** Setelah sukses, Laravel Breeze mengambil alih manajemen *session*, menjaga keamanan *state*, dan mengarahkan pengguna ke Dashboard internal sesuai *role*.

---

### 3. Design System & Theme Configuration (`app.css`)

Konfigurasi di bawah ini diintegrasikan langsung pada berkas `app.css` menggunakan sintaks `@theme` Tailwind CSS terbaru. Palet warna didominasi oleh warna gelap yang solid, abu-abu terkalibrasi, dan aksen merah korporat yang tegas.

```css
@import "tailwindcss";

@theme {
  /* Typography */
  --font-sans: "Plus Jakarta Sans", ui-sans-serif, system-ui;

  /* Brand Colors */
  --color-brand-red: #E4252C;
  --color-brand-red-light: #EF3F3C;
  --color-brand-red-dark: #8F1924;
  --color-brand-red-deep: #6C0C1C;

  /* Neutral & Base Colors */
  --color-dark: #010101;
  --color-gray-dark: #737272;
  --color-gray-medium: #BCBCBC;
  --color-gray-light: #DCDBDB;

  /* Social Integration Colors */
  --color-facebook: #1877F2;
  --color-instagram: #E4405F;
  --color-youtube: #FF0000;
  --color-tiktok: #000000;
}
```

---

### 4. Responsive & Dark Mode Specifications

Aplikasi menerapkan pendekatan **Mobile-First** untuk memastikan kenyamanan akses pada perangkat genggam, serta **Sistem Integrasi Dark Mode** otomatis/manual (berbasis kelas `.dark` atau media query `prefers-color-scheme`).

| Elemen UI / Konteks | Light Mode Spec | Dark Mode Spec (`dark:`) | Responsive Spec (Mobile to Desktop) |
| :--- | :--- | :--- | :--- |
| **Dasar Halaman (`body`)** | Background: `#FFFFFF`<br>Teks: `--color-dark` | Background: `--color-dark`<br>Teks: `#FFFFFF` | Mengalir natural, padding sisi luar berkisar `16px` (mobile) hingga `32px` (desktop). |
| **Sidebar / Navigasi** | Background: `#F8F9FA`<br>Teks: `--color-gray-dark` | Background: `#121212`<br>Teks: `--color-gray-light` | **Mobile:** Menjadi *off-canvas hamburger menu* atau *bottom bar*.<br>**Desktop:** Menetap di sisi kiri (`w-64`). |
| **Kartu Konten / Panel**| Background: `#FFFFFF`<br>Border: `--color-gray-light` | Background: `#1E1E1E`<br>Border: `--color-gray-dark` | Lebar penuh (`w-full`) pada mobile, bertransformasi menjadi grid multi-kolom pada layar lebar. |
| **Tabel Data** | Row Genap: `#FFFFFF`<br>Row Ganjil: `#F9FAFB` | Row Genap: `#1A1A1A`<br>Row Ganjil: `#242424` | Berubah menjadi format *stack card view* pada mobile untuk menghindari *horizontal scroll* paksa. |

---

### 5. Layout & UI Component Specifications

#### 5.1. Login Page (Minimalist & Adaptive)
*   **Layout:** 
    *   **Mobile:** Satu kolom vertikal terpusat, berfokus penuh pada form login dan tombol OAuth.
    *   **Desktop (`md:`):** Pembagian layar yang bersih (form di satu sisi, visual representatif minimalis/ruang kosong teratur di sisi lain).
*   **OAuth Button:** Tombol masuk via Google menggunakan warna netral kontras tinggi (Light: latar putih/border abu-abu; Dark: latar `#2D2D2D`/tanpa border) dengan transisi halus memanfaatkan komponen `Socialite`.
*   **Spesifikasi Elemen:** Form input menggunakan border tipis yang berubah menjadi `--color-brand-red` saat status `focus` baik pada mode terang maupun gelap.

#### 5.2. Central Dashboard (Laravel Breeze Customization)
*   **Navigation & Layout Structure:**
    *   Menggunakan komponen bawaan Breeze yang disesuaikan. Tombol pemicu mode gelap diletakkan pada header atas berdampingan dengan profil pengguna.
    *   Menu aktif ditandai dengan aksen border kiri setebal `4px` menggunakan `--color-brand-red` pada desktop, atau border bawah pada mobile navigasi.
*   **Typography Scale:**
    *   `h1` (Judul Utama): Bold, adaptif terhadap ukuran layar (`text-xl` di mobile, `text-2xl` di desktop).
    *   `h2` (Judul Sekunder): Memiliki aksen garis vertikal di sebelah kiri (`border-left: 4px solid var(--color-brand-red); padding-left: 8px;`). Garis vertikal ini tetap dipertahankan di mobile untuk memperkuat hierarki pembacaan.
    *   `body` (Teks Konten): Teks mengalir secara natural tanpa pemotongan kalimat. Wadah teks menggunakan utilitas responsif agar lebar baris tetap nyaman dibaca (maksimal `prose` atau `max-w-3xl`).

#### 5.3. Data & Management Table (Admin Non-IT Mobile Friendly)
*   **Desktop View:** Tabel data dengan pemisah baris (*border-bottom*) tipis. Memanfaatkan *zebra striping* terkalibrasi sesuai mode gelap/terang.
*   **Mobile View (`max-w-md`):** Menggunakan teknik CSS untuk menyembunyikan tabel tradisional (`hidden md:table`) dan menampilkan data dalam bentuk susunan kartu vertikal (*card list*). Setiap baris data dirender sebagai satu kartu mandiri dengan label field yang jelas.
*   **Action Elements:** Tombol aksi pada mobile diperbesar untuk memenuhi target sentuhan minimum (`44x44px`), menggunakan teks pendek yang intuitif tanpa ikon tunggal yang membingungkan.

---

### 6. Implementation Notes & Best Practices

1.  **Anti-Grayscale Utility:** Pastikan dalam aset Blade maupun komponen frontend, tidak ada kelas utility seperti `grayscale` atau `dark:grayscale` yang diterapkan pada gambar dokumentasi atau logo entitas.
2.  **Flexible Layouts over Text Reduction:** Gunakan kombinasi kelas `w-full h-auto flex flex-col md:flex-row` untuk memastikan kontainer membungkus teks secara dinamis ketika ukuran layar menyusut. Jangan pernah menggunakan utilitas pemotong string di sisi backend (`Str::limit`) atau frontend (`truncate`) pada konten utama.
3.  **Breeze Dark Mode Integration:** Pastikan konfigurasi `tailwind.config.js` atau struktur integrasi Vite Anda dikonfigurasi untuk membaca skema warna dengan tepat (`darkMode: 'class'`), sehingga perubahan status kelas pada elemen `<html>` langsung memperbarui seluruh visual dashboard.
