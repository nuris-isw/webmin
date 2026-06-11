<?php

namespace Tests\Unit;

use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FileUploadServiceTest extends TestCase
{
    protected FileUploadService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FileUploadService();
        Storage::fake('public');
    }

    public function test_it_can_upload_a_valid_image(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

        $path = $this->service->uploadImage($file, 1, 'news');

        $this->assertNotEmpty($path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_it_resizes_image_wider_than_1200px(): void
    {
        // Create a fake image that is 2000px wide
        $file = UploadedFile::fake()->image('large.png', 2000, 1000);

        $path = $this->service->uploadImage($file, 1, 'news');

        $this->assertNotEmpty($path);
        Storage::disk('public')->assertExists($path);

        // Retrieve physical file and assert new size
        $realPath = Storage::disk('public')->path($path);
        list($width, $height) = getimagesize($realPath);

        $this->assertEquals(1200, $width);
        $this->assertEquals(600, $height); // maintains aspect ratio (2:1)
    }

    public function test_it_throws_validation_exception_for_oversized_image(): void
    {
        // Max size is 2048 KB (2MB). Let's create a file of 3000 KB.
        $file = UploadedFile::fake()->create('heavy.jpg', 3000, 'image/jpeg');

        $this->expectException(ValidationException::class);

        $this->service->uploadImage($file, 1, 'news');
    }

    public function test_it_throws_validation_exception_for_invalid_image_mime(): void
    {
        $file = UploadedFile::fake()->create('document.txt', 100, 'text/plain');

        $this->expectException(ValidationException::class);

        $this->service->uploadImage($file, 1, 'news');
    }

    public function test_it_can_upload_a_valid_pdf(): void
    {
        $file = UploadedFile::fake()->create('calendar.pdf', 1000, 'application/pdf');

        $path = $this->service->uploadPdf($file, 1, 'profile');

        $this->assertNotEmpty($path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_it_throws_validation_exception_for_oversized_pdf(): void
    {
        // Max size is 10240 KB (10MB). Let's create a file of 12000 KB.
        $file = UploadedFile::fake()->create('huge.pdf', 12000, 'application/pdf');

        $this->expectException(ValidationException::class);

        $this->service->uploadPdf($file, 1, 'profile');
    }

    public function test_it_throws_validation_exception_for_invalid_pdf_mime(): void
    {
        $file = UploadedFile::fake()->create('photo.jpg', 100, 'image/jpeg');

        $this->expectException(ValidationException::class);

        $this->service->uploadPdf($file, 1, 'profile');
    }

    public function test_it_deletes_old_file_when_replacement_is_provided(): void
    {
        // Upload first file
        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $this->service->uploadImage($oldFile, 1, 'news');
        Storage::disk('public')->assertExists($oldPath);

        // Upload second file and pass old path
        $newFile = UploadedFile::fake()->image('new.jpg');
        $newPath = $this->service->uploadImage($newFile, 1, 'news', $oldPath);

        Storage::disk('public')->assertExists($newPath);
        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_it_deletes_file_correctly(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg');
        $path = $this->service->uploadImage($file, 1, 'news');
        Storage::disk('public')->assertExists($path);

        $result = $this->service->deleteFile($path);

        $this->assertTrue($result);
        Storage::disk('public')->assertMissing($path);
    }
}
