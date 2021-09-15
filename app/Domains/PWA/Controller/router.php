<?php declare(strict_types=1);

namespace App\Domains\PWA\Controller;

use Illuminate\Support\Facades\Route;

Route::get('/pwa', Index::class)->name('pwa.index');
