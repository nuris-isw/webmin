<?php

namespace App\Http\Middleware;

use App\Models\Unit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSmkUnit
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

        // Dapatkan parameter unit dari route jika ada
        $unitParam = $request->route('unit');
        $isSmk = false;

        if ($unitParam instanceof Unit) {
            $isSmk = $unitParam->isSmk();
        } elseif (is_numeric($unitParam)) {
            $isSmk = Unit::where('id', $unitParam)->first()?->isSmk() ?? false;
        } elseif (is_string($unitParam)) {
            $isSmk = Unit::where('slug', $unitParam)->first()?->isSmk() ?? false;
        } else {
            // Jika tidak ada parameter unit di route, cek unit si user
            $isSmk = $user->unit?->isSmk() ?? false;
        }

        if (! $isSmk) {
            return redirect()->route('dashboard')->with('error', 'Akses dibatasi. Fitur ini hanya tersedia untuk unit SMK.');
        }

        return $next($request);
    }
}
