<?php declare(strict_types=1);

namespace App\Services\Network\Ip;

use Exception;
use stdClass;
use Illuminate\Support\Facades\Log;

class Locate
{
    /**
     * @param string $ip
     *
     * @return ?\stdClass
     */
    public static function locate(string $ip): ?stdClass
    {
        foreach (config('ip.services', []) as $service) {
            if ($response = static::service($service, $ip)) {
                return $response;
            }
        }

        return null;
    }

    /**
     * @param string $service
     * @param string $ip
     *
     * @return ?\stdClass
     */
    protected static function service(string $service, string $ip): ?stdClass
    {
        try {
            return (new $service())->locate($ip);
        } catch (Exception $e) {
            Log::error($e);
        }

        return null;
    }
}
