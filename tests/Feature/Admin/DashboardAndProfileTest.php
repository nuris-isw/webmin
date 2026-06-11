<?php

namespace Tests\Feature\Admin;

use App\Models\Unit;
use App\Models\User;
use App\Models\SchoolProfile;
use App\Models\SpmbSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DashboardAndProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test unit admin dashboard loads successfully with correct statistics.
     */
    public function test_unit_admin_dashboard_loads_correctly(): void
    {
        $unit = Unit::factory()->create();
        $admin = User::factory()->adminOf($unit->id)->create();

        // Create some sample unit data
        $unit->news()->create(['judul_berita' => 'News 1', 'slug' => 'news-1']);
        $unit->achievements()->create([
            'judul_prestasi' => 'Achievement 1',
            'tahun_prestasi' => '2026',
            'peraih_prestasi' => 'siswa'
        ]);
        $unit->extracurriculars()->create(['nama_ekskul' => 'Ekskul 1']);
        $unit->galleries()->create(['nama_kegiatan' => 'Gallery 1', 'opsi_tampilan' => 'galeri_dokumentasi']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertSee('Dasbor ' . $unit->nama_sekolah);
        // Verify stats are displayed
        $response->assertSee('Total Berita');
        $response->assertSee('Total Prestasi');
    }

    /**
     * Test tenant isolation for dashboard access.
     */
    public function test_tenant_isolation_on_dashboard_access(): void
    {
        $unitA = Unit::factory()->create();
        $unitB = Unit::factory()->create();

        $adminA = User::factory()->adminOf($unitA->id)->create();

        // Admin A tries to access Dashboard of Unit B -> Blocked (redirects to home dashboard)
        $response = $this->actingAs($adminA)->get(route('admin.dashboard', $unitB));
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error', 'Anda tidak memiliki hak akses untuk unit sekolah ini.');
    }

    /**
     * Test school profile edit and update.
     */
    public function test_school_profile_can_be_edited_and_updated(): void
    {
        Storage::fake('public');

        $unit = Unit::factory()->create();
        $admin = User::factory()->adminOf($unit->id)->create();
        $profile = SchoolProfile::create(['unit_id' => $unit->id, 'email' => 'old@school.sch.id']);

        $response = $this->actingAs($admin)->get(route('admin.profile.edit', $unit));
        $response->assertStatus(200);

        // Upload files
        $logo = UploadedFile::fake()->image('logo.png');
        $kepsekPhoto = UploadedFile::fake()->image('kepsek.jpg');
        $calendar = UploadedFile::fake()->create('calendar.pdf', 100, 'application/pdf');

        $response = $this->actingAs($admin)->put(route('admin.profile.update', $unit), [
            'email'                   => 'new-email@school.sch.id',
            'telepon'                 => '021-123456',
            'alamat'                  => 'Jl. Baru No. 10',
            'nama_kepala_sekolah'     => 'Drs. H. Mulyadi',
            'logo_sekolah'            => $logo,
            'foto_kepala_sekolah'     => $kepsekPhoto,
            'pdf_kalender_akademik'   => $calendar,
            'media_sosial' => [
                'instagram' => 'https://instagram.com/school',
                'facebook'  => 'https://facebook.com/school',
            ],
            'visi'                    => '<p>Visi Baru</p>',
        ]);

        $response->assertRedirect(route('admin.profile.edit', $unit));
        $this->assertDatabaseHas('school_profiles', [
            'id'                  => $profile->id,
            'email'               => 'new-email@school.sch.id',
            'telepon'             => '021-123456',
            'alamat'              => 'Jl. Baru No. 10',
            'nama_kepala_sekolah' => 'Drs. H. Mulyadi',
            'visi'                => '<p>Visi Baru</p>',
        ]);

        $freshProfile = $profile->fresh();
        $this->assertNotNull($freshProfile->logo_sekolah);
        $this->assertNotNull($freshProfile->foto_kepala_sekolah);
        $this->assertNotNull($freshProfile->pdf_kalender_akademik);

        Storage::disk('public')->assertExists($freshProfile->logo_sekolah);
        Storage::disk('public')->assertExists($freshProfile->foto_kepala_sekolah);
        Storage::disk('public')->assertExists($freshProfile->pdf_kalender_akademik);
    }

    /**
     * Test SPMB Settings edit and update.
     */
    public function test_spmb_settings_can_be_updated(): void
    {
        $unit = Unit::factory()->create();
        $admin = User::factory()->adminOf($unit->id)->create();
        $spmb = SpmbSetting::create(['unit_id' => $unit->id, 'status_spmb' => false]);

        $response = $this->actingAs($admin)->get(route('admin.spmb.edit', $unit));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put(route('admin.spmb.update', $unit), [
            'status_spmb'               => '1',
            'url_eksternal_pendaftaran' => 'https://ppdb.school.sch.id',
            'informasi_prosedur'        => '<p>Langkah-langkah pendaftaran...</p>',
        ]);

        $response->assertRedirect(route('admin.spmb.edit', $unit));
        $this->assertDatabaseHas('spmb_settings', [
            'id'                        => $spmb->id,
            'status_spmb'               => true,
            'url_eksternal_pendaftaran' => 'https://ppdb.school.sch.id',
            'informasi_prosedur'        => '<p>Langkah-langkah pendaftaran...</p>',
        ]);
    }
}
