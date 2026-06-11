<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpmbController extends Controller
{
    /**
     * Show the form for editing the SPMB settings.
     */
    public function edit(Unit $unit): View
    {
        $spmb = $unit->spmbSetting;

        // Jika spmb belum terbuat, buat default instansi
        if (!$spmb) {
            $spmb = $unit->spmbSetting()->create([
                'status_spmb'               => false,
                'url_eksternal_pendaftaran' => null,
            ]);
        }

        return view('admin.spmb.edit', compact('unit', 'spmb'));
    }

    /**
     * Update the SPMB settings in storage.
     */
    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $spmb = $unit->spmbSetting;

        $validated = $request->validate([
            'status_spmb'               => ['required', 'boolean'],
            'informasi_prosedur'        => ['nullable', 'string'],
            'url_eksternal_pendaftaran' => ['nullable', 'url', 'max:255'],
        ]);

        $spmb->update([
            'status_spmb'               => (bool) $validated['status_spmb'],
            'informasi_prosedur'        => $validated['informasi_prosedur'],
            'url_eksternal_pendaftaran' => $validated['url_eksternal_pendaftaran'],
        ]);

        return redirect()->route('admin.spmb.edit', $unit)
            ->with('success', 'Pengaturan SPMB berhasil diperbarui.');
    }
}
