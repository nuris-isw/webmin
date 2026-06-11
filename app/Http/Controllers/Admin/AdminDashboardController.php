<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the unit admin dashboard.
     */
    public function index(Unit $unit): View
    {
        $stats = [
            'news'            => $unit->news()->count(),
            'achievements'    => $unit->achievements()->count(),
            'extracurriculars'=> $unit->extracurriculars()->count(),
            'galleries'       => $unit->galleries()->count(),
        ];

        return view('admin.dashboard', compact('unit', 'stats'));
    }
}
