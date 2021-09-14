<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use stdClass;
use App\Services\Network\Ip\Locate as IpLocate;

class AuthCountry extends ActionAbstract
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @var string
     */
    protected string $ip;

    /**
     * @var ?stdClass
     */
    protected ?stdClass $locate;

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $this->setup();

        if ($this->enabled() === false) {
            return true;
        }

        if ($this->ipWhitelist()) {
            return true;
        }

        $this->locate();

        return $this->check();
    }

    /**
     * @return void
     */
    protected function setup(): void
    {
        $this->config = (array)config('auth.country');
        $this->ip = $this->request->ip();
    }

    /**
     * @return bool
     */
    protected function enabled(): bool
    {
        return $this->config['enabled']
            && $this->config['allowed'];
    }

    /**
     * @return bool
     */
    protected function ipWhitelist(): bool
    {
        return $this->config['ip_whitelist']
            && in_array($this->ip, $this->config['ip_whitelist']);
    }

    /**
     * @return void
     */
    protected function locate(): void
    {
        $this->locate = IpLocate::locate($this->ip);
    }

    /**
     * @return bool
     */
    protected function check(): bool
    {
        return empty($this->locate)
            || in_array(strtolower((string)$this->locate->country_code), $this->config['allowed']);
    }
}
