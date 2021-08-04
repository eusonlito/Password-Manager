<?php declare(strict_types=1);

namespace App\Domains\App\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user.auth.api']], static function () {
    Route::post('/app/api/search', Search::class)->name('app.api.search');
    Route::post('/app/api/{id}/payload/{key}', PayloadKey::class)->name('app.api.payload.key');
});
