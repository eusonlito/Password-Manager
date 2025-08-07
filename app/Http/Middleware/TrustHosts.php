<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * @return array
     */
    public function hosts(): array
    {
        $patterns = [$this->allSubdomainsOfApplicationUrl()];

        foreach (array_filter(array_map('trim', explode(',', config('proxy.hosts')))) as $host) {
            $patterns[] = '^'.preg_quote($host, '/').'$';
        }

        return $patterns;
    }
}
