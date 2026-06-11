<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\News;
use App\Models\Unit;
use App\Models\User;
use Illuminate\View\View;

class SuperadminController extends Controller
{
    /**
     * Display the superadmin dashboard overview.
     */
    public function index(): View
    {
        $totalUnits = Unit::count();
        $totalAdmins = User::admins()->count();
        $totalNews = News::count();
        $totalAchievements = Achievement::count();

        // Ambil unit beserta jumlah adminnya
        $units = Unit::withCount('users')->orderBy('nama_sekolah')->get();

        return view('superadmin.dashboard', compact(
            'totalUnits',
            'totalAdmins',
            'totalNews',
            'totalAchievements',
            'units'
        ));
    }
}
