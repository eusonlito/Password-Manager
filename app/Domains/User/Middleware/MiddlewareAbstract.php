<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Illuminate\Http\Request;
use App\Domains\Shared\Middleware\MiddlewareAbstract as MiddlewareAbstractShared;
use App\Domains\User\Model\User as Model;

abstract class MiddlewareAbstract extends MiddlewareAbstractShared
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function load(Request $request): void
    {
        $this->auth = $this->row = $request->user();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param callable $callback
     *
     * @return mixed
     */
    protected function unauthorized(Request $request, callable $callback)
    {
        if ($request->wantsJson()) {
            return response()->json(['code' => 401, 'status' => 'unauthorized', 'message' => 'Unauthorized'], 401);
        }

        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        }

        return $callback($request);
    }
}
