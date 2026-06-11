<?php

namespace Tests\Feature\Superadmin;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test `/dashboard` redirects superadmin to superadmin dashboard.
     */
    public function test_dashboard_redirects_superadmin_correctly(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $response = $this->actingAs($superadmin)->get('/dashboard');

        $response->assertRedirect(route('superadmin.dashboard'));
    }

    /**
     * Test `/dashboard` redirects unit admin to unit admin dashboard.
     */
    public function test_dashboard_redirects_unit_admin_correctly(): void
    {
        $unit = Unit::factory()->create();
        $admin = User::factory()->adminOf($unit->id)->create();

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard', ['unit' => $unit->slug]));
    }

    /**
     * Test Superadmin Dashboard view displays correctly.
     */
    public function test_superadmin_dashboard_displays_correctly(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $unit = Unit::factory()->create(['nama_sekolah' => 'Sekolah Test']);

        $response = $this->actingAs($superadmin)->get(route('superadmin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.dashboard');
        $response->assertSee('Sekolah Test');
    }

    /**
     * Test Superadmin can view units list.
     */
    public function test_superadmin_can_view_units_list(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $unit = Unit::factory()->create(['nama_sekolah' => 'SD Harapan']);

        $response = $this->actingAs($superadmin)->get(route('superadmin.units.index'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.units.index');
        $response->assertSee('SD Harapan');
    }

    /**
     * Test Superadmin can view unit details.
     */
    public function test_superadmin_can_view_unit_details(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $unit = Unit::factory()->create(['nama_sekolah' => 'SD Harapan']);

        $response = $this->actingAs($superadmin)->get(route('superadmin.units.show', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.units.show');
        $response->assertSee('SD Harapan');
    }

    /**
     * Test Superadmin can register a new unit, ensuring default school profile and spmb settings are auto-seeded.
     */
    public function test_superadmin_can_create_unit_with_auto_seeding(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $response = $this->actingAs($superadmin)->post(route('superadmin.units.store'), [
            'nama_sekolah' => 'SMK Negeri 1 Test',
            'jenjang'      => 'smk',
            'is_active'    => '1',
        ]);

        $response->assertRedirect(route('superadmin.units.index'));
        $this->assertDatabaseHas('units', [
            'nama_sekolah' => 'SMK Negeri 1 Test',
            'jenjang'      => 'smk',
            'is_active'    => true,
        ]);

        $unit = Unit::where('nama_sekolah', 'SMK Negeri 1 Test')->first();
        $this->assertNotNull($unit);

        // Verify school profile was seeded
        $this->assertDatabaseHas('school_profiles', [
            'unit_id' => $unit->id,
            'email'   => 'info@smk-negeri-1-test.sch.id',
        ]);

        // Verify spmb setting was seeded
        $this->assertDatabaseHas('spmb_settings', [
            'unit_id'     => $unit->id,
            'status_spmb' => false,
        ]);
    }

    /**
     * Test validation rules for unit creation.
     */
    public function test_unit_creation_validation(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $existingUnit = Unit::factory()->create(['nama_sekolah' => 'Unique School']);

        // Test required fields
        $response = $this->actingAs($superadmin)->post(route('superadmin.units.store'), []);
        $response->assertSessionHasErrors(['nama_sekolah', 'jenjang', 'is_active']);

        // Test school name unique validation
        $response = $this->actingAs($superadmin)->post(route('superadmin.units.store'), [
            'nama_sekolah' => 'Unique School',
            'jenjang'      => 'tk',
            'is_active'    => '1',
        ]);
        $response->assertSessionHasErrors(['nama_sekolah']);

        // Test invalid jenjang validation
        $response = $this->actingAs($superadmin)->post(route('superadmin.units.store'), [
            'nama_sekolah' => 'Another School',
            'jenjang'      => 'invalid_jenjang',
            'is_active'    => '1',
        ]);
        $response->assertSessionHasErrors(['jenjang']);
    }

    /**
     * Test Superadmin can edit unit.
     */
    public function test_superadmin_can_edit_unit(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $unit = Unit::factory()->create(['nama_sekolah' => 'Old Name', 'jenjang' => 'tk']);

        $response = $this->actingAs($superadmin)->put(route('superadmin.units.update', $unit), [
            'nama_sekolah' => 'New Name',
            'jenjang'      => 'smp',
            'is_active'    => '0',
        ]);

        $response->assertRedirect(route('superadmin.units.index'));
        $this->assertDatabaseHas('units', [
            'id'           => $unit->id,
            'nama_sekolah' => 'New Name',
            'jenjang'      => 'smp',
            'is_active'    => false,
        ]);
    }

    /**
     * Test Superadmin can delete unit.
     */
    public function test_superadmin_can_delete_unit(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $unit = Unit::factory()->create();

        $response = $this->actingAs($superadmin)->delete(route('superadmin.units.destroy', $unit));

        $response->assertRedirect(route('superadmin.units.index'));
        $this->assertDatabaseMissing('units', [
            'id' => $unit->id,
        ]);
    }

    /**
     * Test Superadmin can filter user list by role.
     */
    public function test_superadmin_can_filter_user_list_by_role(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        
        $anotherSuperadmin = User::factory()->superadmin()->create(['name' => 'Alpha Superadmin']);
        $unit = Unit::factory()->create();
        $unitAdmin = User::factory()->adminOf($unit->id)->create(['name' => 'Beta Admin']);

        // Filter by superadmin
        $response = $this->actingAs($superadmin)->get(route('superadmin.users.index', ['role' => 'superadmin']));
        $response->assertStatus(200);
        $response->assertSee('Alpha Superadmin');
        $response->assertDontSee('Beta Admin');

        // Filter by admin
        $response = $this->actingAs($superadmin)->get(route('superadmin.users.index', ['role' => 'admin']));
        $response->assertStatus(200);
        $response->assertSee('Beta Admin');
        $response->assertDontSee('Alpha Superadmin');
    }

    /**
     * Test Superadmin can filter user list by unit_id.
     */
    public function test_superadmin_can_filter_user_list_by_unit(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        
        $unitA = Unit::factory()->create();
        $unitB = Unit::factory()->create();

        $adminA = User::factory()->adminOf($unitA->id)->create(['name' => 'Admin of Unit A']);
        $adminB = User::factory()->adminOf($unitB->id)->create(['name' => 'Admin of Unit B']);

        // Filter by Unit A
        $response = $this->actingAs($superadmin)->get(route('superadmin.users.index', ['unit_id' => $unitA->id]));
        $response->assertStatus(200);
        $response->assertSee('Admin of Unit A');
        $response->assertDontSee('Admin of Unit B');

        // Filter by Unit B
        $response = $this->actingAs($superadmin)->get(route('superadmin.users.index', ['unit_id' => $unitB->id]));
        $response->assertStatus(200);
        $response->assertSee('Admin of Unit B');
        $response->assertDontSee('Admin of Unit A');
    }
}
