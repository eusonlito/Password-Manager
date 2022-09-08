<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin extends MiddlewareAbstract
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

        if (empty($this->auth->admin)) {
            return $this->unauthorized($request, static fn () => redirect()->back());
        }

        return $next($request);
    }
}
