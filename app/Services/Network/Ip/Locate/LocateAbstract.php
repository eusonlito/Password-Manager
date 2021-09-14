<?php declare(strict_types=1);

namespace App\Services\Network\Ip\Locate;

use App\Services\Http\Curl\Curl;
use stdClass;

abstract class LocateAbstract
{
    /**
     * @var string
     */
    protected string $host;

    /**
     * @param string $ip
     *
     * @return \stdClass
     */
    abstract public function locate(string $ip): stdClass;

    /**
     * @param string $url
     *
     * @return \App\Services\Http\Curl\Curl
     */
    protected function curl(string $url): Curl
    {
        return (new Curl())
            ->setUrl($url)
            ->setTimeout(5)
            ->setLog()
            ->setCache(60 * 60 * 24 * 30);
    }
}
