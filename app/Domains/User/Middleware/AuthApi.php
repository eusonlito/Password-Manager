<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthApi extends MiddlewareAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->factory()->action([
            'api_key' => $request->header('Authorization'),
            'api_secret' => $request->input('api_secret'),
        ])->authApi();

        return $next($request);
    }
}
