<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\Major;
use App\Models\News;
use App\Models\SchoolProfile;
use App\Models\SpmbSetting;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ---------------------------------------------------------------
        // 1. Superadmin
        // ---------------------------------------------------------------
        User::factory()->superadmin()->create([
            'name'  => 'Super Admin',
            'email' => 'superadmin@webmin.test',
        ]);

        // ---------------------------------------------------------------
        // 2. Unit TK — dengan 1 admin
        // ---------------------------------------------------------------
        $unitTk = Unit::factory()->tk()->create([
            'nama_sekolah' => 'TK Tunas Bangsa',
            'slug'         => 'tk-tunas-bangsa',
        ]);
        User::factory()->adminOf($unitTk->id)->create([
            'name'  => 'Admin TK',
            'email' => 'admin.tk@webmin.test',
        ]);
        $this->seedSchoolProfile($unitTk);
        $this->seedKesiswaan($unitTk);
        $this->seedPublikasi($unitTk);

        // ---------------------------------------------------------------
        // 3. Unit SMP — dengan 1 admin
        // ---------------------------------------------------------------
        $unitSmp = Unit::factory()->smp()->create([
            'nama_sekolah' => 'SMP Harapan Nusantara',
            'slug'         => 'smp-harapan-nusantara',
        ]);
        User::factory()->adminOf($unitSmp->id)->create([
            'name'  => 'Admin SMP',
            'email' => 'admin.smp@webmin.test',
        ]);
        $this->seedSchoolProfile($unitSmp);
        $this->seedKesiswaan($unitSmp);
        $this->seedPublikasi($unitSmp);

        // ---------------------------------------------------------------
        // 4. Unit SMK — dengan 1 admin + data jurusan
        // ---------------------------------------------------------------
        $unitSmk = Unit::factory()->smk()->create([
            'nama_sekolah' => 'SMK Teknologi Mandiri',
            'slug'         => 'smk-teknologi-mandiri',
        ]);
        User::factory()->adminOf($unitSmk->id)->create([
            'name'  => 'Admin SMK',
            'email' => 'admin.smk@webmin.test',
        ]);
        $this->seedSchoolProfile($unitSmk);
        $this->seedKesiswaan($unitSmk);
        $majors = $this->seedMajors($unitSmk);
        $this->seedPublikasi($unitSmk, $majors);
    }

    // ---------------------------------------------------------------
    // Helper: Profil Sekolah
    // ---------------------------------------------------------------

    private function seedSchoolProfile(Unit $unit): void
    {
        SchoolProfile::create([
            'unit_id'                 => $unit->id,
            'email'                   => "info@{$unit->slug}.sch.id",
            'telepon'                 => fake()->phoneNumber(),
            'alamat'                  => fake()->address(),
            'media_sosial'            => [
                'instagram' => "https://instagram.com/{$unit->slug}",
                'facebook'  => "https://facebook.com/{$unit->slug}",
                'youtube'   => null,
                'tiktok'    => null,
            ],
            'nama_kepala_sekolah'     => fake()->name('male'),
            'sambutan_kepala_sekolah' => fake()->paragraphs(3, true),
            'sejarah_singkat_sekolah' => fake()->paragraphs(4, true),
            'visi'                    => fake()->sentence(),
            'misi'                    => fake()->paragraphs(2, true),
            'deskripsi_kurikulum'     => fake()->paragraphs(2, true),
        ]);

        SpmbSetting::create([
            'unit_id'                  => $unit->id,
            'status_spmb'              => fake()->boolean(30),
            'informasi_prosedur'       => fake()->paragraphs(2, true),
            'url_eksternal_pendaftaran' => "https://ppdb.{$unit->slug}.sch.id",
        ]);
    }

    // ---------------------------------------------------------------
    // Helper: Kesiswaan (Prestasi & Ekskul)
    // ---------------------------------------------------------------

    private function seedKesiswaan(Unit $unit): void
    {
        // Prestasi
        $peraih = ['siswa', 'guru', 'tendik', 'sekolah'];
        for ($i = 0; $i < 5; $i++) {
            Achievement::create([
                'unit_id'          => $unit->id,
                'judul_prestasi'   => 'Juara ' . fake()->randomElement(['I', 'II', 'III']) . ' ' . fake()->words(3, true),
                'tahun_prestasi'   => fake()->year(),
                'peraih_prestasi'  => fake()->randomElement($peraih),
                'deskripsi_prestasi' => fake()->sentence(),
            ]);
        }

        // Ekstrakurikuler
        $ekskuls = ['Pramuka', 'PMR', 'Basket', 'Futsal', 'Seni Tari', 'English Club'];
        foreach (array_slice($ekskuls, 0, 4) as $nama) {
            Extracurricular::create([
                'unit_id'        => $unit->id,
                'nama_ekskul'    => $nama,
                'pembina_ekskul' => fake()->name(),
                'jadwal_kegiatan' => fake()->randomElement(['Setiap Senin 14.00-16.00', 'Setiap Rabu 13.00-15.00', 'Setiap Jumat 14.00-16.00']),
            ]);
        }
    }

    // ---------------------------------------------------------------
    // Helper: Publikasi (Berita, Galeri, SPMB)
    // ---------------------------------------------------------------

    private function seedPublikasi(Unit $unit, array $majors = []): void
    {
        // Berita
        for ($i = 0; $i < 5; $i++) {
            News::create([
                'unit_id'      => $unit->id,
                'judul_berita' => fake()->sentence(6),
                'slug'         => News::generateUniqueSlug(fake()->sentence(6), $unit->id),
                'konten_berita' => fake()->paragraphs(5, true),
                'published_at'  => fake()->boolean(70) ? fake()->dateTimeBetween('-6 months', 'now') : null,
            ]);
        }

        // Galeri — hero_section
        $gallery = Gallery::create([
            'unit_id'       => $unit->id,
            'nama_kegiatan' => 'Foto Kegiatan Utama',
            'opsi_tampilan' => 'hero_section',
        ]);
        GalleryPhoto::create(['gallery_id' => $gallery->id, 'file_foto' => 'placeholder/hero-1.jpg', 'urutan' => 1]);

        // Galeri — galeri_dokumentasi
        $gallery2 = Gallery::create([
            'unit_id'       => $unit->id,
            'nama_kegiatan' => 'Dokumentasi Kegiatan Belajar',
            'opsi_tampilan' => 'galeri_dokumentasi',
        ]);
        GalleryPhoto::create(['gallery_id' => $gallery2->id, 'file_foto' => 'placeholder/dok-1.jpg', 'urutan' => 1]);
        GalleryPhoto::create(['gallery_id' => $gallery2->id, 'file_foto' => 'placeholder/dok-2.jpg', 'urutan' => 2]);

        // Galeri — galeri_program (hanya untuk SMK dengan jurusan)
        if (! empty($majors)) {
            foreach ($majors as $major) {
                $gallery3 = Gallery::create([
                    'unit_id'       => $unit->id,
                    'nama_kegiatan' => "Kegiatan Jurusan {$major->shortname}",
                    'opsi_tampilan' => 'galeri_program',
                    'major_id'      => $major->id,
                ]);
                GalleryPhoto::create(['gallery_id' => $gallery3->id, 'file_foto' => 'placeholder/prog-1.jpg', 'urutan' => 1]);
            }
        }
    }

    // ---------------------------------------------------------------
    // Helper: Jurusan SMK
    // ---------------------------------------------------------------

    private function seedMajors(Unit $unit): array
    {
        $data = [
            ['Teknik Komputer dan Jaringan', 'TKJ', 'Program Keahlian'],
            ['Rekayasa Perangkat Lunak',      'RPL', 'Konsentrasi Keahlian'],
            ['Akuntansi dan Keuangan Lembaga', 'AKL', 'Program Keahlian'],
        ];

        $majors = [];
        foreach ($data as [$nama, $shortname, $nomenklatur]) {
            $majors[] = Major::create([
                'unit_id'             => $unit->id,
                'nama_jurusan'        => $nama,
                'nomenklatur_istilah' => $nomenklatur,
                'shortname'           => $shortname,
                'nama_kaprog'         => fake()->name(),
                'deskripsi_jurusan'   => fake()->paragraphs(3, true),
            ]);
        }

        return $majors;
    }
}
