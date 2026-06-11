<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FileUploadService
{
    /**
     * Upload an image file with validation, resizing, and old file cleanup.
     *
     * @throws ValidationException
     */
    public function uploadImage(UploadedFile $file, int $unitId, string $folder, ?string $oldPath = null, int $maxWidth = 1200): string
    {
        // 1. Validate rules
        Validator::make(['file' => $file], [
            'file' => ['required', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048']
        ])->validate();

        // 2. Resize in-place
        $this->resizeImageInPlace($file->getPathname(), $file->getMimeType(), $maxWidth);

        // 3. Delete old file if exists
        $this->deleteFile($oldPath);

        // 4. Store file
        return $file->store("{$unitId}/{$folder}", 'public');
    }

    /**
     * Upload a PDF file with validation and old file cleanup.
     *
     * @throws ValidationException
     */
    public function uploadPdf(UploadedFile $file, int $unitId, string $folder, ?string $oldPath = null): string
    {
        // 1. Validate rules
        Validator::make(['file' => $file], [
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240']
        ])->validate();

        // 2. Delete old file if exists
        $this->deleteFile($oldPath);

        // 3. Store file
        return $file->store("{$unitId}/{$folder}", 'public');
    }

    /**
     * Delete a file from the public storage disk if it exists.
     */
    public function deleteFile(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    /**
     * Resize image in-place to maximum width.
     */
    private function resizeImageInPlace(string $filePath, string $mimeType, int $maxWidth): void
    {
        if (!extension_loaded('gd')) {
            return;
        }

        list($width, $height) = @getimagesize($filePath);
        if (!$width || $width <= $maxWidth) {
            return;
        }

        $newWidth = $maxWidth;
        $newHeight = (int) (($height / $width) * $newWidth);

        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $srcImage = @imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                $srcImage = @imagecreatefrompng($filePath);
                if ($srcImage) {
                    imagealphablending($srcImage, false);
                    imagesavealpha($srcImage, true);
                }
                break;
            case 'image/webp':
                $srcImage = @imagecreatefromwebp($filePath);
                break;
            default:
                return;
        }

        if (!$srcImage) {
            return;
        }

        $dstImage = imagecreatetruecolor($newWidth, $newHeight);

        if ($mimeType === 'image/png' || $mimeType === 'image/webp') {
            imagealphablending($dstImage, false);
            imagesavealpha($dstImage, true);
            $transparent = imagecolorallocatealpha($dstImage, 255, 255, 255, 127);
            imagefilledrectangle($dstImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($dstImage, $filePath, 85);
                break;
            case 'image/png':
                imagepng($dstImage, $filePath, 8);
                break;
            case 'image/webp':
                imagewebp($dstImage, $filePath, 85);
                break;
        }

        imagedestroy($srcImage);
        imagedestroy($dstImage);
    }
}
