<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'dashboard.index';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
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
            ->assertStatus(302)
            ->assertRedirect(route('app.index'));
    }
}
