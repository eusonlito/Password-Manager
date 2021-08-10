<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Model\User as Model;

class UpdateApp extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.update.app';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNoAdminFail(): void
    {
        $this->get($this->route(null, $this->authUserAdmin(false)->id))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostNoAdminFail(): void
    {
        $this->post($this->route(null, $this->authUserAdmin(false)->id))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update-app');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->factoryCreate(Model::class)->id))
            ->assertStatus(200)
            ->assertViewIs('domains.user.update-app');
    }
}
