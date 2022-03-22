<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthTFA extends MiddlewareAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->load($request);

        if ($this->factory()->action()->sessionTFA() === false) {
            return $this->unauthorized($request, static fn () => redirect()->route('user.auth.tfa'));
        }

        return $next($request);
    }
}
