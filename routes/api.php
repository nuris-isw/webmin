<?php

use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\ExtracurricularController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\MajorController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\SpmbController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\UnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    // Units API
    Route::get('/units', [UnitController::class, 'index']);
    Route::get('/units/{slug}', [UnitController::class, 'show']);

    Route::prefix('/units/{slug}')->group(function () {
        // News API
        Route::get('/news', [NewsController::class, 'index']);
        Route::get('/news/{newsSlug}', [NewsController::class, 'show']);

        // Achievements API
        Route::get('/achievements', [AchievementController::class, 'index']);

        // Extracurriculars API
        Route::get('/extracurriculars', [ExtracurricularController::class, 'index']);

        // Galleries API
        Route::get('/galleries', [GalleryController::class, 'index']);
        Route::get('/galleries/{id}', [GalleryController::class, 'show']);

        // SPMB API
        Route::get('/spmb', [SpmbController::class, 'show']);

        // Majors API
        Route::get('/majors', [MajorController::class, 'index']);
        Route::get('/majors/{id}', [MajorController::class, 'show']);

        // Employees API
        Route::get('/employees', [EmployeeController::class, 'index']);
        Route::get('/employees/{id}', [EmployeeController::class, 'show']);
    });
});
