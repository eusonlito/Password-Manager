<?php declare(strict_types=1);

namespace App\Services\Network\Whois;

use Exception;
use Illuminate\Support\Facades\Log;

class Whois
{
    /**
     * @param string $host
     *
     * @return ?array
     */
    public static function get(string $host): ?array
    {
        foreach (config('whois', []) as $service => $config) {
            if ($response = static::service($service, $config, $host)) {
                return $response;
            }
        }

        return null;
    }

    /**
     * @param string $service
     * @param array $config
     * @param string $host
     *
     * @return ?array
     */
    protected static function service(string $service, array $config, string $host): ?array
    {
        $service = new $service($config, $host);

        if ($service->available() === false) {
            return null;
        }

        try {
            return $service->get();
        } catch (Exception $e) {
            Log::error($e);
        }

        return null;
    }
}
