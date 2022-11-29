<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/app', Index::class)->name('app.index');
    Route::any('/app/create', Create::class)->name('app.create');
    Route::any('/app/export', Export::class)->name('app.export');
    Route::any('/app/{id}', Update::class)->name('app.update');
    Route::get('/app/{id}/file/{file_id}', File::class)->name('app.file');
    Route::post('/app/{id}/payload/{key}', PayloadKey::class)->name('app.payload.key');
    Route::post('/app/{id}/delete', Delete::class)->name('app.delete');
});
