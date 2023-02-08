<?php declare(strict_types=1);

namespace App\Domains\PWA\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'pwa.index';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.pwa.index');
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetMineSuccess(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.pwa.index');
    }
}
