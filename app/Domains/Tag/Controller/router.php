<?php declare(strict_types=1);

namespace App\Domains\Tag\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'user.admin']], static function () {
    Route::get('/tag', Index::class)->name('tag.index');
    Route::any('/tag/create', Create::class)->name('tag.create');
    Route::any('/tag/{id}', Update::class)->name('tag.update');
    Route::post('/tag/{id}/delete', Delete::class)->name('tag.delete');
});
