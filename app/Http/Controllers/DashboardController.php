<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request and redirect to role-specific dashboard.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->isSuperadmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        $unit = $user->unit;

        if (! $unit) {
            return redirect()->route('profile.edit')->with('error', 'Akun Anda tidak tertaut pada unit sekolah manapun.');
        }

        // Jika dia admin unit, arahkan ke rute dashboard admin unit
        return redirect()->route('admin.dashboard', ['unit' => $unit->slug]);
    }
}
