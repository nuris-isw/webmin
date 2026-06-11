<?php

namespace Tests\Feature\Admin;

use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\Major;
use App\Models\News;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test News CRUD operations including Draft vs Published state.
     */
    public function test_news_crud_operations(): void
    {
        Storage::fake('public');

        $unit = Unit::factory()->create();
        $admin = User::factory()->adminOf($unit->id)->create();

        // 1. Create News (Draft)
        $response = $this->actingAs($admin)->post(route('admin.news.store', $unit), [
            'judul_berita'  => 'Berita Pertama',
            'konten_berita' => '<p>Konten berita draft</p>',
            'status'        => 'draft',
            'gambar_utama'  => UploadedFile::fake()->image('cover.jpg'),
        ]);

        $response->assertRedirect(route('admin.news.index', $unit));
        $this->assertDatabaseHas('news', [
            'judul_berita' => 'Berita Pertama',
            'slug'         => 'berita-pertama',
            'published_at' => null,
        ]);

        $news = News::where('judul_berita', 'Berita Pertama')->first();
        $this->assertNotNull($news->gambar_utama);
        Storage::disk('public')->assertExists($news->gambar_utama);

        // 2. Update News (Publish)
        $response = $this->actingAs($admin)->put(route('admin.news.update', [$unit, $news]), [
            'judul_berita'  => 'Berita Pertama Updated',
            'konten_berita' => '<p>Konten berita published</p>',
            'status'        => 'publish',
        ]);

        $response->assertRedirect(route('admin.news.index', $unit));
        $this->assertDatabaseHas('news', [
            'id'           => $news->id,
            'judul_berita' => 'Berita Pertama Updated',
        ]);
        $this->assertNotNull($news->fresh()->published_at);

        // 3. Delete News
        $response = $this->actingAs($admin)->delete(route('admin.news.destroy', [$unit, $news]));
        $response->assertRedirect(route('admin.news.index', $unit));
        $this->assertDatabaseMissing('news', ['id' => $news->id]);
        Storage::disk('public')->assertMissing($news->gambar_utama);
    }

    /**
     * Test Achievements CRUD operations with filtering.
     */
    public function test_achievements_crud_and_filtering(): void
    {
        Storage::fake('public');

        $unit = Unit::factory()->create();
        $admin = User::factory()->adminOf($unit->id)->create();

        // Seed some achievements
        $achSiswa = $unit->achievements()->create([
            'judul_prestasi'  => 'Lomba Matematika',
            'tahun_prestasi'  => '2025',
            'peraih_prestasi' => 'siswa',
        ]);
        $achGuru = $unit->achievements()->create([
            'judul_prestasi'  => 'Guru Teladan',
            'tahun_prestasi'  => '2026',
            'peraih_prestasi' => 'guru',
        ]);

        // Test list and filter
        $response = $this->actingAs($admin)->get(route('admin.achievements.index', [$unit, 'peraih_prestasi' => 'siswa']));
        $response->assertStatus(200);
        $response->assertSee('Lomba Matematika');
        $response->assertDontSee('Guru Teladan');

        // Test create
        $response = $this->actingAs($admin)->post(route('admin.achievements.store', $unit), [
            'judul_prestasi'     => 'Prestasi Baru',
            'tahun_prestasi'     => '2026',
            'peraih_prestasi'    => 'tendik',
            'deskripsi_prestasi' => 'Deskripsi',
            'foto_penghargaan'   => UploadedFile::fake()->image('piala.png'),
        ]);

        $response->assertRedirect(route('admin.achievements.index', $unit));
        $this->assertDatabaseHas('achievements', [
            'judul_prestasi'  => 'Prestasi Baru',
            'peraih_prestasi' => 'tendik',
        ]);
    }

    /**
     * Test Extracurriculars CRUD.
     */
    public function test_extracurriculars_crud(): void
    {
        Storage::fake('public');

        $unit = Unit::factory()->create();
        $admin = User::factory()->adminOf($unit->id)->create();

        $response = $this->actingAs($admin)->post(route('admin.extracurriculars.store', $unit), [
            'nama_ekskul'     => 'Pramuka',
            'pembina_ekskul'  => 'Kak Budi',
            'jadwal_kegiatan' => 'Sabtu Sore',
            'logo_ekskul'     => UploadedFile::fake()->image('pramuka.png'),
        ]);

        $response->assertRedirect(route('admin.extracurriculars.index', $unit));
        $this->assertDatabaseHas('extracurriculars', [
            'nama_ekskul'    => 'Pramuka',
            'pembina_ekskul' => 'Kak Budi',
        ]);
    }

    /**
     * Test Galleries CRUD operations including SMK major restrictions.
     */
    public function test_galleries_crud_and_smk_restrictions(): void
    {
        Storage::fake('public');

        $unitSmp = Unit::factory()->create(['jenjang' => 'smp']);
        $adminSmp = User::factory()->adminOf($unitSmp->id)->create();

        $unitSmk = Unit::factory()->create(['jenjang' => 'smk']);
        $adminSmk = User::factory()->adminOf($unitSmk->id)->create();

        // 1. Create Major for SMK unit
        $major = Major::create([
            'unit_id'             => $unitSmk->id,
            'nama_jurusan'        => 'Rekayasa Perangkat Lunak',
            'nomenklatur_istilah' => 'Program Keahlian',
            'shortname'           => 'RPL',
        ]);

        // Test non-SMK unit cannot require major_id and it should be saved as null
        $response = $this->actingAs($adminSmp)->post(route('admin.galleries.store', $unitSmp), [
            'nama_kegiatan' => 'Perkemahan SMP',
            'opsi_tampilan' => 'galeri_dokumentasi',
            'photos'        => [UploadedFile::fake()->image('camp1.jpg')],
        ]);

        $response->assertRedirect(route('admin.galleries.index', $unitSmp));
        $this->assertDatabaseHas('galleries', [
            'nama_kegiatan' => 'Perkemahan SMP',
            'major_id'      => null,
        ]);

        // Test SMK unit with galeri_program requires major_id (validation should fail if empty)
        $response = $this->actingAs($adminSmk)->post(route('admin.galleries.store', $unitSmk), [
            'nama_kegiatan' => 'Pameran Karya RPL',
            'opsi_tampilan' => 'galeri_program',
            'photos'        => [UploadedFile::fake()->image('expo.jpg')],
        ]);
        $response->assertSessionHasErrors(['major_id']);

        // Test SMK unit with galeri_program succeeds when major_id is supplied
        $response = $this->actingAs($adminSmk)->post(route('admin.galleries.store', $unitSmk), [
            'nama_kegiatan' => 'Pameran Karya RPL',
            'opsi_tampilan' => 'galeri_program',
            'major_id'      => $major->id,
            'photos'        => [
                UploadedFile::fake()->image('expo1.jpg'),
                UploadedFile::fake()->image('expo2.jpg'),
            ],
        ]);

        $response->assertRedirect(route('admin.galleries.index', $unitSmk));
        $this->assertDatabaseHas('galleries', [
            'nama_kegiatan' => 'Pameran Karya RPL',
            'major_id'      => $major->id,
        ]);

        $gallery = Gallery::where('nama_kegiatan', 'Pameran Karya RPL')->first();
        $this->assertCount(2, $gallery->photos);

        // 2. Test reordering and photo deletion on edit
        $photo1 = $gallery->photos[0];
        $photo2 = $gallery->photos[1];

        // Swap order and mark photo2 for deletion
        $response = $this->actingAs($adminSmk)->put(route('admin.galleries.update', [$unitSmk, $gallery]), [
            'nama_kegiatan'          => 'Pameran Karya RPL Updated',
            'opsi_tampilan'          => 'galeri_program',
            'major_id'               => $major->id,
            'existing_photos_order'  => [$photo2->id, $photo1->id], // Swap order
            'deleted_photos'         => [$photo2->id],            // Delete photo2
            'photos'                 => [UploadedFile::fake()->image('new_photo.jpg')], // Add new photo
        ]);

        $response->assertRedirect(route('admin.galleries.index', $unitSmk));
        
        // Photo2 should be deleted
        $this->assertDatabaseMissing('gallery_photos', ['id' => $photo2->id]);
        
        // Photo1 should remain but order is updated, and new photo added
        $gallery = $gallery->fresh();
        $this->assertCount(2, $gallery->photos); // photo1 + new_photo
        $this->assertEquals($photo1->id, $gallery->photos[0]->id); // Since photo2 was deleted, photo1 is first now
    }
}
