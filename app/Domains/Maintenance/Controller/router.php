<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

use Illuminate\Support\Facades\Route;

Route::get('/maintenance/opcache/preload', OpcachePreload::class)->name('maintenance.opcache.preload');
