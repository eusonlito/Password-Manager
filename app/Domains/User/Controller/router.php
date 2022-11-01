<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'user.auth.redirect'], static function () {
    Route::any('/user/auth', AuthCredentials::class)->name('user.auth.credentials');
    Route::any('/user/auth/certificate', AuthCertificate::class)->name('user.auth.certificate');
});

Route::group(['middleware' => ['user-auth']], static function () {
    Route::any('/user/profile', Profile::class)->name('user.profile');
    Route::any('/user/profile/tfa', ProfileTFA::class)->name('user.profile.tfa');
    Route::any('/user/profile/certificate', ProfileCertificate::class)->name('user.profile.certificate');
});

Route::group(['middleware' => ['user.auth']], static function () {
    Route::any('/user/auth/tfa', AuthTFA::class)->name('user.auth.tfa');
    Route::any('/user/disabled', Disabled::class)->name('user.disabled');
    Route::get('/user/logout', Logout::class)->name('user.logout');
});

Route::group(['middleware' => ['user-auth', 'user.admin']], static function () {
    Route::get('/user', Index::class)->name('user.index');
    Route::any('/user/create', Create::class)->name('user.create');
    Route::any('/user/{id}', Update::class)->name('user.update');
    Route::any('/user/{id}/team', UpdateTeam::class)->name('user.update.team');
    Route::any('/user/{id}/app', UpdateApp::class)->name('user.update.app');
    Route::post('/user/{id}/boolean/{column}', UpdateBoolean::class)->name('user.update.boolean');
});
