<?php declare(strict_types=1);

namespace App\Services\Network\Whois\Service;

use App\Services\Http\Curl\Curl;

abstract class ServiceAbstract
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @var string
     */
    protected string $host;

    /**
     * @return bool
     */
    abstract public function available(): bool;

    /**
     * @return array
     */
    abstract public function get(): array;

    /**
     * @param array $config
     * @param string $host
     *
     * @return self
     */
    public function __construct(array $config, string $host)
    {
        $this->host = $host;
        $this->config($config);
    }

    /**
     * @param array $config
     *
     * @return void
     */
    protected function config(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @param string $url
     *
     * @return \App\Services\Http\Curl\Curl
     */
    protected function curl(string $url): Curl
    {
        return (new Curl())->setUrl($url);
    }

    /**
     * @param ?string $date
     * @param bool $day = false
     *
     * @return ?string
     */
    protected function date(?string $date, bool $day = false): ?string
    {
        return $date ? date($day ? 'Y-m-d' : 'Y-m-d H:i:s', strtotime($date)) : null;
    }
}
