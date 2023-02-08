<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use Illuminate\Testing\TestResponse;

class AuthCountry extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.auth.credentials';

    /**
     * @const string
     */
    protected const IPS = [
        'null' => '0.0.0.0',
        'local' => '127.0.0.1',
        'es' => '212.128.109.1',
        'us' => '156.33.241.5',
    ];

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->config(true, ['null'], []);

        $this->getIp('es')
            ->assertStatus(401);

        $this->config(true, ['us'], []);

        $this->getIp('es')
            ->assertStatus(401);

        $this->config(true, ['us'], ['us']);

        $this->getIp('es')
            ->assertStatus(401);

        $this->config(true, ['es'], []);

        $this->getIp('us')
            ->assertStatus(401);

        $this->config(true, ['es'], ['es']);

        $this->getIp('us')
            ->assertStatus(401);

        $this->config(true, ['es'], []);

        $this->getIp('local')
            ->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->config(false, [], []);

        $this->get($this->route())
            ->assertStatus(200);

        $this->config(true, [], []);

        $this->get($this->route())
            ->assertStatus(200);

        $this->config(true, ['es'], []);

        $this->getIp('es')
            ->assertStatus(200);

        $this->config(true, ['us'], []);

        $this->getIp('us')
            ->assertStatus(200);

        $this->config(true, ['us'], ['es']);

        $this->getIp('es')
            ->assertStatus(200);

        $this->config(true, ['us'], ['local']);

        $this->getIp('local')
            ->assertStatus(200);

        $this->config(true, ['es', 'us'], []);

        $this->getIp('es')
            ->assertStatus(200);

        $this->config(true, ['us'], ['es', 'us']);

        $this->getIp('es')
            ->assertStatus(200);
    }

    /**
     * @param bool $enabled
     * @param array $allowed
     * @param array $ip_whitelist
     *
     * @return void
     */
    protected function config(bool $enabled, array $allowed, array $ip_whitelist): void
    {
        config([
            'auth.country.enabled' => $enabled,
            'auth.country.allowed' => $allowed,
            'auth.country.ip_whitelist' => array_map(static fn ($value) => static::IPS[$value], $ip_whitelist),
        ]);
    }

    /**
     * @param string $country
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function getIp(string $country): TestResponse
    {
        return $this->withServerVariables(['REMOTE_ADDR' => static::IPS[$country]])
            ->get($this->route());
    }
}
