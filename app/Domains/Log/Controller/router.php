<?php declare(strict_types=1);

namespace App\Domains\Log\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'user.admin']], static function () {
    Route::get('/log', Index::class)->name('log.index');
});
