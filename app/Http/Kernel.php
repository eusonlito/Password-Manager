<?php declare(strict_types=1);

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as KernelVendor;
use App\Domains\User\Middleware\Admin as UserAdmin;
use App\Domains\User\Middleware\Auth as UserAuth;
use App\Domains\User\Middleware\AuthApi as UserAuthApi;
use App\Domains\User\Middleware\AuthCountry as UserAuthCountry;
use App\Domains\User\Middleware\AuthRedirect as UserAuthRedirect;
use App\Domains\User\Middleware\AuthTFA as UserAuthTFA;
use App\Domains\User\Middleware\Enabled as UserEnabled;

class Kernel extends KernelVendor
{
    /**
     * @var array
     */
    protected $middleware = [
        Middleware\TrustProxies::class,
        Middleware\Https::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        Middleware\RequestLogger::class,
        Middleware\Reset::class,
        Middleware\MessagesShareFromSession::class,
        UserAuthCountry::class,
    ];

    /**
     * @var array
     */
    protected $middlewareGroups = [
        'user-auth' => [
            UserAuth::class,
            UserEnabled::class,
            UserAuthTFA::class,
        ],
    ];

    /**
     * @var array
     */
    protected $middlewareAliases = [
        'user.admin' => UserAdmin::class,
        'user.auth' => UserAuth::class,
        'user.auth.api' => UserAuthApi::class,
        'user.auth.redirect' => UserAuthRedirect::class,
        'user.auth.tfa' => UserAuthTFA::class,
        'user.enabled' => UserEnabled::class,
    ];
}
