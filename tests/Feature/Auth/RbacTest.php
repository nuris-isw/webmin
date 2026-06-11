<?php

namespace Tests\Feature\Auth;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Superadmin can access user management.
     */
    public function test_superadmin_can_access_user_management(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $response = $this->actingAs($superadmin)->get(route('superadmin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.users.index');
    }

    /**
     * Test Admin cannot access user management (redirects to dashboard).
     */
    public function test_admin_cannot_access_user_management(): void
    {
        $unit = Unit::factory()->create(['nama_sekolah' => 'SMP Test', 'jenjang' => 'smp']);
        $admin = User::factory()->adminOf($unit->id)->create();

        $response = $this->actingAs($admin)->get(route('superadmin.users.index'));

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error', 'Anda tidak memiliki hak akses Superadmin.');
    }

    /**
     * Test EnsureAdminOfUnit middleware allows access to own unit, but blocks another unit.
     */
    public function test_tenant_isolation_middleware(): void
    {
        $unitA = Unit::factory()->create(['nama_sekolah' => 'Unit A', 'slug' => 'unit-a', 'jenjang' => 'smp']);
        $unitB = Unit::factory()->create(['nama_sekolah' => 'Unit B', 'slug' => 'unit-b', 'jenjang' => 'smp']);

        $adminA = User::factory()->adminOf($unitA->id)->create();

        // Register dummy test routes that use the middleware
        $this->app['router']->get('/test/unit/{unit}', function () {
            return response('Access Allowed');
        })->middleware(['web', 'auth', 'admin.unit']);

        // Admin A tries to access unit A -> Allowed
        $response = $this->actingAs($adminA)->get("/test/unit/{$unitA->slug}");
        $response->assertStatus(200);
        $response->assertSee('Access Allowed');

        // Admin A tries to access unit B -> Redirected to dashboard
        $response = $this->actingAs($adminA)->get("/test/unit/{$unitB->slug}");
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error', 'Anda tidak memiliki hak akses untuk unit sekolah ini.');
    }

    /**
     * Test EnsureSmkUnit middleware restricts non-SMK units.
     */
    public function test_smk_only_middleware(): void
    {
        $unitSmk = Unit::factory()->create(['nama_sekolah' => 'SMK Mandiri', 'slug' => 'smk-mandiri', 'jenjang' => 'smk']);
        $unitSmp = Unit::factory()->create(['nama_sekolah' => 'SMP Mandiri', 'slug' => 'smp-mandiri', 'jenjang' => 'smp']);

        $adminSmk = User::factory()->adminOf($unitSmk->id)->create();
        $adminSmp = User::factory()->adminOf($unitSmp->id)->create();

        // Register dummy test route
        $this->app['router']->get('/test/smk-only/{unit}', function () {
            return response('SMK Allowed');
        })->middleware(['web', 'auth', 'unit.smk']);

        // SMK Admin tries to access -> Allowed
        $response = $this->actingAs($adminSmk)->get("/test/smk-only/{$unitSmk->slug}");
        $response->assertStatus(200);
        $response->assertSee('SMK Allowed');

        // SMP Admin tries to access -> Blocked (Redirected)
        $response = $this->actingAs($adminSmp)->get("/test/smk-only/{$unitSmp->slug}");
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error', 'Akses dibatasi. Fitur ini hanya tersedia untuk unit SMK.');
    }

    /**
     * Test Google OAuth redirect.
     */
    public function test_google_oauth_redirects_correctly(): void
    {
        $response = $this->get(route('auth.google'));
        
        $this->assertTrue($response->isRedirect());
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
    }

    /**
     * Test Google OAuth callback with registered email.
     */
    public function test_google_oauth_logs_in_registered_user(): void
    {
        $user = User::factory()->create(['email' => 'registered@example.com']);

        $abstractUser = $this->createMock(\Laravel\Socialite\Two\User::class);
        $abstractUser->method('getEmail')->willReturn('registered@example.com');
        $abstractUser->method('getId')->willReturn('google-id-123');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard', absolute: false));
        
        $this->assertEquals('google-id-123', $user->fresh()->google_id);
    }

    /**
     * Test Google OAuth callback rejects unregistered email.
     */
    public function test_google_oauth_rejects_unregistered_user(): void
    {
        $abstractUser = $this->createMock(\Laravel\Socialite\Two\User::class);
        $abstractUser->method('getEmail')->willReturn('unregistered@example.com');
        $abstractUser->method('getId')->willReturn('google-id-123');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['email']);
    }
}
