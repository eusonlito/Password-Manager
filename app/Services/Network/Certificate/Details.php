<?php declare(strict_types=1);

namespace App\Services\Network\Certificate;

use Exception;

class Details
{
    /**
     * @param string $host
     *
     * @return ?array
     */
    public static function get(string $host): ?array
    {
        try {
            $request = static::client($host);
        } catch (Exception $e) {
            return null;
        }

        $params = stream_context_get_params($request);

        return openssl_x509_parse($params['options']['ssl']['peer_certificate'], true);
    }

    /**
     * @return resource
     */
    protected static function context()
    {
        return stream_context_create([
            'ssl' => [
                'capture_peer_cert' => true,
                'verify_host' => false,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
    }

    /**
     * @param string $host
     *
     * @return resource
     */
    protected static function client(string $host)
    {
        return stream_socket_client('ssl://'.$host.':443', $errno, $errstr, 30, STREAM_CLIENT_CONNECT, static::context());
    }
}
