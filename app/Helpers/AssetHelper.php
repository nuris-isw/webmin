<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class AssetHelper
{
    /**
     * Get the public URL for a stored file.
     */
    public static function getUrl(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // Return path if it's already a full URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
