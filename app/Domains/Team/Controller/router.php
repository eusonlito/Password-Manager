<?php declare(strict_types=1);

namespace App\Domains\Team\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'user.admin']], static function () {
    Route::get('/team', Index::class)->name('team.index');
    Route::any('/team/create', Create::class)->name('team.create');
    Route::any('/team/{id}', Update::class)->name('team.update');
    Route::any('/team/{id}/user', UpdateUser::class)->name('team.update.user');
    Route::any('/team/{id}/app', UpdateApp::class)->name('team.update.app');
    Route::post('/team/{id}/boolean/{column}', UpdateBoolean::class)->name('team.update.boolean');
    Route::post('/team/{id}/delete', Delete::class)->name('team.delete');
});
