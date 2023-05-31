<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.index';

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
    public function testGetNotAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->get($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testPostNotAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->post($this->route())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.index');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route())
            ->assertStatus(405);
    }
}
