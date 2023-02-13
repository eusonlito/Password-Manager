<?php declare(strict_types=1);

namespace App\Domains\Icon\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'user.admin']], static function () {
    Route::get('/icon', Index::class)->name('icon.index');
    Route::any('/icon/create', Create::class)->name('icon.create');
    Route::any('/icon/{name}', Update::class)->name('icon.update');
    Route::post('/icon/{name}/delete', Delete::class)->name('icon.delete');
});
