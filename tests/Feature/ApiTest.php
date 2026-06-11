<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\Major;
use App\Models\News;
use App\Models\SchoolProfile;
use App\Models\SpmbSetting;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected Unit $unitSmk;
    protected Unit $unitSmp;

    protected function setUp(): void
    {
        parent::setUp();

        // Create testing units using factory (since UnitFactory exists)
        $this->unitSmk = Unit::factory()->create([
            'nama_sekolah' => 'SMK Mandiri',
            'slug' => 'smk-mandiri',
            'jenjang' => 'smk',
            'is_active' => true,
        ]);

        $this->unitSmp = Unit::factory()->create([
            'nama_sekolah' => 'SMP Mandiri',
            'slug' => 'smp-mandiri',
            'jenjang' => 'smp',
            'is_active' => true,
        ]);

        // Create profiles using Eloquent create
        SchoolProfile::create([
            'unit_id' => $this->unitSmk->id,
            'logo_sekolah' => 'logo-smk.png',
            'email' => 'smk@mandiri.sch.id',
            'telepon' => '021-111111',
            'alamat' => 'Jl. SMK Mandiri',
            'google_map_embed_url' => 'https://maps.google.com/smk',
            'media_sosial' => ['facebook' => 'https://facebook.com/smk'],
            'nama_kepala_sekolah' => 'Kepsek SMK',
            'foto_kepala_sekolah' => 'kepsek-smk.png',
            'sambutan_kepala_sekolah' => 'Sambutan SMK',
            'sejarah_singkat_sekolah' => 'Sejarah SMK',
            'visi' => 'Visi SMK',
            'misi' => 'Misi SMK',
            'deskripsi_kurikulum' => 'Kurikulum SMK',
            'pdf_kalender_akademik' => 'kalender-smk.pdf',
        ]);

        SchoolProfile::create([
            'unit_id' => $this->unitSmp->id,
            'logo_sekolah' => 'logo-smp.png',
            'email' => 'smp@mandiri.sch.id',
            'telepon' => '021-222222',
            'alamat' => 'Jl. SMP Mandiri',
            'google_map_embed_url' => 'https://maps.google.com/smp',
            'media_sosial' => ['facebook' => 'https://facebook.com/smp'],
            'nama_kepala_sekolah' => 'Kepsek SMP',
            'foto_kepala_sekolah' => 'kepsek-smp.png',
            'sambutan_kepala_sekolah' => 'Sambutan SMP',
            'sejarah_singkat_sekolah' => 'Sejarah SMP',
            'visi' => 'Visi SMP',
            'misi' => 'Misi SMP',
            'deskripsi_kurikulum' => 'Kurikulum SMP',
            'pdf_kalender_akademik' => 'kalender-smp.pdf',
        ]);
    }

    /**
     * Test GET /api/v1/units returns active units.
     */
    public function test_api_can_list_active_units(): void
    {
        Unit::factory()->create([
            'nama_sekolah' => 'Inactive School',
            'slug' => 'inactive-school',
            'is_active' => false,
        ]);

        $response = $this->getJson('/api/v1/units');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'nama_sekolah',
                        'slug',
                        'jenjang',
                        'is_active',
                        'logo_sekolah',
                    ]
                ]
            ])
            ->assertJsonMissing(['nama_sekolah' => 'Inactive School'])
            ->assertJsonFragment(['nama_sekolah' => 'SMK Mandiri'])
            ->assertJsonFragment(['nama_sekolah' => 'SMP Mandiri']);
    }

    /**
     * Test GET /api/v1/units/{slug} returns unit details.
     */
    public function test_api_can_get_unit_details(): void
    {
        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'nama_sekolah',
                    'slug',
                    'jenjang',
                    'is_active',
                    'profile' => [
                        'email',
                        'telepon',
                        'alamat',
                    ]
                ]
            ])
            ->assertJsonFragment(['email' => 'smk@mandiri.sch.id']);
    }

    /**
     * Test GET /api/v1/units/{slug}/news returns paginated news.
     */
    public function test_api_can_get_paginated_news(): void
    {
        // Create 12 published news articles for SMK Mandiri
        for ($i = 1; $i <= 12; $i++) {
            News::create([
                'unit_id' => $this->unitSmk->id,
                'judul_berita' => "News Article $i",
                'slug' => "news-article-$i",
                'konten_berita' => "Content $i",
                'gambar_utama' => "news-$i.png",
                'published_at' => now()->subDays($i),
            ]);
        }

        // Create 1 draft news article
        News::create([
            'unit_id' => $this->unitSmk->id,
            'judul_berita' => 'Draft Article',
            'slug' => 'draft-article',
            'konten_berita' => 'Content Draft',
            'gambar_utama' => 'draft.png',
            'published_at' => null,
        ]);

        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/news?per_page=10");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'meta' => [
                    'current_page',
                    'per_page',
                    'total',
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ]
            ])
            ->assertJsonCount(10, 'data')
            ->assertJsonFragment(['total' => 12])
            ->assertJsonMissing(['judul_berita' => 'Draft Article']);
    }

    /**
     * Test GET /api/v1/units/{slug}/news/{newsSlug} returns news detail.
     */
    public function test_api_can_get_news_detail(): void
    {
        $news = News::create([
            'unit_id' => $this->unitSmk->id,
            'judul_berita' => 'Unique News Title',
            'slug' => 'unique-news-title',
            'konten_berita' => 'Content',
            'gambar_utama' => 'news.png',
            'published_at' => now(),
        ]);

        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/news/{$news->slug}");

        $response->assertStatus(200)
            ->assertJsonPath('data.judul_berita', 'Unique News Title');
    }

    /**
     * Test GET /api/v1/units/{slug}/achievements with peraih filtering.
     */
    public function test_api_can_get_achievements_with_filters(): void
    {
        Achievement::create([
            'unit_id' => $this->unitSmk->id,
            'judul_prestasi' => 'Siswa Winner',
            'tahun_prestasi' => 2026,
            'peraih_prestasi' => 'siswa',
            'deskripsi_prestasi' => 'Deskripsi Siswa',
            'foto_penghargaan' => 'siswa-winner.png',
        ]);

        Achievement::create([
            'unit_id' => $this->unitSmk->id,
            'judul_prestasi' => 'Guru Winner',
            'tahun_prestasi' => 2025,
            'peraih_prestasi' => 'guru',
            'deskripsi_prestasi' => 'Deskripsi Guru',
            'foto_penghargaan' => 'guru-winner.png',
        ]);

        // Unfiltered
        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/achievements");
        $response->assertStatus(200)->assertJsonCount(2, 'data');

        // Filtered by siswa
        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/achievements?peraih=siswa");
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['judul_prestasi' => 'Siswa Winner'])
            ->assertJsonMissing(['judul_prestasi' => 'Guru Winner']);
    }

    /**
     * Test GET /api/v1/units/{slug}/extracurriculars.
     */
    public function test_api_can_get_extracurriculars(): void
    {
        Extracurricular::create([
            'unit_id' => $this->unitSmk->id,
            'nama_ekskul' => 'Pramuka Mandiri',
            'pembina_ekskul' => 'Kak Ahmad',
            'jadwal_kegiatan' => 'Sabtu',
            'logo_ekskul' => 'logo-ekskul.png',
        ]);

        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/extracurriculars");

        $response->assertStatus(200)
            ->assertJsonFragment(['nama_ekskul' => 'Pramuka Mandiri']);
    }

    /**
     * Test GET /api/v1/units/{slug}/galleries and detail.
     */
    public function test_api_can_get_galleries_and_detail(): void
    {
        $gallery = Gallery::create([
            'unit_id' => $this->unitSmk->id,
            'nama_kegiatan' => 'Upacara Kelulusan',
            'opsi_tampilan' => 'galeri_dokumentasi',
        ]);

        GalleryPhoto::create([
            'gallery_id' => $gallery->id,
            'file_foto' => 'image1.png',
            'urutan' => 2,
        ]);

        GalleryPhoto::create([
            'gallery_id' => $gallery->id,
            'file_foto' => 'image2.png',
            'urutan' => 1,
        ]);

        // Index
        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/galleries?opsi_tampilan=galeri_dokumentasi");
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['nama_kegiatan' => 'Upacara Kelulusan']);

        // Detail with sorted photos
        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/galleries/{$gallery->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'nama_kegiatan',
                    'photos' => [
                        '*' => ['id', 'file_foto', 'urutan']
                    ]
                ]
            ]);

        // Check if photos are sorted by 'urutan' ascending (urutan 1 comes first)
        $photos = $response->json('data.photos');
        $this->assertEquals(1, $photos[0]['urutan']);
        $this->assertEquals(2, $photos[1]['urutan']);
    }

    /**
     * Test GET /api/v1/units/{slug}/spmb.
     */
    public function test_api_can_get_spmb_settings(): void
    {
        SpmbSetting::create([
            'unit_id' => $this->unitSmk->id,
            'status_spmb' => true,
            'informasi_prosedur' => 'Prosedur PPDB SMK',
            'url_eksternal_pendaftaran' => 'https://ppdb.example.com',
        ]);

        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/spmb");

        $response->assertStatus(200)
            ->assertJsonFragment(['status_spmb' => true])
            ->assertJsonFragment(['informasi_prosedur' => 'Prosedur PPDB SMK']);
    }

    /**
     * Test GET /api/v1/units/{slug}/majors restricts non-SMK units.
     */
    public function test_api_majors_endpoints_restrict_non_smk(): void
    {
        // SMK major lookup works
        $major = Major::create([
            'unit_id' => $this->unitSmk->id,
            'nama_jurusan' => 'Rekayasa Perangkat Lunak',
            'nomenklatur_istilah' => 'RPL',
            'shortname' => 'RPL',
            'nama_kaprog' => 'Kaprog RPL',
            'foto_kaprog' => 'kaprog-rpl.png',
            'deskripsi_jurusan' => 'RPL Deskripsi',
        ]);

        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/majors");
        $response->assertStatus(200)
            ->assertJsonFragment(['nama_jurusan' => 'Rekayasa Perangkat Lunak']);

        $response = $this->getJson("/api/v1/units/{$this->unitSmk->slug}/majors/{$major->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['nama_jurusan' => 'Rekayasa Perangkat Lunak']);

        // SMP major lookup results in 404
        $response = $this->getJson("/api/v1/units/{$this->unitSmp->slug}/majors");
        $response->assertStatus(404);

        $response = $this->getJson("/api/v1/units/{$this->unitSmp->slug}/majors/{$major->id}");
        $response->assertStatus(404);
    }

    /**
     * Test Rate Limiting on API endpoints.
     */
    public function test_api_rate_limiting_prevents_spam(): void
    {
        // Hit the endpoint 60 times (limit)
        for ($i = 0; $i < 60; $i++) {
            $response = $this->getJson('/api/v1/units');
            $response->assertStatus(200);
        }

        // 61st hit should return 429 Too Many Requests
        $response = $this->getJson('/api/v1/units');
        $response->assertStatus(429);
    }
}
