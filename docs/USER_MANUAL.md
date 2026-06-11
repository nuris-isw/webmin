# WebMin School CMS — User Manual

Welcome to the **WebMin CMS** user manual. This application is a multi-tenant CMS designed to manage school profiles, news, achievements, extracurriculars, student registrations (SPMB), and major programs (for SMK).

---

## 🔑 Roles & Autentikasi

There are two primary user roles in the platform:

1. **Superadmin**:
   - Accesses the global dashboard.
   - Creates and manages unit schools.
   - Registers and assigns admin accounts to specific units.
   - Can override and manage content for any unit.
2. **Admin Unit**:
   - Accesses the dashboard dedicated to their assigned unit.
   - Manages school profile information (Visi, Misi, Sejarah, Kontak, Kepala Sekolah).
   - Publishes news, achievements, extracurricular activities, galleries, and SPMB settings.
   - Manages majors/curriculum (only for SMK units).

---

## 📂 Modules & Features

### 1. Dashboard Overview
* Provides quick statistics on the system (total news, achievements, active schools, and admin users).
* Shows list entries with responsive desktop table/mobile stack card transformations.

### 2. School Profile
* Divided into three tabs:
  * **Tab A (Kontak & Lokasi)**: Manage school logo, email, phone, address, map location, and social links.
  * **Tab B (Profil & Sejarah)**: Manage principal's name, photo, welcome note, and school history.
  * **Tab C (Akademik)**: Manage Visi, Misi, curriculum details, and download link for the academic calendar (PDF).

### 3. News & Articles (Berita)
* Form allows entering titles, content, uploading a main header image (max 2MB), and saving as `Draft` or `Publish` (setting publication date).
* Supports pagination and responsive list search.

### 4. Achievements (Prestasi)
* Track awards for `siswa`, `guru`, `tendik`, or `sekolah`.
* Requires award year, recipient category, brief description, and photo.

### 5. Extracurriculars (Ekskul)
* Manage school interest clubs and extracurricular activities.
* Require ekskul name, pembina (advisor), schedule, and club logo.

### 6. Gallery (Galeri Kegiatan)
* Creates photo albums.
* Select placement routing:
  * `hero_section` (homepage slides)
  * `gambar_pembuka` (welcoming header)
  * `galeri_dokumentasi` (albums list)
  * `galeri_program` (major study program portfolio - SMK exclusive)
* Upload multiple photos simultaneously with a visual progress bar. Rearrange image order via drag-and-drop.

### 7. SPMB Settings
* Toggle admission status on/off.
* Enter registration guides and define external registration form links (e.g. PPDB portal).

### 8. Majors (SMK Exclusive)
* Manage SMK study programs.
* Define competency naming, short names, principal of study (Kaprog) profile, and description.

---

## 🛠️ Security Actions
* **Destructive operations** (e.g. deleting news, users, or units) will prompt a confirmation alert. Always confirm before deleting to prevent accidental loss of data.
