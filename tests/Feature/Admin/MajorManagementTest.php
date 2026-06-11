<?php

namespace Tests\Feature\Admin;

use App\Models\Major;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MajorManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test root landing page `/` redirects to `/login`.
     */
    public function test_root_page_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    /**
     * Test SMK unit admin can successfully CRUD majors.
     */
    public function test_smk_admin_can_crud_majors(): void
    {
        Storage::fake('public');

        $unit = Unit::factory()->create(['jenjang' => 'smk']);
        $admin = User::factory()->adminOf($unit->id)->create();

        // 1. Create Major
        $response = $this->actingAs($admin)->post(route('admin.majors.store', $unit), [
            'nama_jurusan'        => 'Rekayasa Perangkat Lunak',
            'nomenklatur_istilah' => 'Program Keahlian',
            'shortname'           => 'RPL',
            'nama_kaprog'         => 'Budi Utomo, S.Kom',
            'foto_kaprog'         => UploadedFile::fake()->image('kaprog.jpg'),
            'deskripsi_jurusan'   => '<p>Belajar coding</p>',
        ]);

        $response->assertRedirect(route('admin.majors.index', $unit));
        $this->assertDatabaseHas('majors', [
            'nama_jurusan' => 'Rekayasa Perangkat Lunak',
            'shortname'    => 'RPL',
        ]);

        $major = Major::where('shortname', 'RPL')->first();
        $this->assertNotNull($major->foto_kaprog);
        Storage::disk('public')->assertExists($major->foto_kaprog);

        // 2. Read index
        $response = $this->actingAs($admin)->get(route('admin.majors.index', $unit));
        $response->assertStatus(200);
        $response->assertSee('Rekayasa Perangkat Lunak');

        // 3. Update Major
        $response = $this->actingAs($admin)->put(route('admin.majors.update', [$unit, $major]), [
            'nama_jurusan'        => 'Rekayasa Perangkat Lunak Updated',
            'nomenklatur_istilah' => 'Program Keahlian',
            'shortname'           => 'RPL-NEW',
        ]);

        $response->assertRedirect(route('admin.majors.index', $unit));
        $this->assertDatabaseHas('majors', [
            'id'           => $major->id,
            'nama_jurusan' => 'Rekayasa Perangkat Lunak Updated',
            'shortname'    => 'RPL-NEW',
        ]);

        // 4. Delete Major
        $response = $this->actingAs($admin)->delete(route('admin.majors.destroy', [$unit, $major]));
        $response->assertRedirect(route('admin.majors.index', $unit));
        $this->assertDatabaseMissing('majors', ['id' => $major->id]);
        Storage::disk('public')->assertMissing($major->foto_kaprog);
    }

    /**
     * Test non-SMK unit admin (e.g. SMP) is blocked from accessing majors routes.
     */
    public function test_non_smk_admin_cannot_access_majors(): void
    {
        $unitSmp = Unit::factory()->create(['jenjang' => 'smp']);
        $adminSmp = User::factory()->adminOf($unitSmp->id)->create();

        // Try to access index
        $response = $this->actingAs($adminSmp)->get(route('admin.majors.index', $unitSmp));
        
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error', 'Akses dibatasi. Fitur ini hanya tersedia untuk unit SMK.');

        // Try to store
        $response = $this->actingAs($adminSmp)->post(route('admin.majors.store', $unitSmp), [
            'nama_jurusan'        => 'Pemasaran',
            'nomenklatur_istilah' => 'Program Keahlian',
            'shortname'           => 'PM',
        ]);
        
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error', 'Akses dibatasi. Fitur ini hanya tersedia untuk unit SMK.');
    }
}
