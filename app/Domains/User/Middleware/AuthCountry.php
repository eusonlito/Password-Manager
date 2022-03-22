<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCountry extends MiddlewareAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->factory()->action()->authCountry() === false) {
            return $this->unauthorized($request, static fn () => response('Unauthorized.', 401));
        }

        return $next($request);
    }
}
