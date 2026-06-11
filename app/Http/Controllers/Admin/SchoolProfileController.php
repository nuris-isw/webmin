<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SchoolProfileController extends Controller
{
    /**
     * Show the form for editing the school profile.
     */
    public function edit(Unit $unit): View
    {
        $profile = $unit->schoolProfile;

        // Jika profile belum terbuat, buat default instansi
        if (!$profile) {
            $profile = $unit->schoolProfile()->create([
                'email'        => 'info@' . $unit->slug . '.sch.id',
                'media_sosial' => [
                    'instagram' => null,
                    'facebook'  => null,
                    'youtube'   => null,
                    'tiktok'    => null,
                ],
            ]);
        }

        return view('admin.profile.edit', compact('unit', 'profile'));
    }

    /**
     * Update the school profile in storage.
     */
    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $profile = $unit->schoolProfile;

        $validated = $request->validate([
            'logo_sekolah'            => ['nullable', 'image', 'max:2048'],
            'email'                   => ['nullable', 'email', 'max:255'],
            'telepon'                 => ['nullable', 'string', 'max:50'],
            'alamat'                  => ['nullable', 'string'],
            'google_map_embed_url'    => ['nullable', 'string'],
            'media_sosial.instagram'  => ['nullable', 'string', 'max:255'],
            'media_sosial.facebook'   => ['nullable', 'string', 'max:255'],
            'media_sosial.youtube'    => ['nullable', 'string', 'max:255'],
            'media_sosial.tiktok'     => ['nullable', 'string', 'max:255'],
            'nama_kepala_sekolah'     => ['nullable', 'string', 'max:255'],
            'foto_kepala_sekolah'     => ['nullable', 'image', 'max:2048'],
            'sambutan_kepala_sekolah' => ['nullable', 'string'],
            'sejarah_singkat_sekolah' => ['nullable', 'string'],
            'visi'                    => ['nullable', 'string'],
            'misi'                    => ['nullable', 'string'],
            'deskripsi_kurikulum'     => ['nullable', 'string'],
            'pdf_kalender_akademik'   => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $data = $request->except(['logo_sekolah', 'foto_kepala_sekolah', 'pdf_kalender_akademik', '_token', '_method']);

        // Handle file uploads with cleanup of old files (F7-05)
        if ($request->hasFile('logo_sekolah')) {
            if ($profile->logo_sekolah) {
                Storage::disk('public')->delete($profile->logo_sekolah);
            }
            $data['logo_sekolah'] = $request->file('logo_sekolah')->store("{$unit->id}/profile", 'public');
        }

        if ($request->hasFile('foto_kepala_sekolah')) {
            if ($profile->foto_kepala_sekolah) {
                Storage::disk('public')->delete($profile->foto_kepala_sekolah);
            }
            $data['foto_kepala_sekolah'] = $request->file('foto_kepala_sekolah')->store("{$unit->id}/profile", 'public');
        }

        if ($request->hasFile('pdf_kalender_akademik')) {
            if ($profile->pdf_kalender_akademik) {
                Storage::disk('public')->delete($profile->pdf_kalender_akademik);
            }
            $data['pdf_kalender_akademik'] = $request->file('pdf_kalender_akademik')->store("{$unit->id}/profile", 'public');
        }

        $profile->update($data);

        return redirect()->route('admin.profile.edit', $unit)
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
