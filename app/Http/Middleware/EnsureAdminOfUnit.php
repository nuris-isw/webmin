<?php

namespace App\Http\Middleware;

use App\Models\Unit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminOfUnit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Superadmin bypass
        if ($user->isSuperadmin()) {
            return $next($request);
        }

        // Dapatkan parameter unit dari route
        $unitParam = $request->route('unit');
        $unitId = null;

        if ($unitParam instanceof Unit) {
            $unitId = $unitParam->id;
        } elseif (is_numeric($unitParam)) {
            $unitId = (int) $unitParam;
        } elseif (is_string($unitParam)) {
            $unitId = Unit::where('slug', $unitParam)->value('id');
        }

        // Jika ada parameter unit, verifikasi kecocokan tenant
        if ($unitId !== null && $user->unit_id !== $unitId) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses untuk unit sekolah ini.');
        }

        // Jika tidak ada parameter unit di route, tapi butuh proteksi general
        if ($unitId === null && $user->unit_id === null) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda tidak tertaut pada unit sekolah manapun.');
        }

        return $next($request);
    }
}
