<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * @var string|array
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->setProxies();
        $this->setHeaders();
    }

    /**
     * @return self
     */
    protected function setProxies()
    {
        $this->proxies = match ($trusted = config('proxy.trusted')) {
            '*' => '*',
            default => array_filter(array_map('trim', explode(',', $trusted))),
        };
    }

    /**
     * @return self
     */
    protected function setHeaders()
    {
        $this->headers = intval(config('proxy.headers'));
    }
}
