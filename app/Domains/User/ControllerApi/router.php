<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user.auth.api', 'user.admin']], static function () {
    Route::post('/user/api/index', Index::class)->name('user.api.index');
    Route::post('/user/api/create', Create::class)->name('user.api.create');
    Route::post('/user/api/{id}/detail', Detail::class)->name('user.api.detail');
    Route::post('/user/api/{id}/update', Update::class)->name('user.api.update');
    Route::post('/user/api/{id}/update/team', UpdateTeam::class)->name('user.api.update.team');
    Route::post('/user/api/{id}/update/boolean/{column}', UpdateBoolean::class)->name('user.api.update.boolean');
});
