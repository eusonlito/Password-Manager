<?php declare(strict_types=1);

namespace App\Services\Network\Ping;

class Ping
{
    /**
     * @param string $host
     *
     * @return bool
     */
    public static function get(string $host): bool
    {
        return static::request($host);
    }

    /**
     * @param string $host
     *
     * @return bool
     */
    protected static function request(string $host): bool
    {
        if ($response = fsockopen($host, 80, $errCode, $errStr, 1)) {
            fclose($response);

            return true;
        }

        return false;
    }
}
