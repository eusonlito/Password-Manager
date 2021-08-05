<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class Disabled extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.disabled';

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
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetDisabledSuccess(): void
    {
        $this->authUser(['enabled' => false]);

        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.disabled');
    }

    /**
     * @return void
     */
    public function testPosDisabledSuccess(): void
    {
        $this->authUser(['enabled' => false]);

        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.disabled');
    }

    /**
     * @return void
     */
    public function testGetEnabledFail(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetDashboardFail(): void
    {
        $this->authUser(['enabled' => false]);

        $this->get(route('dashboard.index'))
            ->assertStatus(302)
            ->assertRedirect($this->route());
    }
}
