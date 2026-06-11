# FUNCTIONAL REQUIREMENTS SPECIFICATION (FRS)
## Sistem CMS Multi-Tenant Sekolah Terpusat (Laravel 12 REST API)

### 1. Sistem Autentikasi & RBAC (Role-Based Access Control)
Sistem menggunakan autentikasi berbasis token (Laravel Sanctum) dengan dua tingkatan hak akses:

* **Superadmin (Badan Penyelenggara/Yayasan)**
    * Hak akses penuh bersifat global lintas unit (*cross-tenant access*).
    * Mampu melakukan CRUD pada data Unit Sekolah baru.
    * Mampu mendaftarkan (*register*) dan mengelola akun User (Admin Unit) serta melakukan *assign* User tersebut ke `unit_id` tertentu.
    * Memiliki kemampuan *override* untuk mengelola seluruh konten milik unit manapun.
* **Admin (Operasional Unit Sekolah)**
    * Hak akses terisolasi ketat berdasarkan `unit_id` yang di-*assign* oleh Superadmin.
    * Hanya dapat melakukan CRUD konten pada unit tempat ia ditugaskan.
    * Konten spesifik SMK hanya dapat diakses oleh Admin yang akunnya tertaut pada unit dengan jenjang `smk`.

---

### 2. Kebutuhan Dasbor Superadmin (Platform Level)
Menyediakan agregasi data global dan manajemen inisialisasi unit sekolah.

* **Metrik Ringkasan (Card Widgets):**
    * Total Sekolah (Jumlah seluruh entitas unit).
    * Total User Admin (Jumlah akun operasional terdaftar).
    * Total Konten Berita (Akumulasi artikel dari seluruh unit).
    * Total Prestasi (Akumulasi data prestasi dari seluruh unit).
* **Manajemen Unit:**
    * **Tabel Daftar Unit:** Menampilkan list sekolah yang aktif.
    * **Form Pendaftaran Unit (Inisialisasi):** Input data awal pembuatan sekolah dengan opsi wajib memilih jenjang (`enum`: TK, SMP, SMK).

---

### 3. Arsitektur Menu Dasbor Admin (Unit Level)
Struktur menu dinamis berbasis kondisi jenjang unit sekolah:

```text
Dashboard Admin/
├── 1. Menu Profil Sekolah (Identitas & Akademik)
│   ├── Tab A: Kontak & Lokasi
│   ├── Tab B: Profil & Sejarah
│   └── Tab C: Akademik
├── 2. Menu Kesiswaan (Prestasi & Ekstrakurikuler)
│   ├── Sub-Menu Data Prestasi (Filterable)
│   └── Sub-Menu Data Ekstrakurikuler
├── 3. Menu Publikasi (Konten Dinamis & Informasi PPDB)
│   ├── Sub-Menu Berita/Artikel
│   ├── Sub-Menu Galeri Kegiatan (Multi-opsi Display)
│   └── Sub-Menu Manajemen SPMB (Informasi Penerimaan)
└── 4. Menu Manajemen Jurusan (KHUSUS JENJANG SMK)
    └── Only accessible if Unit Type === 'smk'

### 4. Detail Komponen & Field Data Menu Profil Sekolah

#### Tab A: Kontak & Lokasi
* `logo_sekolah` (File Image)
* `email` (String / Email Format)
* `telepon` (String)
* `alamat` (Text)
* `google_map_embed_url` (Text / Valid URL Iframe)
* `media_sosial` (JSON Object): `instagram`, `facebook`, `youtube`, `tiktok` (String URL).

#### Tab B: Profil & Sejarah
* `nama_kepala_sekolah` (String)
* `foto_kepala_sekolah` (File Image)
* `sambutan_kepala_sekolah` (Rich Text / Markdown)
* `sejarah_singkat_sekolah` (Rich Text / Markdown)

#### Tab C: Akademik
* `visi` (Rich Text / Markdown)
* `misi` (Rich Text / Markdown)
* `deskripsi_kurikulum` (Rich Text / Markdown)
* `pdf_kalender_akademik` (File PDF)

---

### 5. Detail Komponen & Field Data Menu Kesiswaan

#### Sub-Menu Data Prestasi
* `judul_prestasi` (String)
* `tahun_prestasi` (Integer/String)
* `peraih_prestasi` (`enum`): `siswa`, `guru`, `tendik`, `sekolah`.
* `deskripsi_prestasi` (Text)
* `foto_penghargaan` (File Image)

#### Sub-Menu Data Ekstrakurikuler
* `logo_ekskul` (File Image)
* `nama_ekskul` (String)
* `pembina_ekskul` (String)
* `jadwal_kegiatan` (String / Text)

---

### 6. Detail Komponen & Field Data Menu Publikasi

#### Sub-Menu Berita
* `judul_berita` (String)
* `slug` (String, Auto-generated)
* `konten_berita` (Rich Text / Markdown)
* `gambar_utama` (File Image)

#### Sub-Menu Galeri Kegiatan
Sistem manajemen aset visual dengan logika penempatan render (*Display Placement Routing*) yang adaptif terhadap jenjang unit.
* `nama_kegiatan` (String)
* `file_foto` (File Image / Multi-upload)
* `opsi_tampilan` (`enum`):
    * `hero_section` (Slider/Banner utama halaman depan unit)
    * `gambar_pembuka` (Aset visual intro halaman/fitur tertentu)
    * `galeri_dokumentasi` (Masuk ke dalam album dokumentasi umum)
    * `galeri_program` (Logika perilaku khusus berdasarkan jenjang):
        * **Konteks TK/SMP:** Otomatis difilter oleh frontend untuk ditampilkan sebagai **Foto Kegiatan Unggulan** di halaman dashboard utama.
        * **Konteks SMK:** Ditampilkan khusus pada halaman detail jurusan/kompetensi keahlian tertentu.
* `major_id` (Foreign Key / Nullable):
    * **Aturan Validasi Tingkat API:** Wajib diisi (*Required*) jika unit bertipe `smk` DAN `opsi_tampilan` diatur ke `galeri_program`. Field ini akan mengambil relasi dari tabel `majors` milik unit tersebut, memastikan aset foto hanya muncul di jurusan yang terkait. Harus bernilai `null` jika unit bertipe `tk` atau `smp`.

#### Sub-Menu Manajemen SPMB
* `status_spmb` (`boolean`: Buka / Tutup)
* `informasi_prosedur` (Rich Text / Markdown)
* `url_eksternal_pendaftaran` (String URL)

---

### 7. Detail Komponen & Field Data Menu Manajemen Jurusan (Khusus SMK)
Menu ini dilindungi oleh middleware khusus di tingkat API untuk memastikan tidak ada manipulasi data dari unit non-SMK.

* **Karakteristik Data:** Komponen dinamis untuk mengakomodasi perubahan nomenklatur pendidikan vokasi yang sering berubah.
* **Form Input Field:**
    * `id` (Primary Key, digunakan sebagai referensi `major_id` pada Galeri Kegiatan)
    * `nama_jurusan` (String) - Contoh: *Teknik Komputer dan Jaringan*.
    * `nomenklatur_istilah` (String / Dropdown fleksibel) - Menyimpan label penamaan yang digunakan unit saat ini, contoh: *Program Keahlian*, *Konsentrasi Keahlian*, atau *Program Studi*.
    * `shortname` (String) - Contoh: *TKJ*, *RPL*, *AKL*.
    * `nama_kaprog` (String) - Nama Kepala Program Keahlian.
    * `foto_kaprog` (File Image) - Foto resmi Kepala Program Keahlian.
    * `deskripsi_jurusan` (Rich Text / Markdown) - Menampung detail kompetensi, materi esensial, dan prospek kerja jurusan.

